<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;


class Category extends Model
{
    use SoftDeletes;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        $clearAllDashboardCache = function () {
            // جلب معرّفات جميع المستخدمين لتصفير الكاش الخاص بهم
            try {
                $userIds =User::pluck('id');
                foreach ($userIds as $id) {
                    Cache::forget("dashboard_stats_user_{$id}");
                }
            } catch (\Exception $e) {
                // تجنب حدوث خطأ إذا لم يكن جدول المستخدمين جاهزاً
                
            }
        };

        static::saved($clearAllDashboardCache);
        static::deleted($clearAllDashboardCache);
        static::restored($clearAllDashboardCache);
    }

    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Get the tasks associated with this category.
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
