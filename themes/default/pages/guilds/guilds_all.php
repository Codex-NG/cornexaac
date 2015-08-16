<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Guilds</h3>
    </div>
    <div class="panel-body">
        <?php if (isLoggedIn()): ?>
            <a href=<?php echo url('?subtopic=guilds&action=newguild') ?> class="btn btn-primary btn-xs">Create a guild</a>
        <?php endif; ?>

        <table class="table">
            <th>Name</th>
            <th>Members</th>
            <th>Founded</th>
            <?php if (! $guilds->allGuilds()): ?>
                <tr>
                    <td colspan="3">No guilds exists..</td>
                </tr>
            <?php else: ?>
                <?php foreach ($guilds->allGuilds() as $guild): ?>
                    <tr>
                        <td><a href="<?php echo $guild->link() ?>"><?php echo $guild->name(); ?></a></td>
                        <td><?php echo $guild->totalMembers() ?></td>
                        <td><?php echo $guild->creation() ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>  
</div>