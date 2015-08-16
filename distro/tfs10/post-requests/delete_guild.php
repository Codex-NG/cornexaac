<?php

if (isset($_POST['delete_guild_id'])) {

	if (app('formtoken')->validateToken($_POST)) {

		$guild_id = $_POST['delete_guild_id'];

		$guild = app('guild')->find($guild_id);

		if (file_exists(theme('plugin/post-requests/delete_guild.php'))) {
			include theme('plugin/post-requests/delete_guild.php');
		}

		if (is_null($guild)) {
			$delete_guild_errors[] = 'The guild you try to delete do not exists.';
		} else {
			if (! $guild->isOwner()) {
				$delete_guild_errors[] = 'You don\'t have the access to delete this guild.';
			}
		}

		if (! empty($delete_guild_errors)) {
			$app->make('errors')->set($delete_guild_errors);
			header('Location: '. back()); exit;
		}

		$app->make('session')->set('success', 'You\'r guild has successfully been deleted.');

		$guild->terminateGuild();

		redirect(back());
	}

}