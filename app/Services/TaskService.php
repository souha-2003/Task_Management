<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Events\TaskAssigned;

class TaskService
{
    /**
     * جلب المهام الخاصة بالمستخدم مع التصفية والبحث والتقسيم إلى صفحات.
     */
    public function getPaginatedTasksForUser(User $user, ?string $search = null, ?string $filter = null, int $perPage = 5): LengthAwarePaginator
    {
        if ($user->can('edit any task') || $user->can('delete any task')) {
            $query = Task::query()->with(['user', 'categories'])->search($search);
        } else {
            $query = $user->tasks()->with('categories')->search($search);
        }

        if ($filter === 'completed') {
            $query->completed();
        } elseif ($filter === 'pending') {
            $query->pending();
        } elseif ($filter === 'in_progress') {
            $query->inProgress();
        } elseif ($filter === 'review') {
            $query->review();
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * إنشاء مهمة جديدة للمستخدم وربط التصنيفات بها.
     */
    public function createTask(User $user, array $data): Task
    {
        $task = DB::transaction(function () use ($user, $data) {
            $task = $user->tasks()->create($data);

            if (isset($data['categories'])) {
                $task->categories()->sync($data['categories']);
            }

            return $task;
        });

        event(new TaskAssigned($task));

        return $task;
    }

    /**
     * تحديث بيانات المهمة والتصنيفات المرتبطة بها.
     */
    public function updateTask(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $task->update($data);

            $task->categories()->sync($data['categories'] ?? []);

            return $task;
        });
    }

    /**
     * حذف المهمة.
     */
    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }

    /**
     * تبديل حالة المهمة بين الحالات الأربع بشكل حلقي.
     */
    public function toggleTaskStatus(Task $task): Task
    {
        $nextStatus = match ($task->status) {
            'pending' => 'in_progress',
            'in_progress' => 'review',
            'review' => 'completed',
            default => 'pending',
        };

        $task->update([
            'status' => $nextStatus,
        ]);

        return $task;
    }
}
