<?php

ini_set('display_errors', 1);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);

try{
	require_once APP_PATH . 'Config.php';
	require_once APP_PATH . 'Session.php';
	require_once APP_PATH . 'Autoload.php';

	session::init();
	Bootstrap::run(new Request);
}
	catch(Exception $e){
    	echo $e->getMessage();
	}
?>