<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationApiController extends Controller
{
    /**
     * Get user's unread notifications.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();
        
        $notifications = $user->unreadNotifications()->take(10)->get()->map(function ($notification) {
            $data = $notification->data;
            return [
                'id' => $notification->id,
                'data' => [
                    'task_id' => $data['task_id'] ?? null,
                    'title' => isset($data['title_key']) ? __($data['title_key']) : ($data['title'] ?? ''),
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
     * Get user's notification history (paginated).
     */
    public function history(): JsonResponse
    {
        $user = auth()->user();
        
        $paginator = $user->notifications()->paginate(10);
        
        $transformed = collect($paginator->items())->map(function ($notification) {
            $data = $notification->data;
            return [
                'id' => $notification->id,
                'data' => [
                    'task_id' => $data['task_id'] ?? null,
                    'title' => isset($data['title_key']) ? __($data['title_key']) : ($data['title'] ?? ''),
                    'body' => isset($data['body_key']) ? __($data['body_key'], $data['body_replace'] ?? []) : ($data['body'] ?? ''),
                ],
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        return response()->json([
            'notifications' => $transformed,
            'pagination' => [
                'total' => $paginator->total(),
                'count' => $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage()
            ]
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    /**
     * Mark all user's notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Delete a specific notification.
     */
    public function destroy(string $id): JsonResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true, 'message' => 'Notification deleted successfully']);
    }

    /**
     * Delete all notifications of the user.
     */
    public function clearAll(): JsonResponse
    {
        auth()->user()->notifications()->delete();

        return response()->json(['success' => true, 'message' => 'All notifications cleared successfully']);
    }

    /**
     * Update device token for FCM push notifications.
     */
    public function updateDeviceToken(Request $request): JsonResponse
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        auth()->user()->update(['device_token' => $request->device_token]);

        return response()->json(['success' => true, 'message' => 'Device token updated successfully']);
    }
}
