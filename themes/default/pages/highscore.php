
<?php

// app('highscore')->customfields(['soul']);
$highscores = app('highscore')->getHighscore();

$title = (isset($_GET['skill'])) ? highscoreSkillToTitle($_GET['skill']) : 'Level' ;

?>

<style type="text/css">
.nav-pills {
	margin-top: 10px;
    border-right: 1px solid #dadada !important;
    border-left: 1px solid #dadada !important;
    border-bottom: 1px solid #dadada !important; 
}
.nav-pills li {
    border-top: 1px solid #dadada !important;        
}
</style>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Highscores for <?php echo $title ?></h3>
	</div>
	<div class="panel-body">
		<div class="col-md-4">
			<div class="column margintop20">
				<ul class="nav nav-pills nav-stacked">
					<?php foreach (config('character', 'skills') as $get => $value): ?>
						<li><a href="?subtopic=highscore&skill=<?php echo $get ?>">
							<?php echo $value[1]; ?>
						</a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="col-md-8">
			<table class="table">
				<th>Name</th>
				<th>Level</th>

				<?php if(! $highscores): ?>
					<tr>
						<td colspan="2">No records to show..</td>
					</tr>
				<?php else: foreach($highscores['result'] as $highscore): ?>
					<tr>
						<td><?php echo char_link($highscore['name']); ?></td>
						<td><?php echo $highscore['value'] ?></td>
					</tr>
				<?php endforeach; endif; ?>

			</table>
		</div>

		<div style="text-align:center;">
			<?php echo $highscores['pagination']; ?>
		</div>
	</div>
</div>