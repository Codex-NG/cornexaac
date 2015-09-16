
<?php
    $offers = app('shop')->getOffers();

    $paypal = app('paypal');

    $accountName = (isLoggedIn()) ? app('account')->auth()->name : '' ;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Buy points</h3>
    </div>
    <div class="panel-body">
        <table class="table">
            <form method="POST" action="<?php echo $paypal->url() ?>">
    
                <input type="hidden" name='cmd' value='_xclick')>
                <input type="hidden" name='business' value="<?php echo $paypal->email() ?>")>
                <input type="hidden" name='item_name' value='Points')>
                <input type="hidden" name='item_number' value="1")>

                <div class="l-text">Account name:</div>
                <div class="input-field">
                    <input type='text' name='custom' value='<?php echo $accountName; ?>' required>
                </div><p><p>

                <select name="amount">
                    <?php foreach ($paypal->offers() as $dollar => $points): ?>
                        <option value="<?php echo $dollar; ?>"><?php echo $points; ?> points for <?php echo $dollar.' '.$paypal->currency() ?> </option>
                    <?php endforeach; ?>
                </select><p><p>

                <input type="hidden" name='tax' value="0">
                <input type="hidden" name='no_shipping' value="1">
                <input type="hidden" name='no_note' value="1">
                <input type="hidden" name='lc' value='GB'>
                <input type="hidden" name='bn' value='PP-BuyNowBF'>
                <input type="hidden" name='currency_code' value="<?php echo $paypal->currency(); ?>">
                <input type="hidden" name='return' value="<?php echo url('?subtopic=shop'); ?>">
                <input type="hidden" name='notify_url' value="<?php echo url('listener/paypal/PaypalListener.php'); ?>" >
                <input type="hidden" name='cancel_return' value="<?php echo url('?subtopic=shop'); ?>">
                <input type="hidden" name='rm' value="2">

                <input type="submit" value="Buy points">
            </form>
        </table>
    </div>
</div>