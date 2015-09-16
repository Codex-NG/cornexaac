<?php namespace distro\tfs10;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class Guild extends \Illuminate\Database\Eloquent\Model {
	
	/**
	 * Table used by the model
	 */
	protected $table = 'guilds';

	/**
	* Ignore timestampts on insert
	*/
	public $timestamps = false;

	/**
	 * Return all guilds 
	 *
	 * @return boolean|array
	 */
	public function allGuilds()
	{
		return ($this->all()->count() == 0) ? false : $this->all();
	}

	/**
	 * Get the name of guild
	 *
	 * @return string
	 */
	public function name()
	{
		return e($this->name);
	}

	/**
	 * Get the motd of guild
	 *
	 * @return string
	 */
	public function description()
	{
		return e($this->motd);
	}

	/**
	 * Determinate if guild has logo or not
	 *
	 * @return boolean
	 */
	public function hasLogo()
	{
		$extensions = ['gif', 'jpg', 'jpeg', 'png'];

		foreach ($extensions as $extension) {
			if (file_exists(theme('storage/guild_images/'. $this->id . '.' . $extension))) return "{$this->id}.{$extension}";
		}

		return false;
	}


	/**
	 * Get the guild creation date
	 *
	 * @return string
	 */
	public function creation()
	{
		return Carbon::createFromTimeStamp($this->creationdata);
	}

	/**
	 * Return total members in guild
	 *
	 * @return integer
	 */
	public function totalMembers()
	{
		return app('GuildMember')->where('guild_id', $this->id)->count();
	}

	/**
	 * Get all members in guild
	 *
	 * @return array;
	 */
	public function members()
	{
		$members = app('character')->join('guild_membership', function($join){
			$join->on('players.id', '=', 'guild_membership.player_id')
				->where('guild_membership.guild_id', '=', $this->id);
		})->join('guild_ranks', function($join){
			$join->on('guild_ranks.guild_id', '=', 'guild_membership.guild_id');
			$join->on('guild_membership.rank_id', '=', 'guild_ranks.id');
		})->join('guilds', function($join){
			$join->on('guilds.id', '=', 'guild_membership.guild_id');
		})->select('players.name as name', 'players.level as level', 'guild_ranks.name as guild_rank_name', 'players.vocation as vocation', 'account_id as account_id', 'ownerid as ownerid', 'players.id as id')->orderBy('guild_ranks.level', 'desc')->get();


		if ($members->count() > 0) {
			foreach ($members as $member) {

				$account = app('account');

				if ($member->exists()) {
					$results[e($member->guild_rank_name)][] = [
						'name'       => $member->getName(),
						'level'      => $member->getLevel(),
						'rank'       => e($member->guild_rank_name),
						'vocation'   => $member->getVocation(),
						'owner'      => (isLoggedIn()) ? ($member->account_id == $account->auth()->id) : false,
						'guildOwner' => ($member->getID() == $member->ownerid)
 					];
				}
			}
		}
		
		return ($members->count() > 0) ? (object) $results : false;
	}

	/**
	 * Get all guild invites
	 *
	 * @return array
	 */
	public function invites()
	{
		$invites = app('character')->join('guild_invites', function($join){
			$join->on('guild_invites.player_id', '=', 'players.id');
			$join->on('guild_invites.guild_id', '=', 'guild_invites.guild_id')
				->where('guild_invites.guild_id', '=', $this->id);
		})->get();

		if ($invites->count() > 0) {
			foreach ($invites as $invite) {

				$session_owner = false;
				if ($invite->account_id == app('account')->auth()->id) {
					$session_owner = true;
				}

				$results[] = [
					'name'      => $invite->getName(),
					'level'     => $invite->getLevel(),
					'vocation'  => $invite->getVocation(),
					'pid'       => $invite->id,
					'owner'     => $session_owner
				];
			}
		}

		return (! isset($results)) ? false : $results;
	}

	/**
	 * Get all members the current logged in user has in selected guild
	 *
	 * @return void|array
	 */
	public function getUserMembers()
	{
		if (! isLoggedIn()) return false;

		$members = app('character')->join('guild_membership', function($join){
			$join->on('players.id', '=', 'guild_membership.player_id')
				->where('guild_membership.guild_id', '=', $this->id)
				->where('players.account_id', '=', app('account')->auth()->id);
		})->join('guild_ranks', 'guild_membership.rank_id', '=', 'guild_ranks.id')
		->select('guild_ranks.name as guild_rank_name', 'players.id as player_id', 'guild_membership.guild_id as guild_id', 'players.name as name', 'guild_ranks.level as guild_rank_level')->get();

		return $members;
	}

	/**
	 * Get all members the current logged in user has in selected guild expect owner if he is
	 *
	 * @return void|array
	 */
	public function getUserMembersExpectOwner()
	{
		if (! isLoggedIn()) return false;

		$members = app('character')->join('guild_membership', function($join){
			$join->on('players.id', '=', 'guild_membership.player_id')
				->where('guild_membership.guild_id', '=', $this->id)
				->where('players.account_id', '=', app('account')->auth()->id);
		})->join('guild_ranks', 'guild_membership.rank_id', '=', 'guild_ranks.id')
		->join('guilds', 'guilds.id', '=', 'guild_membership.guild_id')
		->select('guild_ranks.name as guild_rank_name', 'players.id as player_id', 'guild_membership.guild_id as guild_id', 'players.name as name', 'guild_ranks.level as guild_rank_level', 'guilds.ownerid as ownerid', 'players.id as id')->get();

		$return = [];
		foreach ($members as $member) {
			if (! ($member['ownerid'] == $member->getID())) {		
				$return[] = [
					'name' => $member->getName(),
					'player_id' => $member->getID(),
					'ownerid' => $member['ownerid'],
				];
			}
		}

		return (empty($return)) ? false : $return;
	}


	/**
	 * Determinate if user is member in guild
	 *
	 * @return boolean
	 */
	public function isMember()
	{
		if ($this->getUserMembers() == false) return false;

		return ($this->getUserMembers()->count() > 0) ? true : false;
	}

	/**
	 * Delete a guild invite
	 *
	 * @return void
	 */
	public function deleteInvite($gid, $pid)
	{
		$guild_invite = app('capsule')->table('guild_invites')->where(function($query) use($gid, $pid) {
			$query->where('player_id', $pid);
			$query->where('guild_id', $gid);
		});

		if ($guild_invite->exists()) {
			$guild_invite->delete();
		}
	}

	/**
	 * Invite a new player to guild
	 *
	 * @return void
	 */
	public function invite(Character $player, $gid)
	{
		Capsule::insert('INSERT INTO `guild_invites` (`player_id`, `guild_id`) VALUES (?, ?)', [$player->id, $gid]);
	}

	/**
	 * Join guild
	 *
	 * @return void
	 */
	public function join(Character $player, $gid) 
	{
		Capsule::delete('DELETE FROM `guild_invites` WHERE `player_id` = ?', [$player->id]);

		$rank = app('capsule')->table('guild_ranks')->where(function($query) use($gid){
			$query->where('guild_id', $gid);
			$query->where('level', 1);
		})->first();

		$new_member = new GuildMember;
		$new_member->player_id = $player->id;
		$new_member->guild_id  = $gid;
		$new_member->rank_id   = $rank->id;
		$new_member->nick      = '';
		$new_member->save();
	}

	/**
	 * Determinate if user is owner of guild
	 *
	 * @return boolean
	 */
	public function isOwner() 
	{
		if (! isLoggedIn()) return false;

		return (boolean) app('character')->where(function($query){
			$query->where('id', $this->ownerid);
			$query->where('account_id', app('account')->auth()->id);
		})->exists();
	}

	/**
	 * Get the owner ID of the guild
	 *
	 * @return integer
	 */
	public function ownerid() 
	{
		return $this->ownerid;
	}

	/**
	 * Determinate if user can invite to guild
	 *
	 * @return boolean
	 */
	public function canInvite()
	{
		if ($this->isOwner()) return true;

		if (! isLoggedIn()) return false;

		if (! $this->isMember()) return false;

		foreach ($this->getUserMembers() as $member) {
			if ($member->guild_rank_level > 1) return true;
		}

		return false;
	}

	/**
	 * Get terminate guild action link
	 *
	 * @return string
	 */
	public function terminateLink()
	{
		return url("?subtopic=guilds&name=".urlencode($this->name())."&action=terminate");
	}

	/**
	 * Get invite to guild action link
	 *
	 * @return string
	 */
	public function inviteLink()
	{
		return url("?subtopic=guilds&name=".urlencode($this->name())."&action=invite");
	}

	/**
	 * Get the leave guild action link
	 *
	 * @return string
	 */
	public function leaveLink()
	{
		return url("?subtopic=guilds&name=".urlencode($this->name())."&action=leave");
	}

	/**
	 * Get the guild link
	 *
	 * @return string
	 */
	public function link()
	{
		return url("?subtopic=guilds&name=". urlencode($this->name()));
	}

	/**
	 * Proceed terminate guild
	 *
	 * @return void
	 */
	public function terminateGuild()
	{
		// Proceed the deletion
		Capsule::table('guild_invites')->where('guild_id', $this->id)->delete();
		Capsule::table('guild_membership')->where('guild_id', $this->id)->delete();
		$this->delete();

		header("Location: ". url('?subtopic=guilds')); exit;
	}

	/**
	 * Determinate if user is leader in guild. 
	 *
	 * @return boolean
	 */
	public function isLeader()
	{

	}

	/**
	 * Determinate if user is vice-leader in guild
	 *
	 * @return boolean
	 */
	public function isViceLeader()
	{

	}

	/**
	 * Create a new guild process
	 *
	 * @return void
	 */
	public function newGuild($name, $player_id)
	{
		$new_guild 			     = new $this;
		$new_guild->name 		 = $name;
		$new_guild->ownerid 	 = $player_id;
		$new_guild->creationdata = time();
		$new_guild->motd         = '';
		$new_guild->save();

		$rank = Capsule::table('guild_ranks')->where(function($query) use($new_guild) {
			$query->where('guild_id', $new_guild->id);
			$query->where('level', 3);
		})->first();

		$new_member = new GuildMember;
		$new_member->player_id = $player_id;
		$new_member->guild_id = $new_guild->id;
		$new_member->rank_id = $rank->id;
		$new_member->nick = '';
		$new_member->save();
	}

}