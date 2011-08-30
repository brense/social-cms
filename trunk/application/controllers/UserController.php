<?php

/**
 * User controller
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class UserController extends AbstractController {
	
	/**
	 * Login function
	 * @param Array $params
	 */	
	public function login(Array $params){
		if(!isset($_SESSION['USER_LOGIN'])){
			// TODO implement login, facebook login, google open id etc?
		}
		if(isset($_POST['referer'])){
			header('Location: ' . $_POST['referer']);
		} else {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	
	/**
	 * Login function
	 */
	public function logout(){
		unset($_SESSION['USER_LOGIN']);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
}