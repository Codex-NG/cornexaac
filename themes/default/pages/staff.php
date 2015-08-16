
<?php $staffs = app('character')->getStaff() ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Staff Members
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <th width="40%">Name</th>
            <th>Position</th>
            <th>Status</th>
            <?php foreach ($staffs as $staff): ?>
                <tr>
                    <td><?php echo char_link($staff['name']); ?></td>
                    <td><?php echo $staff['position']; ?></td>
                    <td>
                        <?php if ($staff['status']): ?>
                            <label class="label label-success">ONLINE</label>
                        <?php else: ?>
                            <label class="label label-danger">OFFLINE</label>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>