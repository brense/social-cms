<?php

/**
 * Autoloader
 *
 * @package library
 * @author Rense Bakker
 * @version 1.0
 */
class AutoLoader {
	
	/**
	 * Variable that holds class name to be loaded
	 */
	private $_class;
	/**
	 * Variable that holds application path to the class files
	 */
	private $_path;
	/**
	 * Variable that holds an array with sources where class files can be found
	 */
	private $_src = array(
		'',
		'controllers/',
		'models/',
		'models/mappers/',
		'views/',
		'helpers/',
		'library/',
		'services/'
	);
	/**
	 * Variable that holds an array with possible class file extentions
	 */
	private $_ext = array(
		'.php'
	);
	
	public static $instance;
		
	public static function instance($src = null, $ext = null) {
		if(empty(self::$instance)) {
			self::$instance = new self($src, $ext);
		}
		return self::$instance;
	}
	
	/**
	 * Constructor, registers the autoload function, sets the path parameter and allows the src and ext parameters to be overridden
	 * @param Array $src
	 * @param Array $ext
	 */
	private function __construct($src = null, $ext = null){
		$this->_path = APP_PATH;
		
		if(is_array($src)) {
			$this->_src = $src;
		}
		if(is_array($ext)) {
			$this->_ext = $ext;
		}
		spl_autoload_register(array($this, 'loadClass'));
	}
	
	/**
	 * The class loader function that loads the classes
	 * @param string $class
	 */
	private function loadClass($class) {
		$this->_class = str_replace('_', '/', $class);
		$found = false;
		// loop through all the class sources and extentions untill the class is found
		foreach($this->_src as $resource) {
			foreach($this->_ext as $ext) {
				if(file_exists($this->_path . $resource . $this->_class . $ext)) {
					include($this->_path . $resource . $this->_class . $ext);
					$found = true;
					break 2;
				}
			}
		}
		if($found){
			spl_autoload($this->_class);
		} else {
			// if no class is found throw an exception
			throw new Exception('class ' . $class . ' not found');
		}
	}

}

$autoloader = Autoloader::instance();