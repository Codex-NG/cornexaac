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

}