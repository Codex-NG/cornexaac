<?php

$distro = ROOT_PATH.'/themes/'.strtolower(config('theme', 'theme')).'/';

/**
 * Autoloader for Theme classes, namespace Theme\CLASSNAME
 */
spl_autoload_register(function($class) use($distro)
{
	if ( ! preg_match('/^Theme\\\/i', $class))
	{
		return false;
	}

 	$class = preg_replace('/^Theme\\\/i', null, $class);

	if ( ! is_file($path = $distro.$class.'.php'))
	{
		throw new Exception($path);
	}

	include_once $path;
});