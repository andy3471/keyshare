<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dlc extends Model
{
    protected $fillable = ['name', 'game_id', 'created_user_id'];

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    public function keys()
    {
        return $this->hasMany('App\Models\Key');
    }
}