<nav class="navbar navbar-fixed-top navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Project name</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php foreach ($pages as $n) { ?>
					<li>
						<a href="?page=<?= $n ?>">
							<?= $n ?>
						</a>
					</li>
				<?php } ?>

				<li>
					<a href="?page=home&role=member">
						home (member)
					</a>
				</li>

			</ul>
		</div><!-- /.nav-collapse -->
	</div><!-- /.container -->
</nav><!-- /.navbar -->