<?php

/**
 * User mapper
 *
 * @package models/mappers
 * @author Rense Bakker
 * @version 1.0
 */
class UserMapper {
	
	/**
	 * Variable that holds an array with the unique fields of the mappers default model
	 * @var Array
	 */
	public $uniques = array('id', 'email');
	
	/**
	 * Returns an instance of the default model of this mapper
	 * @return User
	 */
	public function defaultModel(){
		return new User();
	}
	
}