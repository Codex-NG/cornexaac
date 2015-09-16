<?php

$validator = new App\Classes\Validator([
    'password' => ['required'],
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

    // Validate the password
    if (! $account->validatePassword($response->password)) {
        app('errors')->set(['Password is not correct.']);

        redirect(back());
    }

    app('guild')->where('name', $_GET['name'])->first()->delete();

    redirect('?subtopic=index');
}
