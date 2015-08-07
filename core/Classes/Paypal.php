<?php namespace App\Classes;

class Paypal {

    /**
     * 
     */
    public function __construct()
    {
        $this->settings = (object) config('paypal');
    }

    /**
     * 
     */
    public function url()
    {
        return ($this->settings->sandbox['enabled']) ? $this->settings->sandbox['form_url'] : $this->settings->form_url ;
    }

    /**
     * 
     */
    public function email()
    {
        return ($this->settings->sandbox['enabled']) ? $this->settings->sandbox['email'] : $this->settings->email ;
    }

    /**
     * 
     */
    public function offers()
    {
        return $this->settings->offers;
    }

    /**
     * 
     */
    public function currency()
    {
        return $this->settings->currency;
    }

}