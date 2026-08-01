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
        $user = auth()->user();

        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('completed', true)->count();
        $pendingTasks = $user->tasks()->where('completed', false)->count();
        $totalCategories = Category::count();
        $recentTasks = $user->tasks()->with('categories')->latest()->take(1)->get();

        // Fine-grained admin counts based on specific permissions
        $showAdminSection = $user->can('manage categories') || $user->can('manage roles') || $user->can('manage users');
        $totalUsers = $user->can('manage users') ? User::count() : 0;
        $totalRoles = $user->can('manage roles') ? Role::count() : 0;

        return view('dashboard', compact(
            'totalTasks', 'completedTasks', 'pendingTasks', 'totalCategories', 'recentTasks',
            'showAdminSection', 'totalUsers', 'totalRoles'
        ));
    }
}
