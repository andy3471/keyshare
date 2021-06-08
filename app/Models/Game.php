<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $appends = [
        'url',
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'created_user_id'];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return "/games/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keys()
    {
        return $this->hasMany('App\Models\Key');
    }
}
