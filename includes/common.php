<?php


/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
*/

	putenv("TZ=Asia/Manila"); 
	userAuthentication();
	
	define('USER_ID', 				$_SESSION[SITE_U_CODE]['user_credentials']['user_id']);
	define('USERNAME', 				$_SESSION[SITE_U_CODE]['user_credentials']['user_username']);	
	define('ACCESS_ID', 			$_SESSION[SITE_U_CODE]['user_credentials']['access_id']);	
	define('USER_FIRST_NAME', 		$_SESSION[SITE_U_CODE]['user_credentials']['user_fname']);
	define('USER_LAST_NAME', 		$_SESSION[SITE_U_CODE]['user_credentials']['user_lname']);	
	define('USER_EMAIL', 			$_SESSION[SITE_U_CODE]['user_credentials']['user_email']);	
	define('USER_LAST_LOGIN', 		$_SESSION[SITE_U_CODE]['user_credentials']['user_last_login']);	
	define('USER_LAST_IP_CONNECTED', 	$_SESSION[SITE_U_CODE]['user_credentials']['last_ip_connected']);

	define('DATABASE_BACKUP_PATH', 		'DB_BACKUP/');
	define('TMP_UPLOAD', 		'tmp/');
	


	define('COMPANY_URL',$row['url']);

	
	

	
	

?>