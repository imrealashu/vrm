<?php namespace Listbees\VRM\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Listbees\VRM\VrmControllers;
use Listbees\VRM\VrmMiddlewares;
use Listbees\VRM\VrmMiddlewaresGroup;
use Listbees\VRM\VrmPrefixes;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InstallVRM extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */

    protected $name = 'vrm:make';

    protected $description = 'Generate VisualRouteManager Admin Panel.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function fire()
    {
        // delete middlewares, middlewares groups to prevent duplication
        VrmMiddlewaresGroup::truncate();
        VrmMiddlewares::truncate();
        // create default middleware groups [web, api]
        VrmMiddlewaresGroup::insert([['name' => 'web', 'prefix' => ''], ['name' => 'api', 'prefix' => 'api']]);
        // create default middlewares
        VrmMiddlewares::insert([['name' => 'guest'], ['name' => 'auth'], ['name' => 'auth:api'], ['name' => 'auth.basic']]);
        // create default controller
        $controller = VrmControllers::firstOrCreate(['name' => 'PagesController']);

        if ($controller) {
            return $this->info('Congratulations!!! User created, you can add routes now.');
        }

        return $this->warn('Ooops!!! somthing bad happended.');
    }
}
