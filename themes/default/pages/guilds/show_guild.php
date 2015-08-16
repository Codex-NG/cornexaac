<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Show guild <?php echo $guild->name() ?></h3>
    </div>
    <div class="panel-body">
        <?php if ($guild->canInvite()): ?>
            <a href="<?php echo $guild->inviteLink(); ?>" class="btn btn-primary btn-xs"><i class="fa fa-user-plus"></i>
Invite player</a>
        <?php endif; ?>

        <?php if ($guild->isMember()): ?>
            <a href="<?php echo $guild->leaveLink(); ?>" class="btn btn-warning btn-xs"><i class="fa fa-user-times"></i>
 Leave guild</a>
        <?php endif; ?>

        <?php if ($guild->isOwner()): ?>
            <a href="<?php echo $guild->terminateLink(); ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i>
Terminate guild</a>
        <?php endif; ?>


        <table class="table table-striped" style="margin-top:10px;">  
            <?php if (! $guild->members()): ?>
                <tr>
                    <td colspan="2">This guild seems to not have any members..</td> 
                </tr>
            <?php else: ?>
                <?php foreach ($guild->members() as $member): ?>
                    <tr>
                        <td width="20%"><?php echo $member['rank'] ?></td> 
                        <td><?php echo char_link($member['name']) ?> <label class="label label-info"><?php echo $member['level'] . ' ' . $member['vocation'] ?></label></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        Invited characters
        <table class="table table-striped">
            <?php if (! $guild->invites()): ?>
                <tr>
                    <td>No invited players..</td>
                </tr>
            <?php else: ?>
                <?php foreach ($guild->invites() as $invite): ?>
                    <tr>
                        <td>
                            <?php echo char_link($invite['name']); ?> <label class="label label-info"><?php echo $invite['level'] . ' ' . $invite['vocation'] ?></label>
                            <div class="pull-right" id="guild-invites">
                                <?php if ($invite['owner']): ?>
                                    <form action="" method="POST">
                                        <?php echo app('formtoken')->getField(); ?>
                                        <input type="hidden" name="guild_join_id" value=<?php echo $guild->id ?>>
                                        <input type="hidden" name="guild_join_pid" value=<?php echo $invite['pid']?> >
                                        <input type="submit" value="Join guild" class="btn btn-primary btn-xs">
                                    </form>
                                <?php endif; ?>

                                <?php if ($guild->canInvite()): ?>
                                    <form action="" method="POST">
                                        <?php echo app('formtoken')->getField(); ?>
                                        <input type="hidden" name="guild_cancel_invite_pid" value=<?php echo $invite['pid'] ?>>
                                        <input type="hidden" name="guild_cancel_invite_gid" value=<?php echo $guild->id; ?>>
                                        <input type="submit" value="Cancel" class="btn btn-danger btn-xs">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
        <?php endif; ?>
        </table>
    </div>
</div>