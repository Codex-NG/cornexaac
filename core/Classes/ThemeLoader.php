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

		if (isset($_GET['subtopic'])) {
			if ($_GET['subtopic'] == 'adminpanel') {

				if (! app('admin')->isAdmin()) {
					redirect('?subtopic=index');
				}
				
				if (!isset($_GET['action'])) {
					redirect('?subtopic=index');
				}

				return include $this->path().'/pages/adminpanel/index.php';
			}
		}

		return include $this->path().'/layout.php';
	}

	/**
	 * Render the pages to view
	 *
	 * @return 
	 */
	public function renderPages()
	{
		if (isset($_GET['subtopic'])) {
			$subtopic = $_GET['subtopic'];

			if ($subtopic == 'adminpanel') {
				$action = $_GET['action'];

				return include theme('pages/adminpanel/'.$action.'.php');
			}

			include theme('pages/'.$subtopic.'.php');
		} else {
			include theme('pages/index.php');
		}
	}

}