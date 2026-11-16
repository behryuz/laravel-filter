<?php

namespace Filter\Tests\Fixtures;

use Filter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Filterable;

    protected $table = 'items';
    protected $guarded = [];
    public $timestamps = false;
}
