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

    $thread->delete();

    $replies = app('forumpost')->where(function($query) use($response) {
        $query->where('is_reply', 1);
        $query->where('thread_id', $response->thread_id);
    });

    $replies->delete();

    $redirect = '?subtopic=forum&board='. $_GET['board'];

    app('session')->set('success', 'Thread has been deleted.');

    redirect($redirect);
}