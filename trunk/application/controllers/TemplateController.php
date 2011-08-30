<?php

/**
 * Template controller
 *
 * TODO: needs to be revised completely
 *
 * @package controllers
 * @author Rense Bakker
 * @version 1.0
 */
class TemplateController extends AbstractController {
	
	/**
	* parses the contents of a page
	* @param array $content array with the page contents
	* @return array with the parsed page contents
	*/
	public function parse($content){
		// attempt to get the cached contents
		if($content['cache'] == 'yes') {
			$fileparts = $content;
			unset($fileparts['cache'], $fileparts['cacheTime'], $fileparts['part']);
			$cacheFile = AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->cachePath . sha1(implode($fileparts)) . '.txt';
			if(isset($content['cacheTime'])){
				$time = $content['cacheTime'];
			} else {
				$time = AppHelper::instance()->cfg->cacheTime;
			}
			$cacheEmpty = $this->getCache($cacheFile, $time);
		}
		// parse the content when cache could not be found
		if(!isset($contents)) {
			ob_start();
			if(isset($content['options'])){
				$options = $content['options'];
			} else {
				$options = array();
			}
			switch($content['type']){
				case 'view':
					$this->parseView($content['model'], $content['view'], $content['controller'], $options);
				break;
				case 'template':
					$this->parseTemplate($content['template'], $options);
				break;
				case 'feed':
					$this->parseFeed($content['url'], $options);
				break;
				case 'gadget':
					$this->parseGadget($content['gadget'], $options);
				break;
				case 'content':
					echo $content['content'];
				break;
			}
			$contents = ob_get_contents();
			ob_end_clean();
		}
		// write the contents to the cache file when the cache was empty
		if($content['cache'] == 'yes' && $cacheEmpty) {
			$this->writeCache($cacheFile, $contents);
		}
		// return the parsed contents
		return $contents;
	}
	
	/**
	* cleans up all the cache files
	*/
	public function clearCache(){
		if ($handle = opendir(AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->cachePath)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					unlink(AppHelper::instance()->cfg->rootUrl . AppHelper::instance()->cfg->cachePath . $file);
				}
			}
			closedir($handle);
		}
	}
	
	/**
	* parses the content type "view"
	* @param string $model the name of the model
	* @param string $view the name of the view
	* @param string $controller the name of the controller
	* @param array $options array with options
	*/
	private function parseView($model, $view, $controller, $options = array()){
		$model = new $model();
		$controller = new $controller($model);
		$view = new $view($model, $controller);
		$view->render();
	}
	
	/**
	* parses the content type "template"
	* @param string $template the name of the template
	* @param array $options array with options
	*/
	private function parseTemplate($template, $options = array()){
		$template = AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->tplPath . $template . '.php';
		if(file_exists($template)) {
			include($template);
		} else {
			echo 'template not found';
		}
	}
	
	/**
	* parses the content type "feed"
	* @param string $url the feed url
	* @param array $options array with options
	*/
	private function parseFeed($url, $options = array()){
		// load the feed xml
		$feed = simplexml_load_file($url);
		// get the feed options
		if(isset($options['limit'])){
			$limit = $options['limit'];
		} else {
			$limit = 20;
		}
		// parse the xml contents
		foreach($feed->channel->item as $item){
			$items[] = array(
				'title' => (string)$item->title,
				'link' => (string)$item->link
			);
		}
		$feeds = array(
			'title' => (string)$feed->channel->title,
			'link' => (string)$feed->channel->link,
			'items' => array_slice($items, 0, $limit)
		);
		// include the default feeds template
		include(AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->tplPath . 'feeds.php');
	}
	
	/**
	* parses the content type "gadget"
	* @param string $gadget the location of the gadget
	* @param array $options array with options
	*/
	private function parseGadget($gadget, $options = array()){
		$gadgetUrl = $gadget;
		// include the default gadget template
		include(AppHelper::instance()->cfg->sitePath . AppHelper::instance()->cfg->tplPath . 'gadget.php');
	}
	
	/**
	* gets the cache file contents, returns true if the cache file doesn't exist
	* @param string $cacheFile the location of the cache file
	* @param int $time the cache duration
	* @return bool
	*/
	private function getCache($cacheFile, $time){
		// determine if cache exists
		if(file_exists($cacheFile)){
			// determine of cache file is not expired
			if((filemtime($cacheFile) + $time) > time()){
				$contents = file_get_contents($cacheFile);
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	/**
	* writes the contents to a cache file
	* @param string $cacheFile the location of the cache file
	* @param string $content the content for the cache file
	*/
	private function writeCache($cacheFile, $content){
		file_put_contents($cacheFile, $content);
	}
	
}