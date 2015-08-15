<?php namespace App\Classes;

require_once __DIR__.'/securimage/securimage.php';

class Captcha {

    /**
     * Construct the class
     *
     * @return void
     */
    public function __construct()
    {
        $this->securimage = new \Securimage();
    }

    /**
     * Verify the captcha
     *
     * @return boolean
     */
    public function check($code)
    {
        return $this->securimage->check($code);
    }

    /**
     * Get the captcha image
     *
     * @return image
     */
    public function image()
    {
        return url('core/classes/securimage/securimage_show.php');
    }

}