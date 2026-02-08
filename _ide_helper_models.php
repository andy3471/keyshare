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
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $owner_id
 * @property bool $is_public
 * @property string|null $invite_code
 * @property string|null $discord_webhook_url
 * @property int|null $min_karma
 * @property int|null $claim_cooldown_minutes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string|null $avatar_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User $owner
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereClaimCooldownMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDiscordWebhookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereInviteCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMinKarma($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereNotMember(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $email
 * @property string $token
 * @property string $invited_by
 * @property \Carbon\CarbonImmutable|null $accepted_at
 * @property \Carbon\CarbonImmutable|null $expires_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $inviter
 * @method static \Database\Factories\GroupInvitationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereUpdatedAt($value)
 */
	class GroupInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $group_id
 * @property string|null $game_id
 * @property string $platform_id
 * @property string $key
 * @property string|null $owned_user_id
 * @property \App\Enums\KeyFeedback|null $feedback
 * @property string $created_user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $message
 * @property-read \App\Models\User|null $claimedUser
 * @property-read \App\Models\User $createdUser
 * @property-read \App\Models\Game|null $game
 * @property-read \App\Models\Group|null $group
 * @property-read \App\Models\Platform $platform
 * @method static \Database\Factories\KeyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereOwnedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Key whereUpdatedAt($value)
 */
	class Key extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property \App\Enums\LinkedAccountProvider $provider
 * @property string $provider_user_id
 * @property array<array-key, mixed>|null $data
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount forProvider(\App\Enums\LinkedAccountProvider $provider)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkedAccount whereUserId($value)
 */
	class LinkedAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array<array-key, mixed> $manipulations
 * @property array<array-key, mixed> $custom_properties
 * @property array<array-key, mixed> $generated_conversions
 * @property array<array-key, mixed> $responsive_images
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read mixed $extension
 * @property-read mixed $human_readable_size
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read mixed $original_url
 * @property-read mixed $preview_url
 * @property-read mixed $type
 * @property-read string|null $uuid
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereGeneratedConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Media whereUpdatedAt($value)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $keys
 * @property-read int|null $keys_count
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
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $onboarded_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $bio
 * @property bool $is_admin
 * @property-read string $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Key> $claimedKeys
 * @property-read int|null $claimed_keys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read int $karma
 * @property-read string $karma_colour
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LinkedAccount> $linkedAccounts
 * @property-read int|null $linked_accounts_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $ownedGroups
 * @property-read int|null $owned_groups_count
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOnboardedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Spatie\MediaLibrary\HasMedia {}
}

