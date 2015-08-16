
<?php auth_only(); include theme('includes/alerts.php'); ?>

<div class="panel panel-default">	
	<div class="panel-heading">
		<h3 class="panel-title">Account Management</h3>
	</div>
	<div class="panel-body">
		<h4>Welcome to your account panel, <?php echo app('account')->getName(); ?></h4>

		You created your account <?php echo app('account')->accountCreation(false); ?>

	</div>
</div>

<div class="panel panel-default">	
	<div class="panel-heading">
		<h3 class="panel-title">Characters</h3>
	</div>
	<div class="panel-body" style="padding:0px;">

		<table class="table" style="margin:0px;">
			<thead>
				<th>Name</th>
				<th>Vocation</th>
				<th>Level</th>
				<th></th>
			</thead>
			<tbody>
				<?php if (! app('account')->characters()): ?>
					<tr>
						<td colspan="4">You dont own any characters</td>
					</tr>
				<?php else: ?>
					<?php foreach(app('account')->characters() as $char): ?>
						<tr>
							<td><a href="?subtopic=character&name=<?php echo urlencode(strtolower(e($char['name']))) ?>"><?php echo e($char['name']); ?></a></td>
							<td><?php echo vocIdToName(e($char['vocation'])) ?></td>
							<td><?php echo e($char['level']) ?></td>
							<td><a href="#" class="btn btn-primary btn-xs">Edit</a></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<a href="?subtopic=newcharacter" style="margin:10px;" class="btn btn-primary">Create new character</a>

	</div>
</div>