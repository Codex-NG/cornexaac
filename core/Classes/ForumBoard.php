<?php namespace App\Classes;

class ForumBoard extends \Illuminate\Database\Eloquent\Model {

    /**
     * Table for the modal to use
     */
	protected $table = '__cornexaac_forum_boards';

    /**
     * Make sure the modal not try to use timestamps tables
     */
	public $timestamps = false;

    /**
     * Store pagination object
     */
    public static $pagination;

    /**
     * Retrive all boards
     *
     * @return App\Classes\ForumBoard
     */
    public function boards()
    {
        return $this::orderBy('order', 'asc')->get();
    }

    /**
     * Retrive all posts that belongs board
     *
     * @return App\Classes\ForumPost
     */
    public function posts()
    {
        return app('forumpost')->where(function($query){
            $query->where('is_reply', 1);
            $query->where('board_id', $this->id);
        })->orderBy('created', 'desc')->get();
    }

    /**
     * Retrive all threads that belongs board
     *
     * @return App\Classes\ForumPost
     */
    public function threads()
    {
        $rows = app('forumpost')->where(function($query){
            $query->where('is_reply', 0);
            $query->where('board_id', $this->id);
        })->orderBy('created', 'desc')->paginate(config('forum', 'threads.per_page'))->appends(['subtopic' => 'forum', 'board' => $this->id]);

        $presenter = app('ThemeLoader')->config('presenter.forum-replies');

        static::$pagination = with(new $presenter($rows));
        
        return $rows;
    }

    /**
     * Return latest post information
     *
     * @return App\Classes\ForumPost
     */
    public function last()
    {
        $info = app('forumpost')->where(function($query){
            $query->where('board_id', $this->id);
        })->get()->toArray();

        return (object) last($info);
    }

    /**
     * Determinate if user can create a new thread or not
     *
     * @return boolean
     */
    public function canCreateNew()
    {
        if (! isLoggedIn()) return false;

        $required = 0;

        $access = app('AACAccount')->where('account_id', app('account')->auth()->id)->first()->site_access;

        if ($this->news == 1) $required = 1;

        return ($access >= $required);
    }

    /**
     * Retrive the pagination object
     *
     * @return object
     */
    public function pagination()
    {
        return static::$pagination;
    }

}