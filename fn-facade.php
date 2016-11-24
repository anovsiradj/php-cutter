<?php
use anovsiradj\Cutter;

function cutter_field($field) {
	Cutter::init()->field($field);
}

function cutter_start($name) {
	Cutter::init()->start($name);
}

function cutter_end() {
	Cutter::init()->end();
}
