<?php

declare(strict_types=1);

it('renders the registration screen', function (): void {
    $this->get('/register')->assertOk();
});

it('lets new users register', function (): void {
    $this->post('/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/games');

    $this->assertAuthenticated();
});
