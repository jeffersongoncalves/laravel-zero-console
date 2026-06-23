<?php

namespace JeffersonGoncalves\LaravelZero\Console\Tests\Stubs;

use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use JeffersonGoncalves\LaravelZero\Console\FormatsOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class FormatsOutputStub extends Command
{
    use FormatsOutput;

    public BufferedOutput $buffer;

    public function __construct()
    {
        parent::__construct();

        $this->buffer = new BufferedOutput;
        $style = new OutputStyle(new ArrayInput([]), $this->buffer);
        $this->setOutput($style);
        $this->components = new Factory($style);
    }

    public function callRenderTable(array $headers, array $rows): void
    {
        $this->renderTable($headers, $rows);
    }

    public function callColorize(string $value, string $color): string
    {
        return $this->colorize($value, $color);
    }

    public function callStateColor(string $state): string
    {
        return $this->stateColor($state);
    }

    public function callFormatDate(?string $date, string $format = 'Y-m-d H:i'): string
    {
        return $this->formatDate($date, $format);
    }
}
