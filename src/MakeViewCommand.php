<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
    protected $signature = 'laradeck:view {name}';

    protected $description = 'Make view';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $viewName = $this->argument('name');

        $viewPath = resource_path('views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $viewName) . '.blade.php');

        $directory = dirname($viewPath);

        if (!is_dir($directory)) {
            \File::makeDirectory($directory, 0755, true);
        }

        if (file_exists($viewPath)) {
            $this->error('View already exists!');
        } else {
            \File::put($viewPath, '');
            $this->info('View created successfully.');
        }
    }
}
