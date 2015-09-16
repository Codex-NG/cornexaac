<?php namespace App\Classes;

class News extends \Illuminate\Database\Eloquent\Model {

	protected $table = '__cornexaac_news';

	public $timestamps = false;

	/**
	* Return all news from database, default order is created/desc. 
	* You can call this function anywhere for example by using:
	* $news = app('news')->allNews();
	*
	* $news will return false if there is no news in the database.
	* 
	* @return boolean array 
	*/
	public static function allNews()
	{
		$news = app('forumboard')->where('news', 1)->first();

		return $news->threads();
	}

	/**
	 * Add a new row to news
	 *
	 * @return void
	 */
	public function add($title, $content, $pid)
	{
		$new            = new $this;
		$new->title     = $title;
		$new->content   = $content;
		$new->created   = time();
		$new->posted_by = $pid;
		$new->save();
	}

	/**
	 * Get the total amount of replies to news
	 *
	 * @return integer
	 */
	public function comments()
	{
		$news = app('forumboard')->where('news', 1)->first();

		return $news->repliesCount();
	}

}