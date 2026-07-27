<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

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
