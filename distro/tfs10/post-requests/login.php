<?php

if (isset($_POST['account_name'], $_POST['password'])) {

	if (app('formtoken')->validateToken($_POST)) {

		$name = $_POST['account_name'];
		$password = $_POST['password'];

		$account = app('account');

		if (file_exists(theme('plugin/post-requests/login.php'))) {
			include theme('plugin/post-requests/login.php');
		}

		if (! $account->validate($name, $password)) {
			$login_errors[] = 'Account name or password did not match.';
		}

		if (! empty($login_errors)) {
			$app->make('errors')->set($login_errors);
			redirect(back());
		}

		$account->login($name, $password);

		$redirect = (isset($_GET['action'])) ? '?subtopic='.$_GET['action'] : '?subtopic=myaccount';
		
		redirect($redirect);
	}

}