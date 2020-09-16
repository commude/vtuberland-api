<?php

namespace App\Models\Traits;

trait ScopeTrait
{

    /**
     * Scope a query to search for value.
     * If this query is slow, remove first '%' from the where clause.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $columnName
     * @param string                                $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchFor($query, $columnName, $value)
    {
        return $query->where($columnName, 'LIKE', '%'.$value.'%');
    }

    /**
     * Scope a query to search for value.
     * If this query is slow, remove first '%' from the where clause.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $columnName
     * @param string                                $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrSearchFor($query, $columnName, $value)
    {
        return $query->orWhere($columnName, 'LIKE', '%'.$value.'%');
    }

    /**
     * Scope a query to search within the foreign table.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $tableName
     * @param string                                $columnName
     * @param string                                $value
     *
     * @return mixed
     */
    public function scopeWhereHasSearchFor($query, $tableName, $columnName, $value)
    {
        if ($value || $value === 0 || $value === true) {
            return $query->whereHas($tableName, function ($query) use ($value, $columnName) {
                $query->searchFor($columnName, $value);
            });
        }

        return $query;
    }
}