
<?php 
	$news = app('news')->allNews(); 
?>

<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Latest News</h1></td>
        <td valign="middle">
            <p>Here you will find the latest news about the server.<br>Come back often to stay informed about important changes in the game.</p>
        </td>
    </tr>
</table>

<?php if (! $news->items()): ?>
	<article class="news">
		<header class="news-header">
			<span class="news-date"><?php echo ago(time()) ?></span>
			<h2>Welcome to CornexAAC, version <?php echo config('app', 'version'); ?></h2>
		</header>

		<div class="news-content">
			<?php echo strip_tags('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. <p><p> Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '<p><h1><h2><strong><em><b><i><ul><ol><li><u><strike><hr><br><a><img>'); ?>
		</div>

		<footer class="news-footer">
			Published by <a href="#">CornexAAC</a> in <a href="#">Latest News</a> (<a href="#">12 comments</a>).
		</footer>
	</article>
<?php else: ?>
	<?php foreach($news as $news): ?>
		<article class="news">
			<header class="news-header">
				<span class="news-date"><?php echo ago($news->created); ?></span>
				<h2><?php echo $news->title?></h2>
			</header>

			<div class="news-content">
				<?php echo strip_tags($news->content, '<p><h1><h2><strong><em><b><i><ul><ol><li><u><strike><hr><br><a><img>'); ?>
			</div>

			<footer class="news-footer">
				Published by <?php echo char_link(playerIdToName($news->posted_by)) ?> 
				in 
				<a href="<?php echo url('?subtopic=forum&board='. $news->board_id) ?>">Latest News</a> 
				(<a href="<?php echo url('?subtopic=forum&board='. $news->board_id .'&thread='.$news->id) ?>"><?php echo $news->countReplies() ?> comments</a>).
			</footer>
		</article>

	<?php endforeach; ?>
<?php endif; ?>