
<?php
	$highscore = app('highscore');

	$highscore->setCustomFields(['soul']);
	$highscores = $highscore->getHighscore();

	$title = (isset($_GET['skill'])) ? highscoreSkillToTitle($_GET['skill']) : 'Level' ;
?>

<table>
	<tr class="transparent noborderpadding">
		<td align="center">
			<form method="GET">
				<input type="hidden" name="subtopic" value="highscore">
				<select name="skill">
					<?php foreach (config('character', 'skills') as $get => $value): ?>
						<option value="<?php echo $get ?>"><?php echo $value[1]; ?></option>
					<?php endforeach; ?>
				</select>
				<input type="submit" value="Submit" class="button">
			</form>
		</td>
	</tr>
</table>

<table>
	<tr class="header">
		<th colspan="4">Highscores for <?php echo $title ?></th>
	</tr>
	<tr>
		<th width="1%">#</th>
		<th width="76%">Character</th>
		<th width="8%">Level</th>

		<?php if (isset($_GET['skill']) && $_GET['skill'] == 'experience' or ! isset($_GET['skill'])): ?>
			<th width="15%">Experience</th>
		<?php endif; ?>
	</tr>

	<?php foreach($highscores['result'] as $row): ?>

		<tr>
			<td><?php echo (++$row['rank']) + ((isset($_GET['page']) ? ($_GET['page'] - 1) : 0) * config('highscore', 'per_page')) ?></td>

			<td><?php echo char_link($row['name']); ?></td>

			<td><?php echo $row['value'] ?></td>

			<?php if (isset($_GET['skill']) && $_GET['skill'] == 'experience' or ! isset($_GET['skill'])): ?>
				<td><?php echo $row['experience']; ?></td>
			<?php endif; ?>

		</tr>
	<?php endforeach; ?>
</table>

<?php echo $highscore->getPagination() ?>
