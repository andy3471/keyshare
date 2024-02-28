<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyType extends Model
{
    const GAME = 1;

    const DLC = 2;

    const WALLET = 3;

    const SUBSCRIPTION = 4;
}
