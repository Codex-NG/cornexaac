<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="<?php echo assets('assets/css/bootstrap.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/css/styles.css'); ?>">
		<link rel="stylesheet" href="<?php echo assets('assets/css/font-awesome.css') ?>">
		<style type="text/css">
			.label {
				font-weight: bold;
			}
		</style>
	</head>
	<body>

		<div class="container">

			<img class="img-responsive header" src=<?php echo assets('assets/img/header.jpg') ?>>

			<div class="topmenu">
				<?php include theme('includes/topmenu.php'); ?>
			</div>

			<div class="row">
				<div class="col-md-8">
					<?php $app->getPage(); ?>
				</div>
				<div class="col-md-4">
					<?php if (app('admin')->isAdmin()): ?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Adminpanel</h3>
							</div>
							<div class="panel-body">
								<li><a href="<?php echo url('?subtopic=adminpanel&action=addnews') ?>">Add news</a></li>
								<li><a href="#">Add shop offer</a></li>
							</div>
						</div>
					<?php endif; ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Top 5 players</h3>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
								<?php 
									$topfive = app('highscore')->topfive(); 

									if (! $topfive) {
										echo '<tr><td>No players exists..</td></tr>';
									} else {
										foreach ($topfive as $player) {
											echo sprintf('<tr><td>%s</td><td>%s</td></tr>',
													char_link($player['name']),
													$player['level']);
										}
									}
								?>
							</table>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Server Information</h3>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
								<tr>
									<td>Status:</td>
									<?php if (status()): ?>
										<td><label class="label label-success">ONLINE</label></td>
									<?php else: ?>
										<td><label class="label label-danger">OFFLINE</label></td>
									<?php endif; ?>
								</tr>
								<tr>
									<td>Players online:</td>
									<td><a href="?subtopic=online"><?php echo countOnline(); ?> players online</a></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Facebook</h3>
						</div>
						<div class="panel-body">
							<?php if (config('social', 'facebook.enabled')): ?>
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.4";
								fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-page" data-href="<?php echo config('social', 'facebook.url') ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo config('social', 'facebook.url') ?>"><a href="<?php echo config('social', 'facebook.url') ?>">Facebook</a></blockquote></div></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="footer">
				Powered by CornexAAC - <?php echo config('app', 'version'); ?>
			</div>

		</div>

		<script src="<?php echo assets('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo assets('assets/js/bootstrap.min.js'); ?>"></script>
	</body>
</html>