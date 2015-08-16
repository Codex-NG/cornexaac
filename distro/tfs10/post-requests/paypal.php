<?php

if (isset($_POST['mc_gross'], $_POST['payer_id'])) {
    $points = config('paypal', 'offers')[$_POST['mc_gross']];

    if (file_exists(theme('plugin/post-requests/account.php'))) {
        include theme('plugin/post-requests/account.php');
    }

    $app->make('session')->set('success', 'Thanks for your payment, we have added a total of '.$points.' points to your account!');
    
    redirect('?subtopic=shop');
}