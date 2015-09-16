<?php

/**
 * Determinate if guild exist or not, match against a guild name.
 *
 * @param string  $params[0]
 * @return boolean
 */
App\Classes\Http::extend('guild_exists', function($params)
{
    $guild = app('guild')->where('name', $params[0])->first();

    return ! (boolean) is_null($guild);
});

/**
 * Determinate if user is logged in or not. 
 *
 * @return boolean
 */
App\Classes\Http::extend('auth', function($params)
{
    return isLoggedIn();
});

/**
 * Determinate if user is owner of the guild, match against guild name.
 *
 * @param string  $params[0]
 * @return boolean
 */
App\Classes\Http::extend('is_guild_owner', function($params)
{
    $guild = app('guild')->where('name', $params[0])->first();

    return $guild->isOwner();
});