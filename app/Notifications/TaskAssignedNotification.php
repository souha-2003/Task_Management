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
        if ($this->creator && !$this->creator->hasRole('admin')) {
            return [
                'task_id' => $this->task->id,
                'title_key' => 'messages.task_created_by_employee_title',
                'body_key' => 'messages.task_created_by_employee_body',
                'body_replace' => ['name' => $this->creator->name, 'title' => $this->task->title],
                'title' => 'New Task from Employee!',
                'body' => $this->creator->name . ' created a new task: ' . $this->task->title,
            ];
        }

        return [
            'task_id' => $this->task->id,
            'title_key' => 'messages.new_task_notification_title',
            'body_key' => 'messages.new_task_notification_body',
            'body_replace' => ['title' => $this->task->title],
            'title' => 'New Task Assigned!',
            'body' => 'A new task has been assigned to you: ' . $this->task->title,
        ];
    }
}
