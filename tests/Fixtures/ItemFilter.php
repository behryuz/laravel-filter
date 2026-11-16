<?php

namespace Filter\Tests\Fixtures;

use Filter\Filter;

class ItemFilter extends Filter
{
    protected array $filters = [
        'status' => StatusNodeFilter::class,
        'name' => NameNodeFilter::class,
    ];
}
