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

	'token' => 'CornexAACAuthToken'

];