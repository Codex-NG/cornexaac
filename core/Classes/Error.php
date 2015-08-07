<?php namespace App\Classes;

class Error {

	private static $ERROR_TOKEN = "CornexAACErrorSession";

	/**
	 * Set the session and give it a value
	 *
	 * @param string integer $message
	 * @return void
	 */
	public function set($message)
	{
		$_SESSION[self::$ERROR_TOKEN] = $message;
	}

	/**
	 * Check if the session has been set or not
	 *
	 * @return boolean
	 */
	public function has()
	{
		if (isset($_SESSION[self::$ERROR_TOKEN])) {
			return true;
		}

		return false;
	}

	/**
	 * Get the session value by key
	 * 
	 * @return mixed
	 */
	public function get()
	{
		if ($this->has()) {
			$value = $_SESSION[self::$ERROR_TOKEN];
			
			$this->destroy();

			return $value;
		}

		return false;
	}

	/**
	 * Destroy the session
	 *
	 * @return void
	 */
	public function destroy()
	{
		unset($_SESSION[self::$ERROR_TOKEN]);
	}

}