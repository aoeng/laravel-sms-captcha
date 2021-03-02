<?php

namespace Aoeng\Laravel\SMS\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadConfig();
        $this->loadRoute();
    }

    public function register()
    {
        $this->app->singleton(SMS::class, function ($app) {
            return new SMS($app);
        });
        $this->app->singleton(Captcha::class, function ($app) {
            return new Captcha($app);
        });
    }

    protected function loadConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/sms.php' => config_path('sms.php'),
        ]);
    }

    protected function loadRoute()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
