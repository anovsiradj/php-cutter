<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title><?php echo $page_title ?></title>
	<?php cutter('css') ?>
</head>
<body>
	<h1><?php echo $page_title ?></h1>

	<nav>
		<?php
		echo sprintf('<a href=\'%s\'>(no-page)</a>&nbsp;', dirname($_SERVER['SCRIPT_NAME']));
		foreach ($nav_link as $n) {
			echo sprintf('<a href=\'?web=%s\'>%s</a>&nbsp;', $n, $n);
		} ?>
	</nav>

	<article><?php cutter('content') ?></article>

	<br/>
	<footer><b><?php echo round($exec_time, 10) ?> ms.</b></footer>

	<?php cutter('js') ?>
</body>
</html>