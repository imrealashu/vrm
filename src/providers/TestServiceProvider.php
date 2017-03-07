<?php namespace Listbees\VRM\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        dd("boot");
    }

    public function register()
    {
        dd("register");
    }
}