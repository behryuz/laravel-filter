<?php

namespace Filter\Tests\Fixtures;

use Filter\NodeFilter;
use Illuminate\Database\Eloquent\Builder;

class StatusNodeFilter implements NodeFilter
{
    public function handle(Builder $query, $input): Builder
    {
        return $query->whereIn('status', (array) $input);
    }
}
