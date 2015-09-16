<?php

if (isset($_POST['guild_join_id'], $_POST['guild_join_pid'])) {

	if (app('formtoken')->validateToken($_POST)) {

		$pid       = trim($_POST['guild_join_pid']);
		$guild_id  = $_POST['guild_join_id'];

		$guild = app('guild')->find($guild_id);

		$character = app('character')->where('id', $pid)->first();

		// Check for any plugin extensions
		if (file_exists(theme('plugin/post-requests/delete_guild.php'))) {
			include theme('plugin/post-requests/delete_guild.php');
		}

		// Make sure the guild exists.
		if (! $guild->exists()) {
			$guild_join_errors[] = 'This guild seems not to exist anymore.';
		}

		// Check if the player exists
		if (! $character->exists()) {
			$guild_join_errors[] = 'Player do not exist.';
		} 

		if (! empty($guild_join_errors)) {
			app('errors')->set($guild_join_errors);
			redirect(back());
		}

		app('session')->set('success', 'You have successfully joined this guild.');

		$guild->join($character, $guild_id);

		redirect(back());
	}

}