
<?php
	$player = app('character')->where('id', $post->posted_by)->first();

	$oddeven = ($i % 2 === 0 ? 'even' : 'odd');

	$gamemaster = ($player->isGamemaster() or $player->isGod()) ? 'forum-post-gamemaster' : '' ;

	$shareurl = (isset($_GET['page'])) ? '?subtopic=forum&board='. $thread->board_id .'&thread='. $thread->id .'&page='. $_GET['page'] .'#'. $i : '?subtopic=forum&board='. $thread->board_id .'&thread='. $thread->id .'#'. $i ;
?>

<tr class="nopadding transparent">
	<td colspan="2">
		<div class="<?php echo $gamemaster; ?>">
			<table>

				<tr class="<?php echo $oddeven; ?> forum-post">
					<th width="20%" valign="top">
						<a name="<?php echo $i; ?>"></a>

						<?php echo char_link(playerIdToName($post->posted_by)); ?><br>

						<?php if ($player->isTutor()): ?>
							<small>Tutor</small>
							<br><img src="<?php echo assets('assets/img/tutor.png') ?>"><br>
						<?php endif; ?>

						<?php if ($player->isGamemaster()): ?>
							<small>Gamemaster</small>
							<br><img src="<?php echo assets('assets/img/trial-gm.png') ?>"><br>
						<?php endif; ?>

						<?php if ($player->isGod()): ?>
							<small>God</small>
							<br><img src="<?php echo assets('assets/img/trial-gm.png') ?>"><br>
						<?php endif; ?>

						<small>
							<strong>Vocation:</strong> <?php echo $player->getVocation(); ?><br>

							<strong>Level:</strong> <?php echo $player->getLevel(); ?><br>

							<strong>Posts</strong> <?php echo app('account')->auth()->posts(); ?>

							<?php if ($player->hasGuild()): ?>
								<br><br>
							<?php endif; ?>
						</small>
					</th>
					<td valign="top" class="forum-post-content">
						<div class="post-content">
							<?php echo strip_tags($post->content, '<p><h1><h2><strong><em><b><i><ul><ol><li><u><strike><hr><br><a><img>') ?>
						</div>
					</td>
				</tr>

				<tr class="<?php echo $oddeven; ?> forum-post-footer">
					<th>
						<small>
							<abbr title="#"><?php echo ago($post->created) ?></abbr>
						</small>
					</th>

					<td align="right">
						<small>
							<a href="<?php echo url($shareurl) ?>">#<?php echo $i; ?></a>
						</small>
					</td>
				</tr>

			</table>
		</div>
	</td>
</tr>
<!-- <div style="margin-bottom:2px;"></div> -->