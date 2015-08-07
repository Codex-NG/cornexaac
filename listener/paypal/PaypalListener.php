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

    $points = config('paypal', 'offers')[$_POST['mc_gross']];
    $aid    = app('account')->where('name', $_POST['custom'])->first();

    $account = app('AACAccount')->where('account_id', $aid->id)->first();
    $account->points = $account->points + $points;
    $account->save();

    logg($ipnMessage);
});

$listener->onInvalid(function (MessageInvalidEvent $event) {
   $ipnMessage = $event->getMessage();

   logg($ipnMessage);
});

$listener->onVerificationFailure(function (MessageVerificationFailureEvent $event) {
    $error = $event->getError();

    logg($error);
});

$listener->listen();
