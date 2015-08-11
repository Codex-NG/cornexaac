<?php namespace App\Classes;

class Shop extends \Illuminate\Database\Eloquent\Model {

    /**
     * Table for the model to use
     */
    protected $table = '__cornexaac_shop_offers';

    /**
     * Make sure we not wanna use timestamps
     */
    public $timestamps = false;

    /**
     * Get all donate offers
     *
     * @return boolean|array
     */
    public function getOffers()
    {
        return self::all();
    }

    /**
     * Add a new order to database
     *
     * @return void
     */
    public function newOrder($offer_id, $pid, $itemid, $count)
    {
        app('capsule')->table('__cornexaac_shop_orders')->insert([
            'offer_id' => $offer_id, 
            'player_id' => $pid, 
            'itemid' => $itemid, 
            'count' => $count
        ]);

        app('account')->removePoints(app('shop')->where('id', $offer_id)->first()->points);
    }

}