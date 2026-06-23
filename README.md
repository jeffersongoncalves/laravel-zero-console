# laravel-zero-console

Reusable traits for [Laravel Zero](https://laravel-zero.com) (and plain Laravel)
commands. Extracted from real CLIs that kept copy-pasting the same helpers:
output formatting, standardized API error handling, and path resolution.

## Why

Every CLI ends up reimplementing the same chores: rendering tables that gracefully
handle empty results, colorizing status strings, formatting dates, swallowing API
exceptions into clean exit codes, and turning a `path` argument (or the cwd) into a
real filesystem path. This package ships those as small, focused traits.

## Installation

```bash
composer require jeffersongoncalves/laravel-zero-console
```

Requires PHP `^8.2` and `illuminate/console` `^11.0|^12.0`.

## Traits

### `FormatsOutput`

Use inside an `Illuminate\Console\Command` (relies on `$this->table()` and
`$this->components`).

```php
use Illuminate\Console\Command;
use JeffersonGoncalves\LaravelZero\Console\FormatsOutput;

class ListCommand extends Command
{
    use FormatsOutput;

    public function handle(): int
    {
        // Renders a table, or "No results found." when $rows is empty.
        $this->renderTable(['ID', 'State', 'Updated'], $rows);

        $this->line($this->colorize('OPEN', $this->stateColor('OPEN'))); // <fg=blue>OPEN</>
        echo $this->formatDate('2024-01-02 03:04:05');                   // 2024-01-02 03:04
        echo $this->formatDate(null);                                    // -

        return self::SUCCESS;
    }
}
```

Methods:

- `renderTable(array $headers, array $rows): void` — renders a table, or an info
  message when there are no rows.
- `colorize(string $value, string $color): string` — wraps a value in
  `<fg=color>...</>` tags.
- `stateColor(string $state): string` — case-insensitive lookup of a console color
  for a state.
- `stateColors(): array` — the state→color map. **Override it** to customize. The
  default merges pull-request states (`OPEN`, `MERGED`, `DECLINED`, `SUPERSEDED`)
  with issue-tracker states (`TODO`, `IN PROGRESS`, `DONE`).
- `formatDate(?string $date, string $format = 'Y-m-d H:i'): string` — formats a date
  string via `DateTime`; returns `-` for null/empty/invalid input.

Customizing the color map:

```php
protected function stateColors(): array
{
    return [
        'SHIPPED' => 'magenta',
        'OPEN' => 'cyan',
    ];
}
```

### `HandlesApiErrors`

```php
use JeffersonGoncalves\LaravelZero\Console\HandlesApiErrors;

class FetchCommand extends Command
{
    use HandlesApiErrors;

    public function handle(): int
    {
        return $this->handleApiErrors(function () {
            $data = $this->api->fetch(); // may throw any Throwable

            $this->renderTable(['ID'], $data);

            return self::SUCCESS;
        });
    }
}
```

- `handleApiErrors(callable $callback): int` — runs the callback; on success returns
  its int result (or `SUCCESS` when it returns null); on any `Throwable` prints the
  message via `$this->components->error()` and returns `FAILURE`.

### `ResolvesPath`

```php
use JeffersonGoncalves\LaravelZero\Console\ResolvesPath;

$path = $this->resolvePath($this->argument('path')); // realpath, or cwd when empty
$cwd  = $this->resolveCwd();                          // realpath of getcwd()
```

- `resolvePath(?string $argument = null): string` — resolves an optional argument to
  its realpath, falling back to the cwd; returns the original input when the path
  does not exist.
- `resolveCwd(): string` — the current working directory resolved to its realpath.

## Testing

```bash
composer install
composer test
```

## License

MIT
