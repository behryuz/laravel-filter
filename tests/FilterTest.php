<?php

namespace Filter\Tests;

use Filter\Tests\Fixtures\Item;
use Filter\Tests\Fixtures\ItemFilter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status');
        });

        Item::create(['name' => 'alpha', 'status' => 1]);
        Item::create(['name' => 'beta', 'status' => 2]);
        Item::create(['name' => 'alphabet', 'status' => 2]);
    }

    private function names(array $query): array
    {
        $this->app->make('request')->replace($query);

        return Item::filter(ItemFilter::class)->orderBy('id')->pluck('name')->all();
    }

    public function test_no_input_returns_everything(): void
    {
        $this->assertSame(['alpha', 'beta', 'alphabet'], $this->names([]));
    }

    public function test_single_filter_is_applied(): void
    {
        $this->assertSame(['beta', 'alphabet'], $this->names(['status' => 2]));
    }

    public function test_filters_are_combined(): void
    {
        $this->assertSame(['alphabet'], $this->names(['status' => 2, 'name' => 'alpha']));
    }

    public function test_array_input_is_passed_to_node_filter(): void
    {
        $this->assertSame(['alpha', 'beta', 'alphabet'], $this->names(['status' => [1, 2]]));
    }

    public function test_empty_values_are_ignored(): void
    {
        foreach (['', 0, '0', null, 'null', []] as $empty) {
            $this->assertSame(
                ['alpha', 'beta', 'alphabet'],
                $this->names(['status' => $empty]),
                'value ' . var_export($empty, true) . ' must be ignored'
            );
        }
    }

    public function test_unknown_request_keys_are_ignored(): void
    {
        $this->assertSame(['alpha', 'beta', 'alphabet'], $this->names(['foo' => 'bar']));
    }

    public function test_scope_returns_eloquent_builder(): void
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Builder::class,
            Item::filter(ItemFilter::class)
        );
    }
}
