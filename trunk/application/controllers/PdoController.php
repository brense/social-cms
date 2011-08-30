<?php

/**
 * Pdo controller
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class PdoController implements Interfaces_DbController {
	
	/**
	 * Variable that holds the db handle
	 */
	protected $_handle;
	/**
	 * Variable that holds query to be executed
	 * @var string
	 */
	protected $_query;
	/**
	 * Variable that holds current table
	 * @var string
	 */
	protected $_table;
	
	/**
	 * Constructor
	 * @param string $table
	 */
	public function __construct($table){
		$cfg = AppHelper::instance()->cfg;
		$this->_table = $cfg->db['prfx'] . $table;
		$this->connect($cfg->db['host'], $cfg->db['name'], $cfg->db['user'], $cfg->db['pswd']);
	}
		
	/**
	 * Destructor, ensures the db connection is closed on cleanup
	 */
	public function __destruct(){
		unset($this->_handle);
	}
	
	/**
	 * Connects with the database
	 * @param string $dbhost
	 * @param string $dbname
	 * @param string $dbuser
	 * @param string $dbpswd
	 */
	public function connect($dbhost, $dbname, $dbuser, $dbpswd){
		$this->_handle = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
	}
	
	/**
	 * Executes a given query
	 * @param string $query
	 * @param Array $params
	 * @return string
	 */
	private function execute($query, $params = null){
		// prepare the query
		$this->_query = $this->_handle->prepare($query);
		// bind the parameters
		if(is_array($params)){
			foreach($params as $key => $value){
				$this->_query->bindValue($key, $value);
			}
		}
		// execute the query
		$this->_query->execute();
		return $this->_query;
	}
	
	/**
	 * Provides the means to manually execute a query
	 * @param string $query
	 * @param Array $params
	 * @param string $return
	 */
	public function query($query, $params = null, $return = null){
		$this->_query = $this->execute($query, $params);
		if(isset($return)){
			switch($return){
				case 'fetchAll': 		return $this->fetchAll(); break;
				case 'lastInsertId': 	return $this->getLastInsertId(); break;
			}
		}
	}
	
	/**
	 * Executes a create query
	 * @param Array $values
	 * @return int
	 */
	public function create($values){
		// create parameter array
		foreach($values as $key => $value){
			$cols[] = $key;
			$vals[] = ':' . $key;
			$params[':' . $key] = $value;
		}
		$cols = implode(', ', $cols);
		$vals = implode(', ', $vals);
		// create query
		$query = "INSERT INTO " . $this->_table . " (" . $cols . ") VALUES(" . $vals . ")";
		// execute the query with the given parameters
		$this->_query = $this->execute($query, $params);
		return $this->getLastInsertId();
	}
	
	/**
	 * Executes a read query
	 * @param Array $crits
	 * @param Array $sort
	 * @param Array $limit
	 * @return Array
	 */
	public function read($crits = null, $sort = null, $limit = null){
		// TODO improve sort
		if(isset($sort)) $sort = ' ' . $sort;
		// TODO improve limit
		if(isset($limit)) $limit = ' ' . $limit;
		// create parameter array
		$criteria = '';
		if(isset($crits)){
			foreach($crits as $field => $value){
				$criteria .= $field . ' = :crit' . $field;
				$params[':crit' . $field] = $value;
			}
		}
		if(strlen($criteria) > 0){
			$criteria = ' WHERE ' . $criteria;
		}
		// create query
		$query = "SELECT * FROM " . $this->_table . $criteria . $sort . $limit;
		// execute the query with the given parameters
		$this->_query = $this->execute($query, $params);
		return $this->fetchAll();
	}
	
	/**
	 * Executes an update query
	 * @param Array $crits
	 * @param Array $values
	 */
	public function update($crits, $values){
		// create parameter array
		foreach($values as $key => $value){
			$cols[] = $key . '=:' . $key;
			$params[':' . $key] = $value;
		}
		$cols = implode(', ', $cols);
		foreach($crits as $field => $value){
			$criteria .= $field . ' = :crit' . $field;
			$params[':crit' . $field] = $value;
		}
		if(isset($criteria)){
			$criteria = ' WHERE ' . $criteria;
		}
		// create query
		$query = "UPDATE " . $this->_table . " SET " . $cols . $criteria;
		// execute the query with the given parameters
		$this->_query = $this->execute($query, $params);
	}
	
	/**
	 * Executes a delete query
	 * @param Array $crits
	 */
	public function delete($crits){
		// create parameter array
		foreach($crits as $field => $value){
			$criteria .= $field . ' = :crit' . $field;
			$params[':crit' . $field] = $value;
		}
		if(isset($criteria)){
			$criteria = ' WHERE ' . $criteria;
		}
		// create query
		$query = "DELETE FROM " . $this->_table . ' ' . $criteria;
		// execute the query with the given parameters
		$this->_query = $this->execute($query, $params);
	}
	
	/**
	 * Gets the last inserted id
	 * @return int
	 */
	private function getLastInsertId(){
		return $this->_handle->lastInsertId();
	}
	
	/**
	 * Fetches all the rows
	 * @return Array
	 */
	private function fetchAll(){
		return $this->_query->fetchAll();
	}
	
}