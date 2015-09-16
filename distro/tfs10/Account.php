<?php namespace distro\tfs10;

class Account extends \distro\tfs10\eloquent\AccountEloquent {

    /**
     * Retrive the account name.
     *
     * @return string|integer
     */
    public function getName()
    {
        return e($this->name);
    }

    /**
     * Retrive the account email.
     *
     * @return string
     */
    public function getEmail()
    {
        return e($this->email);
    }

    /**
     * Retrive the accounts current points.
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->AACAccount()->points;
    }

    /**
     * Retrive the accounts total points.
     *
     * @return integer
     */
    public function getTotalPoints()
    {
        return $this->AACAccount()->total_points;
    }

    /**
     * Determinate if account has premium or not
     *
     * @return boolean
     */
    public function isPremium()
    {
        return (boolean) ($this->premdays > 0);
    }

    /**
     * Retrive the total forum posts made by account.
     *
     * @return integer
     */
    public function posts()
    {
        return (int) $this->AACAccount()->forum_posts;
    }

}