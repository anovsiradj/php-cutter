<?php

namespace anovsiradj;

/**
 * Flexible Template Library
 * 
 * @author anovsiradj (Mayendra Costanov) <anov.siradj22@gmail.com>
 * @version 201610211405, 201610261138, 20180602, 20240609
 */

class Cutter
{
	protected $sections = [];
	protected $positions = [];

	protected $config = [
		'suffix' => [
			'',
			'.cutter.php',
			'.php',
			'.inc',
			'.htm',
			'.html',
		],
		'layout' => 'main',
	];

	protected $data = [];
	protected $view = [];

	public function __construct()
	{
		$this->config['path'] = [
			'',
			getcwd(),
		];
	}

	public function set($any, $val = null)
	{
		if (is_array($any)) {
			$old = $this->config;
			$new = $any;
			$this->config = array_replace_recursive($old, $new);
		} elseif (isset($any) && array_key_exists($any, $this->config) && is_array($this->config[$any]) && is_array($val)) {
			$old = $this->config[$any];
			$new = $val;
			$this->config[$any] = array_replace_recursive($old, $new);
		} elseif (isset($any)) {
			$this->config[$any] = $val;
		}
	}

	public function get($any = null)
	{
		if (empty($any)) {
			return $this->config;
		} elseif (isset($this->config[$any])) {
			return $this->config[$any];
		}
		return null;
	}

	public function dataByReference(&$data)
	{
		foreach ($data as $k => &$v) {
			$this->data[$k] = &$v;
		}
	}

	/**
	 * @param mixed $any
	 * @param mixed $val
	 */
	public function data($any = null, $val = null)
	{
		$args = func_get_args();
		if (count($args) === 0) {
			return $this->data;
		} elseif (is_array($any)) {
			$this->dataByReference($any);
		} elseif (count($args) === 2 && isset($any)) {
			$this->data[$any] = $val;
		} elseif (count($args) === 1 && isset($any) && isset($this->data[$any])) {
			return $this->data[$any];
		}
	}

	public function path($names)
	{
		$paths = (array) $this->config['path'];
		$names = (array) $names;
		$suffixs = (array) $this->config['suffix'];

		foreach ($paths as $path) {
			foreach ($suffixs as $suffix) {
				foreach ($names as $name) {
					$file = "$path$name$suffix";
					if (file_exists($file)) {
						return $file;
					}
				}
			}
		}
	}

	public function view($name, $data = [], $render = true)
	{
		$this->dataByReference($data);

		$result = $this->load($this->path($name), true);

		if ($render) $this->render();

		return $result;
	}

	public function render($data = [])
	{
		$this->dataByReference($data);

		$result = $this->load($this->path($this->config['layout']), false);

		return $result;
	}

	public function section($name)
	{
		if (array_key_exists($name, $this->view)) {
			foreach ($this->view[$name] as &$section) echo $section;
			return true;
		}
		return false;
	}

	public function field($name)
	{
		return $this->section($name);
	}

	public function begin($section, $position = null)
	{
		if (!array_key_exists($section, $this->view)) $this->view[$section] = [];

		if (empty($position)) {
			$position = 'after';
		}

		$this->sections[] = $section;
		$this->positions[] = $position;
		ob_start();
	}

	public function start($section, $position = null)
	{
		$this->begin($section, $position);
	}

	public function open($section, $position = null)
	{
		$this->begin($section, $position);
	}

	public function end()
	{
		$section = array_pop($this->sections);
		$position = array_pop($this->positions);

		$content = ob_get_contents();
		ob_end_clean();

		if (empty($section) || preg_match('/^[1na]/', $position)) {
			/* 1 | n/next | a/after */
			array_push($this->view[$section], $content);
		} elseif (empty($section) || preg_match('/^[0pb]/', $position)) {
			/* 0 | p/previous | b/before */
			array_unshift($this->view[$section], $content);
		} else {
			throw new \Exception(sprintf('[Cutter]: unknown "%s" position for section "%s"', $position, $section), 1);
		}
	}

	public function stop()
	{
		$this->end();
	}

	public function close()
	{
		$this->end();
	}

	public function load($_cutter_load_file, $_cutter_load_isob = false)
	{
		if ($_cutter_load_isob) ob_start();
		if (empty($_cutter_load_file)) {
			throw new \Exception('[Cutter]: load empty file', 1);
		} else {
			extract($this->data);
			$cutter = $this; // IMPORTANT
			$result = require($_cutter_load_file);
		}
		if ($_cutter_load_isob) ob_end_clean();

		return $result;
	}

	public function __invoke($section, $callback, $position = null)
	{
		$this->begin($section, $position);
		$callback($this->data);
		$this->end();
	}
}
