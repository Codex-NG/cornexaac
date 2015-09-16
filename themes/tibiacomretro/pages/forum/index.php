
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Forum</h1></td>
        <td valign="middle"></td>
    </tr>
</table>

<table>
    <tr class="header">
        <th width="60%">Board</th>
        <th>Posts</th>
        <th>Threads</th>
        <th>Latest Post</th>
    </tr>
    <?php if (! empty($boards)): ?>
        <?php foreach ($boards as $board): ?>
            <tr>
                <td>
                    <a href="<?php echo url('?subtopic=forum&board='. $board->id) ?>"><?php echo e($board->title); ?></a>

                    <?php if ($board->description): ?>
                        <br><?php echo e($board->description); ?>
                    <?php endif; ?>
                </td>

                <td><?php echo $board->posts()->count(); ?></td>

                <td><?php echo $board->threads()->count(); ?></td>

                <td>
                    <?php if ($board->threads()->count()): ?>
                        <?php $latest = $board->last(); ?>

                        <a href="<?php echo url('?subtopic=forum&board='. $board->id) ?>"><?php echo e($latest->title); ?></a><br>
                        <small>
                            by

                            <a href="#"><img src="<?php echo assets('assets/img/forum-latest.png'); ?>" class="forum-post-latest" width="8" height="8"></a>
                            
                            <a href="#"><?php echo playerIdToName($latest->posted_by); ?></a>,
                            <abbr title="<?php echo Carbon\Carbon::createFromTimestamp($latest->created) ?>"><?php echo ago($latest->created); ?></abbr>
                        </small>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">There are no forum boards as of right now.</td>
        </tr>
    <?php endif; ?>

    <tr class="header">
        <th colspan="4"><small>All times are <?php echo date('T'); ?></small></th>
    </tr>
</table>