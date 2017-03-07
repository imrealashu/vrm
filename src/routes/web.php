<?php 
Route::get("demo", [
    "as"            => "demo",
    "uses"          => "PagesController@demo",
    "middlewares"   => []
]);
