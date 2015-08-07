<?php

session_start();

/*
|--------------------------------------------------------------------------
| Defines
|--------------------------------------------------------------------------
|
| ...
|
*/
define('ROOT_PATH', __DIR__);
define('DISTRO_PATH', __DIR__.'/distro/');

/*
|--------------------------------------------------------------------------
| Bootstrap loaders
|--------------------------------------------------------------------------
|
| ...
|
*/
include ROOT_PATH.'/vendor/autoload.php';
include ROOT_PATH.'/core/bootstrap/eloquent.php';
include ROOT_PATH.'/core/bootstrap/themeloader.php';
include ROOT_PATH.'/core/migrations.php';

/**
* Make sure the paginator has somewhere to grab 
* pages from
*/
Illuminate\Pagination\Paginator::currentPageResolver(function()
{
    return (isset($_GET['page'])) ? $_GET['page'] : false ;
});

$tconfig = include_once config('theme', 'themes_path').'/'.config('theme', 'theme').'/config.php';

$app = new App\Classes\Application();
$app->boot();

$app->bind('routes', new Illuminate\Routing\RouteCollection);

$app->bind('url.context', Illuminate\Http\Request::createFromBase(
    Illuminate\Http\Request::capture()
));

$app->bind('url.generator', new Illuminate\Routing\UrlGenerator($app->make('routes'), $app->make('url.context')));

if (isLoggedIn() && isset($_GET['subtopic'])) {
    if ($_GET['subtopic'] == 'logout') {
        app('account')->logout();
    }
}

/*
|--------------------------------------------------------------------------
| Other includes
|--------------------------------------------------------------------------
|
| .....
|
*/

include DISTRO_PATH.config('app', 'distro_version').'/helpers.php';

if (file_exists(theme('plugin/index.php'))) {
    include theme('plugin/index.php');
}