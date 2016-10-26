<?php
require('../Cutter.php');

// GET INSTANCE
$blade = anovsiradj\Cutter::init();

// ---------- START CONFIG ----------
$blade->config = [
	'layout' => 'admin-layout',
	'view_path' => (__DIR__ . '/view')
];
// --------------- OR ---------------
$blade->layout = 'my-layout';
$blade->view_path = __DIR__ . '/view';
// ----------- END CONFIG -----------

// INITIAL DATA
$blade->data('title', 'whutt?');
$blade->data('nav', ['home', 'about', 'special']);

// JUST EXAMPLE
$webpage = 'page/' . (empty($_GET['web']) ? 'home' : $_GET['web']);

$blade->view($webpage, [
	'title' => $webpage,
	'saymyname' => 'anovsiradj'
], false); // dont call render(); You need call render manually.

$blade->render();
