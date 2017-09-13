<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadCommand extends Command
{
    protected $signature = 'laradeck:download {url} {--save_as=} {--path=}';

    protected $description = 'Download file';

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $file;

    /**
     * @var
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

        $this->path = $this->getPath();

        $resource = fopen($this->url, 'r');

        Storage::put($this->getFileNameWithPath(), $resource);

        fclose($resource);
    }

    protected function getFileNameWithPath(): string
    {
        return $this->path . '/' . $this->file;
    }

    protected function getPath(): string
    {
        return $this->option('path') ?: '';
    }

    protected function getFileName(): string
    {
        return $this->option('save_as') ?: array_slice(explode('/', $this->url), -1)[0];
    }
}
