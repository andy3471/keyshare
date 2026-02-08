<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Groups;

use App\Models\Group;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GroupData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $slug,
        public ?string $description = null,
        public ?string $owner_id = null,
        public ?bool $is_public = null,
        public ?string $invite_code = null,
        public ?int $member_count = null,
        public ?string $role = null,
        public ?string $avatar = null,
        public ?string $discord_webhook_url = null,
    ) {}

    public static function fromModel(Group $group, ?string $role = null): self
    {
        return new self(
            id: (string) $group->id,
            name: $group->name,
            slug: $group->slug,
            description: $group->description,
            owner_id: (string) $group->owner_id,
            is_public: $group->is_public,
            invite_code: $group->invite_code,
            member_count: array_key_exists('members_count', $group->getAttributes()) ? (int) $group->members_count : null,
            role: $role,
            avatar: $group->avatar_url,
            discord_webhook_url: $group->discord_webhook_url,
        );
    }
}
