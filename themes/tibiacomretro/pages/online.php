
<?php $online = app('online')->getAll(); ?>

<table class="heading">
	<tr class="transparent nopadding">
		<td width="50%" valign="middle"><h1>Who Is Online</h1></td>
		<td valign="middle">

		</td>
	</tr>
</table>

<table>
	<tr class="header">
		<th colspan="3">Who Is Online?</th>
	</tr>
	<th width="70%">Name</th>
	<th>Level</th>
	<th>Vocation</th>

	<?php if (! $online): ?>
		<tr>
			<td colspan="3">No players online at the moment..</td>
		</tr>
	<?php else: ?>
		<?php foreach($online as $player):  ?>
			<tr>
				<td><a href="?subtopic=character&name=<?php echo $player['name'] ?>"><?php echo $player['name'] ?></a></td>
				<td><?php echo $player['level'] ?></td>
				<td><?php echo $player['vocation'] ?></td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>