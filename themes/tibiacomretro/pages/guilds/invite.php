
<?php
    if (! $guild->canInvite()) {
        redirect('?subtopic=index');
    }

    include theme('includes/notifications.php');

    app()->getPageInclude(); 
?>

<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Invite Player</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<p>Enter the name of a character you want to invite to your guild and click on "Submit".</p>

<form action="" method="POST">
    <?php echo app('formtoken')->getField(); ?>
    <input type="hidden" name="guild_invite_id" value="<?php echo $guild->id; ?>">
    <table>
        <tr class="header">
            <th colspan="2">Invite Character</th>
        </tr>

        <tr>
            <th width="20%">Character:</th>
            <td>
                <input type="text" name="guild_invite_name">
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <th></th>
            <td>
                <input type="submit" value="Submit" class="button">
                <a href="<?php echo $guild->link(); ?>" class="button">Back</a>
            </td>
        </tr>
    </table>
</form>
