<?php

namespace LucasDotDev\DBQueriesCounter\Tests;

use LucasDotDev\DBQueriesCounter\DBQueriesCounterServiceProvider;
use LucasDotDev\DBQueriesCounter\Traits\CountsQueries;
use Orchestra\Testbench\TestCase as Orchestra;

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
