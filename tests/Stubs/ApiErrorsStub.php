<?php

namespace JeffersonGoncalves\LaravelZero\Console\Tests\Stubs;

use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use JeffersonGoncalves\LaravelZero\Console\HandlesApiErrors;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ApiErrorsStub extends Command
{
    use HandlesApiErrors;

    public BufferedOutput $buffer;

    public function __construct()
    {
        parent::__construct();

        $this->buffer = new BufferedOutput;
        $style = new OutputStyle(new ArrayInput([]), $this->buffer);
        $this->setOutput($style);
        $this->components = new Factory($style);
    }

    public function callHandleApiErrors(callable $callback): int
    {
        return $this->handleApiErrors($callback);
    }
}
