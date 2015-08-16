<?php if (isset($_GET['action'])): $action = $_GET['action']; ?>

    <?php if ($action == 'newguild' && ! isset($_GET['name']) && isLoggedIn()): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Create guild</h3>
            </div>
            <div class="panel-body"> 
                <form action="" method="POST">
                    <?php echo app('formtoken')->getField(); ?>
                    <label>Guild name</label>
                    <p><input type="text" name="guild_create_name" class="form-control"></p>
                    <label>Select a character</label>
                    <p><select name="guild_create_character" class="form-control">
                        <?php foreach (app('account')->characters() as $character): ?>
                            <option value=<?php echo $character->id ?>><?php echo $character->getName(); ?></option>
                        <?php endforeach; ?>
                    </select></p>
                    <input type="submit" class="btn btn-success" value="Create guild">
                </form>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($action == 'terminate' && isset($_GET['name']) && $guild->isOwner()): ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Terminate guild <?php echo $guild->name() ?></h3>
            </div>
            <div class="panel-body">
                <p>Are you sure you want to terminate your guild? This cannot action cannot be undone.</p> 

                <form action="" method="POST">
                    <?php echo app('formtoken')->getField(); ?>
                    <input type="submit" class="btn btn-danger" value="Yes, proceed.">
                    <input type="hidden" name="delete_guild_id" value="<?php echo $guild->id; ?>">
                    <a href=<?php echo $guild->link(); ?> class="btn btn-success">No, take me away.</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($action == 'invite' && isset($_GET['name']) && $guild->canInvite()): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Invite a new player to guild <?php echo $guild->name() ?></h3>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <?php echo app('formtoken')->getField(); ?>
                    <label>Character name</label>
                    <p><input type="text" name="guild_invite_name" class="form-control"></p>
                    <input type="submit" class="btn btn-primary" value="Invite player">
                    <input type="hidden" name="guild_invite_id" value="<?php echo $guild->id; ?>">
                    <a href=<?php echo $guild->link(); ?> class="btn btn-default">Back</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($action == 'leave' && isset($_GET['name']) && $guild->isMember()): ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Leave guild <?php echo $guild->name() ?></h3>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <?php echo app('formtoken')->getField(); ?>
                    <label>Select a character you want to leave the guild with</label>
                    <p>
                        <select class="form-control" name="guild_leave_pid" >
                            <?php foreach ($guild->getUserMembers() as $member): ?>
                                <option value="<?php echo $member->player_id; ?>"><?php echo $member->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <input type="submit" class="btn btn-primary" value="Leave guild">
                    <input type="hidden" name="guild_leave_gid" value="<?php echo $guild->id; ?>">
                    <a href=<?php echo $guild->link(); ?> class="btn btn-default">Back</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>