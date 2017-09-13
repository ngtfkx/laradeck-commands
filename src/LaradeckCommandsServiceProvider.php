<?php

namespace Ngtfkx\Laradeck\Commands;

use Illuminate\Support\ServiceProvider;

class LaradeckCommandsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        DownloadCommand::class,
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}