<?php namespace distro\tfs10;

use Carbon\Carbon;

class Character extends \distro\tfs10\eloquent\CharacterEloquent {

	/**
    * Retrive the character name.
    *
    * @return string
    */
    public function getName()
    {
        return e($this->name);
    }

    /**
    * Retrive the character ID.
    *
    * @return integer
    */
    public function getID()
    {
        return (int) $this->id;
    }

    /**
    * Retrive the level of the character.
    *
    * @return integer
    */
    public function getLevel()
    {
        return (int) $this->level;
    }

    /**
    * Retrive the gender ID of the character.
    *
    * @return integer
    */
    public function getSex()
    {
        return (int) $this->sex;
    }

    /**
    * Retrive the vocation of the character. 
    *
    * @return integer
    */
    public function getVocation()
    {
        return (int) $this->vocation;
    }

    /**
    * Retrive the town ID of the character.
    *
    * @return integer
    */
    public function getTown()
    {
        return (int) $this->town_id;
    }

    /**
     * Determinate if the signed in account owns the character.
     *
     * @return boolean
     */
    public function isOwner()
    {
        return (boolean) ($this->account_id == app('account')->auth()->id); 
    }

    /**
    * Determinate if character is online.
    *
    * @return boolean
    */
    public function isOnline()
    {
        return ! (is_null(app('online')->find($this->id)));
    }

    /**
     * Determinate character is hided.
     *
     * @return boolean
     */
    public function isHided()
    {
        return (boolean) $this->AACPlayer()->hide;
    }

    /**
     * Determinate if character has a comment.
     *
     * @return boolean
     */
    public function hasComment()
    {
        return ($this->AACPlayer()->comment == "") ? false: true;
    }

    /**
     * Retrive characters comment.
     *
     * @return string
     */
    public function getComment()
    {
        return e($this->AACPlayer()->comment);
    }

    /**
     * Retrive the characters last login date.
     *
     * @return string|timestamp
     */
    public function getLastLogin()
    {
        return ($this->lastlogin == 0) ? 'Never.' : Carbon::createFromTimeStamp($this->lastlogin)->toDateTimeString();
    }

    /**
     * Determinate if character has a guild.
     * 
     * @return boolean
     */
    public function hasGuild()
    {
        return app('GuildMember')->where('player_id', $this->id)->exists();
    }

    /**
    * Retrive the character deaths.
    *
    * @return array
    */
    public function getDeaths()
    {
        $get = ['level AS level', 'killed_by AS killed_by', 'is_player AS is_player', 'time AS time'];

        return app('death')->where('player_id', $this->id)->orderBy('time', 'desc')->get($get)->toArray();
    }

}