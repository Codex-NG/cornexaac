<?php

if (isset($_POST['guild_invite_name'], $_POST['guild_invite_id'])) {

	if (app('formtoken')->validateToken($_POST)) {

		$name = trim($_POST['guild_invite_name']);
		$guild_id  = $_POST['guild_invite_id'];

		$guild = app('guild')->find($guild_id);

		$character = app('character')->find($name);

		// Check for any plugin extensions
		if (file_exists(theme('plugin/post-requests/delete_guild.php'))) {
			include theme('plugin/post-requests/delete_guild.php');
		}

		if ($name == "") {
			$guild_invite_errors[] = 'All fields are required.';
		}

		if (! $guild->canInvite()) {
			$guild_invite_errors[] = 'You don\'t have the proper rank to invite someone.';
		}

		// Make sure the guild exists.
		if (! $guild->exists()) {
			$guild_invite_errors[] = 'This guild seems not to exist anymore.';
		}

		// Check if the player exists
		if (is_null($character)) {
			$guild_invite_errors[] = 'Player '.$name.' do not exist.';
		} else {
			// Check if player already is in any guild
			if ($character->hasGuild()) {
				$guild_invite_errors[] = 'Player '.$_POST['guild_invite_name'].' is already in a guild.';
			}
		}

		if (! empty($guild_invite_errors)) {
			app('errors')->set($guild_invite_errors);
			redirect(back());
		}

		app('session')->set('success', 'You have invited player '.$name.' to your guild.');

		$guild->invite($character, $guild_id);

		redirect(back());
	}

}