<?php

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
date_default_timezone_set(config('app', 'timezone'));
include ROOT_PATH.'/core/bootstrap/eloquent.php';
include ROOT_PATH.'/core/migrations.php';
include ROOT_PATH.'/core/validator.php';
include ROOT_PATH.'/core/middleware.php';
session_start();


App\Classes\Validator::renamed(config('validator', 'attributes'));
App\Classes\Validator::setMessages(config('validator', 'messages'));

/**
* Make sure the paginator has somewhere to grab 
* pages from
*/
Illuminate\Pagination\Paginator::currentPageResolver(function()
{
    return (isset($_GET['page'])) ? $_GET['page'] : false ;
});

// Boot the Application
$app = new App\Classes\Application();
$app->boot();

/*
|--------------------------------------------------------------------------
| Other includes
|--------------------------------------------------------------------------
|
| .....
|
*/

include DISTRO_PATH.config('app', 'distro_version').'/helpers.php';
include DISTRO_PATH.config('app', 'distro_version').'/post-requests/requests.php';

if (file_exists(theme('plugin/index.php'))) {
    include theme('plugin/index.php');
}
