<?php

namespace App\Providers;

use App\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel): void
    {
        if (config('app.env') === 'production') {
            $kernel->appendMiddlewareToGroup('web', 'throttle:30,1');
        }
        // \Illuminate\Support\Facades\URL::forceScheme('https');
        // Model::preventLazyLoading(!$this->app->isProduction());
        // Model::preventSilentlyDiscardingAttributes(!$this->app->isProduction());
    }
}
