Installations of Essentials Softwares to run the code on ubuntu:
	1) Update the current installed softwares and upgrade its corressponding packages using following commands
		. sudo apt-get update
		. sudo apt-get upgrade
	2) Install apache2 or nginx (I am using apache2 using following command)
		. sudo apt-get install apache2
	3) Install PHP
		. sudo apt install php
	   To check the version installed PHP => php --version
	4) Install Mysql and set up its local configuration
		. sudo apt-get install mysql-server mysql-client
		. sudo mysql_secure_installation
	   To check the version installed Mysql => mysql --version
	5) Installing phpmyadmin for server setup and database username and password for access controls.
		. sudo apt-get install phpmyadmin
	   Include /etc/phpmyadmin/apache.conf in /etc/apache2/apache2.conf using sudo permissions 
		. sudo -H nano /etc/apache2/apache2.conf
	   Restart the server
	6) Install PHP PDO Mysql Driver sudo apt-get install php7.2-mysql after uncommenting the pdo extension in php.ini file

===================================================================================================
Mysql Table

DROP TABLE IF EXISTS youtube_popular_videos;
CREATE TABLE `railyatri_production`.`youtube_popular_videos` (  
  `id` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `label` TEXT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `view_count` BIGINT(10) NOT NULL DEFAULT 0,
  `main_thumbnails` VARCHAR(255) NOT NULL DEFAULT '',
  `thumbnails` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

Please make changes in database.ini file for DB Credentials in path Application/Database/Database.ini
Keep the db name as key to access.

Please change the CONNECTION_DB_NAME constant in Constants.php to the same db name key kept in database.ini file
Also change the MAIN_SERVER_URL constant in Constants.php file from localhost to server domain if you execute this code to some other domain apart from localhost.