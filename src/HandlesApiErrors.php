<?php

namespace JeffersonGoncalves\LaravelZero\Console;

use Illuminate\Console\Command;

/**
 * Standardized API error handling for Laravel / Laravel Zero commands.
 *
 * Assumes `$this` is an Illuminate\Console\Command (uses `$this->components`
 * and the SUCCESS/FAILURE exit-code constants).
 *
 * @mixin Command
 */
trait HandlesApiErrors
{
    /**
     * Run a callback, catching any Throwable and reporting it as a command
     * failure.
     *
     * On success returns the callback's int return value, defaulting to
     * SUCCESS when the callback returns null. On error prints the message
     * via the error component and returns FAILURE.
     *
     * @param  callable():(int|null)  $callback
     */
    protected function handleApiErrors(callable $callback): int
    {
        try {
            $result = $callback();

            return $result ?? self::SUCCESS;
        } catch (\Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
