<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with task and admin statistics.
     */
public function index(): View
{
    $user = auth()->user(); // جلب المستخدم الحالي

    // 1. حساب إحصائيات المهام الخاصة بالمستخدم فقط
    $totalTasks = $user->tasks()->count();
    $completedTasks = $user->tasks()->where('status', 'completed')->count();
    $pendingTasks = $user->tasks()->where('status', 'pending')->count();
    $inProgressTasks = $user->tasks()->where('status', 'in_progress')->count();
    $reviewTasks = $user->tasks()->where('status', 'review')->count();
    
    // 2. حساب إجمالي التصنيفات بالنظام
    $totalCategories = Category::count();
    
    // 3. جلب آخر مهمة مضافة للمستخدم لعرضها في قسم "الأنشطة الأخيرة"
    $recentTasks = $user->tasks()->with('categories')->latest()->take(1)->get();

    // 4. صلاحيات الأقسام الإدارية الحساسة (للأدمن فقط)
    $showAdminSection = $user->can('manage categories') || $user->can('manage roles') || $user->can('manage users');
    $totalUsers = $user->can('manage users') ? User::count() : 0;
    $totalRoles = $user->can('manage roles') ? Role::count() : 0;

    // 5. إرسال كل هذه المتغيرات إلى واجهة dashboard.blade.php
    return view('dashboard', compact(
        'totalTasks', 'completedTasks', 'pendingTasks', 'inProgressTasks', 'reviewTasks', 'totalCategories', 'recentTasks',
        'showAdminSection', 'totalUsers', 'totalRoles'
    ));
}

}
