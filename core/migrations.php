<?php

if (! $capsule->schema()->hasTable('__cornexaac_accounts')) {
    $capsule->schema()->create('__cornexaac_accounts', function($table)
    {
        $table->increments('id');
        $table->integer('created');
        $table->integer('points');
        $table->integer('account_id');
        $table->integer('site_access');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_news')) {
    $capsule->schema()->create('__cornexaac_news', function($table)
    {
        $table->increments('id');
        $table->string('title', 90);
        $table->string('content', 4500);
        $table->integer('created');
        $table->integer('posted_by');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_players')) {
    $capsule->schema()->create('__cornexaac_players', function($table)
    {
        $table->increments('id');
        $table->integer('player_id');
        $table->string('comment', 145);
        $table->integer('hide');
        $table->integer('created');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_shop_offers')) {
    $capsule->schema()->create('__cornexaac_shop_offers', function($table){
        $table->increments('id');
        $table->integer('is_package');
        $table->string('package_details');
        $table->integer('item_id');
        $table->integer('item_count');
        $table->integer('points');
        $table->string('item_description', 140);
        $table->string('item_title', 50);
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_shop_orders')) {
    $capsule->schema()->create('__cornexaac_shop_orders', function($table){
        $table->increments('id');
        $table->integer('offer_id');
        $table->integer('player_id');
        $table->integer('itemid');
        $table->integer('count');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_paypal_history')) {
    $capsule->schema()->create('__cornexaac_paypal_history', function($table){
        $table->increments('id');
        $table->integer('account_id');
        $table->integer('txn_id');
        $table->integer('time');
        $table->string('payment_amount');
    });
}


// Add columns
if (! $capsule->schema()->hasColumn('total_points', '__cornexaac_accounts')) {
    $capsule->schema()->table('__cornexaac_accounts', function($table)
    {
        $table->integer('total_points');
    });
}

