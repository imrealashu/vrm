<?php

Route::get('login', [
    'as' => 'vrm-login',
    'uses' => 'AccountController@login'
]);

Route::post('login', [
    'as' => 'vrm-process-login',
    'uses' => 'AccountController@processLogin'
]);

Route::get('logout', [
    'as' => 'vrm-logout',
    'uses' => 'AccountController@logout'
]);

Route::get('/', [
    'as' => 'vrm-home',
    'uses' => 'HomeController@home'
]);

Route::get('create', [
    'as' => 'vrm-create',
    'uses' => 'HomeController@create'
]);

Route::post('create', [
    'as' => 'vrm-store',
    'uses' => 'HomeController@store'
]);

Route::post('delete', [
    'as' => 'vrm-delete',
    'uses' => 'HomeController@delete'
]);

Route::post('route-data/add', [
    'as' => 'vrm-add-route-data',
    'uses' => 'HomeController@addRouteData'
]);

Route::post('controller/add', [
    'as' => 'vrm-add-controller',
    'uses' => 'HomeController@addController'
]);