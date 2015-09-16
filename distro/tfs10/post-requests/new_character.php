<?php

$validator = new App\Classes\Validator([
	'character_name' => ['required', 'min:4', 'max:20', 'alpha', 'maxwords:2', 'unique:players,name', 'charname'],
	'character_voc'  => ['required', 'vocation'],
	'character_town' => ['required', 'town'],
	'character_sex'  => ['required', 'gender'],
]);

// If the validation fails
if ($validator->fails()) {
	app('session')->set('validator', $validator);

	redirect(back());
}

// If the validation passes
if ($validator->passes()) {

	if (app('account')->characters() && app('account')->characters()->count() >= config('account', 'max_characters')) {
		app('errors')->set(['You have already reached the maximum allowed characters per one account.']);

		redirect(back());
	}

	$response = (object) $validator->value();

	$character = app('character');

	$character->spawn([
		'name'     => $response->character_name,
		'vocation' => $response->character_voc,
		'sex'      => $response->character_sex,
		'town_id'  => $response->character_town
	]);

	app('session')->set('success', 'Your new character has been created!');
	
	redirect(back());
}
