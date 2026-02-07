<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyType extends Model
{
    public const GAME = 1;

    public const DLC = 2;

    public const WALLET = 3;

    public const SUBSCRIPTION = 4;
}
