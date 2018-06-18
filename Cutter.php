<?php
/**
* 
* Cutter.
* Minimalist PHP template Library.
* 
* @since 201610211405, 201610261138, 20180602
* @author anovsiradj (Mayendra Costanov)
* 
*/

namespace anovsiradj;
use Exception;

class Cutter
{
	private static $instance;
	protected $cfg = [];

	protected $dataset = [];
	protected $viewset = [];

	private function __construct()
	{
		$this->cfg['rendered'] = false;

		$this->cfg['layout'] = 'layout';
		$this->cfg['path'] = '';

		$this->cfg['current_field'] = null;
		$this->cfg['current_stack'] = null;
	}

	public static function &init()
	{
		if (isset(static::$instance) === false) static::$instance = new self;
		return static::$instance;
	}

	public function set($mixed, $value = null)
	{
		if (is_array($mixed)) {
			foreach ($mixed as $k => $v) {
				$this->cfg[$k] = $v;
			}
		} elseif (is_string($mixed)) {
			$this->cfg[$mixed] = $value;
		}
	}

	public function __set($k, $v)
	{
		$this->set($k, $v);
	}

	public function get($mixed = null)
	{
		if ($mixed === null) {
			return $this->cfg;
		} elseif (is_string($mixed) && array_key_exists($mixed, $this->cfg)) {
			return $this->cfg[$mixed];
		}
		return null;
	}

	public function __get($k)
	{
		return $this->get($k);
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

	public function path($name)
	{
		$path = trim(rtrim($this->cfg['path'],'/\\'));
		$path = empty($path) ? $path : ($path . '/');
		return ($path . trim($name, '/\\') . '.cutter.php');
	}

	public function view($name, $data = [], $render = true)
	{
		$this->data($data);
		cutter_load_file($this->path($name), $this->dataset, true);

		if ($render) $this->render();
	}

	public function render($data = [])
	{
		if ($this->cfg['current_field'] !== null) throw new Exception(sprintf('<div>ErrorException <b>%s</b>: You have to close field to render template.</div>', __CLASS__));
		if ($this->cfg['rendered']) return;
		$this->cfg['rendered'] = true;

		$this->data($data);
		cutter_load_file($this->path($this->cfg['layout']), $this->dataset, false);
	}

	public function field($name)
	{
		if (array_key_exists($name, $this->viewset)) {
			echo implode(null, $this->viewset[$name]);
			return true;
		}
		return false;
	}

	public function start($name, $stack = null)
	{
		if ($this->cfg['current_field'] !== null) throw new Exception(sprintf('<div>ErrorException <b>%s</b>: starting field <b>%s</b>, without ending <b>%s</b> field</div>', __CLASS__, $name, $this->cfg['current_field']));

		if (array_key_exists($name, $this->viewset) === false) $this->viewset[$name] = [];
		$this->cfg['current_field'] = $name;
		$this->cfg['current_stack'] = $stack;
		ob_start();
	}

	public function end()
	{
		if ($this->cfg['current_field'] === null) throw new Exception(sprintf('<div>ErrorException <b>%s</b>: closing <b>(null)</b> field</div>', __CLASS__));

		// n/next|a/after
		if (empty($this->cfg['current_stack']) || $this->cfg['current_stack'][0] === 'n' || $this->cfg['current_stack'][0] === 'a') {
			array_push($this->viewset[$this->current_field], ob_get_clean());

		// p/previous|b/before
		} elseif ($this->cfg['current_stack'][0] === 'p' || $this->cfg['current_stack'][0] === 'b') {
			array_unshift($this->viewset[$this->cfg['current_field']], ob_get_clean());

		// oops...
		} else {
			throw new Exception(sprintf('<div>ErrorException <b>%s</b>: unknown <b>%s</b> stack position</div>', __CLASS__, $this->cfg['current_stack']));
		}

		$this->cfg['current_field'] = null;
		$this->cfg['current_stack'] = null;
	}

	public static function facade()
	{
		require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fn-facade.php');
	}
}

function cutter_load_file($_cutter_load_file_path, &$_cutter_load_file_data, $_cutter_load_file_isob) {
	if ($_cutter_load_file_isob) ob_start();
	extract($_cutter_load_file_data);
	include($_cutter_load_file_path);
	if ($_cutter_load_file_isob) ob_end_clean();
}
