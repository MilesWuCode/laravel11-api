<?php

use App\Models\User;

test('fetch me', function () {
    $this->getJson('/api/me')->assertStatus(401);

    $user = User::factory()->create();

    $this
        ->actingAs($user, 'sanctum')
        ->getJson('/api/me')
        ->assertOk();
});
