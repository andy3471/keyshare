<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\KeyFeedback;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Key extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'game_id',
        'platform_id',
        'key',
        'message',
        'created_user_id',
        'group_id',
        'feedback',
    ];

    /** @return BelongsTo<Game, $this> */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /** @return BelongsTo<Platform, $this> */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /** @return BelongsTo<User, $this> */
    public function claimedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_user_id');
    }

    /** @return BelongsTo<User, $this> */
    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    /** @return BelongsTo<Group, $this> */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function claim(User $user): self
    {
        $this->owned_user_id = $user->id;
        $this->save();

        return $this;
    }

    protected function casts(): array
    {
        return [
            'feedback' => KeyFeedback::class,
        ];
    }
}
