<?php

namespace JeffersonGoncalves\LaravelZero\Console\Tests\Stubs;

use JeffersonGoncalves\LaravelZero\Console\ResolvesPath;

class ResolvesPathStub
{
    use ResolvesPath;

    public function callResolvePath(?string $argument = null): string
    {
        return $this->resolvePath($argument);
    }

    public function callResolveCwd(): string
    {
        return $this->resolveCwd();
    }
}
