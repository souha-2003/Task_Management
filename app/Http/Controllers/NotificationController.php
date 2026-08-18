<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get user's unread notifications for the dropdown.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();
        
        // جلب الإشعارات غير المقروءة فقط لتبقى القائمة نظيفة
        $notifications = $user->unreadNotifications()->take(10)->get()->map(function($notification) {
            $data = $notification->data;
            return [
                'id' => $notification->id,
                'data' => [
                    'task_id' => $data['task_id'] ?? null,
                    'title' => isset($data['title_key']) ? __($data['title_key'], $data['body_replace'] ?? []) : ($data['title'] ?? ''),
                    'body' => isset($data['body_key']) ? __($data['body_key'], $data['body_replace'] ?? []) : ($data['body'] ?? ''),
                ],
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });
        
        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Show all notifications history page.
     */
    public function history()
    {
        $user = auth()->user();
        // جلب جميع الإشعارات (المقروءة وغير المقروءة) مع الترقيم
        $notifications = $user->notifications()->paginate(10);
        
        return view('notifications.history', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all user's notifications as read.
     */
    public function markAllAsRead(Request $request): mixed
    {
        auth()->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Delete a specific notification.
     */
    public function destroy(string $id): mixed
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back();
    }

    /**
     * Delete all notifications of the user.
     */
    public function clearAll(): mixed
    {
        auth()->user()->notifications()->delete();

        return redirect()->back();
    }
}
