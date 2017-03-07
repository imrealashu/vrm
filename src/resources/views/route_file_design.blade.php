@foreach($routes as $route)
Route::get("{{ $route->full_path }}", [
    "as"            => "{{ $route->as }}",
    "uses"          => "{{ $route->controller->name ."@". $route->action }}",
    "middlewares"   => {{ $route->middlewares->pluck('name')  }}
]);
@endforeach