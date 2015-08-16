<?php

if (isset($_POST['add_news_content'], $_POST['add_news_title'], $_POST['add_news_post_as'])) {

    if (app('formtoken')->validateToken($_POST)) {

        $title = $_POST['add_news_title'];
        $content = $_POST['add_news_content'];
        $pid = $_POST['add_news_post_as'];

        // Check for extensions
        if (file_exists(theme('plugin/post-requests/create_news.php'))) {
            include theme('plugin/post-requests/create_news.php');
        }

        // Make sure the fields not are empty
        if ($title == '' || $content == '') {
            $create_news_errors[] = 'All fields are required.';
        }

        $character = app('character')->where('id', $pid);

        // Make sure the user owns the character he tries to post as
        if (! $character->exists()) {
            $create_news_errors[] = 'Selected character do not exists.';
        }

        // Make sure the user owns the character he tries to post as
        if (! $character->first()->isOwner()) {
            $create_news_errors[] = 'You do not own the selected character.';
        }

        // Make sure the title only contains letters, digits and spaces
        if (! ctype_alnum(preg_replace('/\s/', '', $title))) {
            $create_news_errors[] = 'Title can only contains letters, digits and spaces.';
        }

        // Errors found
        if (! empty($create_news_errors)) {
            $app->make('errors')->set($create_news_errors);
            redirect(back());
        }

        $new = app('news')->add($title, $content, $pid);

        // No errors found
        $app->make('session')->set('success', 'You have successfully submit a news record.');

        redirect(back());
    }

}