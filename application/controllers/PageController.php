<?php

/**
 * Page controller
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class PageController extends AbstractController {
	
	/**
	 * Parse the page
	 * @param Page $page
	 * @return string
	 */
	public function parse(Page $page){
		// get the page scripts
		$scripts = $this->getScripts();
		// get the page theme + print css
		$styles = $this->getStyles($page->style);
		// parse the page layout TODO: layout controller doesn't exist yet
		$layoutController = new LayoutController();
		return $layoutController->parse($layout, $scripts, $styles);
	}
	
	/**
	 * Get the scripts
	 * @return Array
	 */
	private function getScripts(){
		$dir = AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->scriptPath;
		$url = AppHelper::instance()->cfg->rootUrl . AppHelper::instance()->cfg->scriptPath;
		return $this->readDir($dir, $url);
	}
	
	/**
	 * Get the styles
	 * @param string $style
	 * @return Array
	 */
	private function getStyles($style){
		$dir = AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->themesPath . AppHelper::instance()->cfg->theme . '/css/';
		$url = AppHelper::instance()->cfg->rootUrl . AppHelper::instance()->cfg->themesPath . AppHelper::instance()->cfg->theme . '/css/';
		$styles = $this->readDir($dir, $url);
		$dir .= $style . '/';
		$url .= $style . '/';
		return array_merge($styles, $this->readDir($dir, $url));
	}
	
	// TODO: misplaced function
	private function readDir($dir, $url){
		$files = array();
		if($handle = @opendir($dir)) {
			while(false !== ($file = readdir($handle))) {
				if($file != "." && $file != ".." && !is_dir($dir . $file)) {
					$files[] = $url . $file;
				}
			}
			closedir($handle);
		}
		return $files;
	}
	
}