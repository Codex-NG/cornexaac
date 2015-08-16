
<?php guest_only(); include theme('includes/alerts.php'); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Login</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="POST">
			<?php echo app('formtoken')->getField(); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Account name</label>
				<div class="col-sm-9">
					<input type="password" name="account_name" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-9">
					<input type="password" name="password" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</div>
		</form>

	</div>
</div>