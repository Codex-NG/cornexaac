
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Guilds</h1></td>
        <td valign="middle">
            <p>Information abouts guild.</p>
        </td>
    </tr>
</table>



<table>
    <tr class="transparent noborderpadding">
        <th valign="middle">
            <?php if ($guild->hasLogo()): ?>
                <img src="<?php echo assets('storage/guild_images/' . $guild->hasLogo()) ?>" width="64" height="64">
            <?php else: ?>
                <img src="<?php echo assets('storage/guild_images/default_guild.gif') ?>" width="64" height="64">
            <?php endif; ?>
        </th>

        <th align="center" valign="middle" width="100%">
            <h1><?php echo $guild->name(); ?></h1>
        </th>

        <th valign="middle">
            <?php if ($guild->hasLogo()): ?>
                <img src="<?php echo assets('storage/guild_images/' . $guild->hasLogo()) ?>" width="64" height="64">
            <?php else: ?>
                <img src="<?php echo assets('storage/guild_images/default_guild.gif') ?>" width="64" height="64">
            <?php endif; ?>
        </th>
    </tr>

    <tr class="transparent noborderpadding">
        <td colspan="3">
            <p><?php echo nl2br(e(lines($guild->description(), 5))) ?></p>
        </td>
    </tr>
</table>

<?php if ($guild->isOwner()): ?>
    <table>
        <tr class="transparent noborderpadding">
            <td>
                <a href="<?php echo url('?subtopic=guilds&name='. $guild->name() . '&action=edit') ?>" class="button">Edit Guild</a>
            </td>

            <td align="right">
                <a href="<?php echo url('?subtopic=guilds&name='. $guild->name() . '&action=disband') ?>" class="button">Disband Guild</a>
            </td>
        </tr>
    </table>
    <br>
<?php endif; ?>

<table>
    <tr class="header">
        <th colspan="4">Members</th>
    </tr>
    <tr>
        <th width="25%">Rank</th>
        <th width="50%">Name</th>
        <th width="9%">Level</th>
        <th>Vocation</th>
    </tr>
    <?php if (! $guild->members()): ?>
        <tr>
            <td colspan="2">This guild seems to not have any members..</td> 
        </tr>
    <?php else: ?>
        <?php foreach ($guild->members() as $rank => $members): ?>
            <tr>
                <td width="20%"><?php echo $rank ?></td> 
                <?php $first = false; foreach($members as $member): ?>

                    <?php if ($first): ?> <tr> <td></td><?php endif; ?>
                    <td>
                        <?php echo char_link($member['name']) ?> (Nick) 
                    </td>
                    <td><?php echo $member['level']; ?></td>
                    <td><?php echo $member['vocation']; ?></td>
                    <?php if ($first): ?></tr> <?php endif; ?>

                <?php $first = true;  endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>



<?php if ($guild->isMember()): ?>
    <table>
        <tr class="transparent noborderpadding">
            <td>
                <?php if ($guild->getUserMembersExpectOwner()): ?>
                    <a href="<?php echo url($guild->leaveLink()) ?>" class="button">Leave Guild</a>
                <?php endif; ?>

                <?php if ($guild->isOwner()): ?>
                    <a href="#" class="button">Edit Ranks</a>
                <?php endif; ?>

                <?php if ($guild->isOwner() && $guild->totalMembers() > 1): ?>
                    <a href="#" class="button">Resign from Leadership</a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
<?php endif; ?>

<br><br>

<table>
    <tr class="header">
        <th colspan="3">Pendling Invites</th>
    </tr>
    <tr>
        <th width="75%">Name</th>
        <th width="9%">Level</th>
        <th>Vocation</th>
    </tr>
    <?php if (! $guild->invites()): ?>
        <tr>
            <td colspan="3">No invited characters found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($guild->invites() as $invite): ?>
            <tr>
                <td>
                    <?php echo char_link($invite['name']); ?> 
                    <?php if ($invite['owner']): ?>
                        <form action="" method="POST" style="float:right;">
                            <?php echo app('formtoken')->getField(); ?>
                            <input type="hidden" name="guild_join_id" value=<?php echo $guild->id ?>>
                            <input type="hidden" name="guild_join_pid" value=<?php echo $invite['pid']?> >
                            <input type="submit" value="Join guild" class="button">
                        </form>
                    <?php endif; ?>

                    <?php if ($guild->canInvite()): ?>
                        <form action="" method="POST" style="float:right;margin-right:5px;">
                            <?php echo app('formtoken')->getField(); ?>
                            <input type="hidden" name="guild_cancel_invite_pid" value=<?php echo $invite['pid'] ?>>
                            <input type="hidden" name="guild_cancel_invite_gid" value=<?php echo $guild->id; ?>>
                            <input type="submit" value="Cancel" class="button">
                        </form>
                    <?php endif; ?>
                </td>
                <td><?php echo $invite['level']; ?></td>
                <td><?php echo $invite['vocation']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<table>
    <tr class="transparent noborderpadding">
        <td>
            <?php if ($guild->canInvite()): ?>
                <a href="<?php echo $guild->inviteLink(); ?>" class="button">Invite player</a>
            <?php endif; ?>
        </td>
    </tr>
</table>
