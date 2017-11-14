<?php
session_start();
define ('SITE_U_CODES','');


			$db_server		=  'localhost';
			$db_user		= 'root';
			$db_password	= '';
			$db_name		= 'usaid';
		
	$root_path = '../';
	
	define('DATABASE_HOST_SERVER',$db_server);
	define('DATABASE_SERVER_USERNAME',$db_user);
	define('DATABASE_SERVER_PASSWORD',$db_password);
	define('DATABASE_NAME',$db_name);
	
	// CONNECT TO DATABASE
	$conn = @mysql_connect (DATABASE_HOST_SERVER,DATABASE_SERVER_USERNAME,DATABASE_SERVER_PASSWORD) or die('Could not connect to server');
	
	if($conn)
	{
		@mysql_select_db(DATABASE_NAME ,$conn) or die('Access denied or can\'t find database');
	}
	else
	{
		exit;
	}

		//echo BRANCH_ID;
	
?>
