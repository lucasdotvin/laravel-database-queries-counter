<?php

namespace LucasDotVin\DBQueriesCounter;

use Illuminate\Support\ServiceProvider;

class DBQueriesCounterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Traits/' => base_path('tests/Traits'),
        ], 'laravel-database-queries-counter-traits');
    }
}
