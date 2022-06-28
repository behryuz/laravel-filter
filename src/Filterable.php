<?php

namespace Filter;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, $filter): Builder
    {
        $modelFilter = new $filter($query);
        return $modelFilter->handle();
    }
}
