<?php namespace distro\tfs10\eloquent;

class OnlineEloquent extends \Illuminate\Database\Eloquent\Model {
	
	/**
	 * Table for the model to use
	 */
	protected $table = 'players_online';

	/**
	 * Primary key for the model to use
	 */
	protected $primaryKey = 'player_id';

	/**
	* return all online players as an array
	*
	* @return array 
	*/	
	public static function getAll($extra = null)
	{
		$rows = Self::all();

		if ($rows->count() == 0) {
			return false;
		}

		$return = collect([]);
		foreach ($rows as $row) {
			$char = \distro\tfs10\Character::find(playerIdToName($row['player_id']));	

			$item = collect([
				'name'     => $char->getName(),
				'vocation' => $char->getVocation(),
				'level'    => $char->getLevel()
			]);

			if (! is_null($extra)) {
				foreach ($extra as $key) {
					$item->put($key, $char->$key);
				}
			}

			$return->push($item->all());
		}

		return $return;
	}

}