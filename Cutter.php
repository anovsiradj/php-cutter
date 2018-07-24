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
	const VERSION = '3.0.0';

	protected static $instance;
	protected $cfg = array();

	protected $dataset = array();
	protected $viewset = array();

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
		if (isset(static::$instance) === false) static::$instance = new static;
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

	public function get($mixed = null)
	{
		if (empty($mixed)) {
			return $this->cfg;
		} elseif (is_string($mixed) && isset($this->cfg[$mixed])) {
			return $this->cfg[$mixed];
		}
		return null;
	}

	public function dataReference(&$data)
	{
		foreach ($data as $k => &$v) {
			$this->dataset[$k] = &$v;
		}
	}

	public function data($mixed, $v = null)
	{
		if (is_array($mixed)) {
			$this->dataReference($mixed);
		} elseif (is_string($mixed)) {
			$this->dataset[$mixed] = $v;
		}
	}

	public function path($name)
	{
		$path = empty($this->cfg['path']) ? $this->cfg['path'] : ($this->cfg['path'] . '/');
		return ($path . $name . '.cutter.php');
	}

	public function view($name, $data = array(), $render = true)
	{
		$this->dataReference($data);
		_cutter_include($this->path($name), $this->dataset, true);

		if ($render) $this->render();
	}

	public function render($data = array())
	{
		if ($this->cfg['current_field'] !== null) {
			throw new \Exception('[Cutter]: You have to close field to render template.');
		}
		if ($this->cfg['rendered']) return;
		$this->cfg['rendered'] = true;

		$this->dataReference($data);
		_cutter_include($this->path($this->cfg['layout']), $this->dataset, false);
	}

	public function field($name)
	{
		if (array_key_exists($name, $this->viewset)) {
			foreach ($this->viewset[$name] as &$field) echo $field;
			return true;
		}
		return false;
	}

	public function start($name, $stack = null)
	{
		if ($this->cfg['current_field'] !== null) {
			throw new \Exception(sprintf('[Cutter]: opening field "%s", without closing "%s" field', $name, $this->cfg['current_field']), 1);
		}

		if (!array_key_exists($name, $this->viewset)) $this->viewset[$name] = array();
		$this->cfg['current_field'] = $name;
		$this->cfg['current_stack'] = $stack;
		ob_start();
	}
	public function begin($name, $stack = null)
	{
		$this->start($name, $stack);
	}

	public function end()
	{
		if ($this->cfg['current_field'] === null) {
			throw new \Exception('[Cutter]: cannot closing (null) field', 1);
		}

		/* n/next | a/after */
		if (empty($this->cfg['current_stack']) || preg_match('/^[na]/', $this->cfg['current_stack'])) {
			array_push($this->viewset[$this->cfg['current_field']], ob_get_clean());

		/* p/previous | b/before */
		} elseif (preg_match('/^[pb]/', $this->cfg['current_stack'])) {
			array_unshift($this->viewset[$this->cfg['current_field']], ob_get_clean());

		} else {
			throw new \Exception(sprintf('[Cutter]: unknown "%s" stack position', $this->cfg['current_stack']), 1);
		}

		$this->cfg['current_field'] = null;
		$this->cfg['current_stack'] = null;
	}
	public function stop()
	{
		$this->end();
	}

	public static function facade()
	{
		require __DIR__ . '/fn-facade.php';
	}
}

function _cutter_include($_cutter_load_file_path, &$_cutter_load_file_data, $_cutter_load_file_isob) {
	if ($_cutter_load_file_isob) ob_start();
	extract($_cutter_load_file_data);
	require $_cutter_load_file_path;
	if ($_cutter_load_file_isob) ob_end_clean();
}
