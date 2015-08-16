<?php namespace distro\tfs10;

use Carbon\Carbon;

class Account extends \Illuminate\Database\Eloquent\Model {

	/**
	* Specify the table we gonna use
	*/
	protected $table = "accounts";

	/**
	* Disable timestamps
	*/
	public $timestamps = false;

	/**
	* Validate an account to make sure the entered credentials are correct.
	* As I write this sha1 is the only encryption in TFS 1.1, but as I understand
	* they will update it and use PBKDF2 OR scrypt, (This is not really 100% confirmed yet)
	* so for that we keep the $encryption parameter.
	*
	* @param mixed $name
	* @param mixed $password
	* @param string $encryption
	* @return boolean
	*/
	public function validate($name, $password) 
	{
		if (config('account', 'encryption') == 'sha1') {
			$password = sha1($password);
		}

		$validate = $this->where('name', $name)->where('password', $password)->first();

		if (is_null($validate)) {
			return false;
		}

		return true;
	}

	/**
	* Pretty much the same as validate() method, just that we in login() also
	* start a session and save the account data inside. Just because we also 
	* validate inside login() doesen't mean you should use login() to only validate a account
	*
	* @param mixed $name
	* @param mixed $password
	* @param string $encryption
	* @return mixed
	*/
	public function login($name, $password)
	{
		if (config('account', 'encryption') == 'sha1') {
			$password = sha1($password);
		}
		
		$validate = $this->where('name', $name)->where('password', $password)->first();

		if (! is_null($validate)) {
			$_SESSION[config('account', 'token')] = $validate->toArray();
			return $_SESSION[config('account', 'token')];
		}

		return false;
	}

	/**
	* Deteminate if a user is logged in or not, this method should only be used inside
	* the class since we offer an help function isLoggedIn().. But yeah, you can use this 
	* method as well ofcourse. 
	*
	* @return boolean
	*/
	public function isLoggedIn()
	{
		if (isset($_SESSION[config('account', 'token')])) {
			return true;
		}

		return false;
	}

	/**
	* Logout the currently loggedin user
	*
	* @return boolean
	*/
	public function logout()
	{
		if ($this->isLoggedIn()) {
			app('session')->set('success', 'You have been signed out.');

			unset($_SESSION[config('account', 'token')]);

			redirect('?subtopic=login');
		}

		return false;
	}

	/**
	* Get the account name of currently signed in user.
	* As you probably understand, this method can only be called when you
	* are sure the user is loggedin, for example on myaccount page or something like that. 
	* Usage: $account->getName() 
	* 
	* @return string
	*/
	public function getName()
	{
		return e($this->attributes('name'));
	}

	/**
	 * Returns the accounts total points
	 *
	 * @return integer
	 */
	public function points()
	{
		return app('AACAccount')->where('account_id', $this->attributes('id'))->first()->points;
	}

	/**
	 * Remove points from account
	 *
	 * @return void
	 */
	public function removePoints($points)
	{
		$account = app('AACAccount')->where('account_id', $this->attributes('id'))->first();

		$account->points = $account->points - $points;

		$account->save();
	}

	/**
	* Return the date and time when user created the account. This method also need, 
	* ofcourse, that the user isloggedin. For example, you can call:
	* app('account')->accountCreation() outputs for example "1 day ago"
	* app('account')->accountCreation(false) outputs for example "2015-05-30 04:32:29"
	*
	* @param boolean
	* @return string timestamp
	*/
	public function accountCreation($diff = true) 
	{
		if ($diff) {
			return Carbon::createFromTimeStamp($this->attributes('creation'))->diffForHumans();
		}

		return Carbon::createFromTimeStamp($this->attributes('creation'));
	}

	/**
	* Return all characters that belongs to the loggedin account
	*
	* @return void
	*/
	public function characters()
	{
		$run = Character::where('account_id', $this->attributes('id'))->get();

		if ($run->count() == 0) {
			return false;
		}

		return $run;
	}

	/**
	* 
	*/
	public function newr($name, $password, $email) 
	{
		if (config('account', 'encryption') == "sha1") {
			$password = sha1($password);
		}

		$new = $this;
		$new->name = $name;
		$new->password = $password;
		$new->type     = 1;
		$new->premdays = 0;
		$new->lastday = 0;
		$new->email = $email;
		$new->creation = time();
		$new->save();

		$new_ca = new \App\Classes\Account;
		$new_ca->account_id = $new->id;
		$new_ca->created = time();
		$new_ca->points = 0;
		$new_ca->save();

		return $new->id;
	}

	/**
	 * Return any attribute from the session
	 *
	 * @return string
	 */
	public function attributes($field = null)
	{
		if (isLoggedIn()) {
			return (! is_null($field)) ? $_SESSION[config('account', 'token')][$field] : $_SESSION[config('account', 'token')];
		}
	}

}