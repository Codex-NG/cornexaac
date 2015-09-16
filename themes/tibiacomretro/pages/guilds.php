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

    include theme('includes/notifications.php');
?>


<?php 
    // Show guild actions
    if (isset($_GET['action'])):
        include theme('pages/guilds/'.$_GET['action'].'.php');
    endif;

    // Show specific guild
    if (isset($_GET['name']) && ! isset($_GET['action'])):
        include theme('pages/guilds/show_guild.php');
    endif; 

    // Show all guilds list 
    if (! isset($_GET['name']) && ! isset($_GET['action'])): 
        include theme('pages/guilds/guilds_all.php');
    endif; 
?>