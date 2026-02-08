<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\KeyFeedback;
use App\Models\Key;
use App\Services\KarmaService;

class KeyKarmaObserver
{
    public function __construct(private KarmaService $karmaService) {}

    public function updated(Key $key): void
    {
        if ($key->wasChanged('owned_user_id') && $key->owned_user_id !== null) {
            // Sharer earns +1 karma
            if ($sharer = $key->createdUser) {
                $this->karmaService->incrementKarma($sharer);
            }

            // Claimer spends -1 karma
            if ($claimer = $key->claimedUser) {
                $this->karmaService->decrementKarma($claimer);
            }
        }

        if ($key->wasChanged('feedback')) {
            $sharer = $key->createdUser;

            if (! $sharer) {
                return;
            }

            $originalFeedback = $key->getOriginal('feedback');
            $newFeedback      = $key->feedback;

            if ($newFeedback === KeyFeedback::DidNotWork && $originalFeedback !== KeyFeedback::DidNotWork) {
                $this->karmaService->decrementKarma($sharer);
            }

            if ($originalFeedback === KeyFeedback::DidNotWork && $newFeedback !== KeyFeedback::DidNotWork) {
                $this->karmaService->incrementKarma($sharer);
            }
        }
    }
}
