<?php

declare(strict_types=1);

namespace App\Enums;

enum GroupRole: string
{
    case Owner  = 'owner';
    case Admin  = 'admin';
    case Member = 'member';
}
