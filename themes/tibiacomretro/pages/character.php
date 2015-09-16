
<?php if (isset($_GET['name'])): ?>
	<?php $char = app('character')->where('name', $_GET['name']); ?>

	<?php if (! $char->exists()): ?>
		
		<div class="errors">
			<ul style="list-style:none;">
				<li>Character <?php echo e($_GET['name']); ?> do not exist.</li>
			</ul>
		</div>

	<?php endif; ?>

	<?php if ($char->exists()): $char = $char->first(); ?>

		<table>
			<tr class="header">
				<th colspan="2">Character Information</th>
			</tr>

			<tr>
				<th width="22%">Name</th>
				<td><?php echo $char->getName() ?></td>
			</tr>

			<tr>
				<th>Gender:</th>
				<td><?php echo sexIdToName($char->getSex()) ?></td>
			</tr>

			<tr>
				<th>Vocation:</th>
				<td><?php echo vocIdToName($char->getVocation()) ?></td>
			</tr>

			<tr>
				<th>Level:</th>
				<td><?php echo $char->getLevel() ?></td>
			</tr>

			<tr>
				<th>Town:</th>
				<td><?php echo townIdToName($char->getTown()) ?></td>
			</tr>

			<?php if ($char->hasGuild()): ?>
				<tr>
					<th>Guild Membership:</th>
					<td>
						<?php echo $char->getGuild()['rank']; ?> of 
						<a href="<?php echo guild_link($char->getGuild()['name']); ?>">
							<?php echo $char->getGuild()['name']; ?>
						</a>
					</td>
				</tr>
			<?php endif; ?>

			<tr>
				<th>Last Login:</th>
				<td>
					<?php echo $char->getLastLogin(); ?>
				</td>
			</tr>

			<?php if ($char->hasComment()): ?>
				<tr>
					<th valign="top">Comment:</th>
					<td><?php echo $char->getComment() ?></td>
				</tr>
			<?php endif; ?>

			<tr>
				<th>Account Status:</th>
				<td>
					<?php if ($char->account()->isPremium()): ?>
						<span class="online">Premium Account</span>
					<?php else: ?>
						Free Account
					<?php endif; ?>
				</td>
			</tr>
		</table>
		
		<?php if ($char->getDeaths()): ?>
			<br>
			<table>
				<tr class="header">
					<th colspan="2">Deaths</th>
				</tr>
				<?php foreach ($char->getDeaths() as $death): ?>
					<tr>
						<td width="22%"><?php echo death_time($death['time']) ?></td>
						<td>Killed at level <?php echo $death['level'] ?> by <?php echo ($death['is_player'] == 1) ? "<a href='#'>".$death['killed_by']."</a>" : ''.$death['killed_by'] ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>

		<?php if (! $char->isHided()): ?>

			<br>

			<table>
				<tr class="header">
					<th colspan="2">Account Information</th>
				</tr>
				<tr>
					<th width="22%">Created:</th>
					<td><?php echo $char->account()->accountCreation(false); ?></td>
				</tr>
			</table>

			<br>

			<table>
				<tr class="header">
					<th colspan="4">Characters</th>
				</tr>
				<tr>
					<th width="70%">Name</th>
					<th>Level</th>
					<th>Vocation</th>
					<th>Status</th>
				</tr>

				<?php foreach ($char->account()->characters() as $i => $character): ?>
					<tr>
						<td>
							<?php echo (++$i); ?>.
							<?php if ($char->id === $character->id): ?>
								<?php echo $character->getName(); ?>
								<em style="font-size: 90%; opacity: .5;">(currently viewing)</em>
							<?php else: ?>
								<?php echo char_link($character->getName()); ?>
							<?php endif; ?>
						</td>

						<td><?php echo $character->getLevel(); ?></td>

						<td><?php echo vocIdToName($character->getVocation()); ?></td>

						<td>
							<?php if ($character->isOnline()): ?>
								<span class="online">Online</span>
							<?php else: ?>
								Offline
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>

		<?php endif; ?>

	<?php endif; ?>
<?php endif; ?>

<br>

<form method="GET">
	<input type="hidden" name="subtopic" value="character">
	<table>
		<tr class="header">
			<th colspan="2">Search Character</th>
		</tr>

		<tr>
			<th width="22%">Character:</th>
			<td><input type="text" name="name" required></td>
		</tr>

		<tr class="transparent">
			<th></th>
			<td><input type="submit" value="Search" class="button"></td>
		</tr>
	</table>
</form>