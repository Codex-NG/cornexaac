<?php

return [

	/*
	|--------------------------------------------------------------------------
	| New character towns
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'newchartowns' => [1],

	/*
	|--------------------------------------------------------------------------
	| Towns
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'towns' => [
		1 => 'Thais',
	],

	/*
	|--------------------------------------------------------------------------
	| Skills
	|--------------------------------------------------------------------------
	|
	| $_GET paramter => [skillid, display text]
	|
	*/

	'skills' => [
		'fist'      => [0, 'Fist Fighting'],
 		'club'      => [1, 'Club Fighting'],
 		'sword'     => [2, 'Sword Fighting'],
 		'axe'       => [3, 'Axe Fighting'],
 		'distance'  => [4, 'Distance Fighting'],
 		'shielding' => [5, 'Shielding'],
 		'fishing'   => [6,'Fishing'],

 		// ID 7/8 will always return magic level and experience.
 		'magic'     => [7, 'Magic Level'],	
 		'experience' => [8, 'Experience Level'],	
	],

	/*
	|--------------------------------------------------------------------------
	| Vocations
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'vocations' => [
		0 => 'No vocation',
		1 => 'Sorcerer',
		2 => 'Druid',
		3 => 'Paladin',
		4 => 'Knight',
		5 => 'Master Sorcerer',
		6 => 'Elder Druid',
		7 => 'Royal Paladin',
		8 => 'Elite Knight',
	],

	/*
	|--------------------------------------------------------------------------
	| Available vocations to pick when create a new character
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'newcharvocations' => [1,2,3,4],
	
	/*
	|--------------------------------------------------------------------------
	| New character properties
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'newcharacter' => [

		'level'  	 => 8,

		// sex and town_id fallbacks
		'sex'        => 0,
		'town_id'    => 1,

		'health' 	 => 185,
		'mana'   	 => 40,
		'cap'    	 => 470,
		'soul'   	 => 100,
		'experience' => 2000,

		// Outfit settings
		'maleOutfitId'   => 128,
		'femaleOutfitId' => 136,
		'lookhead'       => 78,
		'lookbody'       => 68,
		'looklegs'       => 58,
		'lookfeet'       => 76,

	],

	/*
	|--------------------------------------------------------------------------
	| Character sex
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'sex' => [
		0 => 'Female',
		1 => 'Male',
	],

	/*
	|--------------------------------------------------------------------------
	| Blocked character names, by words
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'notallowedwords' => [
		'admin',
		'gm',
		'staff',
		'gamemaster',
		'owner',
		'tibia',
		'god',
		'hoster',
		'mapper',
		'cm',
	],
	
];