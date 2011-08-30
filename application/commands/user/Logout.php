<?php

/**
 * User logout command
 *
 * @package commands/user
 * @author Rense Bakker
 * @version 1.0
 */
class Commands_User_Logout implements Interfaces_Command {
	
	/**
	 * Constructor
	 */	
	public function __construct(){
		
	}
	
	/**
	 * Execute
	 * @param Request $request
	 */
	public function execute(Request $request){
		$userController = new UserController();
		$userController->logout();
	}
	
}