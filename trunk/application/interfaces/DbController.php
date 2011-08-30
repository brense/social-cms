<?php

/**
 * Db controller interface
 *
 * @package interfaces
 * @author Rense Bakker
 * @version 1.0
 */
interface Interfaces_DbController {
		
	public function connect($dbhost, $dbname, $dbuser, $dbpswd);
	private function execute($query, $params = null);
	public function query($query, $params = null, $return = null);
	public function create($values);
	public function read($crits = null, $sort = null, $limit = null);
	public function update($crits, $values);
	public function delete($crits);
	private function getLastInsertId();
	private function fetchAll();
	
}