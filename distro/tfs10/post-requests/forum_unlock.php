<?php

$validator = new App\Classes\Validator([
    'thread_id'  => ['required']
]);

if ($validator->fails()) {
    app('session')->set('validator', $validator);

    redirect(back());
}

if ($validator->passes()) {
    $response = (object) $validator->value();

    $thread = app('forumpost')->find($response->thread_id);

    $thread->locked = 0;
    $thread->save();

    $redirect = '?subtopic=forum&board='. $_GET['board'] .'&thread='. $_GET['thread'];

    app('session')->set('success', 'Thread has been unlocked.');

    redirect($redirect);
}