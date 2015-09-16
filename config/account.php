<?php 

return [

	/*
	|--------------------------------------------------------------------------
	| Encryption
	|--------------------------------------------------------------------------
	|
	| tfs10 will ignore this setting because sha1 is only one available right now anyways (AFAIK)
	| tfs03 supports plain/sha1.
	|
	*/	

	'encryption' => 'sha1',

	/*
	|--------------------------------------------------------------------------
	| Max characters
	|--------------------------------------------------------------------------
	|
	| Max characters you are allowed to have on one account
	|
	*/	

	'max_characters' => 10,

	/*
	|--------------------------------------------------------------------------
	| Captcha on register
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/	

	'captcha' => true,
	
	/*
	|--------------------------------------------------------------------------
	| Enabled
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'enable' => true,

	/*
	|--------------------------------------------------------------------------
	| Auth session token
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'token' => 'CornexAACAuthToken',

	/*
	|--------------------------------------------------------------------------
	| Account types
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'type' => [
		1 => 'Player', 
		2 => 'Tutor',
		3 => 'Senior Tutor',
		4 => 'Gamemaster', 
		5 => 'God'
	],

];