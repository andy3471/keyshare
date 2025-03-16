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
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $created_by_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $igdb_id
 * @property string|null $igdb_updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $unclaimedKeys
 * @property-read int|null $unclaimed_keys_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereIgdbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereIgdbUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withoutTrashed()
 */
	class Game extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $game_id
 * @property string $platform_id
 * @property string $keycode
 * @property string $claimed_by_user_id
 * @property string $created_by_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $claimedUser
 * @property-read \App\Models\User $createdUser
 * @property-read \App\Models\Game $game
 * @property-read mixed $image
 * @property-read mixed $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Platform|null $platform
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key unclaimed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereClaimedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereKeycode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key withoutTrashed()
 */
	class Key extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $user_id
 * @property string $provider
 * @property string $provider_account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $profile_url
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProfileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProviderAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUserId($value)
 */
	class LinkedAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $unclaimedKeys
 * @property-read int|null $unclaimed_keys_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Platform whereUpdatedAt($value)
 */
	class Platform extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bio
 * @property bool $is_super_admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $claimedKeys
 * @property-read int|null $claimed_keys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read int $karma
 * @property-read string $karma_color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LinkedAccount> $linkedAccounts
 * @property-read int|null $linked_accounts_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $sharedKeys
 * @property-read int|null $shared_keys_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

