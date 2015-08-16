
<?php guest_only(); include theme('includes/alerts.php'); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Register</h3>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="POST">
			<?php echo app('formtoken')->getField(); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Account name</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="account_name" placeholder="3 to 32 characters">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">E-Mail</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="email" placeholder="3 to 255 characters">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-9">
					<input type="password" name="password" class="form-control" placeholder="3 to 40 characters">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Password again</label>
				<div class="col-sm-9">
					<input type="password" name="password_again" class="form-control" placeholder="3 to 40 characters">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Captcha</label>
				<div class="col-sm-9">
					<img id="captcha" src="<?php echo app('captcha')->image() ?>" alt="CAPTCHA Image" />
					<input type="text" name="captcha_code" class="form-control" size="10" maxlength="6" />
					<a href="#" onclick="document.getElementById('captcha').src = '<?php echo app('captcha')->image() ?>?' + Math.random(); return false">[ Different Image ]</a>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-primary">Register</button>
				</div>
			</div>
		</form>

	</div>
</div>