<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','approved',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function linkedAccounts(){
        return $this->hasMany('App\LinkedAccount');
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getKarma($id = null){
        $k = new \stdClass();

        if ($id == null) {
            $id = auth()->id();
        }
        $karma = Redis::zscore('karma', $id);

        if ($karma == null) {
            $karma = 0;

            $karma = DB::select(DB::raw('
            SELECT (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma, U.id FROM homestead.users AS U
            LEFT OUTER JOIN (
                SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM homestead.`keys`
                WHERE created_user_id = '. $id .'
                GROUP BY created_user_id
            ) AS C
            ON C.user_id = U.id
            LEFT OUTER JOIN (
                SELECT count(owned_user_id) AS ownedkeys, owned_user_id AS user_id FROM homestead.`keys`
                WHERE owned_user_id = '. $id .'
                GROUP BY owned_user_id
            ) AS O
            ON O.user_id = U.id
            WHERE U.id = '. $id
            ));

            foreach ($karma as $user) {
                $karma = Redis::zadd('karma', $user->karma, $user->id);
                $karma = Redis::zscore('karma', $id);
            }
        }

        $k->score = $karma;

        if ($karma < 0) {
            $k->color = 'badge-danger';
        } elseif ($karma < 2) {
            $k->color = 'badge-warning';
        } elseif ($karma < 15) {
            $k->color = 'badge-info';
        } else {
            $k->color = 'badge-success';
        }

        return $k;
    }
}
