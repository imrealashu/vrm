# Visual Route Manager
Visual Route Manager is a web interface to manage your Laravel 5.* routes. 
Using VRM, you can easily add, edit, remove routes also filter them 
accordingly your needs, If your **App / website** is large scaled then it will 
help a lot to manage your routes.

It's in active development and still lack of some features like Resources and Function 
integration, and I will make it done ASAP, anyone wishes to contribute, be my guest, just 
fork it buddy and let me know when you send pull request. :)

How to use
--------------------------------------------
##### step 1
install package through composer

``
composer require listbees/vrm : 0.1.*
``

##### step 2
Add service provider into ``config/app.php``

`Listbees\VRM\Providers\VisualRouteManagerServiceProvider::class,`

##### step 3
Publish vendor files 
It will publish migrations files, config/vrm.php, assets folder to public/vendor/vrm for admin web interface 
(Additionally you can set optional fields in config file like namespace, password etc)

`php artisan vendor:publish --provider="Listbees\VRM\Providers\VisualRouteManagerServiceProvider"`

##### step 3
Migrate tables

`php artisan migrate`

##### step 4
Install Admin Panel

`php artisan vrm:make`

##### step 5
All done, start adding your routes

`http://<your-host>/vrm`

It will prompt for login password, you can manually set password to config.php file, default password is **secret**
