<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
enum LinkedAccountProvider: string
{
    case Steam   = 'steam';
    case Twitch  = 'twitch';
    case Discord = 'discord';
    case Xbox    = 'xbox';

    /** @return array<int, self> */
    public static function enabledProviders(): array
    {
        return array_values(array_filter(
            self::cases(),
            fn (self $provider): bool => $provider->isEnabled(),
        ));
    }

    /**
     * Get all enabled providers as frontend-ready arrays.
     *
     * @return array<int, array{name: string, label: string, color: string, url: string}>
     */
    public static function enabledForFrontend(): array
    {
        return array_map(
            fn (self $provider): array => $provider->toFrontend(),
            self::enabledProviders(),
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::Steam   => 'Steam',
            self::Twitch  => 'Twitch',
            self::Discord => 'Discord',
            self::Xbox    => 'Xbox',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Steam   => '#171a21',
            self::Twitch  => '#9146ff',
            self::Discord => '#5865f2',
            self::Xbox    => '#107c10',
        };
    }

    /** The Socialite driver name used for this provider. */
    public function driver(): string
    {
        return match ($this) {
            self::Steam   => 'steam',
            self::Twitch  => 'twitch',
            self::Discord => 'discord',
            self::Xbox    => 'microsoft',
        };
    }

    /** Check whether this provider has credentials configured and is usable. */
    public function isEnabled(): bool
    {
        return match ($this) {
            self::Steam   => filled(config('services.steam.client_id')),
            self::Twitch  => filled(config('services.twitch.client_id')),
            self::Discord => filled(config('services.discord.client_id')),
            self::Xbox    => filled(config('services.microsoft.client_id')),
        };
    }

    /** Build the redirect URL for this provider. */
    public function redirectUrl(): string
    {
        return route('auth.provider.redirect', $this->value);
    }

    /**
     * Convert to an array suitable for passing to the frontend (login/register pages).
     *
     * @return array{name: string, label: string, color: string, url: string}
     */
    public function toFrontend(): array
    {
        return [
            'name'  => $this->value,
            'label' => $this->label(),
            'color' => $this->color(),
            'url'   => $this->redirectUrl(),
        ];
    }
}
