<?php

include __DIR__.'/register.php';
include __DIR__.'/login.php';
include __DIR__.'/new_character.php';
include __DIR__.'/delete_guild.php';
include __DIR__.'/guild_invite.php';
include __DIR__.'/guild_create.php';
include __DIR__.'/guild_join.php';
include __DIR__.'/guild_cancel_invite.php';
include __DIR__.'/guild_leave.php';
include __DIR__.'/paypal.php';
include __DIR__.'/create_news.php';
include __DIR__.'/shop_buy.php';

if (file_exists(theme('plugin/post-requests/requests.php'))) {
    include theme('plugin/post-requests/requests.php');
}