<?php

$validator = new App\Classes\Validator([
	'account_login'  => 'required',
	'password_login' => 'required'
]);

// If the validation fails
if ($validator->fails()) {
	app('session')->set('validator', $validator);

	redirect(back());
}

// If the validation success
if ($validator->passes()) {

	$account = app('account');
	$name = $_POST['account_login'];
	$password = $_POST['password_login'];

	// Verify the login credentials 
	if (! $account->validate($name, $password)) {
		app('errors')->set([
			'Account name and password did not match.'
		]);

		redirect(back());
	}

	// Login the user
	$account->login($name, $password);

	// Check the URL for a action parameter, if we have one we will redirect to that page
	$redirect = (isset($_GET['action'])) ? '?subtopic='.$_GET['action'] : '?subtopic=myaccount';

	// Set success message
	app('session')->set('success', 'You have been logged in.');

	redirect($redirect);
}
