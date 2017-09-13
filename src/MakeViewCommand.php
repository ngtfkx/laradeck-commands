<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
    protected $signature = 'laradeck:view {name} {--force}';

    protected $description = 'Make view';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $view = $this->argument('name');

        $force = $this->option('force');

        $path = $this->path($view);

        $content = $this->content();

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

    protected function content(): string
    {
        $content = '';

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
