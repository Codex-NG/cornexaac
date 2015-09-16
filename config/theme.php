<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Theme
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/
	
	'theme' => 'tibiacomretro',

	/*
	|--------------------------------------------------------------------------
	| Includements
	|--------------------------------------------------------------------------
	|
	| [url_query => 'post-requests/file']
	|
	*/

	'includements' => [
		'subtopic=guilds&name={name}'                                 => request('guild_join'),
		'subtopic=guilds&name={name}&action=invite'                   => request('guild_invite'),
		'subtopic=register'                                           => request('register'),
		'subtopic=guilds&name={name}&action=edit'                     => request('guild_edit'),
		'subtopic=guilds&name={name}&action=leave'                    => request('guild_leave'),
		'subtopic=shop&buy={buy}'                                     => request('shop_buy'),
		'subtopic=newcharacter'                                       => request('new_character'),
		'subtopic=guilds&action=create'                               => request('guild_create'),
		'subtopic=login'                                              => request('login'),
		'subtopic=forum&board={board}&thread={thread}&action=reply'   => request('forum_reply'),
		'subtopic=forum&board={board}&thread={thread}&action=lock'    => request('forum_lock'),
		'subtopic=forum&board={board}&thread={thread}&action=unlock'  => request('forum_unlock'),
		'subtopic=forum&board={board}&thread={thread}&action=stick'   => request('forum_stick'),
		'subtopic=forum&board={board}&thread={thread}&action=unstick' => request('forum_unstick'),
		'subtopic=forum&board={board}&thread={thread}&action=delete'  => request('forum_delete'),
		'subtopic=forum&board={board}&action=create'                  => request('forum_create_thread'),
	],

	/*
	|--------------------------------------------------------------------------
	| Themes path
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'themes_path' => ROOT_PATH.'/themes',

	/*
	|--------------------------------------------------------------------------
	| Themes absolute URL path
	|--------------------------------------------------------------------------
	|
	| ....
	|
	*/

	'themes_absolute' => 'themes'

];