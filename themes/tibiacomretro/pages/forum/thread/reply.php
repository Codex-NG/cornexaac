
<?php 
	if ($thread->isLocked()) {
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
				<select name="author">
					<?php foreach (app('account')->auth()->characters() as $character): ?>
						<option value="<?php echo $character->id ?>"><?php echo $character->getName() ?></option>
					<?php endforeach; ?>
				</select>

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
