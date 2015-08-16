<?php

if (isset($_POST['product_id'])) {

    if (isset($_POST['shop_buy_name']) || (isset($_POST['shop_buy_for']) && $_POST['shop_buy_for'] != "" )) {
        if (app('formtoken')->validateToken($_POST)) {

            $product_id = $_POST['product_id'];
            $character = app('character')->where('name', $_POST['shop_buy_name']);

            // Check for extensions
            if (file_exists(theme('plugin/post-requests/shop_buy.php'))) {
                include theme('plugin/post-requests/shop_buy.php');
            }

            $product = app('shop')->find($product_id);

            // Make sure user has enought of points
            if (app('account')->points() < $product->points) {
                $shop_buy_errors[] = 'You do not have enought of points.';
            }

            // Check if user want to buy as a gift
            if (isset($_POST['shop_buy_for']) && $_POST['shop_buy_for'] != "") {
                $character = app('character')->where('name', $_POST['shop_buy_for']);
            }

            // Make sure the character exists
            if (! $character->exists()) {
                $shop_buy_errors[] = 'Character do not exists.';
            }

            if (! empty($shop_buy_errors)) {
                $app->make('errors')->set($shop_buy_errors);

                redirect(back());
            }

            $product = app('shop')->find($product_id);

            app('shop')->newOrder($product->id, $character->first()->id, $product->item_id, $product->item_count);

            $app->make('session')->set('success', 'Thanks for your purchase.');

            redirect(back());
        }
    }

}