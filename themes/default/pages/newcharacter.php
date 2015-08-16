<?php auth_only(); include theme('includes/alerts.php'); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">New Character</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="POST">
			<?php echo app('formtoken')->getField(); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Character name</label>
				<div class="col-sm-9">
					<input type="text" name="character_name" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Vocation</label>
				<div class="col-sm-9">
					<?php foreach(config('character', 'newcharvocations') as $id): ?>
						<label class="radio-inline"><input type="radio" value="<?php echo $id ?>" name="character_voc"><?php echo vocIdToName($id) ?> </label>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Sex</label>
				<div class="col-sm-9">
					<label class="radio-inline"><input type="radio" value="0" name="character_sex">Female</label>
					<label class="radio-inline"><input type="radio" value="1" name="character_sex">Male</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Town</label>
				<div class="col-sm-9">
					<?php foreach(config('character', 'newchartowns') as $id): ?>
						<label class="radio-inline"><input type="radio" value="<?php echo $id ?>" name="character_town"><?php echo townIdToName($id) ?> </label>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
			</div>
		</form>
	</div>
</div>