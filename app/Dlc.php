<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dlc extends Model
{
    protected $fillable = ['name', 'game_id', 'created_user_id'];
}
