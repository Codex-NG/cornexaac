
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Edit Guild</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<p>If you want to change the description of your guild, edit the corresponding field and click on the "Submit" button.</p>

<form action="" method="post" enctype="multipart/form-data">
    <?php echo app('formtoken')->getField(); ?>
    <input type="hidden" name="guild_edit_id" value="<?php echo $guild->id ?>">
    <table>
        <tr class="header">
            <th colspan="2">Edit Guild</th>
        </tr>
        <tr>
            <th valign="top" width="20%">Description:</th>
            <td>
                <table>
                    <tr class="transparent nopadding">
                        <td valign="top"><textarea name="guild_description"><?php echo lines($guild->description(), 5); ?></textarea></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <th></th>
            <td>
                <input type="submit" value="Submit" class="button">
                <a href="<?php echo url('?subtopic=guilds&name='.$guild->name()) ?>" class="button">Back</a>
            </td>
        </tr>

    </table>

    <br>

    <p>If you want to change the logo of your guild, enter the path to a 64*64 pixels icon (gif, jpg, jpeg, png) and click on the "Submit" button.</p>

    <table>
        <tr class="header">
            <th colspan="2">Edit Logo</th>
        </tr>

        <tr>
            <th valign="top" width="20%">
                <?php if ($guild->hasLogo()): ?>
                    Logo:
                    <small>(<a href="#">Remove</a>)</small>:
                <?php else: ?>
                    Logo:
                <?php endif; ?>
            </th>
            <td>
                <?php if ($guild->hasLogo()): ?>
                    <img src="<?php echo assets('storage/guild_images/'. $guild->hasLogo()); ?>" width="64" height="64">
               <?php else: ?>
                    <img src="<?php echo assets('storage/guild_images/default_guild.gif') ?>" width="64" height="64">
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>New Logo:</th>
            <td>
                <input type="file" name="guild_edit_logo">
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