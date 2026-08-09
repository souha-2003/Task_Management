<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Google\Client as GoogleClient;

class SendNewTaskPushNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssigned $event): void
    {
        $task = $event->task;
        $user = $task->user; // المستخدم المسندة إليه المهمة

        if (!$user) {
            Log::warning("لم يتم العثور على مستخدم مرتبط بالمهمة المعينة: " . $task->id);
            return;
        }

        $creator = $event->creator;

        // 1. إذا كان المستخدم العادي (وليس أدمن) يضيف مهمة لنفسه
        if ($creator && !$creator->hasRole('admin') && $user->id === $creator->id) {
            // نرسل الإشعار لجميع المديرين (Admins)
            $admins = \App\Models\User::role('admin')->get();
            $title = "مهمة جديدة من موظف!";
            $body = "قام " . $creator->name . " بإضافة مهمة جديدة بعنوان: " . $task->title;

            foreach ($admins as $admin) {
                // حفظ في قاعدة البيانات للأدمن
                $admin->notify(new \App\Notifications\TaskAssignedNotification($task, $creator));
                
                // إرسال FCM للأدمن مع مفاتيح الترجمة
                if ($admin->device_token) {
                    $this->sendPushNotification($admin->device_token, $title, $body, $task->id, [
                        'recipient_id' => (string) $admin->id,
                        'title_key' => 'messages.task_created_by_employee_title',
                        'body_key' => 'messages.task_created_by_employee_body',
                        'body_replace_name' => $creator->name,
                        'body_replace_title' => $task->title,
                    ]);
                }
            }
            return;
        }

        // 2. إذا قام الأدمن أو أي مستخدم بإسناد مهمة لنفسه، لا نرسل له تنبيهاً
        if ($creator && $user->id === $creator->id) {
            Log::info("تنبيه: تم إلغاء إرسال الإشعار لأن المستخدم قام بإسناد المهمة لنفسه.");
            return;
        }

        // 3. الحالة الطبيعية: إرسال التنبيه للمستخدم المسندة إليه المهمة (من الأدمن)
        $user->notify(new \App\Notifications\TaskAssignedNotification($task));

        if ($user->device_token) {
            $title = "مهمة جديدة مسندة إليك!";
            $body = "تم تعيين مهمة جديدة لك بعنوان: " . $task->title;
            $this->sendPushNotification($user->device_token, $title, $body, $task->id, [
                'recipient_id' => (string) $user->id,
                'title_key' => 'messages.new_task_notification_title',
                'body_key' => 'messages.new_task_notification_body',
                'body_replace_title' => $task->title,
            ]);
        }
    }

    /**
     * دالة مساعدة لإرسال إشعار Firebase مع مفاتيح الترجمة
     */
    protected function sendPushNotification(string $deviceToken, string $title, string $body, int $taskId, array $extraData = []): void
    {
        Log::info("جاري إرسال إشعار Firebase...", [
            'task_id' => $taskId,
            'device_token' => $deviceToken,
            'notification_title' => $title,
            'notification_body' => $body,
        ]);

        try {
            $projectId = config('services.firebase.project_id'); 
            
            if ($projectId) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->getFirebaseAccessToken(),
                    'Content-Type' => 'application/json',
                ])->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $deviceToken,
                        'notification' => [
                            'title' => $title,
                            'body' => $body,
                        ],
                        'data' => array_merge([
                            'task_id' => (string) $taskId,
                        ], $extraData)
                    ]
                ]);

                if ($response->successful()) {
                    Log::info("تم إرسال إشعار Firebase بنجاح للرمز: " . $deviceToken);
                } else {
                    Log::error("فشل إرسال إشعار Firebase: " . $response->body());
                }
            }
        } catch (\Exception $e) {
            Log::error("خطأ أثناء الاتصال بـ Firebase: " . $e->getMessage());
        }
    }

    /**
     * دالة للحصول على Access Token لمحاكاة الاتصال
     */
    protected function getFirebaseAccessToken(): string
    {
        $credentialsPath = config('services.firebase.service_account_path');

        if (!file_exists($credentialsPath)) {
            Log::error("ملف Firebase service-account.json غير موجود في المسار المحدد: " . $credentialsPath);
            return '';
        }

        $client = new GoogleClient();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        
        $accessToken = $client->fetchAccessTokenWithAssertion();
        
        return $accessToken['access_token'] ?? '';
    }
}
