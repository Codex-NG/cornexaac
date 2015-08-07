<?php namespace App\Classes;

class News extends \Illuminate\Database\Eloquent\Model {

	protected $table = '__cornexaac_news';

	/**
	* Return all news from database, default order is created/desc. 
	* You can call this function anywhere for example by using:
	* $news = App\Classes\News::allNews();
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

}