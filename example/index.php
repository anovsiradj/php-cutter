<?php

/* DEBUGGING not for production */
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
	require($autoload);
	if (!function_exists('dd') && function_exists('dump')) {
		function dd()
		{
			foreach (func_get_args() as $arg) @dump($arg);
			die;
		}
	}
}

require __DIR__ . '/../Cutter.php';

$pages = ['home', 'about', 'special'];
$page = isset($_GET['page']) ? $_GET['page'] : '';

$roles = ['admin', 'member'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'admin';
$role = isset($_GET['role']) ? $_GET['role'] : $role;

$cutter = new \anovsiradj\Cutter;
$cutter->set('path', [
	__DIR__,
	__DIR__ . '/pages',
	__DIR__ . '/view/page',
]);

$cutter->set('layout', '/view/awesome-layout');

$cutter->data('page_title', 'Welcome To Cutter');
$cutter->data(compact('pages', 'roles'));

if (in_array($page, $pages)) {
	$cutter->view([
		"/{$page}_{$role}",
		"/{$page}",
	], [
		'page_title' => ('Lorem Ipsum: ' . $page),
	], false); // dont do render(), You have to call render() manually.
}

// here we go ...
$cutter->render([
	'exec_time' => (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])
]);

// dd($cutter);
