<?php

namespace LucasDotDev\DBQueriesCounter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LucasDotDev\DBQueriesCounter\DBQueriesCounterServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            DBQueriesCounterServiceProvider::class,
        ];
    }
}
