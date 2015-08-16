<?php namespace distro\tfs10;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class GuildMember extends \Illuminate\Database\Eloquent\Model {
	
	/**
	 * Table used by the model
	 */
	protected $table = 'guild_membership';

    /**
     * 
     */
    protected $primaryKey = 'guild_id';

    /**
    * Ignore timestampts on insert
    */
    public $timestamps = false;

}