<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title><?php echo $title ?></title>
	<style>
		#me {
			background-color: red;
			text-align: center;
		}
		#nav {
			background-color: aqua;
			text-align: center;
		}
		#main {
			background-color: chartreuse;
		}
	</style>
	<?php cutter('css') ?>
</head>
<body>

	<div id="header">
		<h1 id="me"><?php echo $saymyname ?></h1>
		<div id="nav">
			<?php foreach ($nav as $link): ?>
				<a href="?web=<?php echo $link ?>"><?php echo $link ?></a>
			<?php endforeach ?>
		</div>
	</div>

	<div id="main"><?php cutter('content') ?></div>

	<?php cutter('js') ?>

</body>
</html>