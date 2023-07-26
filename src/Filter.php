<?php

namespace Filter;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    protected array $filters;
    private Builder $query;
    private array $input;

    public function __construct(Builder $query)
    {
        $this->query = $query;
        $received_filters = $this->receivedFilters();
        $this->input = $this->removeEmptyInput($received_filters);
    }

    public function handle(): Builder
    {
        foreach ($this->input as $name => $value) {
            $filterInstance = new $this->filters[$name];
            $this->query = $filterInstance->handle($this->query, $value);
        }

        return $this->query;
    }

    public function receivedFilters(): array
    {
        return request()->only(array_keys($this->filters));
    }

    /**
     * Remove empty strings from the input array.
     *
     * @param $input
     * @return array
     */
    public function removeEmptyInput($input): array
    {
        $filterableInput = [];

        foreach ($input as $key => $val) {
            if ($this->includeFilterInput($key, $val)) {
                $filterableInput[$key] = $val;
            }
        }

        return $filterableInput;
    }

    // TODO:: empty method helper
    protected function includeFilterInput($key, $value): bool
    {
        return $value != ''
            && $value != 0
            && $value != null
            && $value != 'null'
            && !(is_array($value) && empty($value));
    }
}
