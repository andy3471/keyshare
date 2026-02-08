<?php

declare(strict_types=1);

use App\Models\User;

it('lets a user view their own profile', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get("/users/{$user->id}")
        ->assertOk();
});

it('lets a user view the edit page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get("/users/{$user->id}/edit")
        ->assertOk();
});

it('lets a user update their name', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put("/users/{$user->id}", [
            'name' => 'Updated Name',
        ])->assertRedirect();

    expect($user->fresh()->name)->toBe('Updated Name');
});

it('requires a name when updating profile', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put("/users/{$user->id}", [
            'name' => '',
        ])->assertSessionHasErrors('name');
});

it('redirects guests from profiles', function (): void {
    $user = User::factory()->create();

    $this->get("/users/{$user->id}")
        ->assertRedirect('/login');
});
