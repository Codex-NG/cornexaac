<?php namespace App\Classes;

class Admin
{

    /**
     * Construct the class
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determinate if the user is website admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return (boolean) app('AACAccount')->where(function($query){
            $query->where('account_id', app('account')->auth()->id);
            $query->where('site_access', 1);
        })->first();
    }
    
}