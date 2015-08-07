<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
	'driver'    => config('database', 'driver'),
	'host'      => config('database', 'mysql.host'),
	'database'  => config('database', 'mysql.database'),
	'username'  => config('database', 'mysql.username'),
	'password'  => config('database', 'mysql.password'),
	'charset'   => config('database', 'mysql.charset'),
	'collation' => config('database', 'mysql.collation'),
	'prefix'    => config('database', 'mysql.prefix'),
]);

$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
