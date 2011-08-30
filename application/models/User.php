<?php

/**
 * User
 *
 * @package models
 * @author Rense Bakker
 * @version 1.0
 */
class User extends Observable {
	
	/**
	 * The user id
	 * @var int
	 */
	protected $_id;
	/**
	 * The users email address
	 * @var string
	 */
	protected $_email;
	/**
	 * The users password
	 * @var string
	 */
	protected $_password;
	/**
	 * The users social network accounts
	 * @var Array
	 */
	protected $_accounts = array();
	/**
	 * The users profiles
	 * @var Array
	 */
	protected $_profiles = array();
	/**
	 * The users roles
	 * @var Array
	 */
	protected $_roles = array();
	/**
	 * The users subscriptions
	 * @var Array
	 */
	protected $_subscriptions = array();
	/**
	 * The users groups
	 * @var Array
	 */
	protected $_groups = array();
	/**
	 * The users settings
	 * @var Array
	 */
	protected $_settings = array();
	
}