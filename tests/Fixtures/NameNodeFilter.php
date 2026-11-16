<?php

namespace Filter\Tests\Fixtures;

use Filter\NodeFilter;
use Illuminate\Database\Eloquent\Builder;

class NameNodeFilter implements NodeFilter
{
    public function handle(Builder $query, $input): Builder
    {
        return $query->where('name', 'like', "%{$input}%");
    }
}
