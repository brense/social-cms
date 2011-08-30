<?php

/**
 * Load page command
 *
 * @package commands/page
 * @author Rense Bakker
 * @version 1.0
 */
class Commands_Page_Load implements Interfaces_Command {
	
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
		$pageMapper = new PageMapper();
		$page = $pageMapper->loadPage($request);
		$pageController = new PageController($page);
		$page->getContents();
		$output = $pageController->parse($page);
		AppHelper::instance()->output->add($output, $this);
	}
	
}