<?php namespace Listbees\VRM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Listbees\VRM\Http\Requests\AddRouteRequest;
use Listbees\VRM\Http\Testing;
use Listbees\VRM\VrmMiddlewares;
use Listbees\VRM\VrmControllers;
use Listbees\VRM\VrmPrefixes;
use Listbees\VRM\VrmRoutes;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $controller_id = ($request->controller_id) ? $request->controller_id : 1;
        $middlewares_group_id = ($request->middlewares_group_id) ? $request->middlewares_group_id : 1;

        $routes = VrmRoutes::with('controller', 'middlewares', 'prefix')
            ->where(['controller_id' => $controller_id, 'middlewares_group_id' => $middlewares_group_id])
            ->get();

        $controllers = VrmControllers::get(['id', 'name']);
        $middlewares = VrmMiddlewares::get(['id', 'name']);
        $prefixes = VrmPrefixes::get(['id', 'name']);

        return view('vrm::home', compact('routes', 'controllers', 'middlewares', 'prefixes', 'controller_id', 'middlewares_group_id'));
    }

    public function delete(Request $request)
    {
        $route = VrmRoutes::find($request->id);
        $this->updateRouteFile($route, 'delete');

        return $route->delete() ? response(['success' => true], 200) : response(['success' => false], 400);
    }

    public function store(AddRouteRequest $request)
    {
        $data = $request->all();
        $path = (count($data["prefix"]) && $data["prefix"]["id"] > 0) ? $data["prefix"]["name"] . "/" . trim($data["path"], "/") : trim($data["path"], "/");
        $type = isset($data["id"]) ? "edit" : "create";

        // add routes detail
        $route = ($type == "edit") ? VrmRoutes::find($data["id"]) : new VrmRoutes();
        $route->middlewares_group_id = $data["middlewares_group_id"];
        $route->namespace = $data["namespace"];
        $route->path = trim($data["path"], "/");
        $route->full_path = $path;
        $route->prefix_id = count($data["prefix"]) ? $data["prefix"]["id"] : 0;
        $route->controller_id = $data["controller"]["id"];
        $route->action = $data["action"];
        $route->method = $data["method"];
        $route->as = $data["as"];
        $route->save();

        // attach middleware to routes in pivot table
        VrmRoutes::find($route["id"])->middlewares()->detach();
        VrmRoutes::find($route["id"])->middlewares()->attach($data['middleware_ids']);
        $routeToFile = VrmRoutes::with('controller', 'middlewares', 'prefix', 'group')
            ->where(['id' => $route["id"]])
            ->first();

        $this->updateRouteFile($routeToFile, $type);
        return $route ? response(['success' => true], 200) : response(['success' => false], 400);
    }

    public function addRouteData(Request $request)
    {
        $type = $request->get('type');
        $value = $request->get('value');

        $classes = [
            'Middlewares' => new VrmMiddlewares(),
            'Prefix' => new VrmPrefixes(),
            'Controller' => new VrmControllers()
        ];

        $data = (new $classes[$type])->firstOrCreate(['name' => $value]);
        return response(['result' => $data]);
    }

    public function updateRouteFile($route, $type = 'create')
    {
        $id = $route->id;
        $file_name = "{$route->group['name']}.php";
        $file_path = __DIR__ . "/../../routes/$file_name";
        $file_contents = File::get($file_path);
        $stringToWrite = ($type == 'delete') ? "" : $this->getTemplate($route);

        if ($type == 'create') {
            $data = $stringToWrite;
            File::append($file_path, $data);
        } else {
            preg_match("/#route_start_$id((.|\s)+?)#route_end_$id/", $file_contents, $match);
            $data = str_replace($match[0], $stringToWrite, $file_contents);
            File::put($file_path, $data);
        }
    }

    protected function getTemplate($route)
    {
        $view = view('vrm::route_file_design', ['route' => $route])->render();
        return str_replace("&quot;", '"', "\n#route_start_$route->id\n$view\n#route_end_$route->id\n");
    }
}