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
        $viewName = $this->argument('name');

        $force = $this->option('force');

        $viewPath = resource_path('views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $viewName) . '.blade.php');

        $directory = dirname($viewPath);

        if (!is_dir($directory)) {
            \File::makeDirectory($directory, 0755, true);
        }

        if ($force || !file_exists($viewPath)) {
            \File::put($viewPath, '');
            $this->info('View created successfully.');
        } else {
            $this->error('View already exists!');
        }
    }
}
