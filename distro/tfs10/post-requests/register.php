<?php

$validator = new App\Classes\Validator([
    'register_rules'    => ['required'],
	'account_register'  => ['required', 'unique:accounts,name', 'min:3', 'max:32'],
	'password_register' => ['required', 'min:4', 'max:40'],
	'password_again'    => ['required', 'same:password_register'],
	'email_register'    => ['required', 'unique:accounts,email', 'min:3', 'max:255', 'email'],
    'captcha_code'      => (config('account', 'captcha')) ? ['required'] : []
]);

// If the validation fails
if ($validator->fails()) {
    app('session')->set('validator', $validator);

	redirect(back());
}

// If the validation passes
if ($validator->passes()) {
    $response = (object) $validator->value();

    $account = app('account');

    $account->register($response->account_register, $response->password_register, $response->email_register);

    $account->login($response->account_register, $response->password_register);

    app('session')->set('success', 'You have been registered.');

    redirect('?subtopic=myaccount');
}
