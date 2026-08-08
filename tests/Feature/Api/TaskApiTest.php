<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
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

    public function test_user_can_list_their_tasks()
    {
        $task = Task::create([
            'title' => 'My Task',
            'description' => 'Description of my task',
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $otherUser = User::factory()->create();
        $otherTask = Task::create([
            'title' => 'Other Task',
            'description' => 'Description of other task',
            'user_id' => $otherUser->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $task->id,
                'title' => $task->title,
            ])
            ->assertJsonMissing([
                'title' => $otherTask->title,
            ]);
    }

    public function test_user_can_create_task_via_api()
    {
        $category = Category::create([
            'name' => 'API Cat',
            'color' => '#ffffff',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/tasks', [
            'title' => 'API Task Title',
            'description' => 'Description of the API task',
            'note' => 'Some note',
            'categories' => [$category->id]
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'note',
                    'status',
                    'is_completed',
                    'completed_at',
                    'created_at',
                    'categories'
                ]
            ])
            ->assertJsonFragment([
                'title' => 'API Task Title',
            ]);
            
        $this->assertDatabaseHas('tasks', [
            'title' => 'API Task Title',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_update_their_task()
    {
        $task = Task::create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Updated Title',
                'is_completed' => true,
            ]);
    }

    public function test_user_cannot_update_other_users_task()
    {
        $otherUser = User::factory()->create();
        $otherTask = Task::create([
            'title' => 'Other Task',
            'description' => 'Other description',
            'user_id' => $otherUser->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/tasks/{$otherTask->id}", [
            'title' => 'Hacked Title',
            'description' => 'Hacked description',
            'status' => 'completed',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_task()
    {
        $task = Task::create([
            'title' => 'Delete Me',
            'description' => 'To be deleted',
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
