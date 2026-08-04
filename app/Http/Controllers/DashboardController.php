<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with task and admin statistics.
     */
    public function index(): View
    {
        $user = auth()->user(); // جلب المستخدم الحالي
        $userId = $user->id;

        // استخدام التخزين المؤقت لتجنب تكرار الاستعلامات عند كل تحديث
        $stats = Cache::remember("dashboard_stats_user_{$userId}", 600, function () use ($user) {
            return [
                'totalTasks' => $user->tasks()->count(),
                'completedTasks' => $user->tasks()->where('status', 'completed')->count(),
                'pendingTasks' => $user->tasks()->where('status', 'pending')->count(),
                'inProgressTasks' => $user->tasks()->where('status', 'in_progress')->count(),
                'reviewTasks' => $user->tasks()->where('status', 'review')->count(),
                'totalCategories' => Category::count(),
                'showAdminSection' => $user->can('manage categories') || $user->can('manage roles') || $user->can('manage users'),
                'totalUsers' => $user->can('manage users') ? User::count() : 0,
                'totalRoles' => $user->can('manage roles') ? Role::count() : 0,
            ];
        });

        // 3. جلب آخر مهمة مضافة للمستخدم لعرضها في قسم "الأنشطة الأخيرة" (لا نخزنها في الكاش لأنها تتغير وتعتمد على العلاقات ومحدودة بـ 1)
        $recentTasks = $user->tasks()->with('categories')->latest()->take(1)->get();

        return view('dashboard', array_merge($stats, [
            'recentTasks' => $recentTasks
        ]));
    }
}
