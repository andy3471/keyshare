<?php

namespace App\Enums\Auth;

enum LinkedAccountProvider: string
{
    case BattleNet = 'battlenet';

    case Discord = 'discord';

    case Microsoft = 'microsoft';

    case Steam = 'steam';

    case Twitch = 'twitch';

}
