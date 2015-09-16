<?php

$validator = new App\Classes\Validator([
    'guild_create_name'      => ['required', 'alpha', 'unique:guilds,name', 'maxwords:'.config('guilds', 'max_words'), 'max:'.config('guilds', 'max_length')],
    'guild_create_character' => ['required', 'charexist', 'charowner', 'noguild', 'minlevel:'. config('guilds', 'min_level')]
]);

// If validator fails
if ($validator->fails()) {
    app('session')->set('validator', $validator);

    redirect(back());
}

// If validator passes
if ($validator->passes()) {
    $response = (object) $validator->value();

    $guild = app('guild');

    $guild->newGuild($response->guild_create_name, $response->guild_create_character);

    app('session')->set('success', 'You\'r guild has successfully been created.');

    redirect(back());
}
