<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope a query to search models by specified columns.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        // If the model defines a $searchable array/property, use it.
        // Otherwise, default to 'title'.
        $columns = property_exists($this, 'searchable') ? (array) $this->searchable : ['title'];

        return $query->where(function (Builder $q) use ($columns, $search) {
            foreach ($columns as $index => $column) {
                if ($index === 0) {
                    $q->where($column, 'like', '%' . $search . '%');
                } else {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            }
        });
    }
}
