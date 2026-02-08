<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Groups;

use App\Models\Group;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GroupCanData extends Data
{
    public function __construct(
        public bool $update,
        public bool $delete,
        public bool $leave,
        public bool $manageMembers,
        public bool $invite,
    ) {}

    public static function fromModel(Group $group): self
    {
        return new self(
            update: Gate::allows('update', $group),
            delete: Gate::allows('delete', $group),
            leave: Gate::allows('leave', $group),
            manageMembers: Gate::allows('manageMembers', $group),
            invite: Gate::allows('invite', $group),
        );
    }
}
