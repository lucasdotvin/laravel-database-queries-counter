<?php

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\ExpectationFailedException;

it('can register an event listener', function () {
    $eventDispatcher = DB::getEventDispatcher();

    expect($eventDispatcher->hasListeners(QueryExecuted::class))->toBeFalse();

    $this->startCountingQueries();

    expect($eventDispatcher->hasListeners(QueryExecuted::class))->toBeTrue();
});

it('can count an event dispatch', function () {
    $eventDispatcher = DB::getEventDispatcher();

    $this->startCountingQueries();

    expect($this->getQueryCount())->toBe(0);

    $eventDispatcher->dispatch(QueryExecuted::class);
    expect($this->getQueryCount())->toBe(1);
});

it('can stop counting event dispatches', function () {
    $eventDispatcher = DB::getEventDispatcher();

    $this->startCountingQueries();

    expect($this->getQueryCount())->toBe(0);

    $eventDispatcher->dispatch(QueryExecuted::class);
    expect($this->getQueryCount())->toBe(1);

    $this->stopCountingQueries();

    $eventDispatcher->dispatch(QueryExecuted::class);
    expect($this->getQueryCount())->toBe(1);
});

it('can assert about event dispatches', function () {
    $eventDispatcher = DB::getEventDispatcher();

    $this->startCountingQueries();

    $this->assertDatabaseQueriesCount(0);

    $eventDispatcher->dispatch(QueryExecuted::class);
    $this->assertDatabaseQueriesCount(1);

    $this->assertDatabaseQueriesCount(2);
})->throws(ExpectationFailedException::class, 'Failed asserting that 1 matches expected 2.');

it('can count an event dispatch with a callback and return its result', function () {
    $eventDispatcher = DB::getEventDispatcher();

    expect($this->getQueryCount())->toBe(0);

    $receivedResult = $this->whileCountingQueries(function () use ($eventDispatcher) {
        $eventDispatcher->dispatch(QueryExecuted::class);

        return true;
    });

    expect($this->getQueryCount())->toBe(1);
    expect($receivedResult)->toBeTrue();
});

it('stops counting event dispatches after run the given callback', function () {
    $eventDispatcher = DB::getEventDispatcher();

    expect($this->getQueryCount())->toBe(0);

    $this->whileCountingQueries(fn () => $eventDispatcher->dispatch(QueryExecuted::class));

    expect($this->getQueryCount())->toBe(1);

    $eventDispatcher->dispatch(QueryExecuted::class);
    expect($this->getQueryCount())->toBe(1);
});
