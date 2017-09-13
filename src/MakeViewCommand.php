<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeViewCommand extends Command
{
    protected $signature = 'laradeck:view {name} {--force} {--extends=} {--section=*} {--stack=*} {--component=*}';

    protected $description = 'Make view';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $view = $this->argument('name');

        $force = $this->option('force');

        $extends = $this->option('extends');

        $sections = $this->parse($this->option('section'));

        $stacks = $this->parse($this->option('stack'));

        $components = $this->parse($this->option('component'));

        $path = $this->path($view);

        $content = $this->content($extends, $sections, $stacks, $components);

        $this->create($path, $content, $force);
    }

    protected function path(string $view): string
    {
        $path = resource_path('views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.blade.php');

        $directory = dirname($path);

        if (!is_dir($directory)) {
            \File::makeDirectory($directory, 0755, true);
        }

        return $path;
    }

    protected function parse($value): array
    {
        $values = [];

        foreach($value as $item) {
            if(Str::contains($item, ',')) {
                $values = array_merge($values, explode(',', $item));
            } else {
                $values[] = $item;
            }
        }

        return $values;
    }

    protected function content($extends, $sections, $stacks, $components): string
    {
        $content = '';

        if ($extends) {
            $content .= "@extends('" . $extends . "')";
        }

        foreach ($sections as $section) {
            $content .=  PHP_EOL . PHP_EOL . "@section('" . $section . "')" . PHP_EOL;
            $content .= "@endsection";
        }

        foreach ($components as $component) {
            $content .= PHP_EOL . PHP_EOL . "@component('" . $component . "')" . PHP_EOL;
            $content .= "@endcomponent";
        }

        foreach ($stacks as $stack) {
            $content .= PHP_EOL . PHP_EOL . "@push('" . $stack . "')" . PHP_EOL;
            $content .= "@endpush";
        }

        return $content;
    }

    protected function create(string $path, string $content, bool $force)
    {
        if ($force || !file_exists($path)) {
            \File::put($path, $content);
            $this->info('View created successfully.');
        } else {
            $this->error('View already exists!');
        }
    }
}
