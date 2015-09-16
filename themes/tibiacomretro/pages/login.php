
<?php 
	guest_only(); 

	include theme('includes/notifications.php');
?>

<table class="heading">
	<tr class="transparent nopadding">
		<td width="50%" valign="middle"><h1>Account</h1></td>
		<td valign="middle">
			View and edit your account.
		</td>
	</tr>
</table>


<form class="form-horizontal" method="POST">
	<?php echo app('formtoken')->getField(); ?>
	<table>
		<tr class="header">
			<th colspan="2">Login</th>
		</tr>
		<tr>
			<th width="20%"><label>Account:</label></th>
			<td>
				<input type="password" name="account_login">

				<?php if ($validator->hasError('account_login')): ?>
					<em class="error"><?php echo $validator->getError('account_login'); ?></em><br>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th width="20%"><label>Password:</label></th>
			<td>
				<input type="password" name="password_login">

				<?php if ($validator->hasError('password_login')): ?>
					<em class="error"><?php echo $validator->getError('password_login'); ?></em><br>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="transparent noborderpadding">
			<th></th>
			<td><input type="submit" value="Submit" class="button"></td>
		</tr>
	</table>
</form>
