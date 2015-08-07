<?php namespace App\Classes;

class ThemeLoader {

	/**
	 * Class contructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->theme = config('theme', 'theme');
	}

	/**
	 * Return the root path of the theme 
	 *
	 * @return string
	 */
	public function path()
	{
		return config('theme', 'themes_path')."/{$this->theme}";
	}

	/**
	 * Return a config value from theme
	 *
	 * @param string $key
	 * @return string
	 */
	public function config($key)
	{
		return get(include $this->path().'/config.php', $key);
	}

	/**
	 * Load the theme to view
	 *
	 * @return void
	 */
	public function load()
	{		
		$app = new Application();

		return include $this->path().'/layout.php';
	}

}