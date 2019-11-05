<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    public function keys()
    {
        return $this->hasMany('App\Keys');
    }
}
