<?php

/**
* 
* use anovsiradj/Cutter::init()->facade()
* or anovsiradj/Cutter::facade()
* to use this functions.
* 
* @since 20180602342132
* 
*/

use anovsiradj\Cutter;

if (function_exists('cutter_field') === false) {
	function cutter_field($field) {
		Cutter::init()->field($field);
	}
}

if (function_exists('cutter_start') === false) {
	function cutter_start($name) {
		Cutter::init()->start($name);
	}
}

if (function_exists('cutter_end') === false) {
	function cutter_end() {
		Cutter::init()->end();
	}
}
