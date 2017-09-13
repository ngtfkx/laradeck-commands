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

        $fileNameWithPath = resource_path('views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $viewName) . '.blade.php');

        $path = dirname($fileNameWithPath);

        if (!is_dir($path)) {
            \File::makeDirectory($path, 0755, true);
        }

        \File::put($fileNameWithPath, '');

        $this->info('Success');
    }
}
