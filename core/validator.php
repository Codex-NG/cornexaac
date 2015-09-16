<?php

App\Classes\Validator::extend('required', function($attribute, $value){
    if (isset($_POST[$attribute])) {
        if ($_POST[$attribute] == "") return false;

        return true;
    }

    return false;
});

App\Classes\Validator::extend('min', function($attribute, $value, $parameters){
    if (! isset($parameters[0])) {
        throw new Exception('The min rule requires a first parameter.');
    }

    return strlen($value) >= (int) $parameters[0];
});

App\Classes\Validator::extend('max', function($attribute, $value, $parameters){
    if (! isset($parameters[0])) {
        throw new Exception('The max rule requires a first parameter.');
    }

    return strlen($value) <= (int) $parameters[0];
});

App\Classes\Validator::extend('same', function($attribute, $value, $parameters){
    if (! isset($parameters[0])) {
        throw new Exception('The same rule requires a first parameter.');
    }

    return ($_POST[$parameters[0]] == $value);
});

App\Classes\Validator::extend('alnum', function($attribute, $value, $parameters){
    return preg_match('/^[a-z0-9]+$/i', $value);
});

App\Classes\Validator::extend('alpha', function($attribute, $value, $parameters){
    return ctype_alpha(preg_replace('/\s/', '', $value));
});

App\Classes\Validator::extend('gender', function($attribute, $value, $parameters){
    return ! ($value != 1 && $value != 0);
});

App\Classes\Validator::extend('email', function($attribute, $value, $parameters){
    return filter_var($value, FILTER_VALIDATE_EMAIL);
});

App\Classes\Validator::extend('unique', function($attribute, $value, $parameters){
    if (! isset($parameters[0], $parameters[1])) {
        throw new Exception('The unique rule not has enough parameters.');
    }

    $table  = $parameters[0];
    $column = $parameters[1];

    $unique = Illuminate\Database\Capsule\Manager::table($table)->where($column, '=', $value)->first();

    return (is_null($unique));
});

App\Classes\Validator::extend('maxwords', function($attribute, $value, $parameters){
    if (! isset($parameters[0])) {
        throw new Exception('The unique rule not has enough parameters.');
    }

    return ! (str_word_count($value) > $parameters[0]);
});

App\Classes\Validator::extend('vocation', function($attribute, $value, $parameters){
    return in_array($value, config('character', 'newcharvocations'));
});

App\Classes\Validator::extend('town', function($attribute, $value, $parameters){
    return in_array($value, config('character', 'newchartowns'));
});

App\Classes\Validator::extend('charname', function($attribute, $value, $parameters){
    if (preg_match(sprintf('/(.)\1{%d,}/', 2), $value) > 0) {
        return false;
    }

    if (in_array(ucwords($value), monsterNames())) {
        return false;
    }

    if (preg_match('/\b('.implode('|', config('character', 'notallowedwords')).')\b/i', strtolower($value))) {
        return false;
    }

    return true;
});

App\Classes\Validator::extend('charowner', function($attribute, $value, $parameters){
    $character = app('character')->where('id', $value)->first();

    if ($character->account_id != app('account')->auth()->id) {
        return false;
    }

    return true;
});

App\Classes\Validator::extend('charexist', function($attribute, $value, $parameters){
    $character = app('character')->where('id', $value)->first();

    if (is_null($character)) {
        return false;
    }

    return true;
});

App\Classes\Validator::extend('noguild', function($attribute, $value, $parameters){
    $character = app('character')->where('id', $value)->first();

    if ($character->hasGuild()) {
        return false;
    }

    return true;
});

App\Classes\Validator::extend('minlevel', function($attribute, $value, $parameters){
    if (! isset($parameters[0])) {
        throw new Exception('The unique rule not has enough parameters.');
    }

    $character = app('character')->where('id', $value)->first();

    if ($character->level < $parameters[0]) {
        return false;
    }

    return true;
});
