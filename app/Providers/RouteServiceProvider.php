<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $fordealNamespace = 'App\Http\Controllers\Dashboard\Fordeal';
    protected $dashboardNamespace = 'App\Http\Controllers\Dashboard';
    protected $domain;
    protected $groupMiddlewares = [
        'web',
//                'verified',
        'auth:employee,company,provider',
        'localeCookieRedirect',
        'localizationRedirect',
        'localeViewPath' ];

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    public const Dashboard = '/dashboard';

    public function __construct($app)
    {
        parent::__construct($app);
        $this->domain = config('app.url');
    }


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapWebRoutes();

        $this->mapFordealRoutes();

        $this->mapDashboardRoutes();

        $this->mapApiRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
//            ->domain($this->domain)
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::group([
//            'domain' => '{company_name}.' . $this->domain,
            'namespace' => $this->dashboardNamespace,
            'middleware' => $this->groupMiddlewares,
        ], base_path('routes/dashboard.php'));

    }

    protected function mapFordealRoutes()
    {
        Route::group([
            'fordeal.' . $this->domain,
            'prefix' => LaravelLocalization::setLocale() . '/dashboard',
            'namespace' => $this->fordealNamespace,
            'middleware' => $this->groupMiddlewares,
        ], base_path('routes/fordeal.php'));
    }
}
