<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Key extends Model
{
    use Notifiable;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $appends = [
        'url',
        'image',
        'name',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'game_id',
        'platform_id',
        'keycode',
        'message',
        'created_user_id',
    ];

    /**
     * @param $value
     * @return string
     */
    public function getKeycodeAttribute($value)
    {
        return ($this->owned_user_id == Auth::id()) ? $value : '';
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return ($this->key_type_id == 1) ? $this->game->name : "{$this->game->name}: {$this->dlc->name}";
    }

    /**
     * @return mixed
     */
    public function getImageAttribute()
    {
        return ($this->key_type_id == 1) ? $this->game->image : $this->dlc->image;
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return "/keys/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dlc()
    {
        return $this->belongsTo('App\Models\Dlc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function platform()
    {
        return $this->belongsTo('App\Models\Platform');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function claimedUser()
    {
        return $this->belongsTo('App\Models\User', 'owned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdUser()
    {
        return $this->belongsTo('App\Models\User', 'created_user_id');
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function routeNotificationForDiscord()
    {
        return config('services.discord.channel');
    }
}
