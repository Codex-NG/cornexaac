<?php

return [
	
	/*
	|--------------------------------------------------------------------------
	| Distro version
	|--------------------------------------------------------------------------
	|
	| 
	*/

	'distro_version' => 'tfs10',

	/*
	|--------------------------------------------------------------------------
	| Server IP
	|--------------------------------------------------------------------------
	|
	| 
	*/

	'server_ip' => 'shadowcores.twifysoft.net',

	/*
	|--------------------------------------------------------------------------
	| Server Port
	|--------------------------------------------------------------------------
	|
	| 
	*/

	'server_port' => 7171,

	/*
	|--------------------------------------------------------------------------
	| Timezone
	|--------------------------------------------------------------------------
	|
	| Used by Carbon to get times, to se supported timezones please visit:
	| http://php.net/manual/en/timezones.php
	|
	*/

	'timezone' => 'Europe/Stockholm',

	/*
	|--------------------------------------------------------------------------
	| Currently CornexAAC version
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/
	
	'version' => '0.7.2',

	/*
	|--------------------------------------------------------------------------
	| Development mode
	|--------------------------------------------------------------------------
	|
	| If set to true, we will load config values from config/local, logs from core/logs/local 
	|
	*/

	'development' => false,

	/*
	|--------------------------------------------------------------------------
	| Application variables
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/
	
	'app_variables' => [
		'session'     => App\Classes\Session::class,
		'errors'      => App\Classes\Error::class,
		'formtoken'   => App\Classes\Formtoken::class,
		'AACAccount'  => App\Classes\Account::class,
		'AACPlayer'   => App\Classes\Player::class,
		'capsule'     => Illuminate\Database\Capsule\Manager::class,
		'ThemeLoader' => App\Classes\ThemeLoader::class,
		'shop'        => App\Classes\Shop::class,
		'paypal'      => App\Classes\Paypal::class,
		'admin'       => App\Classes\Admin::class,
		'news'        => App\Classes\News::class,
		'captcha'     => App\Classes\Captcha::class,
		'validator'   => App\Classes\Validator::class,
		'forum'       => App\Classes\Forum::class,
		'forumboard'  => App\Classes\ForumBoard::class,
		'forumpost'   => App\Classes\ForumPost::class,
		'http'        => App\Classes\Http::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Distro variables
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'distro_variables' => [
		'account'     => Account::class,
		'character'   => Character::class,
		'highscore'   => Highscore::class,
		'online'      => Online::class,
		'guild'       => Guild::class,
		'GuildMember' => GuildMember::class,
		'death'       => Death::class,
	]

];