<?php

namespace Filter;

use Illuminate\Database\Eloquent\Builder;

interface NodeFilter
{
    public function handle(Builder $query, $input): Builder;
}
