<?php

/**
 * Controller interface
 *
 * @package interfaces
 * @author Rense Bakker
 * @version 1.0
 */
interface interfaces_Controller {
	
	public function setModel(Observable $model);
	public function getModel();
	
	public function setView(AbstractView $view);
	public function getView();
	
}