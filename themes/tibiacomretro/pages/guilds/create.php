
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Found Guild</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<?php
    auth_only();

    $account = app('account');

    if (empty($account->characters())) {
        echo "Please <a href='".url('?subtopic=newcharacter')."'>create a new character</a> before you found a guild.";
        exit;
    }
?>

<form method="POST">
    <table>

        <tr class="header">
            <th colspan="3">Create Guild</th>
        </tr>

        <tr>
            <th width="20%">Guild Name:</th>
            <td>
                <input type="text" name="guild_create_name">

                <?php if ($validator->hasError('guild_create_name')): ?>
                    <em class="error"><?php echo $validator->getError('guild_create_name'); ?></em>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th width="20%">Select a character:</th>
            <td>
                <select name="guild_create_character" class="form-control">
                    <?php if (! empty($account->characters())): ?>
                        <?php foreach ($account->characters() as $character): ?>
                            <option value=<?php echo $character->id ?>><?php echo $character->getName(); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>

                    <?php endif; ?>
                </select>

                <?php if ($validator->hasError('guild_create_character')): ?>
                    <em class="error"><?php echo $validator->getError('guild_create_character'); ?></em>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <th></th>
            <td>
                <input type="submit" value="Submit" class="button">

                <a href="<?php echo url('?subtopic=guilds'); ?>" class="button">Back</a>
            </td>
        </tr>

    </table>
</form>
