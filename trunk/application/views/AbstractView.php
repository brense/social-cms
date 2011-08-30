<?php

/**
 * AbstractView
 *
 * @package views
 * @author Rense Bakker
 * @version 1.0
 */
abstract class AbstractView implements interfaces_Observer, interfaces_View {
	
	/**
	 * Variable that holds model that is being observed
	 * @var Observable
	 */
	protected $_model;
	/**
	 * Variable that holds controller that is assigned to the view
	 * @var AbstractController
	 */
	protected $_controller;
	
	/**
	 * Constructor
	 * @param Observable $model
	 * @param AbstractController $controller
	 */
	public function __construct(Observable $model, AbstractController $controller = NULL){
		$this->setModel($model);
		if(isset($controller)){
			$this->setController($controller);
		}
	}
	
	/**
	 * Returns the default controller for the model
	 * @param Observable $model
	 */
	public function defaultController(Observable $model){
		return null;
	}
	
	/**
	 * Sets the model to be observed
	 * @param Observable $model
	 */
	public function setModel(Observable $model){
		$this->_model = $model;
	}
	
	/**
	 * Returns the model that is being observed by the view
	 * @return Observable
	 */
	public function getModel(){
		return $this->_model;
	}
	
	/**
	 * Assign the controller to the view
	 * @param AbstractController $controller
	 */
	public function setController(AbstractController $controller){
		$this->_controller = $controller;
		$this->getController()->setView($this);
	}
	
	/**
	 * Returns the currently assigned controller
	 * @return AbstractController
	 */
	public function getController(){
		if(!isset($this->_controller)){
			$this->setController($this->defaultController($this->getModel()));
		}
		return $this->_controller;
	}
	
	
	/**
	 * Handle the changes made in the observable
	 * @param Observable $observable
	 */
	public function update(Observable $observable, $changes){
		foreach($changes as $key => $value){
			$observable->{$key} = $value;
		}
	}
}