<?php namespace App\Classes;

class ForumPost extends \Illuminate\Database\Eloquent\Model {

	/**
	 * Table for the modal to use
	 */
	protected $table = '__cornexaac_forum_posts';

	/**
	 * Mass-assignement columns
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'content', 'is_reply', 'thread_id', 'posted_by', 'created', 'board_id', 'locked', 'sticked'];

	/**
	 * Make sure the modal not try to use timestamps tables
	 */
	public $timestamps = false;

	/**
	 * Store the pagination object
	 */
	private static $pagination;

	/**
	 * Return latest post that belongs to thread information
	 *
	 * @return App\Classes\ForumPost
	 */
	public function last()
	{
		$info = $this->where(function($query){
			$query->where('id', $this->id);
		})->get()->toArray();

		return (object) last($info);
	}

	/**
	 * Determinate if the thread is locked or not
	 *
	 * @return boolean
	 */
	public function isLocked()
	{
		return (boolean) $this->locked;
	}

	/**
	 * Determinate if the thread is sticky or not
	 *
	 * @return boolean
	 */
	public function isSticked()
	{
		return (boolean) $this->sticked;
	}

	/**
	 * Retrive the signed in account data.
	 *
	 * @return Distro\Account
	 */
	public function user()
	{
		return app('account')->auth();
	}

	/**
	 * Determinate if user is admin
	 *
	 * @return boolean
	 */
	public function isAdmin()
	{
		if (! isLoggedIn()) return false;

		return (boolean) $this->user()->site_access;
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

	/**
	 * Get thread replies
	 *
	 * @return array
	 */
	public function replies()
	{
		$rows = $this->where(function($query){
			$query->where('thread_id', $this->id);
			$query->where('is_reply', 1);
		})->paginate(config('forum', 'replies.per_page'))->appends(['subtopic' => 'forum', 'board' => $this->board_id, 'thread' => $this->id]);

		$presenter = app('ThemeLoader')->config('presenter.forum-replies');

		static::$pagination = with(new $presenter($rows));

		return $rows;
	}

	/**
	 * Get thread amount replies
	 *
	 * Use this method to get amount of replies, and not replies()->count() 
	 * since replies() includes the main post
	 *
	 * @return integer
	 */
	public function countReplies()
	{
		return $this->where(function($query){
			$query->where('thread_id', $this->id);
			$query->where('is_reply', 1);
		})->count();
	}

}