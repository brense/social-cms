<?php

/**
 * Page mapper
 *
 * @package models/mappers
 * @author Rense Bakker
 * @version 1.0
 */
class PageMapper {
	
	/**
	 * Variable that holds an array with the unique fields of the mappers default model
	 * @var Array
	 */
	public $uniques = array('id', 'uri');
	
	/**
	 * Find the correct page that corresponds to the current request
	 * @param Request $request
	 * @return Page
	 */
	public function loadPage(Request $request){
		// create new page instance
		$page = new Page();
		// determine which page is being requested
		$uriparts = explode('/', $request->uri);
		$uri = $request->uri;
		if(count($uriparts) > 0 && strlen($uriparts[0]) > 1){
			for($n = 0; $n < count($uriparts); $n++){
				if($this->get(array('uri' => $uri))){
					$page->uri = $uri;
					break;
				} else {
					$uri = implode('/', explode('/', $uri, -1));
				}
			}
		} else {
			$page->uri = 'home';
		}
		// if no page can be found, load the 404 page
		if(strlen($page->uri) == 0){
			$page->uri = '404';
		}
		// if the user comes from a different website and a landing page exists, load the landing page
		if(strpos($request->referer, AppHelper::instance()->cfg->rootUrl) === false && $page->uri != '404'){
			if($this->get(array('uri' => 'landing/' . $page->uri))){
				$page->uri = 'landing/' . $page->uri;
			}
		}
		// substract the page uri from the requested uri and put the rest in the request parameters
		$request->params = explode('/', str_replace($page->uri . '/', '', $request->uri));
		
		return $page;
	}
		
	/**
	 * Returns an instance of the default model of this mapper
	 * @return Page
	 */
	public function defaultModel(){
		return new Page();
	}
	
}