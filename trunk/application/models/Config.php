<?php

/**
 * Config (singleton)
 *
 * @package models
 * @author Rense Bakker
 * @version 1.0
 */
class Config extends Observable {
	
	/**
	 * The default site theme
	 * @var string
	 */
	protected $_theme;
	/**
	 * The site title
	 * @var string
	 */
	protected $_title;
	/**
	 * Debug mode
	 * @var bool
	 */
	protected $_debug;
	/**
	 * The database configuration
	 * @var Array
	 */
	protected $_db = array();
	/**
	 * The absolute path to the application files
	 * @var string
	 */
	protected $_appPath;
	/**
	 * The absolute path to the site files
	 * @var string
	 */
	protected $_sitePath;
	/**
	 * The root url of the website
	 * @var string
	 */
	protected $_rootUrl;
	/**
	 * The relative path to the cache files (relative to the site path)
	 * @var string
	 */
	protected $_cachePath;
	/**
	 * The relative path to the template files (relative to the site path)
	 * @var string
	 */
	protected $_tplPath;
	/**
	 * The relative path to the script files (relative to the site path)
	 * @var string
	 */
	protected $_scriptPath;
	/**
	 * The relative path to the files folder (relative to the site path)
	 * @var string
	 */
	protected $_filesPath;
	/**
	 * The relative path to the theme files (relative to the site path)
	 * @var string
	 */
	protected $_themesPath;
	/**
	 * The type of encryption that should be used
	 * @var string
	 */
	protected $_encryption;
	/**
	 * The type of hash that should be used
	 * @var string
	 */
	protected $_hash;
	/**
	 * The duration after which cache files should expire
	 * @var string
	 */
	protected $_cacheTime;
	/**
	 * An array that holds all the security keys for authenticating with other services
	 * @var string
	 */
	protected $_keys = array();
	
	private static $_instance;
	
	private function __construct() {}

	public static function instance() {
		if(empty(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
}