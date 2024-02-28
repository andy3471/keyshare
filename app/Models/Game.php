<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $appends = [
        'url',
    ];

    protected $fillable = ['name', 'created_user_id'];

    public function getUrlAttribute()
    {
        return "/games/{$this->id}";
    }

    public function dlcs()
    {
        return $this->hasMany('App\Dlcs');
    }

    public function keys()
    {
        return $this->hasMany('App\Models\Key');
    }
}
