
<?php

$char = app('character')->where('name', $_GET['name']);

if (! $char->exists()): ?>
	
	<div class="alert alert-danger">
		Character <?php echo e($_GET['name']); ?> do not exist.
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Search Character</h3>
		</div>
		<div class="panel-body">
			<form method="GET">
				<input type="hidden" name="subtopic" value="character">
				<input class="form-control" name="name" required>
				<input type="submit" value="Search" style="margin-top:5px;" class="btn btn-primary">
			</form>
		</div>
	</div>

<?php endif; ?>

<?php if ($char->exists()): $char = $char->first(); ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Character <?php echo $char->getName() ?></h3>
		</div>	
		<div class="panel-body">
			<table class="table">
				<tr>
					<td width="30%">Name:</td><td><?php echo $char->getName() ?></td>
				</tr>
				<tr>
					<td>Level:</td><td><?php echo $char->getLevel() ?></td>
				</tr>
				<tr>
					<td>Sex:</td><td><?php echo $char->getSex() ?></td>
				</tr>
				<tr>
					<td>Vocation:</td><td><?php echo $char->getVocation() ?></td>
				</tr>
				<tr>
					<td>Town:</td><td><?php echo $char->getTown() ?></td>
				</tr>
				<?php if ($char->hasGuild()): ?>
					<tr>
						<td>Guild:</td>
						<td>
							<?php echo $char->getGuild()['rank']; ?> of 
							<a href="<?php echo guild_link($char->getGuild()['name']); ?>">
								<?php echo $char->getGuild()['name']; ?>
							</a>
						</td>
					</tr>
				<?php endif; ?>
			</table>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Deaths</h3>
		</div>	
		<div class="panel-body">
			<table class="table">
				<?php $deaths = $char->getDeaths(); if(! $deaths): ?>
					<tr>
						<td>No deaths to show</td>
					</tr>
				<?php else: ?>
					<?php foreach($deaths as $death): ?>
						<tr>
							<td width="30%"><?php echo death_time($death['time']) ?></td>
							<td>Killed at level <?php echo $death['level'] ?> by <?php echo ($death['is_player'] == 1) ? "<a href='#'>".$death['killed_by']."</a>" : ''.$death['killed_by'] ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</div>
	</div>

<?php endif; ?>