<?php

/**
 * Page
 *
 * @package models
 * @author Rense Bakker
 * @version 1.0
 */
class Page extends Observable {
	
	/**
	 * The page id
	 * @var int
	 */
	protected $_id;
	/**
	 * The page uri
	 * @var string
	 */
	protected $_uri;
	/**
	 * The page title
	 * @var string
	 */
	protected $_title;
	/**
	 * The page description
	 * @var string
	 */
	protected $_description;
	/**
	 * The page layout
	 * @var Layout
	 */
	protected $_layout;
	/**
	 * The page style
	 * @var string
	 */
	protected $_style;
	/**
	 * The page content
	 * @var Array
	 */
	protected $_content = array();
	/**
	 * The page breadcrumb trail
	 * @var Array
	 */
	protected $_trail = array();
	
	/**
	 * Get the contents of the page
	 */
	public function getContents(){
		$contentMapper = new ContentMapper();
		$this->_content = $contentMapper->get(array('page' => $this->_uri));
	}
	
	// TODO: getLayout function???
		
}