<?php
// initial configuration
define('CONFIG_FILE', 'configuration/application.php');
define('AUTO_LOADER', 'library/Autoloader.php');
define('APP_PATH', $_SERVER['DOCUMENT_ROOT'] . 'social/application/');
define('SITE_PATH', $_SERVER['DOCUMENT_ROOT'] . 'social/public_html/');
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/social/');
ini_set('include_path', $_SERVER['DOCUMENT_ROOT'] . 'social/application/library/');

// start the application
include(APP_PATH . AUTO_LOADER);
$app = new Application();
$app->start();

// handle the request
$request = new Request();
$app->handleRequest($request);