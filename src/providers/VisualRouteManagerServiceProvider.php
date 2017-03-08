<?php namespace Listbees\VRM\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Listbees\VRM\Commands\InstallVRM;
use Listbees\VRM\Http\Middleware\VRMAuth;

class VisualRouteManagerServiceProvider extends ServiceProvider
{
    protected $vrm_namespace = 'Listbees\VRM\Http\Controllers';
    protected $commands = [InstallVRM::class];
    protected $migrations = [
        'database/migrations/2017_03_03_000001_create_vrm_routes_table.php',
        'database/migrations/2017_03_03_000002_create_vrm_prefixes_table.php',
        'database/migrations/2017_03_03_000003_create_vrm_middlewares_table.php',
        'database/migrations/2017_03_03_000004_create_vrm_middlewares_group_table.php',
        'database/migrations/2017_03_03_000005_create_vrm_controllers_table.php',
        'database/migrations/2017_03_03_000006_create_vrm_middlewares_vrm_routes_table.php'
    ];

    public function register()
    {
        // bind middleware
        $this->app->bind('vrm-auth', VRMAuth::class);

        // register command
        $this->commands($this->commands);
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapVRMRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        // loading views
        $this->loadViewsFrom($this->getPackagePath() . 'resources/views', 'vrm');

        // publish migration files
        $this->publishes([
            $this->getPackagePath() . $this->migrations[0] => base_path($this->migrations[0]),
            $this->getPackagePath() . $this->migrations[1] => base_path($this->migrations[1]),
            $this->getPackagePath() . $this->migrations[2] => base_path($this->migrations[2]),
            $this->getPackagePath() . $this->migrations[3] => base_path($this->migrations[3]),
            $this->getPackagePath() . $this->migrations[4] => base_path($this->migrations[4]),
            $this->getPackagePath() . $this->migrations[5] => base_path($this->migrations[5]),
        ]);

        // publish style files
        $this->publishes([
            $this->getPackagePath() . 'resources/assets' => public_path('vendor/vrm')
        ], 'public');

        // publish config file
        $this->publishes([
            $this->getPackagePath() . 'config/vrm.php' => base_path('config/vrm.php')
        ]);
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
        Route::namespace($this->getNamespace())
            ->middleware('web')
            ->prefix(null)
            ->group($this->getPackagePath() . 'routes/web.php');
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
        Route::namespace($this->getNamespace())
            ->middleware('api')
            ->prefix('api')
            ->group($this->getPackagePath() . 'routes/api.php');
    }

    protected function mapVRMRoutes()
    {
        Route::namespace($this->vrm_namespace)
            ->middleware(['web', 'vrm-auth'])
            ->prefix(config('vrm.path'))
            ->group($this->getPackagePath() . 'routes/vrm.php');
    }

    protected function getNamespace()
    {
        $app = config('vrm.namespace') ? config('vrm.namespace') : 'App';

        return $app . '\Http\Controllers';
    }

    protected function getPackagePath()
    {
        return __DIR__ . "/../";
    }
}