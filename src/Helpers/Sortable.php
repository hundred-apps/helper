<?php

use Illuminate\Support\Str;

if (! function_exists('sortable'))
{
    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param string $columns
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    function sortable(\Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query, $columns)
    {
        if ($columns != null) {

            $columns = Str::of($columns)->explode(',')->map(function ($value) {

                $sort = Str::of($value)->explode(':');
                $by = $sort->get(0);
                $direction = $sort->get(1);

                return
                [
                    'by' => $by,
                    'direction' => Str::lower($direction) === 'asc' || Str::lower($direction) === 'desc' ? $direction : 'asc',
                ];

            })->toArray();

            foreach ($columns as $column) {

                $query = $query->orderBy($column['by'], $column['direction']);
            }
        }

        return $query;
    }
}