<?php 
Route::get("account/demo", [
    "as"            => "demo",
    "uses"          => "PagesController@demo",
    "middlewares"   => [],
]);
