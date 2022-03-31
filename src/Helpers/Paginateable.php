<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (! function_exists('paginateable'))
{
    /**
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @param string $alias
     * @param array $querystring
     * @param bool $isCache
     * @param string $type
     * @return mixed
     */
    function paginateable(\Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query, $alias, $querystring, $isCache = true, $type = 'Illuminate\Pagination\LengthAwarePaginator')
    {
        $per = $alias . '_' . 'limit';
        $current = $alias . '_' . 'current_page';

        $querystr =
        [
            $per => $querystring[$per] ?? 10,
            $current => $querystring[$current] ?? 1,
        ];

        extract($querystr);

        $fn = function () use ($query, $alias, $per, $current, $type) {

            $data = null;

            if ($type === LengthAwarePaginator::class) {

                $data = $query->paginate($per, '*', $alias, $current);

            } else if ($type === CursorPaginator::class) {

                $data = $query->cursorPaginate($per, '*', $alias, $current);
            }

            return $data ? $data->appends($querystring)->toArray() : $query;
        };

        if ($isCache) {

            return Cache::remember(Auth::id().'.'.__CLASS__.'.'.__FUNCTION__.'.'.$alias.'.'.$per.'.'.$current.'.'.$type, Config::get('cache.ttl', 60), $fn);

        } else {

            return $fn();
        }
    }
}