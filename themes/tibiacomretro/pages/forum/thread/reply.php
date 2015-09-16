
<?php 
	if ($thread->isLocked() or ! isLoggedIn()) {
		redirect('?subtopic=forum');
	}

	include theme('includes/notifications.php');
?>

<form method="POST">
	<table>
		<tr class="header">
			<th colspan="2">Reply to thread <?php echo e($thread->title); ?></th>
		</tr>

		<tr>
			<th width="20%">Author:</th>
			<td>
				<?php if (app('account')->characters()): ?>
					<select name="author">
						<?php foreach (app('account')->characters() as $character): ?>
							<option value="<?php echo $character->id ?>"><?php echo $character->getName() ?></option>
						<?php endforeach; ?>
					</select>
				<?php else: ?>
					Please create a character before you answer to a thread.
				<?php endif; ?>

				<?php if ($validator->hasError('author')): ?>
					<em class="error"><?php echo $validator->getError('author'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr>
			<th valign="top">Content:</th>
			<td>
				<textarea id="reply" name="content"></textarea>

				<?php if ($validator->hasError('content')): ?>
					<em class="error"><?php echo $validator->getError('content'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr class="transparent noborderpadding">
			<td></td>
			<td>
				<input type="submit" class="button" value="Reply">
				<a href="<?php echo url('?subtopic=forum&board='. $thread->board_id . '&thread=' . $thread->id) ?>" class="button">Back</a>
			</td>
		</tr>
	</table>
</form>
