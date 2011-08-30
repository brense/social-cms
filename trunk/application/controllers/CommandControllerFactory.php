<?php

/**
 * Command controller factory
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class CommandControllerFactory {
	
	private function __construct(){}
	
	/**
	 * Returns the correct command
	 * @param string $cmd
	 * @param Request $request
	 */
	public static function getCommand($cmd, Request $request){
		$class = 'Commands_' . ucfirst(str_replace('/', '_', $cmd));
		// return the correct command object
		if(class_exists($class)){
			return new $class();
		} else {
			throw new Exception('command "' . $class . '" not found');
		}
	}
}