<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'note',
        'completed',
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
            'completed' => 'boolean',
        ];
    }

    /**
     * Scope a query to search tasks by title.
     */
    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where('title', 'like', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Scope a query to only include completed tasks.
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Scope a query to only include pending (uncompleted) tasks.
     */
    public function scopePending($query)
    {
        return $query->where('completed', false);
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
