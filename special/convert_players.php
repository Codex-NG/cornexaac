<?php


/**
 * Add all players that not exists in __cornexaac_players
 */

define('RUN_CONVERT', true);


if (RUN_CONVERT) {

    require __DIR__.'/../loader.php';

    $characters = app('character')->all(); 

    $converted = 0;
    foreach ($characters as $character) {
        $AACPlayer = app('AACPlayer')->where('player_id', $character->id)->first();
        if (! is_null($AACPlayer)) continue;

        if (is_null($AACPlayer)) {
            app('AACPlayer')->create([
                'player_id' => $character->id,
                'comment'   => '',
                'hide'      => 0,
                'created'   => (isset($character->creation)) ? $character->creation :  time(),
            ]);

            (++$converted);
        }
    }

    echo "A total of ${converted} characters has been converted.";

}