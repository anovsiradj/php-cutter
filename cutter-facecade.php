<?php
function cutter($field) {
	anovsiradj\Cutter::init()->field($field);
}

function cutter_start($name) {
	anovsiradj\Cutter::init()->start($name);
}

function cutter_end() {
	anovsiradj\Cutter::init()->end();
}
