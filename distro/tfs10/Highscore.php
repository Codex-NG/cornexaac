<?php namespace distro\tfs10;

class Highscore extends \Illuminate\Database\Eloquent\Model {
	
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
	private static $customfields = null;

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
	public static function customfields(array $array)
	{
		self::$customfields = $array;
	}
	
	/**
	 * Get highscore
     *
     * @retur array
	 */
    public function getHighscore()
    {
        $presenter = app('ThemeLoader')->config('presenter');

        $per_page = config('highscore', 'per_page');

        $ignore = config('highscore', 'ignore');

        if ($this->skillid == 7 || $this->skillid == 8) {
            $query = app('character')->where('group_id', '<', $ignore)->orderBy($this->skill_column, 'desc')->paginate($per_page)->appends($this->appends);
        } else {
            $query = self::orderBy($this->skill_column, 'desc')->where('group_id', '<', $ignore)->paginate($per_page)->appends($this->appends);
        }

        foreach ($query as $player) {
            $return[self::$loop]['name'] = playerIdToName($player['id']);
            $return[self::$loop]['value'] = $player[$this->skill_column];
            if (! is_null(self::$customfields)) {
                foreach (self::$customfields as $customfield) {
                    $return[self::$loop][$customfield] = e($player[$customfield]);
                }
            }
            self::$loop++;
        }

        $with = with(new $presenter($query))->render();

        return ['result' => $return, 'pagination' => $with];
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