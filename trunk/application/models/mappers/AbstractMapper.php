<?php

/**
 * Abstract mapper
 *
 * @package models/mappers
 * @author Rense Bakker
 * @version 1.0
 */
abstract class AbstractMapper {
	
	/**
	 * Variable that holds the db handle
	 */
	protected $_handle;
	/**
	 * Variable that holds an array with unique db keys
	 * @var Array
	 */
	public $uniques = array();
	
	/**
	 * Constructor, creates a handle to the db controller
	 */
	public function __construct(){
		$this->_handle = DbControllerFactory::getDbController($this->_table);
	}
	
	/**
	 * Destructor, cleans up the handle to the db controller
	 */
	public function __destruct(){
		unset($this->_handle);
	}
	
	/**
	 * Get model data
	 * @param Array $crits
	 * @param string $sort
	 * @param string $limit
	 * @return Array
	 */
	public function get($crits = null, $sort = null, $limit = null){
		return $this->_handle->read($crits, $sort, $limit);
	}
	
	/**
	 * Save model data
	 * @param Object $object
	 * @param Array $crits
	 * @param string $action
	 */
	public function save($object, $crits = null, $action = null){
		// convert object to array
		$array = $this->toArray($object);
		
		// set action to update if id exists in the array
		if(isset($array['id'])){
			$action = 'update';
			$crits = array('id' => $array['id']);
		}
		
		// update or insert the data
		switch($action){
			case 'update':
				return $this->_handle->update($crits, $array);
			break;
			default:
				return $this->_handle->create($array);
			break;
		}
	}
	
	/**
	 * Delete model data from db
	 * @param Object $object
	 * @param Array $crits
	 */
	public function delete($object = null, $crits = null){
		// set object id as criteria if no criteria are given
		if(isset($object) && !isset($crits)){
			$crits = array('id' => $object->id);
		}
		// delete the rows
		return $this->_handle->delete($crits);
	}
	
	/**
	 * Drop the table
	 */
	public function dropTable(){
		$query = "DROP TABLE " . $this->_table;
		$this->_handle->execute($query);
	}
	
	/**
	 * Empty the table
	 */
	public function emptyTable(){
		$query = "TRUNCATE TABLE " . $this->_table;
		$this->_handle->execute($query);
	}
	
	/**
	 * Convert array to object
	 * @param Array $array
	 * @param Object $object
	 */
	protected function toObject($array, $object){
		if(!empty($array)){
        	foreach($array as $key => $value){
            	$object->{$key} = $value;
        	}
        	return $object;
    	}
    	return false;
	}
	
	/**
	 * Convert object to array
	 * @param Object $object
	 * @return Array
	 */
	protected function toArray($object){
		$type = strlen(get_class($object))+3;
		$object = (array)$object;
		foreach($object as $key => $value){
			if(substr($key, $type) != 'bservers' && substr($key, $type) != '0'){
				$array[substr($key, $type)] = $value;
			}
		}
    	return $array;
	}
	
	abstract public function defaultModel();
	
}