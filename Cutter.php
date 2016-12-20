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
	private static $instance;
	private $config = [];

	private $rendered = false;
	private $dataset = [];
	private $viewset = [];
	private $current_field = null;
	private $current_stack = null;

	public $once_data = false;
	private $once_datakey = [];

	private function __construct()
	{
		$this->set_layout('layout');
	}

	public static function init()
	{
		if (!isset(static::$instance)) static::$instance = new Cutter();
		return static::$instance;
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

	public function data(...$args)
	{
		if (isset($args[0])) {
			if (is_array($args[0])) {
				foreach ($args[0] as $k => $v) {
					$this->dataset[$k] = $v;
				}

			} elseif (is_string($args[0])) {
				$v = isset($args[1]) ? $args[1] : null;
				$this->dataset[$args[0]] = $v;
			}

			unset($args);

		} else {
			return $this->dataset;
		}
	}

	public function rem_data($key)
	{
		if (isset($this->dataset[$key])) unset($this->dataset[$key]);
	}

	public function set_layout($name)
	{
		$this->layout = $name;
	}

	public function get_layout()
	{
		return $this->layout;
	}

	public function set_path($path)
	{
		$path = realpath($path);

		if ($path === false) {
			$this->view_path = __DIR__ . DIRECTORY_SEPARATOR;

		} else {
			$this->view_path = $path . DIRECTORY_SEPARATOR;
		}
	}

	// deprecated
	public function set_view_path($path)
	{
		return $this->set_path($path);
	}

	public function get_path($name = null)
	{
		if (empty($name)) {
			return $this->view_path;
		} else {
			$name = str_replace('/', DIRECTORY_SEPARATOR, trim($name, '/'));
			$path = $this->view_path;

			return ($path . $name . '.cutter.php');
		}
	}

	// deprecated
	public function get_view_path($name = null)
	{
		return $this->get_path($name);
	}

	// deprecated
	public function load_view($name, $data = [])
	{
		$this->view($name, $data, false);
	}

	public function view($name, $data = [], $render = true)
	{
		$this->data($data);
		cutter_load_file($this->get_path($name), $this->dataset, true);

		if ($render) $this->render();
	}

	public function render($data = [])
	{
		if ($this->current_field !== null) {
			throw new Exception(sprintf('<div>Error <b>%s</b>: You have to close field, to render</div>', __CLASS__));
		}
		if ($this->rendered) return;
		$this->rendered = true;

		$this->data($data);
		cutter_load_file($this->get_path($this->layout), $this->dataset, false);
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
			throw new Exception(sprintf('<div>Error <b>%s</b>: start field <b>%s</b>, without closing <b>%s</b> field</div>', __CLASS__, $name, $this->current_field));
		}

		if (empty($this->viewset[$name])) $this->viewset[$name] = [];
		$this->current_field = $name;
		$this->current_stack = $stack;
		ob_start();
	}

	public function end()
	{
		if ($this->current_field === null) {
			throw new Exception(sprintf('<div>Error <b>%s</b>: closing <b>null</b> field</div>', __CLASS__));
		}

		// p/prev/previous
		if ($this->current_stack !== null && $this->current_stack[0] === 'p') {
			array_unshift($this->viewset[$this->current_field], ob_get_clean());

		// n/next otherwise
		} else {
			array_push($this->viewset[$this->current_field], ob_get_clean());
		}

		$this->current_field = null;
		$this->current_stack = null;
	}
}

function cutter_load_file($path, &$data, $ob) {
	if ($ob) ob_start();
	extract($data);
	include($path);
	if ($ob) ob_end_clean();
}

require (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fn-facade.php');
