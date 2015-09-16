<?php auth_only(); include theme('includes/notifications.php'); ?>

<table class="heading">
	<tr class="transparent nopadding">
		<td width="50%" valign="middle"><h1>Create Character</h1></td>
		<td valign="middle">

		</td>
	</tr>
</table>

<form action="" method="POST">
	<?php echo app('formtoken')->getField(); ?>
	<table>
		<tr class="header">
			<th colspan="2">Create Character</th>
		</tr>

		<tr>
			<th width="20%">Name:</th>
			<td>
				<input type="text" name="character_name">

				<?php if ($validator->hasError('character_name')): ?>
					<em class="error"><?php echo $validator->getError('character_name'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr>
			<th width="20%">Vocation:</th>
			<td>
				<?php foreach(config('character', 'newcharvocations') as $id): ?>
					<input type="radio" value="<?php echo $id ?>" name="character_voc"><?php echo vocIdToName($id) ?>
				<?php endforeach; ?>

				<?php if ($validator->hasError('character_voc')): ?>
					<em class="error"><?php echo $validator->getError('character_voc'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr>
			<th width="20%">Sex:</th>
			<td>
				<input type="radio" value="0" name="character_sex">Female
				<input type="radio" value="1" name="character_sex">Male

				<?php if ($validator->hasError('character_sex')): ?>
					<em class="error"><?php echo $validator->getError('character_sex'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr>
			<th width="20%">Town:</th>
			<td>
				<?php foreach(config('character', 'newchartowns') as $id): ?>
					<input type="radio" value="<?php echo $id ?>" name="character_town"><?php echo townIdToName($id) ?>
				<?php endforeach; ?>

				<?php if ($validator->hasError('character_town')): ?>
					<em class="error"><?php echo $validator->getError('character_town'); ?></em>
				<?php endif; ?>
			</td>
		</tr>

		<tr class="transparent noborderpadding">
			<th></th>
			<td>
				<input type="submit" value="Submit" class="button">
				<a href="<?php echo url('?subtopic=myaccount') ?>" class="button">Back</a>
			</td>
		</tr>
	</table>
</form>
