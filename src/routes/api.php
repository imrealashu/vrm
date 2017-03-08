<?php 
Route::get("account/demo", [
    "as"            => "demo",
    "uses"          => "TestController@demo",
    "middlewares"   => [],
]);
Route::get("contact", [
    "as"            => "contact",
    "uses"          => "PagesController@contact",
    "middlewares"   => [],
]);
Route::get("test", [
    "as"            => "test",
    "uses"          => "PagesController@test",
    "middlewares"   => [],
]);
