<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Jetstream\Jetstream;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'karma',
        'karma_color',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function linkedAccounts()
    {
        return $this->hasMany('App\Models\LinkedAccount');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claimedKeys()
    {
        return $this->hasMany('App\Models\Key', 'owned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sharedKeys()
    {
        return $this->hasMany('App\Models\Key', 'created_user_id');
    }

    /**
     * @return array
     */
    public function getKarmaAttribute()
    {
        // TODO tidy this
        $id = $this->id;
        $karma = Redis::zscore('karma', $id);

        if ($karma == null) {
            $karma = 0;

            $karma = DB::select(DB::raw(
                '
            SELECT (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma, U.id FROM users AS U
            LEFT OUTER JOIN (
                SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
                WHERE created_user_id = ' . $id . '
                GROUP BY created_user_id
            ) AS C
            ON C.user_id = U.id
            LEFT OUTER JOIN (
                SELECT count(owned_user_id) AS ownedkeys, owned_user_id AS user_id FROM `keys`
                WHERE owned_user_id = ' . $id . '
                GROUP BY owned_user_id
            ) AS O
            ON O.user_id = U.id
            WHERE U.id = ' . $id
            ));

            foreach ($karma as $user) {
                $karma = Redis::zadd('karma', $user->karma, $user->id);
                $karma = Redis::zscore('karma', $id);
            }
        }

        return $karma;
    }

    /**
     * @return string
     */
    public function getKarmaColorAttribute()
    {
        // TODO tidy this
        $karma = $this->karma;

        if ($karma < 0) {
            return 'danger';
        } elseif ($karma < 2) {
            return 'warning';
        } elseif ($karma < 15) {
            return 'info';
        } else {
            return 'success';
        }
    }

    /**
     * @return mixed
     */
    public function hasTeams()
    {
        return $this->allTeams()->isNotEmpty();
    }

    /**
     * @param $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        return $this->id == optional($team)->user_id;
    }

    /**
     * @param $team
     * @return bool
     */
    public function isCurrentTeam($team)
    {
        return optional($team)->id === $this->currentTeam->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->allTeams()->first());
        }
        return $this->belongsTo(Jetstream::teamModel(), 'current_team_id');
    }
}
