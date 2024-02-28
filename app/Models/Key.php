<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Key extends Model
{
    use HasFactory;
    use Notifiable;

    protected $appends = [
        'url',
        'image',
        'name',
    ];

    protected $fillable = [
        'game_id',
        'platform_id',
        'keycode',
        'message',
        'created_user_id',
    ];

    public function getNameAttribute()
    {
        if ($this->key_type_id == 1) {
            return $this->game->name;
        } elseif ($this->key_type_id == 2) {
            return "{$this->game->name}: {$this->dlc->name}";
        }
    }

    public function getImageAttribute()
    {
        if ($this->key_type_id == 1) {
            return $this->game->image;
        } elseif ($this->key_type_id == 2) {
            return $this->dlc->image;
        }
    }

    public function getUrlAttribute()
    {
        return "/keys/{$this->id}";
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    public function dlc()
    {
        return $this->belongsTo('App\Models\Dlc');
    }

    public function platform()
    {
        return $this->belongsTo('App\Models\Platform');
    }

    public function claimedUser()
    {
        return $this->belongsTo('App\Models\User', 'owned_user_id');
    }

    public function createdUser()
    {
        return $this->belongsTo('App\Models\User', 'created_user_id');
    }

    public function routeNotificationForDiscord()
    {
        return config('services.discord.channel');
    }
}
