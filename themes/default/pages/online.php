
<?php

$online = app('online')->getAll();
 
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Who is online</h3>
	</div>
	<div class="panel-body">
		<table class="table">
			<th>Name</th>
			<th>Vocation</th>
			<th>Level</th>

			<?php if (! $online): ?>
				<tr>
					<td colspan="3">No players online at the moment..</td>
				</tr>
			<?php else: ?>
				<?php foreach($online as $player):  ?>
					<tr>
						<td><a href="?subtopic=character&name=<?php echo $player['name'] ?>"><?php echo $player['name'] ?></a></td>
						<td><?php echo $player['vocation'] ?></td>
						<td><?php echo $player['level'] ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>