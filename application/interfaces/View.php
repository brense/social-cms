<?php

/**
 * View interface
 *
 * @package interfaces
 * @author Rense Bakker
 * @version 1.0
 */
interface interfaces_View {
	
	public function setModel(Observable $model);
	public function getModel();
	
	public function setController(AbstractController $controller);
	public function getController();
	
	public function defaultController(Observable $model);
	
}