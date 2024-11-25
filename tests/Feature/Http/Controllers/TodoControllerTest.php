<?php

use App\Models\User;

test('todo crud', function () {
    $this->getJson('/api/todos')
        ->assertStatus(401);

    $user = User::factory()->create();

    $this
        ->actingAs($user, 'sanctum')
        ->getJson('/api/todos')
        ->assertOk();

    $response = $this
        ->actingAs($user, 'sanctum')
        ->postJson('/api/todos', [
            'name' => 'test todo',
            'completed_at' => null,
        ])
        ->assertCreated()
        ->assertJson([
            'data' => [
                'name' => 'test todo',
                'completed_at' => null,
            ],
        ]);

    $todoId = $response->json('data.id');

    $this
        ->getJson("/api/todos/{$todoId}")
        ->assertOk()
        ->assertJson([
            'data' => [
                'name' => 'test todo',
                'completed_at' => null,
            ],
        ]);

    $now = now()->format('Y-m-d H:i:s');

    $response = $this
        ->patchJson("/api/todos/{$todoId}", [
            'name' => 'renamed todo',
            'completed_at' => $now,
        ])
        ->assertOk()
        ->assertJson([
            'data' => [
                'name' => 'renamed todo',
                'completed_at' => $now,
            ],
        ]);

    $this->deleteJson("/api/todos/{$todoId}")
        ->assertNoContent();

});
