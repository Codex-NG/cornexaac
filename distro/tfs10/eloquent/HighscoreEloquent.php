<?php namespace distro\tfs10\eloquent;

class HighscoreEloquent extends \Illuminate\Database\Eloquent\Model {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'players';

	/**
	 * Store loop count
	 *
	 * @var integer
	 */
	private static $loop = 0; 

	/**
	 * Store custom fields
	 *
	 * @var array
	 */
	public static $customfields = [];

	/**
	 * Store the pagination object
	 *
	 * @var object
	 */
	public static $pagination;

	/**
	 * Store skill_id and table column
	 *
	 * @var array
	 */
	private static $columns = [
		0 => 'skill_fist',
		1 => 'skill_club',
		2 => 'skill_sword',
		3 => 'skill_axe',
		4 => 'skill_dist',
		5 => 'skill_shielding',
		6 => 'skill_fishing',

		// 
		7 => 'maglevel',
		8 => 'level',
	];

	/**
	 * Construct the class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$skill_id = (! isset($_GET['skill'])) ? 8 : config('character', 'skills')[$_GET['skill']][0];

		$appends = (! isset($_GET['skill'])) ? ['subtopic' => 'highscore'] : ['subtopic' => 'highscore', 'skill' => $_GET['skill']];

		$this->appends = $appends;

		$this->skillid = $skill_id;

		$this->skill_column = self::$columns[$skill_id];
	}

	/**
	 * Set custom fields
	 *
	 * @return void
	 */
	public static function setCustomFields(array $array)
	{
		static::$customfields = $array;
	}

	/**
	 * Retrive rows per page on highscore
	 *
	 * @return integer
	 */
	public function perPage()
	{
		return (int) config('highscore', 'per_page');
	}

	/**
	 * Determinate if custom fields has been set. 
	 *
	 * @return boolean
	 */
	public function hasCustom()
	{
		return ! (boolean) empty(static::$customfields);
	}

	/**
	 * Retrive the custom fields.
	 *
	 * @return array
	 */
	public function getCustomFields()
	{
		return static::$customfields;
	}

	/**
	 * Set pagination object
	 *
	 * @return void
	 */
	public function setPagination($items)
	{
		$presenter = app('ThemeLoader')->config('presenter.highscores');

		static::$pagination = with(new $presenter($items));
	}

	/**
	 * Get the pagination
	 *
	 * @return object
	 */
	public function getPagination()
	{
		return static::$pagination->render();
	}
	
	/**
	 * Get highscore
	 *
	 * @retur array
	 */
	public function getHighscore()
	{
		$per_page = $this->perPage();

		$ignore = config('highscore', 'ignore');

		if ($this->skillid == 7 or $this->skillid == 8) {
			$query = app('character')->where('group_id', '<', $ignore)->orderBy($this->skill_column, 'desc')->paginate($per_page)->appends($this->appends);
		} else {
			$query = self::orderBy($this->skill_column, 'desc')->where('group_id', '<', $ignore)->paginate($per_page)->appends($this->appends);
		}

		foreach ($query as $player) {
			$return[self::$loop]['rank'] = self::$loop;
			$return[self::$loop]['name'] = playerIdToName($player['id']);
			$return[self::$loop]['level'] = $player['level']; 
			$return[self::$loop]['experience'] = $player['experience'];
			$return[self::$loop]['value'] = $player[$this->skill_column];
			if (! is_null(self::$customfields)) {
				foreach (self::$customfields as $customfield) {
					$return[self::$loop][$customfield] = e($player[$customfield]);
				}
			}
			self::$loop++;
		}

		$this->setPagination($query);

		return ['result' => $return];
	}

	/**
	 * Get the 5 highest players
	 *
	 * @return boolean|array
	 */
	public function topfive() 
	{
		$level = self::orderBy('level', 'desc')->take(5)->get();

		foreach ($level as $player) {
			$return[] = [
				'name'  => $player['name'],
				'level' => $player['level']
			];
		}

		return (is_null($return)) ? false : $return ;
	}

}