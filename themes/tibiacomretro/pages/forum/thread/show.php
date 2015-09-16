
<?php
	if (is_null($thread)) {
		redirect('?subtopic=forum');
	}

	$posts = $thread->replies();

	$threadlink = url('?subtopic=forum&board='. $thread->board_id .'&thread='. $thread->id);

	include theme('includes/notifications.php');

	$page = (int) (isset($_GET['page'])) ? $_GET['page'] : 1;
	$total = config('forum', 'replies.per_page');
	$perPage = $total;
	$offset = ($page * $perPage) - $perPage;

	if ($thread->lastip != ip2long(userIP())) {
		$thread->views  = $thread->views + 1;
		$thread->lastip = ip2long(userIP());
		$thread->save();
	}
?>

<table class="heading">
    <tr class="transparent nopadding">
        <td width="50%" valign="middle"><h1>Forum</h1></td>
        <td valign="middle"></td>
    </tr>
</table>

<table>
	<tr class="transparent noborderpadding">
		<td>
			<?php if (! $thread->isLocked() && isLoggedIn()): ?>
				<a href="<?php echo url($threadlink . '&action=reply') ?>" class="button">Reply to thread</a>
			<?php endif; ?>

			<?php if ($thread->isAdmin()): ?>
				<?php if ($thread->isLocked()): ?>
					<a href="<?php echo url($threadlink . '&action=unlock'); ?>" class="button">Unlock</a>
				<?php else: ?>
					<a href="<?php echo url($threadlink . '&action=lock'); ?>" class="button">Lock</a>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($thread->isAdmin()): ?>
				<?php if ($thread->isSticked()): ?>
					<a href="<?php echo url($threadlink . '&action=unstick'); ?>" class="button">Unstick</a>
				<?php else: ?>
					<a href="<?php echo url($threadlink . '&action=stick'); ?>" class="button">Stick</a>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($thread->isAdmin()): ?>
				<a href="<?php echo url($threadlink . '&action=delete'); ?>" class="button">Delete</a>
			<?php endif; ?>
		</td>
		<td align="right"><?php echo $thread->pagination()->render() ?></td>
	</tr>
</table>

<table>
	<tr class="header">
		<th width="20%">Author</th>
		<th><?php echo e($thread->title) ?></th>
	</tr>

	<!-- Original post -->
	<?php 
		if (! isset($_GET['page']) or $_GET['page'] == 1) 
		{
			$i = 1;

			$post = app('forumpost')->where('id', $_GET['thread'])->first();

			include theme('pages/forum/thread/post.php');
		} 
	?>

	<!-- Replies -->
	<?php
		foreach ($posts as $i => $post) {
			$i = ($offset + $i) + 2; 

			include theme('pages/forum/thread/post.php'); 
		}
	?>

	<!-- Footer -->
	<tr class="header">
		<th colspan="2"><small>All times are <?php echo date('T'); ?></small></th>
	</tr>
</table>

<table>
	<tr class="transparent noborderpadding">
		<td>
			<?php if (! $thread->isLocked() && isLoggedIn() ): ?>
				<a href="<?php echo url($threadlink . '&action=reply') ?>" class="button">Reply to thread</a>
			<?php endif; ?>
		</td>
		<td align="right"><?php echo $thread->pagination()->render() ?></td>
	</tr>
</table>