<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../Cutter.php');

// GET INSTANCE
$blade = anovsiradj\Cutter::init();

// ---------- START CONFIG ----------
$blade->set_path('view');
$blade->set_layout('awesome-layout');
// ----------- END CONFIG -----------

// DEFAULT DATA
$blade->data('page_title', 'Welcome To Cutter');

// JUST EXAMPLE
$pages = ['home', 'about', 'special'];
$blade->data('nav_link', $pages);

if (!empty($_GET['web']) && in_array($_GET['web'], $pages)) {

	$webpage = 'page/' . $_GET['web'];

	$blade->view($webpage, [
		'page_title' => ('Lorem Ipsum: ' . $_GET['web']),
	], false); // dont render(); You need to call render() manually.
}

// here we go...,
$blade->render([
	'exec_time' => (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])
]);
