<?php

if (isset($_POST['guild_cancel_invite_pid'], $_POST['guild_cancel_invite_gid'])) {

	if (app('formtoken')->validateToken($_POST)) {

		$gid = e($_POST['guild_cancel_invite_gid']);
		$pid = e($_POST['guild_cancel_invite_pid']);

		$guild = app('guild')->find($gid);

		// Include plugin extension if exists
		if (file_exists(theme('plugin/post-requests/guild_cancel_invite.php'))) {
			include theme('plugin/post-requests/guild_cancel_invite.php');
		}

		// Make sure user has right access to cancel an invitation
		if (! $guild->canInvite()) {
			$guild_cancel_invite_errors[] = 'You are not allowed to cancel an invite in this guild.';
		}

		if (! empty($guild_cancel_invite_errors)) {
			$app->make('errors')->set($guild_cancel_invite_errors);
			header('Location: '. back()); exit;
		}

		$guild->deleteInvite($gid, $pid);

		$app->make('session')->set('success', 'You have successfully removed this invitation.');

		redirect(back());
	}

}