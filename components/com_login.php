<?php



/********************************************************
* NOTES !! NOTES !! NOTES !! NOTES !! NOTES !! NOTES !! 
*
* PASSWORD = md5(concat(md5('password'),'salt'))
*********************************************************/

$username 	= strtolower($_POST["username"]);
$password 	= $_POST["password"];
$email 		= $_POST["email"];
$action 	= $_POST["action"];

if($action == 'login')
{
	if($username != '' || $password != '')
	{

		$pass = md5(md5($password) . getUserSalt($username));
		$sql = "SELECT * FROM tbl_user WHERE 
				user_username= ".GetSQLValueString($username,"text")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);

		if($ctr > 0)
		{ 
			if($row['user_isblocked'] == 'Y')
			{
				$err_msg = 'Your account is blocked. Please contact the Administrator.';
			}		
			else
			{
				$sql = "SELECT * FROM tbl_user WHERE 
						user_username= ".GetSQLValueString($username,"text")." AND 
						user_password= ".GetSQLValueString($pass,"text")
						;
						
				$query = mysql_query($sql);
				$row = mysql_fetch_array($query);
				$ctr = mysql_num_rows($query);		
				if($ctr > 0 && $row['user_isblocked'] == 'N')
				{

						setSessionData($row['user_username']); // will set all session needed
						clearUserFailedLoginHistory($row['user_username']);						
						storedSessionLogs(); // save the session logs in the database
						updateUserLastLogin();	// update user last login
						echo '<script language="javascript">window.location =\'index.php\';</script>';
					
				}
				else
				{
					$err_msg = 'Invalid username and password or your account is blocked.';
				}
			}
		}
		else
		{
			$err_msg = 'Invalid username or password';
		}
	}
	else
	{
		$err_msg = 'Invalid username or password';
	}
	
}


$content_template = 'components/block/blk_com_login.php';
?>