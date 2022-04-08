<?php

namespace LucasDotVin\DBQueriesCounter\Tests;

use LucasDotVin\DBQueriesCounter\DBQueriesCounterServiceProvider;
use LucasDotVin\DBQueriesCounter\Traits\CountsQueries;
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
