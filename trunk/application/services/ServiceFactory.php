<?php

/**
 * Service factory
 *
 * @package services
 * @author Rense Bakker
 * @version 1.0
 */
class ServiceFactory {
	
	private function __construct(){}
	
	public static function getService($service) {
		$class = ucfirst($service) . 'Service';
		if(class_exists($class)){
			return new $class();
		} else {
			return false;
		}
	}
	
}