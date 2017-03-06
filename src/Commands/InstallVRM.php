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

    protected $name = 'vrm:generate';

    protected $description = 'Generate VisualRouteManager Admin User.';

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
        $password = $this->option('password');
        if (strlen($password) < 4) return $this->info('Password is very insecure, make sure to have at-least 4 characters.');

        $data = json_encode(["hash" => Hash::make($password)]);
        if (Storage::put('vrm-password.json', $data)) {
            // delete middleware groups to prevent duplication
            VrmMiddlewaresGroup::truncate();
            // create default middleware groups [web, api]
            VrmMiddlewaresGroup::insert([['name' => 'web', 'prefix' => ''], ['name' => 'api', 'prefix' => 'api']]);
            // create default middlewares
            VrmMiddlewares::insert([['name' => 'guest'], ['name' => 'auth'], ['name' => 'auth:api'], ['name' => 'auth.basic']]);
            // create default controller
            VrmControllers::firstOrCreate(['name' => 'PagesController']);

            return $this->info('Congratulations!!! User created, you can add routes now.');
        }

        return $this->warn('Ooops!!! somthing bad happended.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['password', InputArgument::OPTIONAL, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['password', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
