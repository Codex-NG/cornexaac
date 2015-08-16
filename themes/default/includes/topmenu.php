<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Brand</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="?subtopic=index"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Community <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="?subtopic=search">Search character</a></li>
						<li><a href="?subtopic=online">Who is online?</a></li>
						<li><a href="?subtopic=highscore">Highscores</a></li>
						<li><a href="?subtopic=guilds">Guilds</a></li>
						<li><a href="?subtopic=staff">Support</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Library <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Server info</a></li>
						<li><a href="#">Spells</a></li>
						<li><a href="#">Creatures</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Shop <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo url('?subtopic=buypoints') ?>">Get premium points</a></li>
						<li><a href="<?php echo url('?subtopic=shop') ?>">Choose gift</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if (isLoggedIn()): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="?subtopic=myaccount">My account</a></li>
							<li><a href="?subtopic=logout">Logout</a></li>
						</ul>
					</li>
					<?php else: ?>
						<li><a href="?subtopic=register"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>  Register</a></li>
						<li><a href="?subtopic=login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>  Login</a></li>
				<?php endif; ?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>