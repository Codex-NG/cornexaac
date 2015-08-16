<?php

if (isset($_POST['guild_leave_pid'], $_POST['guild_leave_gid'])) {

    if (app('formtoken')->validateToken($_POST)) {

        $gid = (int) trim($_POST['guild_leave_gid']);
        $pid = (int) trim($_POST['guild_leave_pid']);

        $guild = app('GuildMember')->where(function($query) use($gid, $pid) {
            $query->where('guild_id', $gid);
            $query->where('player_id', $pid);
        });

        $character = app('character')->where('id', $pid);

        // Include plugin extension if exists
        if (file_exists(theme('plugin/post-requests/guild_leave.php'))) {
            include theme('plugin/post-requests/guild_leave.php');
        }

        // Make sure the field is not empty
        if ($pid == "" | $gid == "") {
            $guild_leave_errors[] = 'All fields are required.';
        }

        // Make sure the player is member of an guild
        if (! $guild->exists()) {
            $guild_leave_errors[] = 'Somethin went wrong, please try again.';
        }

        $isowner = app('guild')->where(function($query) use($gid, $pid) {
            $query->where('id', $gid);
            $query->where('ownerid', $pid);
        })->exists();
        if ($isowner) {
            $guild_leave_errors[] = 'You cannot leave a guild with owner, you have to terminate it.';
        }

        // Make sure the user is logged in.
        if (! isLoggedIn()) {
            $guild_leave_errors[] = 'You need to be logged in to leave a guild.';
        }

        // Make sure character exists
        if (! $character->exists()) {
            $guild_leave_errors[] = 'Character seems not to exist.';
        }

        // Make sure user owns the character
        if ($character->first()->account_id != app('account')->attributes('id')) {
            $guild_leave_errors[] = 'You do not own selected character.';
        }

        if (! empty($guild_leave_errors)) {
            $app->make('errors')->set($guild_leave_errors);
            redirect(back());
        }

        $guild->delete();

        $app->make('session')->set('success', 'You has successfully leave the guild.');

        redirect(back());
    }

}