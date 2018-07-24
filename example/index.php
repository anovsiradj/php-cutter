<?php
require __DIR__ . '/../Cutter.php';

$blade = anovsiradj\Cutter::init();

$blade->facade();
$blade->set('path', __DIR__ . '/view');
$blade->set('layout','awesome-layout');

$blade->data('page_title', 'Welcome To Cutter');

$pages = ['home', 'about', 'special'];
$blade->data('nav_link', $pages);

if (!empty($_GET['web']) && in_array($_GET['web'], $pages)) {

	$webpage = 'page/' . $_GET['web'];

	$blade->view($webpage, [
		'page_title' => ('Lorem Ipsum: ' . $_GET['web']),
	], false); // dont do render(); You have to call render() manually.
}

// here we go...,
$blade->render([
	'exec_time' => (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])
]);
