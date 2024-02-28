<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    public function keys()
    {
        return $this->hasMany('App\Models\Key');
    }
}
