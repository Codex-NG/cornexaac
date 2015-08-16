<?php

if (isset($_POST['account_name'], $_POST['password'], $_POST['password_again'], $_POST['email'], $_POST['captcha_code'])) {

	if ($app->make('formtoken')->validateToken($_POST)) {

		$name = trim($_POST['account_name']);
		$password = trim($_POST['password']);
		$password_again = trim($_POST['password_again']);
		$email = trim($_POST['email']);
		$captcha = trim($_POST['captcha_code']);

		// Make sure the fields are not empty
		if ($name == "" || $password_again == "" || $password == "" || $email == "" || $captcha == "") {
			$register_errors[] = 'All fields are required.';
			$app->make('errors')->set($register_errors);
			redirect(back());
		} 

		$account = app('account');

		if (file_exists(theme('plugin/post-requests/register.php'))) {
			include theme('plugin/post-requests/register.php');
		}

		// Make sure account name is only letters and digits
		if (preg_match('/[^A-Za-z0-9]/', $name)) {
			$register_errors[] = 'Account name can only contains letters and digits.';
		} else {
			// Make sure the account name not already exist
			if (! is_null($account->where('name', $name)->first())) {
				$register_errors[] = 'Account name already exist.';
			}

			// Make sure the email not already exist
			if (! is_null($account->where('email', $email)->first())) {
				$register_errors[] = 'E-Mail already exist.';
			}
		}

		// Make sure the password is not to short or to long
		if (strlen($password) < 3 || strlen($password) > 40) {
			$register_errors[] = 'Password has to be between 3 - 40 characters long.';
		}

		// Make sure the email is not to short or to long
		if (strlen($email) < 3 || strlen($email) > 255) {
			$register_errors[] = 'E-Mail has to be between 3 - 40 characters long.';
		}

		// Make sure the email is valid
		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$register_errors[] = 'E-Mail is not a valid E-Mail address.';
		}

		// Make sure the password matches eachother 
		if ($password != $password_again) {
			$register_errors[] = 'Passwords do not match.';
		}

		// Make sure the captcha is correct
		if (! app('captcha')->check($captcha)) {
			$register_errors[] = 'Wrong captcha, try again.';
		}

		// Make sure the account name is not to short or to long
		if (strlen($name) < 3 || strlen($name) > 32) {
			$register_errors[] = 'Account name has to be between 3 - 32 characters long.';
		}

		if (! empty($register_errors)) {
			$app->make('errors')->set($register_errors);
			redirect(back());
		}	

		$app->make('session')->set('success', 'You have been registered.');

		$account->newr($name, $password, $email);

		$account->login($name, $password);
		
		redirect('?subtopic=myaccount');
	} 

}