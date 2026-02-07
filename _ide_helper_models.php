<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $removed
 * @property int|null $igdb_id
 * @property-read string|null $aggregated_rating
 * @property-read string|null $aggregated_rating_count
 * @property-read mixed $description
 * @property-read \Illuminate\Support\Collection|null $genres
 * @property-read string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
 * @property-read mixed $name
 * @property-read int|null $parent_game_id
 * @property-read \Illuminate\Support\Collection|null $screenshots
 * @property-read string $url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereIgdbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereRemoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $game_id
 * @property string $platform_id
 * @property string $key
 * @property string|null $owned_user_id
 * @property string $created_user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $message
 * @property int $removed
 * @property string|null $wallet_id
 * @property string|null $subscription_id
 * @property-read \App\Models\User|null $claimedUser
 * @property-read \App\Models\User $createdUser
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $image
 * @property-read mixed $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Platform $platform
 * @property-read string $url
 * @method static \Database\Factories\KeyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereOwnedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereRemoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereWalletId($value)
 */
	class Key extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $linked_account_provider_id
 * @property string $account_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $profileurl
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereLinkedAccountProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProfileurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUserId($value)
 */
	class LinkedAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property int|null $igdb_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereIgdbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereUpdatedAt($value)
 */
	class Platform extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $image
 * @property string|null $bio
 * @property bool $is_approved
 * @property bool $is_admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $claimedKeys
 * @property-read int|null $claimed_keys_count
 * @property-read mixed $karma
 * @property-read string $karma_colour
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LinkedAccount> $linkedAccounts
 * @property-read int|null $linked_accounts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $sharedKeys
 * @property-read int|null $shared_keys_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

