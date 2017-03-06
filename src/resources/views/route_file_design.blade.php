Route::get("{{ $route->path }}", [
    "as"            => "{{ $route->as }}",
    "uses"          => "{{ $route->controller->name ."@". $route->action }}",
    "middlewares"   => {{ $route->middlewares->pluck('name')  }}
]);