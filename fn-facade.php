<?php
/**
* 
* by $blade->facade()
* or anovsiradj/Cutter::facade()
* to use this functions.
* 
* @since 20180602342132, 20180724202309
* 
*/

use anovsiradj\Cutter;

/* FIELD */
if (!function_exists('cutter_field')) {
	function cutter_field($field) {
		Cutter::init()->field($field);
	}
}

/* BEGINNING */
if (!function_exists('cutter_start')) {
	function cutter_start($name, $stack = null) {
		Cutter::init()->start($name, $stack);
	}
}

if (!function_exists('cutter_begin')) {
	function cutter_begin($name, $stack = null) {
		Cutter::init()->start($name, $stack);
	}
}

/* ENDING */
if (!function_exists('cutter_stop')) {
	function cutter_stop() {
		Cutter::init()->end();
	}
}
if (!function_exists('cutter_end')) {
	function cutter_end() {
		Cutter::init()->end();
	}
}
