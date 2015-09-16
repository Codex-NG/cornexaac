<?php if (app('errors')->has()): ?>
	<div class="errors">
		<!-- <strong>Following errors has occured</strong><p><p> -->
        <ul>
    		<?php foreach(array_flatten(app('errors')->get()) as $error): ?>
    			<li><?php echo $error; ?></li>
    		<?php endforeach; ?>
        </ul>
	</div>
<?php endif; ?>