<?php

/**
 * Request
 *
 * @package models
 * @author Rense Bakker
 * @version 1.0
 */
class Request extends Observable {
	
	/**
	 * The request uri
	 * @var string
	 */
	protected $_uri;
	/**
	 * The request parameters
	 * @var Array
	 */
	protected $_params;
	/**
	 * The request method (post, get, etc.)
	 * @var string
	 */
	protected $_method;
	/**
	 * The requesters useragent
	 * @var string
	 */
	protected $_useragent;
	/**
	 * The referer
	 * @var string
	 */
	protected $_referer;
	/**
	 * The request timestamp
	 * @var string
	 */
	protected $_timestamp;
	/**
	 * The requesters ip
	 * @var string
	 */
	protected $_ip;

	protected $_history = array();

	public function __construct() {
		$this->init();
	}
	
	/**
	 * Initializes the request objects and sets the correct variables
	 */
	private function init() {
		// sanitize the requested uri
		$uri = str_replace(AppHelper::instance()->cfg->rootUrl, '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$uri = array_shift(explode('?', $uri));
		if(substr($uri, -1, 1) == '/'){
			$uri = substr($uri, 0, -1);
		}
		// find the requesters ip
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// set the request object variables
		if(isset($_SERVER['REQUEST_METHOD'])) {			
			$this->_uri			= $uri;
			$this->_params		= $_REQUEST;
			$this->_method		= $_SERVER['REQUEST_METHOD'];
			$this->_useragent	= $_SERVER['HTTP_USER_AGENT'];
			$this->_referer		= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			$this->_timestamp	= $_SERVER['REQUEST_TIME'];
			$this->_ip			= trim($ip);
		}
		$this->logRequest();
	}
	
	/**
	 * Saves all requests in the database
	 */
	private function logRequest() {
		// TODO: save requests in database
	}
	
	/**
	 * Check if a requester ip is blocked
	 */
	public function ipBlock(){
		$blacklist = array('127.0.0');
		if(in_array($this->_ip, $blacklist)){
			return true;
		} else {
			return false;
		}
	}

}

