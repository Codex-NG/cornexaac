<?php

include __DIR__.'/../../loader.php';

use Mdb\PayPal\Ipn\Event\MessageInvalidEvent;
use Mdb\PayPal\Ipn\Event\MessageVerificationFailureEvent;
use Mdb\PayPal\Ipn\Event\MessageVerifiedEvent;
use Mdb\PayPal\Ipn\ListenerBuilder\Guzzle\InputStreamListenerBuilder as ListenerBuilder;

$listenerBuilder = new ListenerBuilder();

if (config('paypal', 'sandbox.enabled')) {
    $listenerBuilder->useSandbox();
}

$listener = $listenerBuilder->build();

$listener->onVerified(function (MessageVerifiedEvent $event) {
    $ipnMessage = $event->getMessage();

    $error = false;
    $txn_id = $_POST['txn_id'];
    $payment_status = $_POST['payment_status'];
    $receiver_email = $_POST['receiver_email'];
    $mc_gross = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];

    // check that txn_id has not been previously processed
    $txn_res = app('capsule')->table('__cornexaac_paypal_history')->where('txn_id', $txn_id);
    if ($txn_res->exists()) {
        $error = true;
    }

    // check whether the payment_status is Completed
    if ($payment_status != "Completed") {
        $error = true;
    }

    // check that receiver_email is your PayPal email
    if ($receiver_email != app('paypal')->email()) {
        $error = true;
    }

    $paypal = app('paypal')->offers();
    // check that payment_amount exists
    if (! isset($paypal[$mc_gross])) {
        $error = true;
    }

    // check payment_currency are correct
    if ($payment_currency != app('paypal')->currency()) {
        $error = true;
    }

    // process payment and mark item as paid.
    if (! $error) {
        $points   = $paypal[$mc_gross];
        $account  = app('account')->where('name', $_POST['custom'])->first();

        app('capsule')->table('__cornexaac_paypal_history')->insert([
            'account_id'     => $account->id,
            'txn_id'         => $txn_id,
            'time'           => time(),
            'payment_amount' => $mc_gross
        ]);

        $account = app('AACAccount')->where('account_id', $account->id)->first();
        $account->points = $account->points + $points;
        $account->total_points = $account->total_points + $points;
        $account->save();
    }

    logger($ipnMessage);
});

$listener->onInvalid(function (MessageInvalidEvent $event) {
   $ipnMessage = $event->getMessage();

   logger($ipnMessage);
});

$listener->onVerificationFailure(function (MessageVerificationFailureEvent $event) {
    $error = $event->getError();

    logger($error);
});

$listener->listen();
