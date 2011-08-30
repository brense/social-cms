<?php

/**
 * Output helper
 *
 * @package helpers
 * @author Rense Bakker
 * @version 1.0
 */
class OutputHelper {
	
	/**
	 * Variable that holds all the added output
	 * @var string
	 */
	private $_output = '';
	/**
	 * Variable that determines if output is locked or not
	 * @var bool
	 */
	private static $_locked = false;
	
	private $_history = array();
	
	private static $_instance;
	
	private function __construct() {}

	public static function instance() {
		if(empty(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Add output to the output helper
	 * @param string $content
	 * @param Object $requester
	 * @param bool $lock
	 */
	public function add($content, $requester, $lock = false){
		// prevent output from being added if the output helper is locked
		if($this->_locked === false){
			$this->_output .= $content;
			$this->_history[] = array('content' => $content, 'requester' => get_class($requester));
			// lock the output if the parameter $lock is true
			if($lock === true){
				$this->_locked = true;
			}
		}
	}
	
	/**
	 * Display the output
	 * @return string
	 */
	public function display(){
		return $this->_output;
	}
	
}