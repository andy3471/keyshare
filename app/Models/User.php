<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $appends = [
        'karma',
        'karma_color',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'approved',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function linkedAccounts()
    {
        return $this->hasMany('App\Models\LinkedAccount');
    }

    public function claimedKeys()
    {
        return $this->hasMany('App\Models\Key', 'owned_user_id');
    }

    public function sharedKeys()
    {
        return $this->hasMany('App\Models\Key', 'created_user_id');
    }

    public function getKarmaAttribute()
    {
        $id = $this->id;
        $karma = Redis::zscore('karma', $id);

        if ($karma == null) {
            $karma = 0;

            $karma = DB::select(
                '
                    SELECT
                        (COALESCE(C.createdkeys, 0) - COALESCE(O.ownedkeys, 0)) AS karma,
                        U.id
                    FROM
                        users AS U
                            LEFT OUTER JOIN (
                            SELECT
                                COUNT(created_user_id) AS createdkeys,
                                created_user_id AS user_id
                            FROM
                                keys
                            WHERE
                                created_user_id = 1
                            GROUP BY
                                created_user_id
                        ) AS C ON C.user_id = U.id
                            LEFT OUTER JOIN (
                            SELECT
                                count(owned_user_id) AS ownedkeys,
                                owned_user_id AS user_id
                            FROM
                                keys
                            WHERE
                                owned_user_id = 1
                            GROUP BY
                                owned_user_id
                        ) AS O ON O.user_id = U.id
                    WHERE
                        U.id = 1
            ');

            foreach ($karma as $user) {
                $karma = Redis::zadd('karma', $user->karma, $user->id);
                $karma = Redis::zscore('karma', $id);
            }
        }

        return $karma;
    }

    public function getKarmaColorAttribute()
    {
        $karma = $this->karma;

        if ($karma < 0) {
            return 'badge-danger';
        } elseif ($karma < 2) {
            return 'badge-warning';
        } elseif ($karma < 15) {
            return 'badge-info';
        } else {
            return 'badge-success';
        }
    }
}
