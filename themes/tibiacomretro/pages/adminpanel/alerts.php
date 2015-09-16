<?php if (app('session')->has('success')): ?>
	<div class="alert alert-success">
		<?php echo app('session')->get('success'); ?>
	</div>
<?php endif; ?>

<?php if (app('errors')->has()): ?>
	<div class="alert alert-danger">
		<strong>Following errors has occured</strong><p><p>
        <ul>
    		<?php foreach(app('errors')->get() as $error): ?>
    			<li><?php echo $error; ?></li>
    		<?php endforeach; ?>
        </ul>
	</div>
<?php endif; ?>