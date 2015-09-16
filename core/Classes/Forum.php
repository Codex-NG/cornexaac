<?php namespace App\Classes;

class Forum
{

    /**
     * Construct the class
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Retrive all boards
     *
     * @return array
     */
    public function getBoards()
    {
        return app('forumboard')->boards();
    }
    
}