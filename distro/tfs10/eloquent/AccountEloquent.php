<?php namespace distro\tfs10\eloquent;

use Carbon\Carbon;

class AccountEloquent extends \Illuminate\Database\Eloquent\Model {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "accounts";

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;

	/**
	* Validate an account to make sure the entered credentials are correct.
	*
	* @param mixed $name
	* @param mixed $password
	* @return boolean
	*/
	public function validate($name, $password) 
	{
		$password = $this->encrypt($password);

		$validate = $this->where('name', $name)->where('password', $password)->first();

		return ! (boolean) is_null($validate);
	}

	/**
	* Validate a account password.
	*
	* @return boolean
	*/
	public function validatePassword($password) 
	{
		return (boolean) ($this->AACAccount()->password == sha1($password));
	}

	/**
	* Login a account.
	*
	* @param mixed $name
	* @param mixed $password
	* @return $_SESSION|boolean
	*/
	public function login($name, $password)
	{
		$password = $this->encrypt($password);

		$validate = $this->where('name', $name)->where('password', $password)->first();

		if (! is_null($validate)) {
			$_SESSION[config('account', 'token')] = $validate->toArray();

			return $_SESSION[config('account', 'token')];
		}

		return false;
	}

	/**
	* Deteminate if a user is signed in.
	*
	* @return boolean
	*/
	public function check()
	{
		return (boolean) isset($_SESSION[config('account', 'token')]);
	}

	/**
	* Logout the account.
	*
	* @return boolean|void
	*/
	public function logout()
	{
		if ($this->check()) {
			app('session')->set('success', 'You have been signed out.');

			unset($_SESSION[config('account', 'token')]);

			redirect('?subtopic=login');
		}

		return false;
	}

	/**
	 * Retrive the account from AACAccount model.
	 *
	 * @return \App\Classes\AACAccount
	 */
	public function AACAccount()
	{
		return app('AACAccount')->where('account_id', $this->id)->first();
	}

	/**
	 * Remove points from the account.
	 *
	 * @return void
	 */
	public function removePoints($remove)
	{
		$account = $this->AACAccount();

		$account->points = $account->points - $remove;

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
			return Carbon::createFromTimeStamp($this->creation)->diffForHumans();
		}

		return Carbon::createFromTimeStamp($this->creation)->toDateTimeString();
	}

	/**
	* Retrive the accounts characters.
	*
	* @return void
	*/
	public function characters()
	{
		$characters = app('character')->where('account_id', $this->id)->get();

		return (boolean) ($characters->count() == 0) ? false : $characters;
	}

	/**
	* Register a new account.
	*
	* @var string|integer  $name
	* @var mixed  $password
	* @var email  $email
	* @return integer (creation ID)
	*/
	public function register($name, $password, $email) 
	{
		$password = $this->encrypt($password);

		$new = $this;
		$new->name = $name;
		$new->password = $password;
		$new->type     = 1;
		$new->premdays = 0;
		$new->lastday = 0;
		$new->email = $email;
		$new->creation = time();
		$new->save();

		return $new->id;
	}

	/**
	 * Return signed in account data info.
	 *
	 * @return array
	 */
	public function auth()
	{
		if (! $this->check()) return false;

		return $this->find($_SESSION[config('account', 'token')]['id']);
	}

	/**
	 * Return the value encrypted with choosen encryption
	 *
	 * @return string
	 */
	public function encrypt($key)
	{
		$encryption = config('account', 'encryption');

		switch ($encryption) {
			case 'md5':
				$encryption = md5($key);
				break;

			case 'plain':
				$encryption = $key;
				break;
			
			default:
				$encryption = sha1($key);
				break;
		}

		return $encryption;
	}

}