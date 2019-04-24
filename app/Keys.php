<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keys extends Model
{
    protected $fillable = ['game_id', 'platform_id', 'keycode', 'message', 'created_user_id'];
}
