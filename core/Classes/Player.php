<?php namespace App\Classes;

class Player extends \Illuminate\Database\Eloquent\Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = '__cornexaac_players';

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
    protected $fillable = ['player_id', 'comment', 'hide', 'created'];

}