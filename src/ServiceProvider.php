<?php

namespace Filter;
use Filter\Commands\MakeFilter;
use Filter\Commands\MakeNodeFilter;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/filter.php' => config_path('filter.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(MakeFilter::class);
        $this->commands(MakeNodeFilter::class);
    }
}