<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_guest_cannot_list_users()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_non_admin_cannot_list_users()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_list_users()
    {
        $this->user->givePermissionTo('manage users');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->user->id,
                'email' => $this->user->email,
            ]);
    }

    public function test_admin_can_update_user_roles_and_permissions()
    {
        $targetUser = User::factory()->create();
        
        $this->user->givePermissionTo('manage users');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/users/{$targetUser->id}", [
            'roles' => ['admin'],
            'permissions' => ['manage categories'],
        ]);

        $response->assertStatus(200);

        $targetUser->refresh();
        $this->assertTrue($targetUser->hasRole('admin'));
        $this->assertTrue($targetUser->hasDirectPermission('manage categories'));
    }
}
