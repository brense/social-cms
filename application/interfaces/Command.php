<?php

/**
 * Command interface
 *
 * @package interfaces
 * @author Rense Bakker
 * @version 1.0
 */
interface Interfaces_Command {
	
	public function execute(Request $request);
	
}