
<?php
    
    if (! $guild->getUserMembersExpectOwner()) {
        redirect('?subtopic=guilds&name='. $_GET['name']);
    }

?>

<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Leave Guild</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<p>Select a character below to leave the guild with.</p>

<form action="" method="post" enctype="multipart/form-data">
    <?php echo app('formtoken')->getField(); ?>

    <table>
        <tr class="header">
            <th colspan="2">Leave Guild</th>
        </tr>

        <tr>
            <th width="20%" valign="top">Character:</th>
            <td>
                <table>
                    <tr class="transparent nopadding">
                        <td valign="top">
                            <?php foreach ($guild->getUserMembersExpectOwner() as $member): ?>
                                <input type="hidden" value="<?php echo $guild->id; ?>" name="guild_leave_id">
                                <input type="radio" name="guild_leave_character" value="<?php echo $member['player_id']; ?>">
                                <label><?php echo $member['name']; ?></label>
                                <br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <th></th>
            <td>
                <input type="submit" value="Submit" class="button">
                <a href="<?php echo url('?subtopic=guilds&name='. $guild->name()); ?>" class="button">Back</a>
            </td>
        </tr>
    </table>
</form>