<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title><?php echo $page_title ?></title>
	<?php cutter_field('css') ?>
</head>
<body>
	<h1><?php echo $page_title ?></h1>

	<nav>
		<a href="?web=">(no-page)</a>&nbsp;
		<?php
		foreach ($nav_link as $n) {
			echo sprintf('<a href="?web=%s">%s</a>&nbsp;', $n, $n);
		} ?>
	</nav>

	<article><?php cutter_field('content') ?></article>

	<br/>
	<footer><b><?php echo round($exec_time, 8) ?> ms.</b></footer>

	<?php cutter_field('js') ?>
</body>
</html>
