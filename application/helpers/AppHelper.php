<?php

/**
 * Application helper
 *
 * @package helpers
 * @author Rense Bakker
 * @version 1.0
 */
class AppHelper {
	
	/**
	 * Holds the config object
	 * @var Config
	 */
	public $cfg;
	/**
	 * Holds the output helper object
	 * @var OutputHelper
	 */
	public $output;
	/**
	 * Holds the user object
	 * @var User
	 */
	public $user;
	/**
	 * Holds the request object
	 * @var Request
	 */
	public $request;
	private static $_instance;
	
	private function __construct() {}

	public static function instance() {
		if(empty(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
}