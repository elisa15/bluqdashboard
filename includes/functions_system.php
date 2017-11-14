<?php


function countProductByParent($product_category_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_product WHERE product_category_id = " .$product_category_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
	case "text":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
	  break;    
	case "long":
	case "int":
	  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	  break;
	case "double":
	  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	  break;
	case "date":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;
	case "defined":
	  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	  break;
  }
  return $theValue;
}

function generatePassword($length = 8, $letters = '1234567890qwertyuiopasdfghjklzxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ') 
{ 
	$pass = ''; 
	$lettersLength = strlen($letters)-1; 
	
	for($i = 0 ; $i < $length ; $i++) 
	{ 
	$pass .= $letters[rand(0,$lettersLength)]; 
	} 
	
	return $pass; 
}  


function generateRandomString($length = 20, $letters = '1234567890qwertyuiopasdfghjklzxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ') 
{ 
	$arr_str = array();
	$lettersLength = strlen($letters)-1; 
	
	for($i = 0 ; $i < $length ; $i++) 
	{ 
		$arr_str[] = $letters[rand(0,$lettersLength)]; 
	} 
	
	return implode('',$arr_str);
} 

function generateSaltString($length = 10, $letters ='1234567890qwertyuiopasdfghjklzxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ') 
{ 
	$arr_str = array();
	$lettersLength = strlen($letters)-1; 
	
	for($i = 0 ; $i < $length ; $i++) 
	{ 
		$arr_str[] = $letters[rand(0,$lettersLength)]; 
	} 
	
	return implode('',$arr_str);
} 

function getUserIP()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   /*check ip from share internet*/
	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   /*to check ip is pass from proxy*/
	{
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}



function getUserSalt($username)
{

	if($username != '' && isset($username))
	{
		$sql = "SELECT user_salt FROM tbl_user WHERE 
			user_username= ".GetSQLValueString($username,"text")
			;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		return $row['user_salt'];
	}
}

function setSessionData($username)
{
	if($username != '' && isset($username))
	{
												
		$sql = "SELECT * FROM tbl_user WHERE 
				user_username= ".GetSQLValueString($username,"text")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
														
		$_SESSION[SITE_U_CODE]['logged_info'] 	= array(
													'log_session_id'	=> session_id(),
													'log_status' 		=> 1,
													'log_timestamp' 	=> time(),
													'log_ip_address'	=> getUserIP()
												);
			
		$_SESSION[SITE_U_CODE]['user_credentials'] 	= array(
													'user_id' 			=> $row['id'],
													'user_type' 		=> $row['user_type'],
													'user_fname' 		=> $row['user_fname'],
													'user_lname' 		=> $row['user_lname'],
													'user_contact_num' 	=> $row['user_contact_num'],
													'user_email' 		=> $row['user_email'],
													'user_username' 	=> $row['user_username'],
													'user_password' 	=> $row['user_password'],
													'user_isblocked'	=> $row['user_isblocked'],
													'user_salt'			=> $row['user_salt'],
													'user_last_login'	=> $row['user_last_login'],
												);
	}
}

function clearUserFailedLoginHistory($username)
{
	$sql = "UPDATE tbl_user SET 
		user_failed_logs  = '0',
		user_last_failed_login = '0',
		user_no_of_block_times	= '0'
		WHERE username= ".GetSQLValueString($username,"text");	
	mysql_query ($sql);

}

function storedSessionLogs()
{

	if(SYS_ALLOWED_SIM_LOGIN == 'N')
	{
		$sql = "DELETE FROM tbl_session_logs WHERE user_id = ".$_SESSION[SITE_U_CODE]['user_credentials']['user_id'];
		mysql_query ($sql);
	}			
		$sql = "INSERT INTO tbl_session_logs 
				(
					session_id,
					user_id,
					ip_connected, 
					date_logged
				) 
				VALUES 
				(
					".GetSQLValueString($_SESSION[SITE_U_CODE]['logged_info']['log_session_id'] ,"text").", 
					".GetSQLValueString($_SESSION[SITE_U_CODE]['user_credentials']['user_id'] ,"int").", 
					".GetSQLValueString($_SESSION[SITE_U_CODE]['logged_info']['log_ip_address'] ,"text").", 
					".GetSQLValueString($_SESSION[SITE_U_CODE]['logged_info']['log_timestamp'] ,"int") ."
				)";
		
		mysql_query ($sql);

}

function updateUserLastLogin()
{
	$sql = "UPDATE tbl_user SET 
				user_last_login = ".GetSQLValueString($_SESSION[SITE_U_CODE]['logged_info']['log_timestamp'] ,"int") . "
				WHERE id = " . GetSQLValueString($_SESSION[SITE_U_CODE]['user_credentials']['user_id'] ,"int");
	
	if(mysql_query ($sql))
	{
	}
}

function userAuthentication()
{
	if($_SESSION[SITE_U_CODE]['logged_info']['log_status'] === 1)
	{
		if(!checkIfUserSessionIsActive())
		{
		
			session_unset();
			session_destroy();
			session_regenerate_id(true);
			echo '<script language="javascript">alert(\'Session expired. Please try to login again.\');window.location =\'index.php\';</script>';
		}	
		else
		{
			define('USER_IS_LOGGED', 1);
		}
	}
	else
	{
		define('USER_IS_LOGGED', 0);	
	}

}	

function checkIfUserSessionIsActive()
{
	$sql = "SELECT * FROM tbl_session_logs WHERE 
		session_id = ".GetSQLValueString($_SESSION[SITE_U_CODE]['logged_info']['log_session_id'],"text") ." AND
		user_id = ".GetSQLValueString($_SESSION[SITE_U_CODE]['user_credentials']['user_id'],"text")
		;
	$query = mysql_query($sql);
	$ctr = mysql_num_rows($query);

	if($ctr > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}	

function countCategoryByParent($parent_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_category WHERE category_parent = " .$parent_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function createthumb($name,$filename,$new_w,$new_h)
{
		//$system=explode('.',$name);
		if (preg_match('/.jpg|.jpeg/',$name)){
			$src_img=imagecreatefromjpeg($name);
		}
		if (preg_match('/.png/',$system[1])){
			$src_img=imagecreatefrompng($name);
		}
		
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) {
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) {
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) {
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		
		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename); 
		} else {
			imagejpeg($dst_img,$filename); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
}


function createthumb_no_crop($name,$filename,$new_w,$new_h){
	$system=explode('.',$name);
	if (preg_match('/jpg|jpeg/',$system[1])){
		$src_img=imagecreatefromjpeg($name);
	}
	if (preg_match('/png/',$system[1])){
		$src_img=imagecreatefrompng($name);
	}	
}


function generateImage($img_param_arr,$src_path,$dest_path,$new_w,$new_h)
{

	$x 		= $img_param_arr[0];
	$y 		= $img_param_arr[1];
	$w 		= $img_param_arr[2];
	$h 		= $img_param_arr[3];

	list($width, $height, $image_type) = getimagesize($src_path);

    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($src_path); break;
        case 2: $src = imagecreatefromjpeg($src_path); break;
        case 3: $src = imagecreatefrompng($src_path); break;
        default: return '';  break;
    }	
	
	$dst_r = imagecreatetruecolor($new_w, $new_h );

	imagecopyresampled($dst_r,$src,0,0,$x,$y,$new_w,$new_h,$w,$h);
	
    switch ($image_type)
    {
        case 1: imagegif($dst_r); break;
        case 2: imagejpeg($dst_r,$dest_path,100);  break; // best quality
        case 3: imagepng($dst_r, $dest_path, 0); break; // no compression
        default: echo ''; break;
    }


	
}

/* backup the db OR just a table */
function backup_tables($author,$backup_path,$host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	//save file
	$tmp_filename = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
	$handle = fopen($backup_path.$tmp_filename,'w+');
	
	if(fwrite($handle,$return))
	{
		fclose($handle);
		$fp = fopen($backup_path.$tmp_filename, "r");
		$data = fread ($fp, filesize($backup_path.$tmp_filename));
		fclose($fp);
		
		$filename = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql.gz';
		$zp = gzopen($backup_path.$filename , "w9");
		
		if(gzwrite($zp, $data))
		{
			gzclose($zp);		
			@unlink($backup_path.$tmp_filename);
			if(backup_logs($backup_path,$filename,$author))
			{
				return true;
			}
		}
	}
	else
	{
		fclose($handle);
		return false;
	}	

}
function backup_logs($backup_path,$backup_filename,$author)
{
	
	$myFile = $backup_path."backup_logs.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = '|' . $backup_filename . "," . $author . "," . time() . "\n";
	
	if(fwrite($fh, $stringData))
	{
		fclose($fh);
		return true;
	}
	else
	{
		fclose($fh);
		return false;
	}	
}

function checkIfEmailExist($email)
{
	if($email != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE user_email= ".GetSQLValueString($email,"text");
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);


		if($ctr >= 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkIfEmailExistUpdate($email)
{
	if($email != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE user_email= ".GetSQLValueString($email,"text");
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);


		if($ctr > 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


function countImageByAlbum($album_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_images WHERE album_id = " .$album_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function countImageBySlideshowCategory($category_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_slideshow WHERE category_id = " .$category_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function countServicesByCategory($service_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_services WHERE service_id = " .$service_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}


function checkUserIfExistForEdit($username,$cust_id)
{
	if($email != '' || $cust_id != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE 
				id <> ".GetSQLValueString($cust_id,"int") . " 
				AND user_username= ".GetSQLValueString($username,"text");
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		$ctr = mysql_num_rows($query);
		
		if($ctr > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkEmailIfExistForEdit($email,$cust_id)
{
	if($email != '' || $cust_id != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE 
				id <> ".GetSQLValueString($cust_id,"int") . " 
				AND user_email= ".GetSQLValueString($email,"text");
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		$ctr = mysql_num_rows($query);
		
		if($ctr > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkIfEmailExistForAddUser($email)
{
	if($email != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE user_email= ".GetSQLValueString($email,"text");
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);

		if($ctr > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkIfUserExistForAddUser($username)
{
	if($username != '')
	{
		$sql = "SELECT * FROM tbl_user 
				WHERE user_username= ".GetSQLValueString($username,"text");
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);

		if($ctr > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkIfEmailIsValid($email)
{
  return !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function checkIfCategoryNameExistForProductCategoryAdd($category_name)
{
	if($category_name != '')
	{
		$sql = "SELECT * FROM tbl_category 
				WHERE category_name= ".GetSQLValueString($category_name,"text");
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$ctr = mysql_num_rows($query);

		if($ctr > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function checkIfCategoryNameExistForProductCategoryEdit($category_name,$category_parent)
{
	if($category_name != '' || $category_parent != '')
	{
		$sql = "SELECT * FROM tbl_category 
				WHERE 
				category_parent = ".GetSQLValueString($category_parent,"int") . " 
				AND category_name= ".GetSQLValueString($category_name,"text");
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		$ctr = mysql_num_rows($query);
		
		if($ctr > 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>