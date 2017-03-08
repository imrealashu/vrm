<?php 
Route::get("about", [
    "as"            => "about",
    "uses"          => "PagesController@about",
    "middlewares"   => [],
]);
Route::get("demo", [
    "as"            => "demo",
    "uses"          => "TestController@demo",
    "middlewares"   => [],
]);
