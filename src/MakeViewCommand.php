<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeViewCommand extends Command
{
    protected $signature = 'laradeck:view 
                            {name : View name with dot syntax} 
                            {--F|force : Rewrite exists view} 
                            {--extends= : Extends directive} 
                            {--section=* : Section directive} 
                            {--stack=* : Push directive} 
                            {--component=* : Component directive}
                            ';

    protected $description = 'Create a new view';

    /**
     * @var string
     */
    protected $view;

    /**
     * @var bool
     */
    protected $force;

    /**
     * @var string
     */
    protected $extends;

    /**
     * @var array
     */
    protected $sections;

    /**
     * @var array
     */
    protected $stacks;

    /**
     * @var array
     */
    protected $components;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->view = $this->argument('name');

        $this->force = $this->option('force');

        $this->extends = $this->option('extends');

        $this->sections = $this->parse($this->option('section'));

        $this->stacks = $this->parse($this->option('stack'));

        $this->components = $this->parse($this->option('component'));

        $path = $this->path();

        $content = $this->content();

        $this->create($path, $content);
    }

    /**
     * Get path of view file and create directories for it
     *
     * @return string
     */
    protected function path(): string
    {
        $path = resource_path('views' . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $this->view) . '.blade.php');

        $directory = dirname($path);

        if (!is_dir($directory)) {
            \File::makeDirectory($directory, 0755, true);
        }

        return $path;
    }

    /**
     * Generate content of a view
     *
     * @return string
     */
    protected function content(): string
    {
        $content = '';

        if ($this->extends) {
            $content .= "@extends('" . $this->extends . "')";
        }

        $types = [
            'section' => $this->sections,
            'component' => $this->components,
            'push' => $this->stacks,
        ];

        foreach ($types as $key => $values) {
            $content .= $this->blocks($key, $values);
        }

        return $content;
    }

    /**
     * Write content to a view
     *
     * @param string $path
     * @param string $content
     */
    protected function create(string $path, string $content)
    {
        if ($this->force || !file_exists($path)) {
            \File::put($path, $content);
            $this->info('View created successfully.');
        } else {
            $this->error('View already exists!');
        }
    }

    /**
     * @param $value
     * @return array
     */
    protected function parse($value): array
    {
        $values = [];

        foreach ($value as $item) {
            if (Str::contains($item, ',')) {
                $values = array_merge($values, explode(',', $item));
            } else {
                $values[] = $item;
            }
        }

        return $values;
    }

    /**
     * @param $name
     * @param $type
     * @return string
     */
    protected function block($name, $type): string
    {
        $content = PHP_EOL . PHP_EOL . "@" . $type . "('" . $name . "')" . PHP_EOL;
        $content .= "@end" . $type;

        return $content;
    }

    /**
     * @param string $key
     * @param array $values
     * @return string
     */
    protected function blocks(string $key, array $values): string
    {
        $content = '';

        foreach ($values as $item) {
            $content .= $this->block($item, $key);
        }

        return $content;
    }
}
