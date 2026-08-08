<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
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

    public function test_user_can_list_categories()
    {
        Category::create([
            'name' => 'Work',
            'color' => '#ff0000',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Work',
                'color' => '#ff0000',
            ]);
    }

    public function test_user_cannot_create_category_without_permission()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/categories', [
            'name' => 'New Category',
            'color' => '#00ff00',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_create_category_with_permission()
    {
        $this->user->givePermissionTo('manage categories');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/categories', [
            'name' => 'New Category',
            'color' => '#00ff00',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'New Category',
                'color' => '#00ff00',
            ]);
    }

    public function test_user_can_show_category()
    {
        $category = Category::create([
            'name' => 'Personal',
            'color' => '#0000ff',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Personal',
                'color' => '#0000ff',
            ]);
    }

    public function test_user_can_update_category_with_permission()
    {
        $category = Category::create([
            'name' => 'Personal',
            'color' => '#0000ff',
        ]);

        $this->user->givePermissionTo('manage categories');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/categories/{$category->id}", [
            'name' => 'Updated Personal',
            'color' => '#ffff00',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Personal',
                'color' => '#ffff00',
            ]);
    }

    public function test_user_can_delete_category_with_permission()
    {
        $category = Category::create([
            'name' => 'Personal',
            'color' => '#0000ff',
        ]);

        $this->user->givePermissionTo('manage categories');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Category deleted successfully'
            ]);

        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
    }
}
