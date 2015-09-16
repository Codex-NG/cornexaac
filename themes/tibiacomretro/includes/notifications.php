<?php if (app('session')->has('success')): ?>
    <div class="success">
        <p><?php echo app('session')->get('success'); ?></p>
    </div>
<?php endif; ?>

<?php if (app('errors')->has()): ?>
    <div class="errors">
        <!-- <strong>Following errors has occured</strong><p><p> -->
        <ul style="list-style:none;">
            <?php foreach(array_flatten(app('errors')->get()) as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>