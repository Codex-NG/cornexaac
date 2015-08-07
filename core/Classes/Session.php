<?php namespace App\Classes;

class Session {

	/**
	 * Set the session and give it a value
	 *
	 * @param string $key
	 * @param string integer $message
	 * @return void
	 */
	public function set($key, $message)
	{
		$_SESSION[$key] = $message;
	}

	/**
	 * Check if the session has been set or not
	 *
	 * @param string integer $key
	 * @return boolean
	 */
	public function has($key)
	{
		if (isset($_SESSION[$key])) {
			return true;
		}

		return false;
	}

	/**
	 * Get the session value by key
	 * 
	 * @param integer string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($this->has($key)) {
			$value = $_SESSION[$key];
			
			$this->destroy($key);

			return $value;
		}

		return false;
	}

	/**
	 * Destroy the session
	 *
	 * @param integer string $key
	 * @return void
	 */
	public function destroy($key)
	{
		unset($_SESSION[$key]);
	}

}