<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $fillable = ['game_id', 'platform_id', 'keycode', 'message', 'created_user_id'];
}
