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

    $thread = app('forumpost')->where(function($query) use($response) {
        $query->where('id', $response->thread_id);
    })->first();

    $thread->locked = 1;
    $thread->save();

    $redirect = '?subtopic=forum&board='. $_GET['board'] .'&thread='. $_GET['thread'];

    app('session')->set('success', 'Thread has been locked.');

    redirect($redirect);
}