<?php

namespace App\Providers;

use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public const HOME = '/home';
    protected $namespace = null;


    public function boot(): void
    {
        RateLimiter::for('api', static function (Request $request) {
            return [
                Limit::perMinute(50)->by($request->ip()),
                Limit::perSecond(2)->by($request->ip()),
            ];
        });

        Route::middleware([ApiKeyMiddleware::class, 'throttle:api',])
            ->group(
                function () {
                    $this->generalRoutes();
                    //                    $this->accountRoutes();
                }
            );
    }

    public function generalRoutes(): void
    {
        Route::prefix('api/v1/utility/')
            ->namespace($this->namespace)
            ->group(function () {
                include base_path('routes/v1/general.php');
                include base_path('routes/v1/rokeeb.php');
            });
    }



    //    public function accountRoutes(): void
    //    {
    //        Route::middleware(['access.token'])
    //            ->prefix('api/v1/account/')
    //            ->namespace($this->namespace)
    //            ->group(function () {
    //                include base_path('routes/v1/account.php');
    //            });
    //    }
}
