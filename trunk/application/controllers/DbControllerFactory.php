<?php

/**
 * Db Controller Factory
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class DbControllerFactory {
	
	private function __construct(){}
	
	/**
	 * Returns the correct db controller
	 * @param string $table
	 * @param string $dbType
	 */
	public static function getDbController($table, $dbType = null) {
		// determine the correct db type
		if(!isset($dbType)){
			$dbType = AppHelper::instance()->cfg->db['type'];
		}
		$class = 'Db_' . ucfirst($dbType) . 'Controller';
		// return the correct db controller object
		if(class_exists($class)){
			return new $class($table);
		} else {
			throw new Exception('db controller of type "' . $dbType . '" not found');
		}
	}
	
}