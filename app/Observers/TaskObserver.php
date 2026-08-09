<?php

namespace App\Observers;

use App\Models\Task;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TaskObserver
{
    /**
     * Handle the Task "saving" event.
     * يتم استدعاؤها تلقائياً قبل حفظ المهمة (في الإضافة والتعديل)
     */
    public function saving(Task $task): void
    {
        // 1. تأمين البيانات وتنسيقها (حماية من ثغرات XSS وجعل الحرف الأول كبيراً)
        $task->title = strip_tags(ucfirst($task->title));
        if ($task->description) {
            $task->description = strip_tags($task->description);
        }

        // 2. إدارة تاريخ إنجاز المهمة تلقائياً في حقل completed_at
        if ($task->isDirty('status')) {
            if ($task->status === 'completed') {
                $task->completed_at = now();
            } else {
                $task->completed_at = null;
            }

            // لتنظيف الملاحظات القديمة إذا كانت تحتوي على التوقيت المخزن سابقاً
            if ($task->note) {
                $task->note = trim(preg_replace('/\[Completed on [0-9\-:\s]+\]/', '', $task->note));
            }
        }
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Log::info("TaskObserver: A new task has been created. Title: '{$task->title}' (ID: {$task->id})");

        // إرسال إيميل تجريبي لصاحب المهمة عند إنشائها
        if ($task->user && $task->user->email) {
            Mail::raw("مرحباً {$task->user->name}، لقد تم إنشاء مهمة جديدة لك بعنوان: '{$task->title}' بنجاح.", function ($message) use ($task) {
                $message->to($task->user->email)
                        ->subject("إشعار بمهمة جديدة: {$task->title}");
            });
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // التحقق مما إذا تم تعديل حالة المهمة وتسجيلها وإرسال إيميل
        if ($task->wasChanged('status')) {
            Log::info("TaskObserver: Task ID {$task->id} status updated to '{$task->status}'");

            if ($task->user && $task->user->email) {
                if ($task->status === 'completed') {
                    Mail::raw("مرحباً {$task->user->name}، نود إعلامك بأن المهمة: '{$task->title}' قد اكتملت بنجاح الآن.", function ($message) use ($task) {
                        $message->to($task->user->email)
                                ->subject("اكتملت المهمة: {$task->title}");
                    });
                } elseif ($task->status === 'review') {
                    Mail::raw("مرحباً {$task->user->name}، نود إعلامك بأن المهمة: '{$task->title}' أصبحت قيد المراجعة الآن.", function ($message) use ($task) {
                        $message->to($task->user->email)
                                ->subject("المهمة قيد المراجعة: {$task->title}");
                    });
                }
            }
        } else {
            Log::info("TaskObserver: Task ID {$task->id} has been updated.");
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Log::info("TaskObserver: Task ID {$task->id} has been deleted.");

        // حذف تلقائي لجميع الإشعارات المرتبطة بهذه المهمة لتجنب خطأ 404
        \Illuminate\Support\Facades\DB::table('notifications')
            ->where('data->task_id', $task->id)
            ->delete();
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        Log::info("TaskObserver: Task ID {$task->id} has been restored.");
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        Log::info("TaskObserver: Task ID {$task->id} has been permanently deleted.");
    }
}
