<?php



if (! $capsule->schema()->hasTable('__cornexaac_accounts')) {
    $capsule->schema()->create('__cornexaac_accounts', function($table)
    {
        $table->increments('id');
        $table->integer('created');
        $table->integer('points');
        $table->integer('account_id');
        $table->integer('site_access');
        $table->integer('total_points');
        $table->integer('forum_posts');
    });

    $capsule->schema()->getConnection()->unprepared('
        DROP TRIGGER IF EXISTS cornex_accounts
    ');

    $capsule->schema()->getConnection()->unprepared('
        CREATE TRIGGER cornex_accounts AFTER INSERT ON `accounts` FOR EACH ROW
        BEGIN
            INSERT INTO __cornexaac_accounts (`created`, `points`, `account_id`, `site_access`, `total_points`, `forum_posts`) VALUES (UNIX_TIMESTAMP(), 0, NEW.id, 0, 0, 0);
        END
    ');
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
        $table->integer('hide')->default(0);
        $table->integer('created');
    });

    $capsule->schema()->getConnection()->unprepared('
        DROP TRIGGER IF EXISTS cornex_players
    ');

    $capsule->schema()->getConnection()->unprepared('
        CREATE TRIGGER cornex_players AFTER INSERT ON `players` FOR EACH ROW
        BEGIN
            INSERT INTO __cornexaac_players (`player_id`, `comment`, `created`) VALUES (NEW.id, "", UNIX_TIMESTAMP());
        END
    ');
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
        $table->string('txn_id');
        $table->integer('time');
        $table->string('payment_amount');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_forum_boards')) {
    $capsule->schema()->create('__cornexaac_forum_boards', function($table){
        $table->increments('id');
        $table->string('title');
        $table->string('description');
        $table->integer('news');
        $table->integer('order');
    });
}


if (! $capsule->schema()->hasTable('__cornexaac_forum_posts')) {
    $capsule->schema()->create('__cornexaac_forum_posts', function($table){
        $table->increments('id');
        $table->string('title')->nullable();
        $table->string('content', 10000);
        $table->integer('is_reply')->default(0);
        $table->integer('thread_id');
        $table->integer('posted_by');
        $table->integer('created');
        $table->integer('views');
        $table->integer('lastip');
        $table->integer('board_id');
        $table->integer('locked');
        $table->integer('sticked');
    });
}


$news_board = $capsule->table('__cornexaac_forum_boards')->where('news', 1)->first();
if (is_null($news_board)) {
    $capsule->table('__cornexaac_forum_boards')->insert([
        'title'       => 'Latest News',
        'description' => 'All the news goes here.',
        'news'        => 1,
        'order'       => 1,
    ]); 
}

