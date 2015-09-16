<?php

/*
|--------------------------------------------------------------------------
| get($array, $key)
|--------------------------------------------------------------------------
|
| A nicer way to return array values by key. For example you can enter:
| $array = ['johnny' => ['username' => 'john', 'location' => 'Sweden']]; 
| by using get($array, 'johnny.username'); // returns john
|
*/
function get($array, $key) {
	if (is_null($key)) return $array;

	if (isset($array[$key])) return $array[$key];
	
	foreach (explode('.', $key) as $segment)
	{
		if ( ! is_array($array) || ! array_key_exists($segment, $array))
		{
			return null;
		}
		$array = $array[$segment];
	}

	return $array;
}

/*
|--------------------------------------------------------------------------
| config($config, $key)
|--------------------------------------------------------------------------
|
| $config expects to be the name of the config file located in config folder. 
| And $key can be used as above in the get($array, $key) function example.
|
*/
function config($config, $key = null, $real_path = false) {
	if ($real_path) {
		if (is_null($key)) return include ROOT_PATH."/config/${config}.php";

		return get(include ROOT_PATH."/config/${config}.php", $key);
	}

	if (app()->isLocal()) {
		if (is_null($key)) return include ROOT_PATH."/config/local/${config}.php";

		return get(include ROOT_PATH."/config/local/${config}.php", $key);
	}

	if (is_null($key)) return include ROOT_PATH."/config/${config}.php";

	return get(include ROOT_PATH."/config/${config}.php", $key);
}

/*
|--------------------------------------------------------------------------
| theme()
|--------------------------------------------------------------------------
|
| Returns the path to the currently used theme
|
*/
function theme($file = null) 
{
	$theme = config('theme', 'theme');

	if (! is_null($file)) {
		return config('theme', 'themes_path')."/${theme}/${file}";
	}

	return config('theme', 'themes_path')."/${theme}";
}

/*
|--------------------------------------------------------------------------
| isLoggedIn()
|--------------------------------------------------------------------------
|
| Determinate if the user is logged in or not
|
*/
function isLoggedIn() 
{
	$account = app('account');
	if ($account->check()) {
		return true;
	}

	return false;
}

/*
|--------------------------------------------------------------------------
| guest_only()
|--------------------------------------------------------------------------
|
| Place it in top of views that only is visible for guest and not loggedin users
|
*/
function guest_only() 
{
	if (isLoggedIn()) {
		header('Location: ?subtopic=myaccount'); exit;
	}
}

/*
|--------------------------------------------------------------------------
| auth_only()
|--------------------------------------------------------------------------
|
| Place it in top of views that only is visible for loggedin users and not guests
|
*/
function auth_only($action = null)
{
	if (! isLoggedIn()) {
		$url = (! is_null($action)) ? "?subtopic=login&action=$action" : "?subtopic=login";

		header("Location: $url"); exit;
	}
}

/*
|--------------------------------------------------------------------------
| vocIdToName($id)
|--------------------------------------------------------------------------
|
| Convert vocation ID to proper name
|
*/
function vocIdToName($id)
{
	return config('character', 'vocations.'.$id);
}

/*
|--------------------------------------------------------------------------
| townIdToName($id)
|--------------------------------------------------------------------------
|
| Convert town ID to proper name
|
*/
function townIdToName($id)
{
	return (isset(config('character', 'towns')[$id])) ? config('character', 'towns')[$id] : 'Unknown';
}

/*
|--------------------------------------------------------------------------
| monsterNames()
|--------------------------------------------------------------------------
|
| Returns an array of monster names from core/cache/monsters.json
| generate a new monster.json by using the special folder
|
*/
function monsterNames()
{
	return json_decode(file_get_contents(ROOT_PATH.'/core/cache/monsters.json'));
}

/*
|--------------------------------------------------------------------------
| sexIdToName($id)
|--------------------------------------------------------------------------
|
|...
|
*/
function sexIdToName($id)
{
	return config('character', 'sex.'.$id);
}

/*
|--------------------------------------------------------------------------
| guildNameToId($name)
|--------------------------------------------------------------------------
|
|...
|
*/
function guildNameToId($name)
{
	return app('guild')->where('name', $name)->first()->id;
}

/*
|--------------------------------------------------------------------------
| death_time()
|--------------------------------------------------------------------------
|
| ...
|
*/
function death_time($timestamp)
{
	return Carbon\Carbon::createFromTimeStamp($timestamp);
}

/**
 * Convert unix timestamp to readable format
 *
 * @return string
 */
function ago($timestamp)
{
	return Carbon\Carbon::createFromTimeStamp($timestamp)->diffForHumans();
}

/*
|--------------------------------------------------------------------------
| playerIdToName($pid)
|--------------------------------------------------------------------------
|
| Convert a player ID to name
|
*/
function playerIdToName($pid)
{
	$player = app('character')->where('id', $pid)->first();

	if (is_null($player)) return false;
	
	return $player->name;
}

/*
|--------------------------------------------------------------------------
| highscoreSkillToTitle($skill)
|--------------------------------------------------------------------------
|
| 
|
*/
function highscoreSkillToTitle($skill)
{
	return config('character', 'skills')[$skill][1];
}

/*
|--------------------------------------------------------------------------
| char_link($name)
|--------------------------------------------------------------------------
|
| 
|
*/
function char_link($name) {
	$name = e($name);

	return "<a href='?subtopic=character&name=${name}'>${name}</a>";
}

/**
 * Determinate if the server is offline or online.
 *
 * @return boolean
 */
if (! function_exists('status')) {
	function status() {
		@$sock = fsockopen (config('app', 'server_ip'), config('app', 'server_port'), $errno, $errstr, 1);

		return (! $sock) ? false : true;
	}
}

/**
 * Returns instance of App\Classes\Application another class
 *
 * @param namepsace $class
 * @return App\Classes\Application|object
 */
if (! function_exists('app')) {
	function app($class = null) {
		$app = App\Classes\Application::getInstance();

		if ($class) {
			$namespace = $app->make($class);
			
			return new $namespace;
		}

		return $app;
	}
}

if (! function_exists('distro')) {
	function distro($class)
	{
		$distro = config('app', 'distro_version');

		$class = sprintf("distro\%s\%s", $distro, $class);

		return $class;
	}
}

if (! function_exists('themes')) {
	function themes($class)
	{
		$theme = config('theme', 'theme');
		
		$class = sprintf("themes\%s\%s", $theme, $class);

		return $class;
	}
}

if (!function_exists('url')) {
	/**
	 * Generate a url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed   $parameters
	 * @param  bool    $secure
	 * @return string
	 */
	function url($path = null, $parameters = [], $secure = null)
	{
		$routes = new Illuminate\Routing\RouteCollection;

		$context=  Illuminate\Http\Request::createFromBase(
		    Illuminate\Http\Request::capture()
		);

		$generator = new Illuminate\Routing\UrlGenerator($routes, $context);

		return $generator->to($path, $parameters, $secure);
	}
}

function urlObj()
{
	$routes = new Illuminate\Routing\RouteCollection;

	$context=  Illuminate\Http\Request::createFromBase(
	    Illuminate\Http\Request::capture()
	);

	return new Illuminate\Routing\UrlGenerator($routes, $context);
}

/*
|--------------------------------------------------------------------------
| assets()
|--------------------------------------------------------------------------
|
| Returns a absolute url to the theme
|
*/
function assets($asset = null) 
{
	$theme = config('theme', 'theme');

	return url(config('theme', 'themes_absolute')) . "/$theme/" . $asset;
}

/**
 * 
 */
if (! function_exists('userIP')) {
	function userIP() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';


		if ($ipaddress == '::1') {
			$ipaddress = '127.0.0.1';
		}
		return $ipaddress;
	}
}

/*
|--------------------------------------------------------------------------
| guild_link($name)
|--------------------------------------------------------------------------
|
| 
|
*/
function guild_link($name) {
	$name = e($name);

	return url('?subtopic=guilds&name='. $name);
}

function back() {
	return url('?' . http_build_query($_GET));
}

function redirect($url) {
	header('Location: '. url($url)); exit;
}

function logger($data) {
	if (app()->isLocal()) {
		return error_log(date('[Y-m-d H:i e] '). $data . PHP_EOL, 3, __DIR__.'/logs/local/cornexaac.log');
	}

    error_log(date('[Y-m-d H:i e] '). $data . PHP_EOL, 3, __DIR__.'/logs/cornexaac.log');
}


if ( ! function_exists('lines'))
{
	/**
	 * Force a maximum amount of lines in a string.
	 *
	 * @param  string $string
	 * @param  integer $lines 10
	 * @return string
	 */
	function lines($string, $lines = 10)
	{
		$i = 0;
		return preg_replace_callback('/\\r\\n/i', function($value) use(&$i, $lines)
		{
			if ((++$i) > $lines)
			{
				return null;
			}
			return head($value);	
		}, $string);
	}
}

function urlQuery($query) 
{
    $pattern = preg_replace('/{(.*?)}/i', '(.+)', $query);

    return (boolean) preg_match('/^'.$pattern.'$/i', http_build_query($_GET));
}

function request($file)
{
	return DISTRO_PATH.config('app', 'distro_version')."/post-requests/${file}.php";
}