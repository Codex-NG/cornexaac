<?php

function countOnline() {
    $online = app('online')->getAll();

    return (!$online) ? 0 : count($online);
}

function guildIDtoName($id) {
    $guild = app('guild')->where('id', $id)->first();

    return ($guild->exists()) ? $guild->name() : false; 
}