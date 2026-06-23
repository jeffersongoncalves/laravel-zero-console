<?php

namespace JeffersonGoncalves\LaravelZero\Console;

/**
 * Output formatting helpers for Laravel / Laravel Zero commands.
 *
 * Assumes `$this` is an Illuminate\Console\Command (uses `$this->table()`
 * and `$this->components`).
 */
trait FormatsOutput
{
    /**
     * Render a table, or an informational message when there are no rows.
     *
     * @param  array<int, string>  $headers
     * @param  array<int, array<int|string, mixed>>  $rows
     */
    protected function renderTable(array $headers, array $rows): void
    {
        if (empty($rows)) {
            $this->components->info('No results found.');

            return;
        }

        $this->table($headers, $rows);
    }

    /**
     * Wrap a value in console foreground-color tags.
     */
    protected function colorize(string $value, string $color): string
    {
        return "<fg={$color}>{$value}</>";
    }

    /**
     * Resolve a console color for a given state.
     *
     * Lookup is case-insensitive against the map returned by stateColors().
     */
    protected function stateColor(string $state): string
    {
        return $this->stateColors()[strtoupper($state)] ?? 'white';
    }

    /**
     * State -> color map. Override in the consuming command to customize.
     *
     * Default merges common pull-request states (OPEN/MERGED/DECLINED/SUPERSEDED)
     * with common issue-tracker states (TODO/IN PROGRESS/DONE).
     *
     * @return array<string, string>
     */
    protected function stateColors(): array
    {
        return [
            'OPEN' => 'blue',
            'MERGED' => 'green',
            'DECLINED' => 'red',
            'SUPERSEDED' => 'gray',
            'TODO' => 'blue',
            'TO DO' => 'blue',
            'IN PROGRESS' => 'yellow',
            'DONE' => 'green',
        ];
    }

    /**
     * Format a date string. Returns '-' for null/empty/invalid input.
     */
    protected function formatDate(?string $date, string $format = 'Y-m-d H:i'): string
    {
        if ($date === null || $date === '') {
            return '-';
        }

        try {
            return (new \DateTime($date))->format($format);
        } catch (\Exception) {
            return '-';
        }
    }
}
