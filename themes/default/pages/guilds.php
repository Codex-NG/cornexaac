<?php
    $guilds = app('guild');

    if (isset($_GET['name'])) {
        $guild = $guilds->where('name', $_GET['name']);

        if ($guild->exists()) {
            $guild = $guild->first();
        } else {
            header('Location: '. url('?subtopic=guilds'));
        }
    }

    include theme('includes/alerts.php');
?>


<?php 
    // Guild actions boxes
    include theme('pages/guilds/guild_actions.php');

    // Show specific guild
    if (isset($_GET['name'])):
        include theme('pages/guilds/show_guild.php');
    endif; 

    // Show all guilds list 
    if (! isset($_GET['name']) && ! isset($_GET['action'])): 
        include theme('pages/guilds/guilds_all.php');
    endif; 
?>