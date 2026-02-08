<?php

declare(strict_types=1);

use App\Models\User;

it('renders the login screen', function (): void {
    $this->get('/login')->assertOk();
});

it('lets users authenticate via the login screen', function (): void {
    $user = User::factory()->create();

    $this->post('/login', [
        'email'    => $user->email,
        'password' => 'password',
    ])->assertRedirect('/games');

    $this->assertAuthenticated();
});

it('rejects authentication with an invalid password', function (): void {
    $user = User::factory()->create();

    $this->post('/login', [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

it('lets users log out', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/logout')
        ->assertRedirect('/');

    $this->assertGuest();
});
