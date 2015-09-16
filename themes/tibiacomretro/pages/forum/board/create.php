<?php
    if (! $board->canCreateNew()) {
        redirect('?subtopic=forum');
    }
?>

<form method="POST">

    <table>
        <tr class="header">
            <th colspan="2">Create thread in <?php echo $board->title ?></th>
        </tr>

        <tr>
            <th width="20%">Title</th>
            <td>
                <input type="text" name="title">

                <?php if ($validator->hasError('title')): ?>
                    <em class="error"><?php echo $validator->getError('title'); ?></em><br>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>Author:</th>
            <td>
                <?php if ($characters = app('account')->auth()->characters()): ?>
                    <select name="author">
                        <?php foreach ($characters as $character): ?>
                            <option value="<?php echo $character->id ?>"><?php echo $character->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    Please create a character before you create a new thread.
                <?php endif; ?>

               <?php if ($validator->hasError('author')): ?>
                    <em class="error"><?php echo $validator->getError('author'); ?></em><br>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th valign="top">Content:</th>
            <td>
                <textarea id="reply" name="content"></textarea>

                <?php if ($validator->hasError('content')): ?>
                    <em class="error"><?php echo $validator->getError('content'); ?></em><br>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <td></td>
            <td>
                <input type="submit" value="Submit" class="button">
                <a href="#" class="button">Back</a>
            </td>
        </tr>
    </table>

</form>