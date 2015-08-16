<?php

if (isset($_POST['character_voc'], $_POST['character_name'], $_POST['character_town'], $_POST['character_sex'])) {

	if (app('formtoken')->validateToken($_POST)) {
		
		$name = trim($_POST['character_name']);
		$voc  = $_POST['character_voc'];
		$town = $_POST['character_town'];
		$sex  = $_POST['character_sex'];
		$character = app('character');

		if (file_exists(theme('plugin/post-requests/new_character.php'))) {
			include theme('plugin/post-requests/new_character.php');
		}

		if (strlen($name) < 4 || strlen($name) > 20) {
			$new_char_error[] = 'Character name has to be between 4 - 20 characters long.';
		}

		if (! ctype_alpha(preg_replace('/\s/', '', $name))) {
			$new_char_error[] = 'Character name can only contains alphabetic characters.';
		}

		if ($sex != 1 && $sex != 0) {
			$new_char_error[] = 'Character sex is not valid';
		}

		if ($name == "") {
			$new_char_error[] = 'All fields are required';
		}

		if (str_word_count($name) > 2) {
			$new_char_error[] = 'Name can only contains maximum of 2 words.';
		}

		// Make sure the field is not modified
		if (! in_array($voc, config('character', 'newcharvocations'))) {
			$new_char_error[] = 'Selected vocation is not valid.';
		}

		// Make sure the field is not modified
		if (! in_array($town, config('character', 'newchartowns'))) {
			$new_char_error[] = 'Selected town is not valid.';
		}

		if (! is_null($character->where('name', $name)->first())) {
			$new_char_error[] = 'Name has already been taken.';
		}

		// Make sure the user not uses a monster name
		if (in_array(ucwords($name), monsterNames())) {
			$new_char_error[] = 'You cannot use the same name as a monster.';
		}

		// Make sure the name only has 2 of same characters next to eachother
		if (preg_match(sprintf('/(.)\1{%d,}/', 2), $name) > 0) {
			$new_char_error[] = 'Invalid name.';
		}

		// Make sure the user not try to use any of our config specifik blocked words
		if (preg_match('/\b('.implode('|', config('character', 'notallowedwords')).')\b/i', strtolower($name))){
			$new_char_error[] = 'The name is not valid.';
		}

		if (! empty($new_char_error)) {
			app('errors')->set($new_char_error);
			header('Location: ?subtopic=newcharacter'); exit;
		}

		// 
		$app->make('session')->set('success', 'Your new character has been created!');
		
		$character->newr($name, $town, $voc, $sex);

		header('Location: ?subtopic=newcharacter'); exit;
	}

}