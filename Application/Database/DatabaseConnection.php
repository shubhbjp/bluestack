<?php

class DatabaseConnection {
	
	private static $instance;
		
	public static function getDBConnection($dbName, $masterNode = true) {
		if ($masterNode) {
			if ($dbName == Constants::CONNECTION_DB_NAME) {
				if (self::$instance == NULL) {
					self::$instance = DatabaseConnection::getMasterDbConnection($dbName);
				}
			return self::$instance;
			}
		} else {
			Common::sendResponse(Constants::API_ERROR, Codes::DB_CONNECTION_FAILED);
		}
	}
	
	public static function getMasterDbConnection($dbName) {
		$dbConnectionData = parse_ini_file ( DB_PATH . 'Database.ini', true );
		if (isset ( $dbConnectionData [$dbName] )) {
			try {
				$connect = new PDO ( $dbConnectionData [$dbName] ['dsn'], $dbConnectionData [$dbName] ['username'], $dbConnectionData [$dbName] ['password'] );
				$connect->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch(\Exception $e) {
				Common::sendResponse(Constants::API_ERROR, Codes::DB_CONNECTION_FAILED);
			}
			return $connect;
		} else {
			Common::sendResponse(Constants::API_ERROR, Codes::DB_CONNECTION_FAILED);
		}
	}
}