<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    protected \App\Models\Task $task;
    protected ?\App\Models\User $creator;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Task $task, ?\App\Models\User $creator = null)
    {
        $this->task = $task;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $creatorName = $this->creator ? $this->creator->name : 'System';
        $isSubmittingAdmin = $this->creator && $this->creator->hasRole('admin');

        if ($isSubmittingAdmin) {
            return [
                'task_id' => $this->task->id,
                'title_key' => 'messages.task_created_by_admin_title',
                'body_key' => 'messages.task_created_by_admin_body',
                'body_replace' => ['title' => $this->task->title],
                'title' => 'New Task from Admin',
                'body' => 'Admin created a new task: ' . $this->task->title,
            ];
        }

        return [
            'task_id' => $this->task->id,
            'title_key' => 'messages.task_created_by_user_title',
            'body_key' => 'messages.task_created_by_user_body',
            'body_replace' => ['name' => $creatorName, 'title' => $this->task->title],
            'title' => 'New Task from ' . $creatorName,
            'body' => $creatorName . ' created a new task: ' . $this->task->title,
        ];
    }
}
