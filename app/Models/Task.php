<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Searchable;
use App\Traits\FilterableByCompletion;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    use SoftDeletes, Searchable, FilterableByCompletion;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        $clearCache = function ($task) {
            if ($task->user_id) {
                Cache::forget("dashboard_stats_user_{$task->user_id}");
            }
        };

        static::saved($clearCache);
        static::deleted($clearCache);
        static::restored($clearCache);
    }

    /**
     * Columns that can be searched.
     */
    protected $searchable = ['title'];

    // اختياري: إذا كان اسم الحقل مختلفاً عن 'completed'
    // protected $completedColumn = 'completed'; 


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'note',
        'status',
        'completed_at',
        'user_id', 
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Check if task is completed
     */
    // استخدمنا getCompletedAttribute() بدلاً من @if($task->status === 'completed') @endif في الـ blade
    
    public function getCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories associated with this task.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
