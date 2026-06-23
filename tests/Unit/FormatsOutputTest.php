<?php

use JeffersonGoncalves\LaravelZero\Console\Tests\Stubs\CustomStateColorsStub;
use JeffersonGoncalves\LaravelZero\Console\Tests\Stubs\FormatsOutputStub;

beforeEach(function () {
    $this->stub = new FormatsOutputStub;
});

it('colorizes a value with fg tags', function () {
    expect($this->stub->callColorize('hi', 'red'))->toBe('<fg=red>hi</>');
});

it('maps known states to colors case-insensitively', function () {
    expect($this->stub->callStateColor('OPEN'))->toBe('blue')
        ->and($this->stub->callStateColor('merged'))->toBe('green')
        ->and($this->stub->callStateColor('Declined'))->toBe('red')
        ->and($this->stub->callStateColor('SUPERSEDED'))->toBe('gray')
        ->and($this->stub->callStateColor('done'))->toBe('green')
        ->and($this->stub->callStateColor('In Progress'))->toBe('yellow')
        ->and($this->stub->callStateColor('todo'))->toBe('blue');
});

it('falls back to white for unknown states', function () {
    expect($this->stub->callStateColor('whatever'))->toBe('white');
});

it('honors an overridden stateColors map', function () {
    $stub = new CustomStateColorsStub;

    expect($stub->callStateColor('shipped'))->toBe('magenta')
        ->and($stub->callStateColor('OPEN'))->toBe('cyan')
        ->and($stub->callStateColor('merged'))->toBe('white');
});

it('formats a valid date with the default format', function () {
    expect($this->stub->callFormatDate('2024-01-02 03:04:05'))->toBe('2024-01-02 03:04');
});

it('formats a valid date with a custom format', function () {
    expect($this->stub->callFormatDate('2024-01-02', 'd/m/Y'))->toBe('02/01/2024');
});

it('returns a dash for null, empty and invalid dates', function () {
    expect($this->stub->callFormatDate(null))->toBe('-')
        ->and($this->stub->callFormatDate(''))->toBe('-')
        ->and($this->stub->callFormatDate('not-a-date'))->toBe('-');
});

it('renders an info message when there are no rows', function () {
    $this->stub->callRenderTable(['Name'], []);

    expect($this->stub->buffer->fetch())->toContain('No results found.');
});

it('renders a table when rows are present', function () {
    $this->stub->callRenderTable(['Name'], [['Jeff']]);

    $output = $this->stub->buffer->fetch();

    expect($output)->toContain('Jeff')
        ->and($output)->toContain('Name');
});
