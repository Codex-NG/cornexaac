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
		$news = self::orderBy('created', 'desc')->get();

		if ($news->count() == 0) return false;

		return $news;
	}

	/**
	 * Add news
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

}