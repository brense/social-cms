<?php
$cfg = array(
	'theme'			=> 'default',
	'title'			=> 'Rense Bakker',
	'debug'			=> false,
	'db' => array(
		'type'		=> 'pdo',
		'host'		=> 'localhost',
		'name'		=> 'social_cms',
		'user'		=> 'social_cms',
		'pswd'		=> 'cms_social',
		'prfx'		=> ''
	),
	'cachePath'		=> 'cache/',
	'tplPath'		=> 'templates/',
	'filesPath'		=> 'files/',
	'scriptPath'	=> 'public/js/',
	'themesPath'	=> 'public/themes/',
	'encryption'	=> 'MCRYPT_RIJNDAEL_256',
	'hash'			=> 'sha1',
	'cacheTime'		=> 120,
	'keys' => array(
		'secret'	=> '6e02b54d83a0a92d58c9d1e66f4facd0d0f87626',
	)
);