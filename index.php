<?php
define('ROOT_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'Application' . DIRECTORY_SEPARATOR);
require_once 'AutoLoad.php';
try {
	$autoLoad = new AutoLoad();
	$autoLoad->apiHandling();	
} catch (Exception $e) {
	echo $e;
}
?>