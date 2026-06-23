<?php

namespace JeffersonGoncalves\LaravelZero\Console\Tests\Stubs;

class CustomStateColorsStub extends FormatsOutputStub
{
    protected function stateColors(): array
    {
        return [
            'SHIPPED' => 'magenta',
            'OPEN' => 'cyan',
        ];
    }
}
