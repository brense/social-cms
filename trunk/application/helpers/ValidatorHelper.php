<?php

/**
 * Validator helper
 *
 * TODO: needs to be revised
 *
 * @package helpers
 * @author Rense Bakker
 * @version 1.0
 */
class ValidatorHelper {
	
	private $_rules = array();
	private $_errors = array();
	
	public function __construct() {
		
	}
	
	public function addRule($field, $rules, $name, Array $options = array()){
		$this->_rules[] = array('field' => $field, 'rules' => $rules, 'name' => $name, 'options' => $options);
	}

	public function validate($input) {
		foreach($this->_rules as $rule){
			if(isset($input[$rule['field']])){
				foreach($rule['rules'] as $validator){
					switch($validator){
						// validate required fields
						case 'required':
							if(!$this->required($input[$rule['field']])){
								$this->_errors[] = array('field' => $rule['field'], 'msg' => 'The field "' . $rule['name'] . '" is required');
							}
						break;
						// validate if value exists
						case 'exists':
							if(!$this->exists($input[$rule['field']], $rule['options'])){
								$this->_errors[] = array('field' => $rule['field'], 'msg' => $rule['name'] . ' "' . $input[$rule['field']] . '" already exists');
							}
						break;
						// validate matching fields
						case 'match':
							if(isset($rule['options']['match'])){
								if(!$this->match($input[$rule['field']], $rule['options']['match'])){
									$this->_errors[] = array('field' => $rule['field'], 'msg' => 'The fields do not match');
								}
							}
						break;
						// validate email address
						case 'email':
							if(!$this->email($input[$rule['field']], $rule['options'])){
								$this->_errors[] = array('field' => $rule['field'], 'msg' => 'The email address is not valid');
							}
						break;
						// validate password
						case 'password':
							if(!$this->password($input[$rule['field']], $rule['options'])){
								$this->_errors[] = array('field' => $rule['field'], 'msg' => 'Your password should be atleast 8 character and should contain letters and numbers');
							}
						break;
					}
				}
			}
		}
		if(count($this->_errors) > 0){
			return $this->_errors;
		} else {
			return true;
		}
	}
	
	private function required($value){
		if(strlen($value) > 0){
			return true;
		} else {
			return false;
		}
	}
	
	private function exists($value, Array $options = array()){
		// TODO implement exists function
	}
	
	private function match($value, $match){
		if($value == $match){
			return true;
		} else {
			return false;
		}
	}
	
	private function email($value, Array $options = array()){
		$findats = strrpos($email, "@");
		if(is_bool($findats) && !$findats) {
			return false;
		}
		else {
			$domain = substr($email, $findats+1);
			$local = substr($email, 0, $findats);
			$locallength = strlen($local);
			$domainlength = strlen($domain);
			if($locallength < 1 || $locallength > 64) {
				return false;
			}
			elseif($domainlength < 1 || $domainlength > 256) {
				return false;
			}
			elseif($local[0] == '.' || $local[$locallength-1] == '.') {
				return false;
			}
			elseif((preg_match('/\\.\\./', $local)) || (preg_match('/\\.\\./', $domain))) {
				return false;
			}
			elseif(!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				return false;
			}
			elseif(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
				if(!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
					return false;
				}
			}
			elseif(!isset($options['dns']) && (!(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))) {
				return false;
			}
		}
		return true;
	}
	
	private function password($value, Array $options = array()){
		if(strlen($value) >= 8 && preg_match('#[0-9]#', $value) && preg_match('#[^a-z]#', $value)){
			return true;
		} else {
			return false;
		}
	}
	
}