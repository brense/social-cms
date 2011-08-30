<?php

/**
 * Observer interface
 *
 * @package interfaces
 * @author Rense Bakker
 * @version 1.0
 */
interface interfaces_Observer {
	
	public function update(Observable $observable, $changes);
	
}