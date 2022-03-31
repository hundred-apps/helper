<?php

if (! function_exists('searchable'))
{
    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param string $context
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    function searchable(\Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query, $column, $context)
    {
        if ($column != null && $context != null) $query = $query->where($column, 'like', '%' . $context . '%');

        return $query;
    }
}