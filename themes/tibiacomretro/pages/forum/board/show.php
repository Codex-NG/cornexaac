
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Forum</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<?php if ($board->description): ?>
    <p><?php echo $board->description; ?></p>
<?php endif; ?>

<table>
    <tr class="transparent noborderpadding">
        <td>
            <?php if ($board->canCreateNew()): ?>
                <a href="<?php echo url('?subtopic=forum&board='. $board->id .'&action=create') ?>" class="button">Create Thread</a>
            <?php endif; ?>
        </td>
        <td colspan="3" align="right"><?php echo $board->pagination()->render() ?></td>
    </tr>

    <tr class="header">
        <th width="54%">Thread</th>
        <th width="8%">Replies</th>
        <th width="8%">Views</th>
        <th>Latest Post</th>
    </tr>

    <?php if ($items = $threads->items()): ?>
        <?php foreach($items as $thread): ?>
            <tr>
                <td>
                    <?php if ($thread->isLocked()): ?>
                        <img src="<?php echo assets('assets/img/lock.png'); ?>" style="vertical-align: top;" title="locked">
                    <?php endif; ?>

                    <?php if ($thread->isSticked()): ?>
                        <img src="<?php echo assets('assets/img/pin.png') ?>" style="vertical-align: top;" title="sticked">
                    <?php endif; ?>
                    
                    <a href="<?php echo url('?subtopic=forum&board='.$thread->board_id.'&thread=' . $thread->id) ?>"><?php echo e($thread->title); ?></a>

                    <br>
                    <small>
                        by
                        <?php echo char_link(playerIdToName($thread->posted_by)); ?>,
                        <abbr title="<?php echo Carbon\Carbon::createFromTimestamp($thread->created) ?>"><?php echo ago($thread->created); ?></abbr>
                    </small>
                </td>

                <td><?php echo $thread->countReplies() ?></td>

                <td><?php echo $thread->views ?></td>

                <td>
                    <small>
                        by
                        <?php $latest = $thread->last(); ?>

                        <a href="#"><img src="<?php echo assets('assets/img/forum-latest.png') ?>" class="forum-post-latest" width="8" height="8"></a>

                        <?php echo char_link(playerIdToName($latest->posted_by)); ?>,
                        <abbr title="<?php echo Carbon\Carbon::createFromTimestamp($latest->created) ?>"><?php echo ago($latest->created); ?></abbr>
                    </small>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">There are no threads as of right now. Why don't you create one?</td>
        </tr>
    <?php endif; ?>

    <tr class="header">
        <th colspan="4"><small>All times are <?php echo date('T'); ?></small></th>
    </tr>

    <tr class="transparent noborderpadding">
        <td>
            <?php if ($board->canCreateNew()): ?>
                <a href="#" class="button">Create Thread</a>
            <?php endif; ?>
        </td>
        <td colspan="3" align="right"><?php echo $board->pagination()->render() ?></td>
    </tr>
</table>