<?php

$http = app('http');

$http->request('myaccount', ['auth']);
$http->request('guilds/{name}/invite', ['guild_exists:{name}', 'auth', 'is_guild_owner:{name}']);
$http->request('guilds/{name}/edit', ['auth', 'guild_exists:{name}', 'is_guild_owner:{name}']);

/*
|--------------------------------------------------------------------------
| ?subtopic=guilds&name={name}&action=disband
|--------------------------------------------------------------------------
|
| Before the user will be allowed to disband the guild, we want to make 
| sure that the user is signed in, the guild exists and the user is the 
| owner of the guild that are going to be disbanded.
| 
*/
$http->request('guilds/{name}/disband', ['auth', 'guild_exists:{name}', 'is_guild_owner:{name}'], function($callback){
	include request('guild_disband');
});

/*
|--------------------------------------------------------------------------
| ?subtopic=logout
|--------------------------------------------------------------------------
|
| Logout the signed in account.
| 
*/
$http->request('logout', ['auth'], function($callback){
	app('account')->logout();
});

/*
|--------------------------------------------------------------------------
| ?subtopic=shop&buy={productid}
|--------------------------------------------------------------------------
|
| Verify that the user is signed in and has a minimum of 1 character
| registered on the account in order to proceed the purchase.
| 
*/
$http->request('shop/{productid}', ['auth'], function($callback){
	$characters = app('account')->characters();

	if (! $characters) {
		app('errors')->set(['Please create a character first.']);

		redirect('?subtopic=shop');
	}
});
