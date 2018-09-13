<?php

namespace Long\Youzan;

use Illuminate\Support\ServiceProvider;
use Long\Youzan\Open\Client;

/**
 * Class YouzanProvider
 * @package Long\Youzan
 */
class YouzanProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('youzan.php'),
        ], 'config');
    }

    
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client();
        });

        // Client 配置别名 
        $this->app->alias(Client::class, 'youzan');
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [Client::class, 'youzan'];
    }
}
