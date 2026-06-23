<?php

namespace JeffersonGoncalves\LaravelZero\Console;

/**
 * Filesystem path resolution helpers for commands.
 */
trait ResolvesPath
{
    /**
     * Resolve a path from an optional argument, falling back to the current
     * working directory. Returns the realpath when it exists, otherwise the
     * original input untouched.
     */
    protected function resolvePath(?string $argument = null): string
    {
        $path = $argument !== null && $argument !== '' ? $argument : getcwd();
        $real = realpath((string) $path);

        return $real !== false ? $real : (string) $path;
    }

    /**
     * Resolve the current working directory to its realpath.
     */
    protected function resolveCwd(): string
    {
        $cwd = getcwd();
        $real = $cwd !== false ? realpath($cwd) : false;

        return $real !== false ? $real : (string) $cwd;
    }
}
