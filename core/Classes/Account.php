<?php namespace App\Classes;

class Account extends \Illuminate\Database\Eloquent\Model {

    /**
     * Table for the modal to use
     */
	protected $table = '__cornexaac_accounts';

    /**
     * Make sure the modal not try to use timestamps tables
     */
	public $timestamps = false;

    /**
     * Get users points
     *
     * @return integer
     */
    public function points()
    {
        return $this->where('account_id', app('account')->auth()->id)->first()->points;
    }

    /**
     * Retrive loggedin data from AAC accounts
     *
     * @return array
     */
    public function attributes($key = null)
    {
        $data = $this->where('account_id', app('account')->attributes('id'))->first();

        if (! is_null($key)) {
            return $data->$key;
        }

        return $data;
    }

}