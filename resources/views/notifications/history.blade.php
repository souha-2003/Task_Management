<x-app-layout>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 col-12 mb-3 mb-md-0">
            <h2 class="fw-bold mb-0 text-dark">🔔 {{ app()->getLocale() == 'ar' ? 'أرشيف الإشعارات' : 'Notifications History' }}</h2>
        </div>
        <div class="col-md-6 col-12 text-md-end text-start d-flex justify-content-md-end gap-2 flex-wrap">
            <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm border-0 px-3 py-2 fw-semibold d-flex align-items-center gap-1.5" style="font-size: 0.8rem; border-radius: 8px; background-color: rgba(99, 102, 241, 0.08); color: #6366f1; transition: all 0.2s;" onmouseover="this.style.backgroundColor='rgba(99, 102, 241, 0.15)'" onmouseout="this.style.backgroundColor='rgba(99, 102, 241, 0.08)'">
                    ✔ {{ app()->getLocale() == 'ar' ? 'تحديد الكل كمقروء' : 'Mark All as Read' }}
                </button>
            </form>
            <form action="{{ route('notifications.clearAll') }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من مسح جميع الإشعارات؟' : 'Are you sure you want to clear all notifications?' }}')" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm border-0 px-3 py-2 fw-semibold d-flex align-items-center gap-1.5" style="font-size: 0.8rem; border-radius: 8px; background-color: rgba(239, 68, 68, 0.08); color: #ef4444; transition: all 0.2s;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.15)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.08)'">
                    🗑 {{ app()->getLocale() == 'ar' ? 'مسح الكل' : 'Clear All' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Notifications List Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($notifications->isEmpty())
                <div class="text-center py-5">
                    <h5 class="text-secondary mb-3">
                        {{ app()->getLocale() == 'ar' ? 'لا توجد إشعارات سابقة' : 'No notifications history found' }}
                    </h5>
                </div>
            @else
                <div class="list-group list-group-flush" style="border-radius: 16px; overflow: hidden;">
                    @foreach ($notifications as $notification)
                        @php
                            $isUnread = is_null($notification->read_at);
                            $taskId = $notification->data['task_id'] ?? '#';
                            $title = isset($notification->data['title_key']) ? __($notification->data['title_key']) : ($notification->data['title'] ?? 'Notification');
                            $body = isset($notification->data['body_key']) ? __($notification->data['body_key'], $notification->data['body_replace'] ?? []) : ($notification->data['body'] ?? '');
                        @endphp
                        
                        <div class="list-group-item p-4 d-flex justify-content-between align-items-center gap-3" 
                             style="background-color: {{ $isUnread ? 'rgba(99, 102, 241, 0.04)' : 'rgba(241, 245, 249, 0.4)' }}; border-bottom: 1px solid rgba(226, 232, 240, 0.8);">
                            <div class="d-flex align-items-start gap-3">
                                <!-- Status dot -->
                                <span class="mt-2" style="width: 8px; height: 8px; background-color: {{ $isUnread ? '#6366f1' : '#cbd5e1' }}; border-radius: 50%; display: inline-block; flex-shrink: 0; {{ $isUnread ? 'box-shadow: 0 0 6px #6366f1;' : '' }}"></span>
                                <div>
                                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem; color: {{ $isUnread ? '#4f46e5' : '#475569' }};">
                                        {{ $title }}
                                    </h6>
                                    <p class="mb-2" style="font-size: 0.88rem; line-height: 1.4; color: {{ $isUnread ? '#1e293b' : '#64748b' }};">
                                        {{ $body }}
                                    </p>
                                    <span class="text-muted small">
                                        📅 {{ $notification->created_at->setTimezone(auth()->user()->timezone ?? 'UTC')->format('Y-m-d h:i A') }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end d-flex align-items-center gap-2 flex-shrink-0">
                                <a href="{{ route('tasks.show', $taskId) }}" 
                                   onclick="event.preventDefault(); markAndRedirect('{{ $notification->id }}', '{{ route('tasks.show', $taskId) }}');" 
                                   class="btn btn-sm border-0 px-3 py-1.5 fw-semibold d-flex align-items-center gap-1" 
                                   style="font-size: 0.78rem; border-radius: 8px; background-color: rgba(99, 102, 241, 0.08); color: #6366f1; white-space: nowrap; transition: all 0.2s;"
                                   onmouseover="this.style.backgroundColor='rgba(99, 102, 241, 0.15)'"
                                   onmouseout="this.style.backgroundColor='rgba(99, 102, 241, 0.08)'">
                                    🔍 {{ app()->getLocale() == 'ar' ? 'عرض المهمة' : 'View Task' }}
                                </a>
                                @if($isUnread)
                                    <button onclick="markSingleAsRead(event, '{{ $notification->id }}')" 
                                            class="btn btn-sm border-0 px-2 py-1.5 fw-semibold d-flex align-items-center justify-content-center" 
                                            style="font-size: 0.78rem; border-radius: 8px; background-color: rgba(16, 185, 129, 0.08); color: #10b981; width: 32px; height: 32px; transition: all 0.2s;" 
                                            title="{{ app()->getLocale() == 'ar' ? 'تحديد كمقروء' : 'Mark as read' }}"
                                            onmouseover="this.style.backgroundColor='rgba(16, 185, 129, 0.15)'"
                                            onmouseout="this.style.backgroundColor='rgba(16, 185, 129, 0.08)'">
                                        ✔
                                    </button>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذا الإشعار؟' : 'Are you sure you want to delete this notification?' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm border-0 px-2 py-1.5 fw-semibold d-flex align-items-center justify-content-center" 
                                            style="font-size: 0.78rem; border-radius: 8px; background-color: rgba(239, 68, 68, 0.08); color: #ef4444; width: 32px; height: 32px; transition: all 0.2s;" 
                                            title="{{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}"
                                            onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.15)'"
                                            onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.08)'">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="p-4 d-flex justify-content-center border-top">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- JS Helper to mark single notification as read on click -->
    <script>
        function markAndRedirect(notificationId, targetUrl) {
            axios.post(`/notifications/${notificationId}/read`)
                .then(() => {
                    window.location.href = targetUrl;
                })
                .catch(() => {
                    window.location.href = targetUrl;
                });
        }
    </script>
</x-app-layout>
