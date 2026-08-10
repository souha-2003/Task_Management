<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Task;
use App\Observers\TaskObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Event;
use App\Events\TaskAssigned;
use App\Listeners\SendNewTaskPushNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        Event::listen(
            TaskAssigned::class,
            SendNewTaskPushNotification::class
        );

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
