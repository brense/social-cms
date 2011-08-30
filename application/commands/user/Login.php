<?php

/**
 * User login command
 *
 * @package commands/user
 * @author Rense Bakker
 * @version 1.0
 */
class Commands_User_Login implements Interfaces_Command {
	
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
		$userController->login($request->params);
	}
	
}