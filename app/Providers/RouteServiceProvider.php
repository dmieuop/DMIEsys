<?php

namespace App\Providers;

use App\Http\Middleware\HomeRedirect;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dmiesys/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(base_path('routes/dmiesys/api.php'));

            Route::middleware('web', 'throttle:10,1', ProtectAgainstSpam::class)
                ->group(base_path('routes/web.php'));

            Route::middleware('web', 'throttle:20,1', HomeRedirect::class, ProtectAgainstSpam::class)
                ->name('home.')
                ->prefix('pages')
                ->group(base_path('routes/home/web.php'));

            Route::middleware('web', 'auth', 'throttle:50,1', ProtectAgainstSpam::class)
                ->prefix('dmiesys')
                ->group(base_path('routes/dmiesys/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
