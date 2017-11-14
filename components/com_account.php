<?php


if(USER_IS_LOGGED != '1')
{
	echo '<script language="javascript">redirect(\'index.php\');</script>'; // No Access Redirect to main
}



$content_title = 'Users';
$pagination = '';
$parent_menu = 'tools';

$view ='edit'; // initialize action



$id					= USER_ID;

$user_fname 		= $_POST['user_fname'];
$user_lname 		= $_POST['user_lname'];
$user_username 		= $_POST['user_username'];
$user_password 		= $_POST['user_password'];
$user_re_password 	= $_POST['user_re_password'];
$user_email 		= $_POST['user_email'];
$user_isblocked 	= $_POST['user_isblocked'] == '' ? 'N' :'Y';
$search_key			= $_POST['search_key'];
$page_rows 			= $_POST['page_rows']; 
$pageNum			= $_POST['pageNum'];


if($_SESSION[SITE_U_CODE]['comp'] != $comp)
{
	$_SESSION[SITE_U_CODE]['comp'] 		= $comp;
	$_SESSION[SITE_U_CODE]['page_rows'] = 10;
	$_SESSION[SITE_U_CODE]['pageNum']	= 1;
}

if($action == 'save')
{
	if($user_fname == '' || $user_lname == '' || $user_username == '' || $user_password == '' || $user_re_password == '' || $user_email == '' )
	{
		$err_msg = 'Some of the required fields are missing.';
	}
	else if(checkIfEmailIsValid($user_email))
	{
		$err_msg = 'Invalid email address.';
	}
	else if(checkIfEmailExistForAddUser($user_email))
	{
		$err_msg = 'Email address already exist';
	}
	else if(checkIfUserExistForAddUser($user_username))
	{
		$err_msg = 'Username already exist';
	}
	else if($user_password != $user_re_password)
	{
		$err_msg = 'The password entered doesn\'t match ';
	}
	else
	{	
		$generated_salt = generateSaltString();		
		$encrypted_pass = md5(md5($user_password).$generated_salt);
		
		$sql = "INSERT INTO tbl_user 
				( 
					access_id,
					user_fname,
					user_lname,
					user_username, 
					user_password,
					user_salt,
					user_email,
					user_isblocked,
					created_by,
					date_created,
					date_modified
				) 
				VALUES 
				(
					".GetSQLValueString('2',"int").",
					".GetSQLValueString($user_fname,"text").",  
					".GetSQLValueString($user_lname,"text").", 
					".GetSQLValueString($user_username,"text").",
					".GetSQLValueString($encrypted_pass,"text").",
					".GetSQLValueString($generated_salt,"text").",
					".GetSQLValueString($user_email,"text").",
					".GetSQLValueString($user_isblocked,"text").",  
					".GetSQLValueString(USER_ID,"int").",
					".time().",
					".time()."
				)";
		
		if(mysql_query ($sql))
		{
			echo '<script language="javascript">alert("User has been successfully Added!");window.location =\'index.php?comp='.$comp.'\';</script>';
		}
	}	
}
else if($action == 'update')
{
	if($user_fname == '' || $user_lname == '' || $user_username == '' || $user_email == '' )
	{
		$err_msg = 'Some of the required fields are missing.';
	}
	else if(checkIfEmailIsValid($user_email))
	{
		$err_msg = 'Invalid email address.';
	}
	else if(checkEmailIfExistForEdit($user_email,$id))
	{
		$err_msg = 'Email address already exist';
	}
	else if(checkUserIfExistForEdit($user_username,$id))
	{
		$err_msg = 'Username already exist';
	}
	else if(($user_password != '' && $user_re_password == '') || ($user_password == '' && $user_re_password != ''))
	{
		$err_msg = 'Please confirm your password';
	}
	else if( ($user_password != '' && $user_re_password != '') && ($user_password != $user_re_password))
	{
		$err_msg = 'The password entered doesn\'t match.';
	}
	else
	{	
		if( ($user_password != '' && $user_re_password != '') && ($user_password == $user_re_password))
		{
			$generated_salt = generateSaltString();
			$encrypted_pass = md5(md5($user_password).$generated_salt);	
			$salt_field = 'user_salt = '.GetSQLValueString($generated_salt,"text").',';
			$password_field = 'user_password = '.GetSQLValueString($encrypted_pass,"text").',';
		}
	
		$sql = "UPDATE tbl_user SET 
				user_fname = ".GetSQLValueString($user_fname,"text").",  
				user_lname = ".GetSQLValueString($user_lname,"text").",  
				user_username = ".GetSQLValueString($user_username,"text").",   
				user_email = ".GetSQLValueString($user_email,"text").",	
				" .$salt_field." 				
				" .$password_field." 
				user_isblocked = ".GetSQLValueString($user_isblocked,"text").",  
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;		

		if(mysql_query ($sql))
		{
			echo '<script language="javascript">alert("User has been successfully updated.");window.location =\'index.php?comp='.$comp.'\';</script>';
		}
		else
		{
			mysql_error();
		}
	}
}
else if($action == 'delete')
{
	foreach($id as $item)
	{
		if ($item != '')
		{
			$sql = "DELETE FROM tbl_user WHERE id=" .$item;
			mysql_query ($sql);			
		}
	}

	if(count($arr_str) > 0)
	{
		echo '<script language="javascript">alert("Item has been successfully deleted.");window.location =\'index.php?comp='.$comp.'\';</script>';
	}
}
else if($action == 'publish')
{
	foreach($id as $item)
	{
		$sql = "UPDATE tbl_user SET user_isblocked = 'Y', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}
else if($action == 'unpublish')
{
	foreach($id as $item)
	{
		$sql = "UPDATE tbl_user SET user_isblocked = 'N', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}

if($view == 'edit')
{
	if(is_array($id))
	{
		$id	= $id[0]; // only get the first index for edit.
	}
	
	$sql = "SELECT * FROM tbl_user where id = " . GetSQLValueString($id,"int");
	$query = mysql_query ($sql);
	$row = mysql_fetch_array($query);

	$user_fname 		= $row['user_fname'] != $_POST['user_fname']? $row['user_fname'] : $_POST['user_fname'];
	$user_lname 		= $row['user_lname'] != $_POST['user_lname']? $row['user_lname'] : $_POST['user_lname'];
	$user_username 		= $row['user_username'] != $_POST['user_username']? $row['user_username'] : $_POST['user_username'];
	$user_email 		= $row['user_email'] != $_POST['user_email']? $row['user_email'] : $_POST['user_email'];	
	$user_password 		= $_POST['user_password'];
	$user_re_password 	= $_POST['user_re_password'];
	$user_isblocked 	= $row['user_isblocked'];
}
else if($view == 'add')
{

	$user_fname 		= $_POST['user_fname'];
	$user_lname 		= $_POST['user_lname'];
	$user_username 		= $_POST['user_username'];
	$user_password 		= $_POST['user_password'];
	$user_re_password 	= $_POST['user_re_password'];	
	$user_email 		= $_POST['user_email'];	
	$user_isblocked 	= $_POST['user_isblocked'] == '' ? 'N' :'Y';
}

// component block, will be included in the template page

$content_template = 'components/block/blk_com_account.php';

?>