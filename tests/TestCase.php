<?php

namespace LucasDotDev\DBQueriesCounter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LucasDotDev\DBQueriesCounter\DBQueriesCounterServiceProvider;
use LucasDotDev\DBQueriesCounter\Traits\CountsQueries;

class TestCase extends Orchestra
{
    use CountsQueries;

    protected function getPackageProviders($app)
    {
        return [
            DBQueriesCounterServiceProvider::class,
        ];
    }
}
