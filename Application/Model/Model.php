<?php
class Model {
	
	public  function __construct() {
		Common::loadClass(DB_PATH);
	}

	protected function getDbInstance() {
		define ('DB_PATH', APP_DIR . 'Database' . DIRECTORY_SEPARATOR);
		require_once DB_PATH . 'DatabaseConnection.php';
		return DatabaseConnection::getDBConnection(Constants::CONNECTION_DB_NAME);
	}
}