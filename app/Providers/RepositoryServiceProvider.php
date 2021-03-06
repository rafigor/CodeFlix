<?php

namespace CodeFlix\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CodeFlix\Repositories\UserRepository','CodeFlix\Repositories\UserRepositoryEloquent');
        $this->app->bind('CodeFlix\Repositories\CategoryRepository','CodeFlix\Repositories\CategoryRepositoryEloquent');
        $this->app->bind('CodeFlix\Repositories\SerieRepository','CodeFlix\Repositories\SerieRepositoryEloquent');
        $this->app->bind('CodeFlix\Repositories\VideoRepository','CodeFlix\Repositories\VideoRepositoryEloquent');

        //:end-bindings:
    }
}
