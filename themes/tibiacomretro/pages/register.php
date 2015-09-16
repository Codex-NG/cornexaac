<?php 
	guest_only(); 	

	include theme('includes/notifications.php');
?>

<table class="heading">
	<tr class="transparent nopadding">
		<td width="50%" valign="middle"><h1>Sign Up</h1></td>
		<td valign="middle">
			Create your account in order to log in.
		</td>
	</tr>
</table>

<form class="form-horizontal" method="POST">
	<?php echo app('formtoken')->getField(); ?>
	<table>
		<tr class="header">
			<th colspan="2">Create Account</th>
		</tr>
		<tr>
			<th width="20%">Account:</th>
			<td>
				<input type="text" name="account_register">

				<?php if ($validator->hasError('account_register')): ?>
					<em class="error"><?php echo $validator->getError('account_register'); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th width="20%">Email:</th>
			<td>
				<input type="text" name="email_register">

				<?php if ($validator->hasError('email_register')): ?>
					<em class="error"><?php echo $validator->getError('email_register'); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th width="20%">Password:</th>
			<td>
				<input type="password" name="password_register">

				<?php if ($validator->hasError('password_register')): ?>
					<em class="error"><?php echo $validator->getError('password_register'); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th width="20%">Repeat:</th>
			<td>
				<input type="password" name="password_again">

				<?php if ($validator->hasError('password_again')): ?>
					<em class="error"><?php echo $validator->getError('password_again'); ?></em>
				<?php endif; ?>
			</td>
		</tr>
		<?php if (config('account', 'captcha')): ?>
			<tr>
				<th width="20%">Captcha:</th>
				<td>
					<img id="captcha" width="196" src="<?php echo app('captcha')->image() ?>" alt="CAPTCHA Image" /><br>

					<input type="text" name="captcha_code" class="form-control" size="10" maxlength="6" />

					<?php if ($validator->hasError('captcha_code')): ?>
						<em class="error"><?php echo $validator->getError('captcha_code'); ?></em><br>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2">
				<input type="checkbox" name="register_rules">
				<label for="terms">I agree with the <a href="#">Terms of Service</a> & <a href="#">Server Rules</a>.</label>

				<?php if ($validator->hasError('register_rules')): ?>
					<em class="error"><?php echo $validator->getError('register_rules'); ?></em><br>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="transparent noborderpadding">
			<th></th>
			<td>
				<input type="submit" value="Submit" class="button">
				<a href="#" class="button">Back</a>
			</td>
		</tr>
	</table>
</form>
