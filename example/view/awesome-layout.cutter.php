<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title><?php echo $page_title ?></title>
	<?php $cutter->field('css') ?>
</head>
<body>
	<h1><?php echo $page_title ?></h1>

	<nav>
		<a href="?page=">(blank)</a>&nbsp;
		<?php
		foreach ($pages as $n) {
			echo sprintf('<a href="?page=%s">%s</a>&nbsp;', $n, $n);
		} ?>
	</nav>

	<article><?php $cutter->field('content') ?></article>

	<br/>
	<footer><b><?php echo round($exec_time, 8) ?> ms.</b></footer>

	<?php $cutter->field('js') ?>
</body>
</html>
