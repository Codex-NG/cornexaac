

<?php $news = app('news')->allNews(); ?>

<?php if (! $news): ?>
	<div class="panel panel-default">
		<div class="panel-body">
			No news to display..
		</div>
	</div>
<?php else: ?>
	<?php foreach($news as $news): ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $news['title'] ?></h3>
			</div>
			<div class="panel-body">
				<?php
					echo $news['content'];
				?>
				<hr>
				<small>Written <?php echo ago($news['created']); ?> by <a href="#"><?php echo playerIdToName($news['posted_by']); ?></a></small>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>