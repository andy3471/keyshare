<?php

declare(strict_types=1);

it('returns a successful response for the welcome page', function (): void {
    $this->get('/')->assertOk();
});
