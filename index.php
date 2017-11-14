<?php
include_once('config.php');
include_once('includes/functions_system.php');
include_once('includes/functions_get.php');
include_once('includes/functions_generate.php');
include_once('includes/common.php');

$comp = $_REQUEST['comp'];
$action = $_REQUEST['action'];
$view = $_REQUEST['view'];

if(USER_IS_LOGGED == '1')	
{
	if($comp != '') 
	{ 

		if(file_exists('components/'.$comp.'.php')) 
		{ 
			include ('components/'.$comp.'.php'); 
		}
		else 
		{ 
			include_once('components/com_dashboard.php');
		} 
	} 
	else 
	{ 
		include_once('components/com_dashboard.php');
	} 			
	
	// Main Page Template
	require_once('templates/default/default.php');		
}
else if($comp == 'com_forgot_pass')
{
	include_once('components/com_forgot_pass.php');	
	require_once('templates/default_forgot_pass.php');
}
else
{
	include_once('components/com_login.php');
	require_once('templates/default/login.php');
} 

	

?>