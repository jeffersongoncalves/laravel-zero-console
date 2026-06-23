<?php

use JeffersonGoncalves\LaravelZero\Console\Tests\Stubs\ApiErrorsStub;

beforeEach(function () {
    $this->stub = new ApiErrorsStub;
});

it('returns the callback int result on success', function () {
    expect($this->stub->callHandleApiErrors(fn () => 42))->toBe(42);
});

it('defaults to SUCCESS when the callback returns null', function () {
    expect($this->stub->callHandleApiErrors(fn () => null))->toBe(ApiErrorsStub::SUCCESS);
});

it('returns FAILURE and prints the error message when the callback throws', function () {
    $result = $this->stub->callHandleApiErrors(function () {
        throw new RuntimeException('boom');
    });

    expect($result)->toBe(ApiErrorsStub::FAILURE)
        ->and($this->stub->buffer->fetch())->toContain('boom');
});
