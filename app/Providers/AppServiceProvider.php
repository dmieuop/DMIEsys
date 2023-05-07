<?php

namespace App\Providers;

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
    public function boot(): void
    {
        // \Illuminate\Support\Facades\URL::forceScheme('https');
        // Model::preventLazyLoading(!$this->app->isProduction());
        // Model::preventSilentlyDiscardingAttributes(!$this->app->isProduction());
    }
}
