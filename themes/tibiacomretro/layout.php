<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?php echo assets('assets/img/favicon.png') ?>">

    <!-- Stylesheets -->
    <link href="<?php echo assets('assets/css/app.css') ?>" rel="stylesheet" media="all">
    <link href="<?php echo assets('assets/css/trumbowyg.min.css') ?>" rel="stylesheet" media="all">
    <title>Title</title>
</head>
	<body>

		<section id="pandaac">
			<header id="header">
				<a href="<?php echo url('/') ?>"><img src="<?php echo assets('assets/img/header-left.png') ?>" alt="Tibia"></a>
			</header>

			<aside id="topbar">
				<ul>
					<li><a href="<?php echo url('/') ?>">Home</a></li>
					<li><a href="<?php echo url('?subtopic=guilds') ?>">Guilds</a></li>
					<li><a href="<?php echo url('?subtopic=online') ?>">Who is online</a></li>
					<li><a href="<?php echo url('#') ?>">Support</a></li>
					<li><a href="<?php echo url('#') ?>">faq</a></li>
				</ul>
			</aside>

			<div id="content-container">
				<aside id="sidebar">
					<section id="sidebar-links">
						<div class="line"></div>
						<div class="line wide"></div>

						<ul>
							<li><a href="<?php echo url('/') ?>">Latest news</a></li>
							<li><a href="<?php echo url('?subtopic=myaccount') ?>">Account</a></li>
							<?php if (isLoggedIn()): ?>
								<li><a href="<?php echo url('?subtopic=logout') ?>">Logout</a></li>
							<?php else: ?>
								<li><a href="<?php echo url('?subtopic=register') ?>">Register</a></li>
							<?php endif; ?>
							<li><a href="<?php echo url('?subtopic=character') ?>">Character</a></li>
							<li><a href="<?php echo url('?subtopic=highscore') ?>">Highscores</a></li>
							<li><a href="<?php echo url('?subtopic=forum') ?>">Forum</a></li>
							<li><a href="#">Latest deaths</a></li>
							<li><a href="<?php echo url('?subtopic=shop') ?>">Shop offers</a></li>
							<li><a href="<?php echo url('?subtopic=buypoints') ?>">Buy points</a></li>
						</ul>

						<div class="line wide"></div>
						<div class="line"></div>
					</section>

					<section id="sidebar-misc">
						<div class="line"></div>
							<a href="<?php echo url('?subtopic=myaccount') ?>" class="martel">My account</a>
						<div class="line"></div>

						<br>

						<a href="<?php echo url('?subtopic=online') ?>">Players online</a>
						<div class="line"></div>
						<a href="<?php echo url('?subtopic=online') ?>">
							<?php echo countOnline(); ?> players
						</a>
						<div class="line"></div>
					</section>
				</aside>

				<div id="main-container">
					<main id="main">
						<div id="content">
							<?php app()->getPage(); ?>
						</div>
					</main>

					<div id="copyright">
						CornexAAC - <?php echo config('app', 'version'); ?>
					</div>
				</div>
			</div>
		</section>

		<!-- Javascripts -->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="<?php echo assets('assets/js/trumbowyg.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo assets('assets/js/app.js'); ?>"></script>
		<script type="text/javascript">
			$('#reply').trumbowyg({
			    fullscreenable: false,
			    resetCss: true
			});
		</script>
	</body>
</html>