<?php

namespace Summergeorge\GitBookLib;

use Summergeorge\GitBookLib\Facades\GitBookLib;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/config/book.php' => config_path('book.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/Resources' => base_path('resources/views/vendor/gitbook'),
        ], 'migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gitbooklib', function () {
            return new GitBookLib();
        });
        $this->mergeConfigFrom(
            __DIR__.'/config/book.php', 'book'
        );
//        $this->app['gitbooklib'] = $this->app->share(function ($app) {
//            return new GitBookLib();
//        });
    }

    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['gitbooklib'];
    }
}
