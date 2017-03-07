<?php namespace Listbees\VRM\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Listbees\VRM\Commands\InstallVRM;
use Listbees\VRM\Http\Middleware\VRMAuth;

class VisualRouteManagerServiceProvider extends ServiceProvider
{
    protected $vrm_namespace = 'Listbees\VRM\Http\Controllers';
    protected $commands = [
        InstallVRM::class,
    ];
    protected $migrations = [
        'database/migrations/2017_03_03_000000_create_vrm_routes_table.php',
        'database/migrations/2017_03_03_000000_create_vrm_middlewares_group_table.php',
        'database/migrations/2017_03_03_000000_create_vrm_middlewares_table.php',
        'database/migrations/2017_03_03_000000_create_vrm_controllers_table.php',
        'database/migrations/2017_03_03_000000_create_vrm_prefixes_table.php',
        'database/migrations/2017_03_03_000000_create_vrm_middlewares_vrm_routes_table.php'
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
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'vrm');

        $data = [
            __DIR__ . "/../" . $this->migrations[0] => base_path($this->migrations[0]),
            __DIR__ . "/../" . $this->migrations[1] => base_path($this->migrations[1]),
            __DIR__ . "/../" . $this->migrations[2] => base_path($this->migrations[2]),
            __DIR__ . "/../" . $this->migrations[3] => base_path($this->migrations[3]),
            __DIR__ . "/../" . $this->migrations[4] => base_path($this->migrations[4]),
            __DIR__ . "/../" . $this->migrations[5] => base_path($this->migrations[5]),
        ];

        // publish migration files
        $this->publishes($data);

        // publish style files
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/vrm')
        ], 'public');
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
            ->group(__DIR__ . '/../routes/web.php');
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
            ->group(__DIR__ . '/../routes/api.php');
    }

    private function mapVRMRoutes()
    {
        Route::namespace($this->vrm_namespace)
            ->middleware(['web', 'vrm-auth'])
            ->prefix('vrm')
            ->group(__DIR__ . '/../routes/vrm.php');
    }

    private function getNamespace()
    {
        $app = config('vrm.namespace') ? config('vrm.namespace') : 'App';

        return $app . '\Http\Controllers';
    }
}