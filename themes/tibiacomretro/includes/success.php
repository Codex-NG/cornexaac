<?php if (app('session')->has('success')): ?>
    <div class="success">
        <p><?php echo app('session')->get('success'); ?></p>
    </div>
<?php endif; ?>