# Laravel Database Queries Counter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lucasdotvin/laravel-database-queries-counter.svg?style=flat-square)](https://packagist.org/packages/lucasdotvin/laravel-database-queries-counter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lucasdotvin/laravel-database-queries-counter/run-tests?label=tests)](https://github.com/lucasdotvin/laravel-database-queries-counter/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/lucasdotvin/laravel-database-queries-counter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/lucasdotvin/laravel-database-queries-counter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lucasdotvin/laravel-database-queries-counter.svg?style=flat-square)](https://packagist.org/packages/lucasdotvin/laravel-database-queries-counter)

This package provides a simple way to check how many queries a test suite has performed.

> It is important to keep in mind that merely controlling how many queries you perform on the database is not enough to ensure your application has a good performance. This package does not intend to do it, instead, it is thought to help you prevent common mistakes (like N+1 queries).

## Installation

You can install the package via composer:

```bash
composer require lucasdotvin/laravel-database-queries-counter --dev
```

You can publish the traits if you want to extend them:

```bash
php artisan vendor:publish --tag="laravel-database-queries-counter-traits"
```

## Usage

Add the `CountsQueries` trait to your test suite class to access the package methods, like `startCountingQueries`, `stopCountingQueries`, and `assertDatabaseQueriesCount`, as demonstrated below, where we assert that an index route does not perform N+1 queries to load the posts from a blog:

```php
<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use LucasDotVin\DBQueriesCounter\Traits\CountsQueries;
use Tests\TestCase;

class PostTest extends TestCase
{
    use CountsQueries;

    public function testIndexPageDoesNotPerfomNPlusOneQueries()
    {
        Post::factory()->times(10)->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->startCountingQueries();

        $response = $this->get(route('posts.index'));

        $this->stopCountingQueries();

        $response->assertSuccessful();
        $this->assertDatabaseQueriesCount(1);
    }
}
```

You can also use the method `whileCountingQueries` to avoid having to control when to start and stop counting queries, as below, where we refactor the example above:

```php
    public function testIndexPageDoesNotPerfomNPlusOneQueries()
    {
        Post::factory()->times(10)->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->whileCountingQueries(fn () => $this->get(route('posts.index')));

        $response->assertSuccessful();
        $this->assertDatabaseQueriesCount(1);
    }
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lucas Vinicius](https://github.com/lucasdotvin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
