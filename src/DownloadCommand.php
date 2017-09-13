<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadCommand extends Command
{
    protected $signature = 'laradeck:download 
                            {url} 
                            {--name= : Save file with name} 
                            {--path= : Path relative storage/app}';

    protected $description = 'Download file';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->url = $this->argument('url');

        $this->file = $this->getFileName();

        $this->path = $this->getFilePath();

        $resource = fopen($this->url, 'r');

        Storage::put($this->getFileNameWithPath(), $resource);

        fclose($resource);
    }

    /**
     * @return string
     */
    protected function getFileNameWithPath(): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->file;
    }

    /**
     * @return string
     */
    protected function getFilePath(): string
    {
        return $this->option('path') ?: '';
    }

    /**
     * @return string
     */
    protected function getFileName(): string
    {
        return $this->option('name') ?: array_slice(explode('/', $this->url), -1)[0];
    }
}
