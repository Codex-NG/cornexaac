<?php

if (isset($_POST['guild_description'], $_POST['guild_edit_id'])) {

    if (app('formtoken')->validateToken($_POST)) {

        $gid = e($_POST['guild_edit_id']);
        $guild_description = e(trim($_POST['guild_description']));

        $guild = app('guild')->find($gid);

        // Include plugin extension if exists
        if (file_exists(theme('plugin/post-requests/guild_edit.php'))) {
            include theme('plugin/post-requests/guild_edit.php');
        }

        // Make sure the guild exists
        if (is_null($guild) or ! isLoggedIn()) {
            redirect('?subtopic=guilds');

            // Make sure the user is owner of the guild
            if (! $guild->isOwner()) {
                redirect('?subtopic=guilds');
            }
        }

        if (strlen($guild_description) > 140) {
            $guild_edit_errors[] = 'Guild description to long.';
        }

        if (isset($_FILES['guild_edit_logo']) && file_exists($_FILES['guild_edit_logo']['tmp_name']) && is_uploaded_file($_FILES['guild_edit_logo']['tmp_name'])) {

            $extensions = ['gif', 'jpg', 'jpeg', 'png'];

            $file_ext = pathinfo($_FILES['guild_edit_logo']['name'], PATHINFO_EXTENSION);

            if ($_FILES['guild_edit_logo']['error'] !== UPLOAD_ERR_OK) {
                $guild_edit_errors[] = 'File not uploaded, error code: '. $_FILES['file']['error'];
            }

            $image = getimagesize($_FILES['guild_edit_logo']['tmp_name']);
            if ($image === FALSE) {
                $guild_edit_errors[] = 'Unable to determine image type of uploaded file';
            }

            if(! in_array($file_ext, $extensions) ) {
                $guild_edit_errors[] = 'File extension is not allowed.';
            }

            if (empty($guild_edit_errors)) {
                $temp = explode(".", $_FILES["guild_edit_logo"]["name"]);

                $newfilename = $guild->id . '.' . end($temp);

                move_uploaded_file($_FILES["guild_edit_logo"]["tmp_name"], theme('storage/guild_images/' . $newfilename));
            }
        }

        if (! empty($guild_edit_errors)) {
            app('errors')->set($guild_edit_errors);

            redirect(back());
        }

        $guild->motd = $guild_description;
        $guild->save();

        app('session')->set('success', 'You have successfully edited the guild.');

        redirect(back());
    }

}