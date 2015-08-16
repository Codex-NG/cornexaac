<?php namespace distro\tfs10;

class Character extends \Illuminate\Database\Eloquent\Model {

	/**
	* Specify the table we gonna use
	*/
	protected $table = "players";

	/**
	* Specify the primary key
	*/
	protected $primaryKey = 'name';

	/**
	* Ignore timestampts on insert
	*/
	public $timestamps = false;

	/**
	* Create a new character. As this method is very restricted, I will make it easier to 
	* extends such things as add a last parameter with an array where you can override and column with 
	* custom values based on your needs. 
	*
	* @param string $name
	* @param integer $town
	* @param integer $voc
	* @param integer $sex
	* @return void
	*/
	// public function create($name, $town, $voc, $sex)
	public function newr($name, $town, $voc, $sex)
	{
		$new = $this;
		$new->name       = ucwords(strtolower($name));
		$new->account_id = Account::attributes('id');
		$new->level      = config('character', 'newcharacter.level');
		$new->vocation   = $voc; 
		$new->health     = config('character', 'newcharacter.health');
		$new->healthmax  = config('character', 'newcharacter.health');
		$new->experience = config('character', 'newcharacter.experience');
		$new->lookbody   = config('character', 'newcharacter.lookBody');
		$new->lookfeet   = config('character', 'newcharacter.lookFeet');
		$new->lookhead   = config('character', 'newcharacter.lookHead');
		$new->looklegs   = config('character', 'newcharacter.lookLegs');
		$new->looktype   = (($sex == 0) ? config('character', 'newcharacter.femaleOutfitId') : config('character', 'newcharacter.maleOutfitId'));
		$new->mana       = config('character', 'newcharacter.mana');
		$new->manamax    = config('character', 'newcharacter.mana');
		$new->soul       = config('character', 'newcharacter.soul');
		$new->town_id    = $town;
		$new->cap        = config('character', 'newcharacter.cap');
		$new->sex        = $sex;
		$new->save();

		$new_ca = new \App\Classes\Player;
		$new_ca->player_id = $new->name;
		$new_ca->comment   = '';
		$new_ca->hide      = 0;
		$new_ca->created   = time();
		$new_ca->save();
	}


	/**
	* The methods below, is ONLY, and ONLY possible to use if you call the 
	* Distro\Character with find method and first arg as the character name
	* For example, you can make like this:
	*
	*	$character = Distro\Character::find('Cornex');
	*	if (is_null($character)) {
	*		// The character does not exist, do something.
	*		header('Location: /'); exit;
	*	}
	*	
	*	echo $character->getName(); // outputs "Cornex"
    *
	*/


	/**
	* Get the name of the character
	*
	* @return string
	*/
	public function getName()
	{
		return e($this->name);
	}

	/**
	* Determinate if the user is online or not
	*
	* @return boolean
	*/
	public function isOnline()
	{
		$status = app('online')->find($this->id);

		return (is_null($status)) ? false : true;
	}

	/**
	* Get the position of the character
	*
	* @return string
	*/
	public function getPosition()
	{
		return config('character', 'group_id')[$this->group_id];
	}

	/**
	* Get the level of the character 
	*
	* @return integer
	*/
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * Determinate if the user is owner of character
	 *
	 * @return boolean
	 */
	public function isOwner()
	{
		return (boolean) ($this->account_id == app('account')->attributes('id')); 
	}

	/**
	* Get the sex of a character, also with option to convert to readable format.
	* For example: 
	* $character->getSex(); // outputs Male
	* $character->getSex(false); // outputs 1
	*
	* @param boolean $convert
	* @return string integer
	*/
	public function getSex($convert = true)
	{
		if ($convert) {
			return sexIdToName($this->sex);
		}

		return $this->sex;
	}

	/**
	* Get the vocation of the character, with an option to convert to readable format.
	* For example:
	* $character->getVocation(); // outputs "Sorcerer"
	* $character->getVocation(); // outputs 1
	*
	* @param boolean $convert
	* @return string integer
	*/
	public function getVocation($convert = true)
	{
		if ($convert) {
			return vocIdToName($this->vocation);
		}

		return $this->vocation;
	}

	/**
	* Get the town of the character, with option to convert to readable format.
	* For example:
	* $character->getTown(); // outputs "Thais"
	* $character->getTown(false); // outputs 1
	*
	* @param boolean $convert
	* @return string integer
	*/
	public function getTown($convert = true)
	{
		if ($convert) {
			return townIdToName($this->town_id);
		}

		return $this->town_id;
	}

	/**
    * Get the deaths of a character, this is very important if you make 
    * a new distro package to works with other server that you return the same
    * array or you have to include a custom character.php view that fit your return
	*
	* Be sure to always return the same array, example:
	* ['time', 'level', 'killed_by', 'is_player']
	*
	* @return array
	*/
	public function getDeaths()
	{
		$data = Death::where('player_id', $this->id)->orderBy('time', 'desc');

		if (is_null($data)) return false;

		$rows = 0;
		$return = [];
		foreach ($data->get() as $value) {

			$return[$rows]['time'] = $value['time'];
			$return[$rows]['level'] = $value['level'];
			$return[$rows]['killed_by'] = $value['killed_by'];
			$return[$rows]['is_player'] = $value['is_player'];

			$rows++;
		}	

		return $return;
	}

	/**
	 * Determinate if the user has a guild or not, return false 
	 * if the user not have a guild, and return guild name if user has.
	 * 
	 * @return boolean|string
	 */
	public function hasGuild()
	{
		$guild = app('GuildMember')->where('player_id', $this->id);

		return ($guild->exists()) ? true : false;
	}

	/**
	 * 
	 */
	public function getGuild()
	{
		$guild = app('GuildMember')->where('player_id', $this->id)->first();

		$rank = app('capsule')->table('guild_ranks')->where(function($query) use($guild) {
			$query->where('id', $guild->rank_id);
			$query->where('guild_id', $guild->guild_id);
		})->first();

		$guild = [
			'name' => guildIDtoName($rank->guild_id),
			'rank' => e($rank->name)
		];

		return $guild;
	}

	/**
	 * Get staff members
	 *
	 * @return array
	 */
	public function getStaff()
	{
		$get = app('character')->where('group_id', '>=', 2)->orderBy('group_id', 'desc')->get();

		foreach ($get as $staff) {
			$return[] = [
				'name'     => e($staff->getName()),
				'position' => e($staff->getPosition()),
				'status'   => $staff->isOnline()
			];
		}

		return $return;
	}

}