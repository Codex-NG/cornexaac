<?php
    if (! $thread->isAdmin()) {
        redirect('?subtopic=forum');
    }
?>
    
<form method="POST">
    <input type="hidden" value="<?php echo $thread->id; ?>" name="thread_id">
    <table>
        <tr class="header">
            <th colspan="2">Delete thread <?php echo e($thread->title); ?></th>
        </tr>
        <tr>
            <td colspan="2">Are you sure you want to delete thread <strong><?php echo e($thread->title); ?></strong> by <strong><?php echo playerIdToName($thread->posted_by); ?></strong>?</td>
        </tr>
        <tr class="transparent noborderpadding">
            <th width="20%"></th>
            <td>
                <input type="submit" class="button" value="Submit">
                <a href="<?php echo url('?subtopic=forum&board='. $thread->board_id .'&thread='. $thread->id) ?>" class="button">Back</a>
            </td>
        </tr>
    </table>
</form>