<?php

$validator = new App\Classes\Validator([
    'title'  => ['required', 'max:25'],
    'content' => ['required', 'max:500'],
    'author'  => ['required', 'charexist', 'charowner'],
]);

if ($validator->fails()) {
    app('session')->set('validator', $validator);

    redirect(back());
}

if ($validator->passes()) {
    $response = (object) $validator->value();

    $thread = app('forumpost')->create([
        'title'     => $response->title, 
        'content'   => $response->content,
        'is_reply'  => 0,
        'thread_id' => 0,
        'posted_by' => $response->author,
        'created'   => time(),
        'board_id'  => $_GET['board'],
        'loked'     => 0,
        'sticked'   => 0,
    ]);
    
    $redirect = '?subtopic=forum&board='. $_GET['board'] .'&thread='. $thread->id;

    $account = app('AACAccount')->where('account_id', app('account')->auth()->id)->first();
    $account->forum_posts += 1;
    $account->save();

    app('session')->set('success', 'Your thread has been created.');

    redirect($redirect);
}