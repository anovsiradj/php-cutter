<?php
/**
* 
* Cutter.
* Minimalist PHP templating.
* 
* @date 201610211405, 201610261138
* @author anovsiradj (Mayendra Costanov)
*/

namespace anovsiradj;

class Cutter
{
	protected static $inst;
	private $config = [];
	private $dataset = [];
	private $viewset = [];
	private $current_field = null;

	private function __construct()
	{
		$this->layout = 'layout';
	}

	public function __get($key)
	{
		if ($key === 'config') return $this->config;
		if (isset($this->config[$key])) return $this->config[$key];
		return null;
	}

	public function __set($key, $val)
	{
		if ($key === 'config') {
			if (is_array($val)) {
				foreach ($val as $k => $v) $this->config[$k] = $v;
			} else exit(0);

		} else $this->config[$key] = $val;
	}

	public function data($k, $v = '!@#$%')
	{
		// then, you can passing $v as 'null' or false or '' or anything-else
		if ($v === '!@#$%') {
			if (isset($this->dataset[$k])) return $this->dataset[$k];
			return null;
		}
		$this->dataset[$k] = $v;
	}

	private function make_view_path($name)
	{
		$name = str_replace('//', DIRECTORY_SEPARATOR, trim($name, '/'));
		$path = trim($this->view_path, '/');
		if (!empty($path)) $path .= DIRECTORY_SEPARATOR;

		return ($path . $name . '.cutter.php');
	}

	public static function init()
	{
		if (!isset(static::$inst)) static::$inst = new Cutter();
		return static::$inst;
	}

	public function view($name, Array $data = [], $render = true)
	{
		$this->dataset = array_merge($this->dataset, $data);
		cutter_load_file($this->make_view_path($name), $this->dataset);
		if ($render) $this->render();
	}

	public function render()
	{
		static $rendered = false;
		if ($rendered) return;
		$rendered = true;
		cutter_load_file($this->make_view_path($this->layout), $this->dataset, false);
	}

	public function field($name)
	{
		if (isset($this->viewset[$name])) {
			echo implode(null, $this->viewset[$name]);
		}
	}

	public function start($name)
	{
		if ($this->current_field !== null) exit(0);
		$this->current_field = $name;
		ob_start();
	}

	public function end()
	{
		if ($this->current_field === null) exit(0);
		$this->viewset[$this->current_field][] = ob_get_clean();
		$this->current_field = null;
	}
}

function cutter_load_file($path, $data, $ob = true) {
	if (file_exists($path)) {
		if ($ob) ob_start();
		extract($data);
		include($path);
		if ($ob) ob_end_clean();
	}
}

require('cutter-facecade.php');