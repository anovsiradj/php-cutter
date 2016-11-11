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
	private $current_stack = null;

	private function __construct()
	{
		$this->layout = 'layout';
	}

	public static function init()
	{
		if (!isset(static::$inst)) static::$inst = new Cutter();
		return static::$inst;
	}

	public function __get($key)
	{
		if ($key === 'config') return $this->config;

		if (!isset($this->config[$key])) $this->config[$key] = null;
		return $this->config[$key];
	}

	public function __set($key, $val)
	{
		if ($key === 'config' && is_array($val)) {
			foreach ($val as $k => $v) $this->config[$k] = $v;

		} else $this->config[$key] = $val;
	}

	public function data()
	{
		$args = func_get_args();

		if (isset($args[0])) {
			if (is_array($args[0])) {
				foreach ($args[0] as $k => $v) {
					$this->dataset[$k] = $v;
				}

			} elseif (is_string($args[0])) {
				$v = isset($args[1]) ? $args[1] : null;
				$this->dataset[$args[0]] = $v;
			}

		} else {
			return $this->dataset;
		}
	}

	public function set_view_path($path)
	{
		$path = realpath($path);

		if ($path === false) {
			$this->view_path = __DIR__ . DIRECTORY_SEPARATOR;

		} else {
			$this->view_path = $path . DIRECTORY_SEPARATOR;
		}
	}
	public function get_view_path($name = null)
	{
		if (isset($name)) {
			$name = str_replace('/', DIRECTORY_SEPARATOR, trim($name, '/'));
			$path = $this->view_path;

			return ($path . $name . '.cutter.php');

		} else {
			return $this->view_path;
		}
	}

	public function load_view($name, $data)
	{
		$this->data($data);
		cutter_load_file($this->get_view_path($name), $this->dataset, true);
	}

	public function view($name, $data = [], $render = true)
	{
		$this->load_view($name, $data);
		if ($render) $this->render();
	}

	public function render($data = [])
	{
		static $rendered = false;
		if ($rendered) return;
		$rendered = true;

		$this->data($data);

		cutter_load_file($this->get_view_path($this->layout), $this->dataset, false);
	}

	public function field($name)
	{
		if (isset($this->viewset[$name])) {
			echo implode(null, $this->viewset[$name]);
		}
	}

	public function start($name, $stack = null)
	{
		if ($this->current_field !== null) {
			echo sprintf('<div>Error <b>%s</b>: start field <b>%s</b>, without closing <b>%s</b> field</div>', __CLASS__, $name, $this->current_field);
			die();
		}

		if (empty($this->viewset[$name])) $this->viewset[$name] = [];
		$this->current_field = $name;
		$this->current_stack = $stack;
		ob_start();
	}

	public function end()
	{
		if ($this->current_field === null) {
			echo sprintf('<div>Error <b>%s</b>: closing <b>null</b> field</div>', __CLASS__);
			die();
		}

		if ($this->current_stack === 'prev') {
			array_unshift($this->viewset[$this->current_field], ob_get_clean());
		} else {
			array_push($this->viewset[$this->current_field], ob_get_clean());
		}

		$this->current_field = null;
		$this->current_stack = null;
	}
}

function cutter_load_file($path, $data, $ob) {
	if ($ob) ob_start();
	extract($data);
	include($path);
	if ($ob) ob_end_clean();
}

require('fn-facade.php');
