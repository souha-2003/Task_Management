<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
