<?php

/**
 * Application
 *
 * @author Rense Bakker
 * @version 1.0
 */
class Application {
	
	/**
	 * Constructor
	 */
	public function __construct(){
		// set the exception handler
		set_exception_handler(array($this, 'handleExceptions'));
	}
	
	/**
	 * Starts the application and saves the config, output, and user objects in the app helper
	 */
	public function start(){
		// start the session
		session_start();
		
		// initialize the config object
		$config = Config::instance();
		AppHelper::instance()->cfg = $config;
		
		// load the config file into the config object
		if(file_exists(SITE_PATH . CONFIG_FILE)){
			include(SITE_PATH . CONFIG_FILE);
		} else {
			throw new Exception('config file not found');
		}
		foreach($cfg as $key => $value){
			AppHelper::instance()->cfg->$key = $value;
		}
		AppHelper::instance()->cfg->appPath = APP_PATH;
		AppHelper::instance()->cfg->sitePath = SITE_PATH;
		AppHelper::instance()->cfg->rootUrl = ROOT_URL;
		
		// initialize the output helper object
		$output = OutputHelper::instance();
		AppHelper::instance()->output = $output;
				
		// initialize the user object
		if(isset($_SESSION['USER_LOGIN'])){
			$userid = substr($_SESSION['USER_LOGIN'], 0, -40);
			$user = new User();
			$user->id = $userid;
			$userController = new UserController($user);
			AppHelper::instance()->user = $userController->getModel();
		}
	}
	
	/**
	 * Exception handler
	 * @param Exception $exception
	 */
	public static function handleExceptions(Exception $exception) {
		//TODO log exceptions
		print_r($exception);
	}
	
	/**
	 * Request handler
	 * @param Request $request
	 */
	public function handleRequest(Request $request){
		// store the request object in the app helper
		AppHelper::instance()->request = $request;
		
		// check if the users ip is blocked
		if($request->ipBlock()){
			throw new Exception('your ip is blocked');
			exit;
		} else {
			if($request->method == 'GET'){
				// handle get
				if(substr($request->uri, 0, 3) == 'api'){
					// handle api requests
					$cmd = $request->uri;
				} else {
					// handle page requests
					$cmd = 'page/Load';
				}
			} else if($request->method == 'POST' && substr($request->uri, 0, 4) == 'app/'){
				// handle post
				$cmd = substr($request->uri, 4);
			}
			// get the correct command object and execute the command
			$command = CommandControllerFactory::getCommand($cmd, $request);
			$command->execute($request);
		}
	}
}



