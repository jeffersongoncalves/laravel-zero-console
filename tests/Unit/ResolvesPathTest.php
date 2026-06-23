<?php

use JeffersonGoncalves\LaravelZero\Console\Tests\Stubs\ResolvesPathStub;

beforeEach(function () {
    $this->stub = new ResolvesPathStub;
});

it('resolves a given path to its realpath', function () {
    $dir = sys_get_temp_dir();

    expect($this->stub->callResolvePath($dir))->toBe(realpath($dir));
});

it('falls back to the cwd realpath when no argument is given', function () {
    expect($this->stub->callResolvePath())->toBe(realpath(getcwd()));
});

it('returns the original input untouched when the path does not exist', function () {
    $missing = 'this/path/does/not/exist-12345';

    expect($this->stub->callResolvePath($missing))->toBe($missing);
});

it('resolves the current working directory', function () {
    expect($this->stub->callResolveCwd())->toBe(realpath(getcwd()));
});
