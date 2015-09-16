<?php namespace distro\tfs10\eloquent;

use Carbon\Carbon;

class CharacterEloquent extends \Illuminate\Database\Eloquent\Model {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "players";

	/**
     * Primary attribute used by the model.
     *
     * @var string
     */
	protected $primaryKey = 'name';

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name', 'level', 'sex', 'town_id', 'health', 'mana', 'cap', 'soul', 'experience', 'lookhead', 'lookbody', 'looklegs', 'lookfeet', 'looktype', 'account_id', 'vocation'];

	/**
	 * Determinate if we use custom value or config value
	 *
	 * @param array $custom
	 * @param string $column
	 * @return mixed
	 */
	public function value($column, array $custom)
	{
		return (isset($custom[$column])) ? $custom[$column] : config('character', 'newcharacter.'. $column);
	}

	/**
	* Create a new character. 
	*
	* @param array $data
	* @return void
	*/
	public function spawn(array $data)
	{
		$data = [
			'name'       => ucfirst(strtolower($data['name'])),
			'account_id' => app('account')->auth()->id,
			'level'      => $this->value('level', $data),
			'vocation'   => $data['vocation'],
			'health'     => $this->value('health', $data),
			'experience' => $this->value('experience', $data),
			'lookbody'   => $this->value('lookbody', $data),
			'lookfeet'   => $this->value('lookfeet', $data),
			'lookhead'   => $this->value('lookhead', $data),
			'looklegs'   => $this->value('looklegs', $data),
			'looktype'   => (($this->value('sex', $data) == 0) ? config('character', 'newcharacter.femaleOutfitId') : config('character', 'newcharacter.maleOutfitId')),
			'mana'       => $this->value('mana', $data),
			'soul'		 => $this->value('soul', $data),
			'town_id'    => (int) $this->value('town_id', $data),
			'cap'        => $this->value('cap', $data),
			'sex'        => (int) $this->value('sex', $data),
		];

		$this::create($data);
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

	/**
	 * Return account info
	 *
	 * @return object
	 */
	public function account()
	{
		$account = app('account')->find($this->account_id);

		return $account;
	}

	/**
	 * Get the accounts information from __cornexaac_character
	 * 
	 * @return array
	 */
	public function AACPlayer()
	{
		return app('AACPlayer')->where('player_id', $this->account_id)->first();
	}

	/**
	 * Get the characters account info from 
	 * 
	 * @return array
	 */
	public function AACAccount()
	{
		return app('AACAccount')->where('account_id', $this->account_id)->first();
	}

    /**
     * Determinate if player is tutor
     *
     * @return boolean
     */
    public function isTutor()
    {
    	return (boolean) ($this->account()->type == 2 && $this->group_id == 1); 
    }

    /**
     * Determinate if player is gamemaster
     *
     * @return boolean
     */
    public function isGamemaster()
    {
    	return (boolean) ($this->account()->type == 4 && $this->group_id == 2);
    }

    /**
     * Determinate if player is god
     *
     * @return boolean
     */
    public function isGod()
    {
    	return (boolean) ($this->account()->type == 5 && $this->group_id == 3);
    }

}