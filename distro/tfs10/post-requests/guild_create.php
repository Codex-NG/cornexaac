<?php

if (isset($_POST['guild_create_name'], $_POST['guild_create_character'])) {

    if (app('formtoken')->validateToken($_POST)) {

        $guild_name = trim($_POST['guild_create_name']);

        $guild = app('guild');

        $character = app('character')->where('id', $_POST['guild_create_character'])->first();

        // Include plugin extension if exists
        if (file_exists(theme('plugin/post-requests/guild_create.php'))) {
            include theme('plugin/post-requests/guild_create.php');
        }

        // Make sure the field is not empty
        if ($guild_name == "") {
            $guild_create_errors[] = 'All fields are required.';
        }

        // Make sure the user is logged in.
        if (! isLoggedIn()) {
            $guild_create_errors[] = 'You need to be logged in to create a guild.';
        }

        // Make sure user owns the character
        if ($character->account_id != app('account')->attributes('id')) {
            $guild_create_errors[] = 'You do not own selected character.';
        }

        // Make sure the guild name only contains letters
        if (! ctype_alpha(preg_replace('/\s+/', '', $guild_name))) {
            $guild_create_errors[] = 'Guild name can only contains alphabetic characters.';
        }

        // Make sure the selected character is above min level
        if ($character->level < config('guilds', 'min_level')) {
            $guild_create_errors[] = 'Selected character is to low level to create a guild.';
        }

        // Make sure the character not already owns a guild
        if ($character->hasGuild()) {
            $guild_create_errors[] = 'Selected character do already owns a guild.';
        }

        // Determinate if guild already exists
        if ($guild->where('name', $guild_name)->exists()) {
            $guild_create_errors[] = 'A guild with this name already exist.';
        }

        // Check the guild name is not to long
        $max_length = config('guilds', 'max_length');
        if (strlen($guild_name) > $max_length) {
            $guild_create_errors[] = 'The guild name is to long, max '.$max_length.' characters.';
        }

        // Make sure the guildname not contains more words than allowed
        $max_words = config('guilds', 'max_words');
        if (str_word_count($guild_name) > $max_words) {
            $guild_create_errors[] = 'The guild name contains to many words, max '.$max_words.' words allowed.';
        }

        if (! empty($guild_create_errors)) {
            $app->make('errors')->set($guild_create_errors);
            redirect(back());
        }

        $guild->newGuild($guild_name, $character);

        $app->make('session')->set('success', 'You\'r guild has successfully been created.');

        redirect('?subtopic=guilds&name='. $guild_name);
    }

}