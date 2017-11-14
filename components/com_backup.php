<?php


if(USER_IS_LOGGED != '1')
{
	echo '<script language="javascript">redirect(\'index.php\');</script>'; // No Access Redirect to main
}


$content_title = 'Database Backup Manager';
$pagination = '';
$parent_menu = 'tools';

$view = $view==''?'list':$view; // initialize action

$id							= $_POST['id'];


$search_key					= $_POST['search_key'];

$page_rows 					= $_POST['page_rows']; 
$pageNum					= $_POST['pageNum'];

if($_SESSION[SITE_U_CODE]['comp'] != $comp)
{
	$_SESSION[SITE_U_CODE]['comp'] 		= $comp;
	$_SESSION[SITE_U_CODE]['page_rows'] = 10;
	$_SESSION[SITE_U_CODE]['pageNum']	= 1;
}


if($action == 'backup')
{

	if(backup_tables(USER_ID, DATABASE_BACKUP_PATH, DATABASE_HOST_SERVER, DATABASE_SERVER_USERNAME, DATABASE_SERVER_PASSWORD, DATABASE_NAME))
	{
		echo '<script language="javascript">alert("Database backup has been successfully created.");window.location =\'index.php?comp='.$comp.'\';</script>';
	}
	else
	{
		echo '<script language="javascript">alert("Failed in creating database backup. Please contact system administrator.");window.location =\'index.php?comp='.$comp.'\';</script>';
	}

}
else if($action == 'delete')
{
	$log_file = DATABASE_BACKUP_PATH . "backup_logs.log";
	$arr_data = array();
	foreach($id as $item)
	{
		if ($item != '')
		{
			if(file_exists($log_file))
			{
				$fh = fopen($log_file, 'r');
				$theData = fread($fh, filesize($log_file));
				fclose($fh);
				if($theData != '' )
				{
					$backup_logs = explode("|",$theData);
				}	
				
				foreach($backup_logs  as $logs ) 
				{
					if($logs != '')
					{
						list($filename,$author,$time_logs) = explode(",",$logs);
						if($filename != $item)
						{
							$arr_data[] = "|" . $logs . "\n";
						}
						else
						{
							@unlink( DATABASE_BACKUP_PATH.$filename );
						}
					}
				}				
			}
		}
	}

	$fh = fopen($log_file , 'w') or die("can't open file");
	$stringData = implode('',$arr_data);
	fwrite($fh, $stringData);
	fclose($fh);

	echo '<script language="javascript">alert("Item has been successfully deleted.");window.location =\'index.php?comp='.$comp.'\';</script>';

}

// component block, will be included in the template page
$content_template = 'components/block/blk_com_backup.php';
?>