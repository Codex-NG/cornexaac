<?php namespace App\Classes;

class Application {

	/**
	 * Store all bindings as array
	 */
	protected static $bindings;

	/**
	 * Store all disto bindings as array
	 */
	protected static $distro;

	/**
	 * Store current instance object
	 */
	protected static $instance;

	/**
	 * Boot the application
	 *
	 * @return void
	 */
	public function boot()
	{
		self::$instance = $this;

		$this->bindApp();

		$this->bindDistro();
	}

	/**
	 * Bind all application objects to the application
	 *
	 * @return void
	 */
	public function bindApp()
	{
		$variables = config('app', 'app_variables');

		foreach ($variables as $alias => $class) {
			$this->bind($alias, $class);
		}
	}

	/**
	 * Bind all distro objects to the application
	 *
	 * @return void
	 */
	public function bindDistro()
	{
		$variables = config('app', 'distro_variables');

		foreach ($variables as $alias => $class) {
			$this->bind($alias, $class, true);
		}
	}

	/**
	 * Load the current used theme
	 *
	 * @param mixed $variables
	 * @return void
	 */
	public function loadTheme()
	{
		$this->getPageInclude(); 
		
		app('ThemeLoader')->load();
	}

	/**
	 * Bind a object to the application
	 *
	 * @param string $alias
	 * @param string $class
	 * @param boolean $distro
	 * @return App\Classes\Application
	 */
	public function bind($alias, $class, $distro = false)
	{
		if (is_object($class))
		{
			return static::$bindings[$alias] = $class;
		}

		if ($distro)
		{
			return static::$distro[$alias] = distro($class);
		}

		return static::$bindings[$alias] = $class;
	}

	/**
	 * Call binded class by alias
	 *
	 * @return object
	 */
	public function make($alias)
	{
		if (isset(static::$distro[$alias])) {
			return static::$distro[$alias];
		}

		if (! isset(static::$bindings[$alias])) {
			throw new \Exception(sprintf('Cannot find class %s', $alias));
		}

		return static::$bindings[$alias];
	}

	/**
	 * Return instance of Application
	 *
	 * @return App\Classes\Application
	 */
	public static function getInstance()
	{
		if (! (static::$instance instanceof static)) {
			return new static;
		}

		return static::$instance;
	}

	/**
	 * Return the pages
	 *
	 * @return 
	 */
	public function getPage()
	{
		return app('ThemeLoader')->renderPages();
	}

	/**
	 * Load file(s)
	 *
	 * @return void
	 */
	public function load($files)
	{
		if (! is_array($files)) return include $files;

		array_walk($files, function($file){
			include $file;
		});
	}

	/**
	 * Get all included files and load them into view
	 *
	 * @return void
	 */
	public function getPageInclude()
	{
		array_walk(config('theme', 'includements'), function($files, $url){
			if (! urlQuery($url)) return;

			$this->load($files);
		});
	}

	/**
	 * Determinate if Application is in development mode
	 *
	 * @return boolean
	 */
	public function isLocal()
	{
		return config('app', 'development', true);
	}

}
