<?php

/**
 * Observable (abstract model)
 *
 * @package models
 * @author Rense Bakker
 * @version 1.0
 */
abstract class Observable {
	
	/**
	 * Variable that holds an array with the history of the model
	 * @var Array
	 */
	protected $_history = array();
	/**
	 * Variable that holds an array of observers that observe the model
	 * @var Array
	 */
	protected $_observers = array();
	
	/**
	 * Assign an observer to the model
	 * @param AbstractView $view
	 */
	public function addObserver(AbstractView $view){
		$this->_observers[] = $view;
	}
	
	/**
	 * Remove an observer from the models observer list
	 * @param AbstractView $view
	 */
	public function removeObserver(AbstractView $view){
		foreach($this->_observers as &$observer){
			if($observer === $view){
				unset($observer);
			}
		}
	}
	
	/**
	 * Notify observers of changes to the model
	 */
	public function notifyObservers($changes){
		foreach($this->_observers as $observer){
			$observer->update($this, $changes);
		}
	}
	
	/**
	 * Magic setter
	 * @param string $name
	 * @param string $value
	 */
	public function __set($name, $value){
		$changes = array(
			'function'	=> 'set',
			'params'	=> $name,
			'values'	=> $value,
			'timestamp'	=> date('U')
		);
		$this->notifyObservers($changes);
		$this->_history[] = $changes;
		
		$this->{'_' . $name} = $value;
	}
	
	/**
	 * Magic getter
	 * @param string $name
	 */
	public function __get($name){
		$changes = array(
			'function'	=> 'get',
			'params'	=> $name,
			'values'	=> $this->{'_' . $name},
			'timestamp'	=> date('U')
		);
		$this->notifyObservers($changes);
		$this->_history[] = $changes;
		
		return $this->{'_' . $name};
	}
	
	/**
	 * Return the models history
	 * @return Array
	 */
	public function getHistory(){
		return $this->_history;
	}

}