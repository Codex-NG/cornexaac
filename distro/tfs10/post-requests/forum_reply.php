<?php

$validator = new App\Classes\Validator([
    'author'  => ['required', 'charexist', 'charowner'],
    'content' => ['required']
]);

if ($validator->fails()) {
    app('session')->set('validator', $validator);

    redirect(back());
}

if ($validator->passes()) {
    $response = (object) $validator->value();

    $thread = app('forumpost')->where(function($query){
        $query->where('id', $_GET['thread']);
    })->first();

    $reply = app('forumpost')->create([
        'content'   => $response->content,
        'is_reply'  => 1,
        'title'     => $thread->title,
        'thread_id' => $thread->id,
        'posted_by' => $response->author,
        'created'   => time(),
        'board_id'  => $thread->board_id,
        'locked'    => 0,
        'sticked'   => 0,
    ]);

    $account = app('AACAccount')->where('id', app('AACAccount')->auth()->id)->first();
    $account->forum_posts = $account->forum_posts + 1;
    $account->save();

    $redirect = '?subtopic=forum&board='. $_GET['board'] .'&thread='. $_GET['thread'] .'#'. ($thread->replies()->count() - 1);

    redirect($redirect);
}