<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Searchable;
use App\Traits\FilterableByCompletion;

class Task extends Model
{
    use SoftDeletes, Searchable, FilterableByCompletion;

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
