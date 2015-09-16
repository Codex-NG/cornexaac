
<?php 
	include theme('includes/notifications.php'); 

	$account = app('account')->auth();
?>

<table>
	<tr class="header">
		<th colspan="2">General Information</th>
	</tr>

	<tr>
		<th width="20%">Account:</th>
		<td><?php echo $account->getName(); ?></td>
	</tr>

	<tr>
		<th>Email:</th>
		<td><?php echo $account->getEmail(); ?></td>
	</tr>

	<tr>
		<th>Created:</th>
		<td><?php echo $account->accountCreation(false); ?></td>
	</tr>

	<tr>
		<th>Account Status:</th>
		<td>
			<?php if ($account->isPremium()): ?>
				<span class="online">Premium Account</span>
			<?php else: ?>
				Free Account
			<?php endif; ?>
		</td>
	</tr>
</table>

<table>
	<tr class="transparent noborderpadding">
		<td width="100%">
			<a href="#" class="button">Change Email</a>
			<a href="#" class="button">Change Password</a>
		</td>
		<td>
			<a href="<?php echo url('?subtopic=logout') ?>" class="button">Logout</a>
		</td>
	</tr>
</table>

<br><br>

<table>
	<tr class="header">
		<th colspan="4">Characters</th>
	</tr>
	<tr>
		<th width="70%">Name</th>
		<th>Gender</th>
		<th>Status</th>
		<th></th>
	</tr>

	<?php if ($characters = $account->characters()): ?>
		<?php foreach ($characters as $i => $player): ?>
			<tr>

				<td>
					<?php echo ++$i; ?>.
					<?php echo char_link($player->getName()); ?>
					<em class="desc">(Level <?php echo $player->getLevel() . ' ' . vocIdToName($player->getVocation()) ?>)</em>
				</td>

				<td><?php echo sexIdToName($player->getSex()); ?></td>

				<td>
					<?php if ($player->isHided()): ?>
						<?php if ($player->isOnline()): ?>
							<span class="online">Online</span>, Hidden
						<?php else: ?>
							Offline, Hidden
						<?php endif; ?>
					<?php else: ?>
						<?php if ($player->isOnline()): ?>
							<span class="online">Online</span>
						<?php else: ?>
							Offline
						<?php endif; ?>
					<?php endif; ?>
				</td>

				<td>
					[<a href="#">Edit</a>]
				</td>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="4">You do not have any characters as of right now, why don't you go ahead and create one?</td>
		</tr>
	<?php endif; ?>
</table>

<table>
	<tr class="transparent noborderpadding">
		<td>
			<a href="<?php echo url('?subtopic=newcharacter') ?>" class="button">Create Character</a>
			<a href="#" class="button">Delete Character</a>
		</td>
	</tr>
</table>
