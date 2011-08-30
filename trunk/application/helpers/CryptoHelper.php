<?php

/**
 * Cryptography helper
 *
 * @package helpers
 * @author Rense Bakker
 * @version 1.0
 */
class CryptoHelper {
	
	/**
	 * Stores the hash type that should be used
	 * @var int
	 */
	private $_hash;
	/**
	 * Stores the encryption type that should be used
	 * @var int
	 */
	private $_encryption;
	
	/**
	 * Constructor, allows the configured hash and encryption value to be overriden
	 * @param string $hash
	 * @param string $encryption
	 */
	public function __construct($hash = null, $encryption = null) {
		// if hash parameter is provided to constructure, override the default configured hash value
		if(isset($hash)){
			$ths->_hash = $hash;
		} else {
			$this->_hash = AppHelper::instance()->cfg->hash;
		}
		// if encryption parameter is provided to constructure, override the default configured encryption value
		if(isset($encryption)){
			$this->_encryption = $encryption;
		} else {
			$this->_encryption = AppHelper::instance()->cfg->encryption;
		}
	}
	
	/**
	 * Creates a hash from the given input
	 * @param string $input
	 * @return string
	 */
	public function hash($input) {
		return hash($this->_hash, $input);
	}
	
	/**
	 * Encrypts the provided input, if encryption fails it will create a hash
	 * @param string $input
	 * @return string
	 */
	public function encrypt($input) {
		if(function_exists('mcrypt_encrypt')){
			$iv_size = mcrypt_get_iv_size($this->_encryption, MCRYPT_MODE_ECB);
    		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    		return mcrypt_encrypt($this->_encryption, AppHelper::instance()->cfg->keys['secret'], $input, MCRYPT_MODE_ECB, $iv);
		} else {
			return $this->hash($input);
		}
	}
	
	/**
	 * Decrypts the provided input, if decryption fails it will throw an exception
	 * @param string $input
	 * @return string
	 */
	public function decrypt($input) {
		if(function_exists('mcrypt_encrypt')){
			$iv_size = mcrypt_get_iv_size($this->_encryption, MCRYPT_MODE_ECB);
    		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    		return mcrypt_decrypt($this->_encryption, AppHelper::instance()->cfg->keys['secret'], $input, MCRYPT_MODE_ECB, $iv);
		} else {
			throw new Exception('mcrypt not enabled, unable to decrypt input');
		}
	}
	
}