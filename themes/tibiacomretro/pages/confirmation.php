
<?php 
    $session = app('session');

    if (! $session->has('confirmation')): 
        return redirect('?subtopic=index');
    endif; 

    $session->destroy('fields');
    $session->destroy('confirmation');
?>

<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Confirmation</h1></td>
        <td valign="middle">

        </td>
    </tr>
</table>

<p>If you want to change the description of your guild, edit the corresponding field and click on the "Submit" button.</p>

<form action="" method="post" >
    <?php echo app('formtoken')->getField(); ?>

    <p>If you want to change the logo of your guild, enter the path to a 64*64 pixels icon (gif, jpg, jpeg, png) and click on the "Submit" button.</p>

    <table>
        <tr class="header">
            <th colspan="2">Edit Logo</th>
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