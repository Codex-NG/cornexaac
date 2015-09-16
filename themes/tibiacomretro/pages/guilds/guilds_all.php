
<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Guilds</h1></td>
        <td valign="middle">
            <p>Below is a list of all the available guilds. Click on any view button to get more information about a guild.</p>
        </td>
    </tr>
</table>

<table>
    <tr class="header">
        <th colspan="3">Guilds</th>
    </tr>
    <tr>
        <th>Logo</th>
        <th width="100%">Description</th>
        <th></th>
    </tr>
    <?php if (! $guilds->allGuilds()): ?>
        <tr>
            <td colspan="3">No guilds exists..</td>
        </tr>
    <?php else: ?>
        <?php foreach ($guilds->allGuilds() as $guild): ?>
            <tr>
                <td>
                    <?php if ($guild->hasLogo()): ?>
                        <img src="<?php echo assets('storage/guild_images/' . $guild->hasLogo()) ?>" width="64" height="64">
                    <?php else: ?>
                        <img src="<?php echo assets('storage/guild_images/default_guild.gif') ?>" width="64" height="64">
                    <?php endif; ?>
                </td>
                <td valign="middle">
                    <strong><?php echo $guild->name() ?></strong>
                    <?php if (! ($guild->description() == "")): ?>
                        <br><?php echo $guild->description(); ?>
                    <?php endif; ?>
                </td>
                <td valign="middle">
                    <a href="<?php echo $guild->link() ?>" class="button">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php if (isLoggedIn()): ?>
    <table>
        <tr class="transparent noborderpadding">
            <td>
                <a href="<?php echo url('?subtopic=guilds&action=create'); ?>" class="button">Found Guild</a>
            </td>
        </tr>
    </table>
<?php endif; ?>