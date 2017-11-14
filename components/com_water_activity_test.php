<?php

/*if(USER_IS_LOGGED != '1')
{
	echo '<script language="javascript">redirect(\'index.php\');</script>'; // No Access Redirect to main
}*/


$content_title = 'Water Activity';
$pagination = '';
$parent_menu = 'dashboard';

$view = $view==''?'list':$view; // initialize action

$id				= $_POST['id'];
$pic_action = $_POST['pic_action'];
$pic_action_id = $_POST['pic_action_id'];
 // [-] for images
$slideshow_pic = $_POST['slideshow_pic'] ;
$slide_id = $_POST['slide_id'];
// [+] for images
$crop_x 		= $_POST['crop_x'];
$crop_y 		= $_POST['crop_y'];
$crop_w 		= $_POST['crop_w'];
$crop_h 		= $_POST['crop_h'];
$img_param_arr	= array($crop_x,$crop_y,$crop_w,$crop_h);
$uploaded_file 	= $_POST['uploaded_file'];
 // [-] for images

$opt			= $_POST['opt'];
$count			= $_POST['count'];
$content_type_id  = $_POST['content_type_id'];
$category_id	= $_POST['category_id'];
$title			= $_POST['title'];
$description	= $_POST['description'];
$details		= $_POST['details'];
$thumbnail_photo = $_POST['thumbnail'];
$fileupload_file = $_FILES['fileupload_file']['name'];
$img_file 		= $_POST['img_file'];
$publish 		= $_POST['publish'] == '' ? 'N' :'Y';
$featured 		= $_POST['featured'] == '' ? 'N' :'Y';

$caption1		= $_POST['caption1'];
$caption		= $_POST['photo_caption'];
$caption2		= $_POST['caption2'];
$caption3		= $_POST['caption3'];
$fileupload_file1 = $_FILES['fileupload_file1']['name'];
$fileupload_file2 = $_FILES['fileupload_file2']['name'];
$fileupload_file3 = $_FILES['fileupload_file3']['name'];
$arr_err_msg = array();
$slide_id = $_POST['slide_id'];
$new_destination = $_POST['new_destination'];
$search_key		= $_POST['search_key'];
$page_rows 		= $_POST['page_rows']; 
$pageNum		= $_POST['pageNum'];


if($_SESSION[SITE_U_CODE]['comp'] != $comp)
{
	$_SESSION[SITE_U_CODE]['comp'] 		= $comp;
	$_SESSION[SITE_U_CODE]['page_rows'] = 10;
	$_SESSION[SITE_U_CODE]['pageNum']	= 1;
}

if($action == 'save')
{
	if($_FILES['fileupload_file']['name'] != '')
	{
		$unique_id='lifestyle_contents_'.time();
		$file_ext=explode(".",$_FILES['fileupload_file']['name']);
		$file_type=strtolower($file_ext[1]);
		$photo_size=getimagesize($_FILES['fileupload_file']['tmp_name']);
		$width = $photo_size[0];
		$height = $photo_size[1];
	}
	
	
	if($_FILES['fileupload_file1']['name'] != '')
	{
		$rename1 = basename($_FILES['fileupload_file1']['name']);
		$unique_id1='destination-hotlist-slideshow_'.'1_'.time();
		$file_ext1=explode(".",$_FILES['fileupload_file1']['name']);
		$file_type1=strtolower($file_ext1[1]);
		$photo_size1=getimagesize($_FILES['fileupload_file1']['tmp_name']);
		$width1 = $photo_size1[0];
		$height1 = $photo_size1[1];
	}
	if($_FILES['fileupload_file2']['name'] != '')
	{
		$rename2 = basename($_FILES['fileupload_file2']['name']);
		$unique_id2='destination-hotlist-slideshow_'.'2_'.time();
		$file_ext2=explode(".",$_FILES['fileupload_file2']['name']);
		$file_type2=strtolower($file_ext2[1]);
		$photo_size2=getimagesize($_FILES['fileupload_file2']['tmp_name']);
		$width2 = $photo_size2[0];
		$height2 = $photo_size2[1];
	}
	if($_FILES['fileupload_file3']['name'] != '')
	{
		$rename3 = basename($_FILES['fileupload_file3']['name']);
		$unique_id3='destination-hotlist-slideshow_'.'3_'.time();
		$file_ext3=explode(".",$_FILES['fileupload_file3']['name']);
		$file_type3=strtolower($file_ext3[1]);
		$photo_size3=getimagesize($_FILES['fileupload_file3']['tmp_name']);
		$width3 = $photo_size3[0];
		$height3 = $photo_size3[1];
	}
	
	if ($content_type_id == '' && $new_destination == '')
	{
		$arr_err_msg[] = '- Content Type';
	}
	if ($title == '')
	{
		$arr_err_msg[] = '- Title';
	}
	if( $_FILES['fileupload_file']['name'] == '')
	{
		$arr_err_msg[] = '- Content Thumbnail Photo';
	}
	else if($_FILES['fileupload_file']['tmp_name'] !='' && ($height != 415 || $width != 620))
	{
		$arr_err_msg[] = '- You can only upload an image with a size of 620px by 415px';
	}
	else if($_FILES['fileupload_file']['tmp_name'] !='' && ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png' && $file_type != 'gif'))
	{
		$arr_err_msg[] = '- You can only upload an image with jpeg,png,gif file type';
	}
	/*if ($description == '')
	{
		$arr_err_msg[] = '- Short Description';
	}
	/*if( $_FILES['fileupload_file']['name'] == '')
	{
		$arr_err_msg[] = '- Content Thumbnail Photo';
	}
	/*else if($_FILES['fileupload_file']['tmp_name'] !='' && ($height != 415 || $width != 620))
	{
		$arr_err_msg[] = '- You can only upload an image with a size of 620px by 415px';
	}
	else if($_FILES['fileupload_file']['tmp_name'] !='' && ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png' && $file_type != 'gif'))
	{
		$arr_err_msg[] = '- You can only upload an image with jpeg,png,gif file type';
	}*/
	
	$err_msg = implode("<br>",$arr_err_msg);
	
	if($err_msg != '' )
	{
		$err_msg = 'Some required fields are incorrect/missing.<br>'.$err_msg;
	}
	else
	{
		if($_FILES['fileupload_file']['tmp_name'] != '')
		{
			$upload_file = $unique_id.".".$file_type;
			
			if(!move_uploaded_file($_FILES['fileupload_file']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file)) 
			{
				//$err_msg = 'Error in generating image.';
			}
		}
		
		if($_FILES['fileupload_file1']['tmp_name'] != '')
		{
			$upload_file1 = $unique_id1.".".$file_type1;
			
			if(!move_uploaded_file($_FILES['fileupload_file1']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file1)) 
			{
				//$err_msg = 'Error in generating image.';
			}
		}
		if($_FILES['fileupload_file2']['tmp_name'] != '')
		{
			$upload_file2 = $unique_id2.".".$file_type2;
			
			if(!move_uploaded_file($_FILES['fileupload_file2']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file2)) 
			{
				//$err_msg = 'Error in generating image.';
			}
		}
		if($_FILES['fileupload_file3']['tmp_name'] != '')
		{
			$upload_file3 = $unique_id3.".".$file_type3;
			
			if(!move_uploaded_file($_FILES['fileupload_file3']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file3)) 
			{
				//$err_msg = 'Error in generating image.';
			}
		}
		
		if($err_msg  == '')
		{
			if($content_type_id == '' && $new_destination != '')
			{
				$sql_s_sort = "SELECT * FROM tbl_lifestyle_content_type  ORDER BY sort_order DESC";
			$qry_s_sort = mysql_query($sql_s_sort);
			$row_s_sort = mysql_fetch_array($qry_s_sort);
			
			$new_sort_val = 1 + $row_s_sort['sort_order'];
		
			$sql_insert = mysql_query("INSERT INTO tbl_lifestyle_content_type  ( 
						title,
						sort_order,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						".GetSQLValueString($new_destination,"text").", 
						".GetSQLValueString($new_sort_val,"text").", 
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)");
					
					
			}
			elseif($content_type_id != '' && $new_destination == '')
			{
				$new_destination_id = $content_type_id;	
			}
			if($sql_insert)
			{
				$selects = mysql_query("SELECT * FROM tbl_lifestyle_content_type WHERE title='".$new_destination."'");
				while($country_rows = mysql_fetch_array($selects))
				{
					$new_destination_id = $country_rows['id'];	
				}	
			}
			else
			{
				$new_destination_id = $content_type_id;
			}
			$sql_s_sort = "SELECT * FROM ai_articles where content_type_id = ".$content_type_id."
						  ORDER BY sort_order DESC";
			$qry_s_sort = mysql_query($sql_s_sort);
			$row_s_sort = mysql_fetch_array($qry_s_sort);
			
			$new_sort_val = 1 + $row_s_sort['sort_order'];
			
			
			
			$sql = mysql_query ("INSERT INTO ai_articles
					( 
						
						content_type_id,
						title,
						description,
						details,
						img_file, 
						sort_order,
						publish,
						featured,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						
						".GetSQLValueString($new_destination_id,"text").", 
						".GetSQLValueString($title,"text").", 
						".GetSQLValueString($description,"text").", 
						".GetSQLValueString($details,"text").", 
						".GetSQLValueString($upload_file,"text").", 
						".GetSQLValueString($new_sort_val,"text").", 
						".GetSQLValueString($publish,"text").",  
						".GetSQLValueString($featured,"text").",   
						".time().",
						".time().",
						".USER_ID."
					)");
			
			if($sql)
			{
				if($fileupload_file1 != "")
			{
				$select_id = mysql_query("SELECT * FROM ai_articles WHERE content_type_id = ".$new_destination_id);
				while($row_id = mysql_fetch_array($select_id))
				{
					$ctid = $row_id['id'];	
				}
				
			$sql1 = mysql_query("INSERT INTO tbl_lifestyle_content_slideshow
					( 
						content_type_id,
						title,
						caption,
						img_file, 
						sort_order,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						".$ctid.", 
						".GetSQLValueString($title,"text").", 
						".GetSQLValueString($caption1,"text").",
						".GetSQLValueString($upload_file1,"text").", 
						".GetSQLValueString($new_sort_val,"text").", 
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)") or die ("error1:".mysql_error());
			}
			
			
			
			if($fileupload_file2 != "")
			{
				$select_id = mysql_query("SELECT * FROM ai_articles WHERE content_type_id = ".$new_destination_id);
				while($row_id = mysql_fetch_array($select_id))
				{
					$ctid = $row_id['id'];	
				}
				
			$sql2 = mysql_query("INSERT INTO tbl_lifestyle_content_slideshow
					( 
						content_type_id,
						title,
						caption,
						img_file, 
						sort_order,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						".$ctid.", 
						".GetSQLValueString($title,"text").", 
						".GetSQLValueString($caption2,"text").",
						".GetSQLValueString($upload_file2,"text").", 
						".GetSQLValueString($new_sort_val,"text").", 
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)")or die ("error2:".mysql_error());
			}
			
			if($fileupload_file3 != "")
			{
				$select_id = mysql_query("SELECT * FROM ai_articles WHERE content_type_id = ".$new_destination_id);
				while($row_id = mysql_fetch_array($select_id))
				{
					$ctid = $row_id['id'];	
				}
				
			$sql3 = mysql_query("INSERT INTO tbl_lifestyle_content_slideshow
					( 
						content_type_id,
						title,
						caption,
						img_file, 
						sort_order,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						".$ctid.", 
						".GetSQLValueString($title,"text").", 
						".GetSQLValueString($caption3,"text").",
						".GetSQLValueString($upload_file3,"text").", 
						".GetSQLValueString($new_sort_val,"text").", 
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)")or die ("error3:".mysql_error());;
			}
				
				/*echo '<script language="javascript">alert("Item has been successfully Added!");window.location =\'index.php?comp='.$comp.'\';</script>';*/
				$view = 'list';
				$sucess_msg = '<div class="message success"><p>Item Has been successfully added!</p></div>';
			}
			else 
			{		
			die('Error:' . mysql_error());
			}
		}	
	}
}

elseif($action == 'delete_pic')
{
	
	/*echo '<script language="javascript">alert("delete button is click & id='.$slide_id.'.");window.location =\'index.php?comp='.$comp.'\';</script>';*/
	
	$delete_sql = mysql_query("DELETE FROM tbl_lifestyle_content_slideshow
							WHERE id = ".$slide_id."");
	
	
}

else if($action == 'update')
{
	if($_FILES['fileupload_file']['name'] != '')
	{
		$unique_id='lifestyle_contents_'.time();
		$file_ext=explode(".",$_FILES['fileupload_file']['name']);
		$file_type=strtolower($file_ext[1]);
		$photo_size=getimagesize($_FILES['fileupload_file']['tmp_name']);
		$width = $photo_size[0];
		$height = $photo_size[1];
	}
	
	if($_FILES['fileupload_file1']['name'] != '')
	{
		$rename1 = basename($_FILES['fileupload_file1']['name']);
		$unique_id1='destination-hotlist-slideshow_'.$rename1.'_'.time();
		$file_ext1=explode(".",$_FILES['fileupload_file1']['name']);
		$file_type1=strtolower($file_ext1[1]);
		$photo_size1=getimagesize($_FILES['fileupload_file1']['tmp_name']);
		$width1 = $photo_size1[0];
		$height1 = $photo_size1[1];
	}
	if($_FILES['fileupload_file2']['name'] != '')
	{
		$rename2 = basename($_FILES['fileupload_file2']['name']);
		$unique_id2='destination-hotlist-slideshow_'.$rename2.'_'.time();
		$file_ext2=explode(".",$_FILES['fileupload_file2']['name']);
		$file_type2=strtolower($file_ext2[1]);
		$photo_size2=getimagesize($_FILES['fileupload_file2']['tmp_name']);
		$width2 = $photo_size2[0];
		$height2 = $photo_size2[1];
	}
	if($_FILES['fileupload_file3']['name'] != '')
	{
		$rename3 = basename($_FILES['fileupload_file3']['name']);
		$unique_id3='destination-hotlist-slideshow_'.$rename3.'_'.time();
		$file_ext3=explode(".",$_FILES['fileupload_file3']['name']);
		$file_type3=strtolower($file_ext3[1]);
		$photo_size3=getimagesize($_FILES['fileupload_file3']['tmp_name']);
		$width3 = $photo_size3[0];
		$height3 = $photo_size3[1];
	}
	
	
	
	if ($content_type_id == '' && $new_destination == '')
	{
		$arr_err_msg[] = '- Content Type';
	}
	if ($title == '')
	{
		$arr_err_msg[] = '- Title';
	}
	/*
	if($img_file == '' && $_FILES['fileupload_file']['name'] == '')
	{
		$arr_err_msg[] = '- Content Thumbnail Photo';
	}
	else if($_FILES['fileupload_file']['tmp_name'] !='' && ($height != 415 || $width != 620))
	{
		$arr_err_msg[] = '- You can only upload an image with a size of 620px by 415px';
	}
	else if($_FILES['fileupload_file']['tmp_name'] !='' && ($file_type != 'jpg' && $file_type != 'jpeg' && $file_type != 'png' && $file_type != 'gif'))
	{
		$arr_err_msg[] = '- You can only upload an image with jpeg,png,gif file type';
	}*/
	
	$err_msg = implode("<br>",$arr_err_msg);
	
	if($err_msg != '' )
	{
		$err_msg = 'Some required fields are incorrect/missing.<br>'.$err_msg;
	}
	else
	{
		if ($_FILES['fileupload_file']['name'] !='')
		{
				$upload_file = $unique_id.".".$file_type;
				
				if(!move_uploaded_file($_FILES['fileupload_file']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file)) 
				{
					//$err_msg = 'Error in generating image.';
				}
				
				// clean the uploaded files
				$sql = "SELECT * FROM ai_articles 
						WHERE id = " .$id;	
				$query = mysql_query($sql);
				while($row = mysql_fetch_array($query))
				{
					if(file_exists(LIFESTYLE_THUMB_PATH. $row['img_file']))
					{
						@unlink(LIFESTYLE_THUMB_PATH.$row['img_file']);
					}
					
					if(file_exists(LIFESTYLE_FULL_PATH. $row['img_file']))
					{
						@unlink(LIFESTYLE_FULL_PATH.$row['img_file']);
					}
					
				}	
				
				$img_field = 'img_file = '.GetSQLValueString($upload_file,"text").','; 			
		
		}
		
				
		if($err_msg  == '')
		{
			
			
			
			if ($fileupload_file1 !='')
		{
				$rename11 = basename($_FILES['fileupload_file1']['name']);
				$unique_id11	='destination-hotlist-slideshow_1'.'_'.time();
				
				$file_ext11=explode(".",$_FILES['fileupload_file1']['name']);
				$file_type11=strtolower($file_ext11[1]);
				$photo_size11=getimagesize($_FILES['fileupload_file1']['tmp_name']);
				$width11 = $photo_size11[0];
				$height11 = $photo_size11[1];
				
				$upload_file1 = $unique_id11.".".$file_type11;
				
				if(!move_uploaded_file($_FILES['fileupload_file1']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file1)) 
				{
					//$err_msg = 'Error in generating image.';
				}
				
				
				
				
				$sql1 = "INSERT INTO tbl_lifestyle_content_slideshow
					( 
						category_id,
						content_type_id,
						title,
						caption,
						img_file,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						
						".GetSQLValueString($category_id,"text").",
						".$id.",
						".GetSQLValueString($title,"text").",
						".GetSQLValueString($caption1,"text").",
						".GetSQLValueString($upload_file1,"text").",
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)";
					mysql_query ($sql1) or die ("ERROR: image 1 ".mysql_error());
				
				
		
		}
		if ($fileupload_file2 !='')
		{
				$rename22 = basename($_FILES['fileupload_file2']['name']);
				$unique_id22	='destination-hotlist-slideshow_2'.'_'.time();
				$file_ext22=explode(".",$_FILES['fileupload_file2']['name']);
				$file_type22=strtolower($file_ext22[1]);
				$photo_size22=getimagesize($_FILES['fileupload_file2']['tmp_name']);
				$width22 = $photo_size22[0];
				$height22 = $photo_size22[1];
				$upload_file2 = $unique_id22.".".$file_type22;
				
				if(!move_uploaded_file($_FILES['fileupload_file2']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file2)) 
				{
					//$err_msg = 'Error in generating image.';
				}
				
				
				
				
				$sql2 = "INSERT INTO tbl_lifestyle_content_slideshow
					( 
						
						category_id,
						content_type_id,
						title,
						caption,
						img_file,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						
						".GetSQLValueString($category_id,"text").",
						".$id.",
						".GetSQLValueString($title,"text").",
						".GetSQLValueString($caption2,"text").",
						".GetSQLValueString($upload_file2,"text").",
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)";
			mysql_query ($sql2) or die ("ERROR: image 2 ".mysql_error());	
				
		
		}
		if ($fileupload_file3 !='')
		{
				$rename33 = basename($_FILES['fileupload_file3']['name']);
				$unique_id33	='destination-hotlist-slideshow_3'.'_'.time();
		$file_ext33=explode(".",$_FILES['fileupload_file3']['name']);
		$file_type33=strtolower($file_ext33[1]);
		$photo_size33=getimagesize($_FILES['fileupload_file3']['tmp_name']);
		$width33 = $photo_size33[0];
		$height33 = $photo_size33[1];
				$upload_file3 = $unique_id33.".".$file_type33;
				
				if(!move_uploaded_file($_FILES['fileupload_file3']['tmp_name'], LIFESTYLE_FULL_PATH . $upload_file3)) 
				{
					//$err_msg = 'Error in generating image.';
				}
				
								
				
				
				$sql3 = "INSERT INTO tbl_lifestyle_content_slideshow
					( 
						
						category_id,
						content_type_id,
						title,
						caption,
						img_file,
						publish,
						date_created,
						date_modified,
						created_by
					) 
					VALUES 
					(
						".GetSQLValueString($category_id,"text").",
						".$id.",
						".GetSQLValueString($title,"text").",
						".GetSQLValueString($caption3,"text").",
						".GetSQLValueString($upload_file3,"text").",
						".GetSQLValueString($publish,"text").",    
						".time().",
						".time().",
						".USER_ID."
					)";
					mysql_query ($sql3) or die ("ERROR: image 3 ".mysql_error());
							
		
		}
			
			
			
			$sql_curr = "SELECT * FROM ai_articles 
				WHERE id=" .$id;
			$qry_curr = mysql_query($sql_curr);
			$row_curr = mysql_fetch_array($qry_curr);
			
			$curr_category = $row_curr['content_type_id'];
				
			$c_sorting = $row_curr['sort_order'];
			$update_sort_order = '';
			if($curr_category != $content_type_id)	
			{	
				$sql_sort = "SELECT max(sort_order) as max_sort FROM ai_articles 
					WHERE content_type_id=" .$content_type_id;
				$qry_sort = mysql_query($sql_sort);
				$row_sort = mysql_fetch_array($qry_sort);
				
				$new_sort= $row_sort['max_sort']+1 ;
				$update_sort_order = " sort_order = ".$new_sort .","; 
			}
			
			$sql = "UPDATE ai_articles SET 
			        content_type_id = ".GetSQLValueString($content_type_id,"text").",
					category_id = ".GetSQLValueString($category_id,"text").",
					title = ".GetSQLValueString($title,"text").",  
					description = ".GetSQLValueString($description,"text").",  
					details = ".GetSQLValueString($details,"text").",  
					".$img_field ."  
					publish = ".GetSQLValueString($publish,"text").",  
					featured = ".GetSQLValueString($featured,"text").",  
					date_modified = ".GetSQLValueString(time(),"int")."  
					WHERE id = " .$id;		
					
					
					for($i=0;$i<$count;$i++){
						
						$caption_id = $_POST['caption_slide_id'][$i];
						
			$sqlupdate1="UPDATE tbl_lifestyle_content_slideshow
			 SET caption='".$caption[$i]."' WHERE id='".$caption_id."'";
			$result1=mysql_query($sqlupdate1) or die ("update error:".mysql_error());
			}
					
	
			if(mysql_query ($sql))
			{
				
				
				
				if($curr_category != $content_type_id)	
				{
					$sql_sort_pos = "SELECT * FROM ai_articles 
									 WHERE content_type_id = ".$curr_category." and sort_order > " . $c_sorting;
					$qry_sort_pos = mysql_query($sql_sort_pos);
					$ctr_sort_pos = mysql_num_rows($qry_sort_pos);
					
					$n_sorting = $c_sorting;
					
					while($row_sort_pos = mysql_fetch_array($qry_sort_pos))
					{
							$sql = "UPDATE ai_articles
									SET sort_order = $n_sorting
									WHERE id = " . $row_sort_pos['id'] ;
							mysql_query ($sql);
							
							$n_sorting++;
					}
				}
				
				
			/*	echo '<script language="javascript">alert("Item has been successfully updated.");window.location =\'index.php?comp='.$comp.'\';</script>';*/
			$view = 'edit';
				$sucess_msg = '<div class="message success"><p>Item Has been successfully updated!</p></div>';
			}
		}
		
	}
	
}
else if($action == 'delete')
{
	foreach($id as $item)
	{
		if ($item != '')
		{
			// clean the uploaded files
			$sql = "SELECT * FROM ai_articles
					WHERE id = $item";
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query))
			{
				if(file_exists(LIFESTYLE_THUMB_PATH. $row['img_file']))
				{
					@unlink(LIFESTYLE_THUMB_PATH.$row['img_file']);
				}

				if(file_exists(LIFESTYLE_FULL_PATH. $row['img_file']))
				{
					@unlink(LIFESTYLE_FULL_PATH.$row['img_file']);
				}
			}	
			
			$sql = "SELECT * FROM ai_articles 
					WHERE id=" .$item;
			$qry = mysql_query($sql);
			$row = mysql_fetch_array($qry);
			
			$category_id = $row['content_type_id'];
			
			$sql = "DELETE FROM ai_articles 
					WHERE id=" .$item;
			mysql_query ($sql);
			
			$c_sorting = $row['sort_order'];
			
			$sql_sort_pos = "SELECT * FROM ai_articles 
							 WHERE sort_order > " . $c_sorting . " and content_type_id = ".$category_id;
			$qry_sort_pos = mysql_query($sql_sort_pos);
			$ctr_sort_pos = mysql_num_rows($qry_sort_pos);
			
			$n_sorting = $c_sorting;
			
			while($row_sort_pos = mysql_fetch_array($qry_sort_pos))
			{
					$sql = "UPDATE ai_articles
							SET sort_order = $n_sorting
							WHERE id = " . $row_sort_pos['id'] ;
					mysql_query ($sql);
					
					$n_sorting++;
			}
		}
	}

	if(count($arr_str) > 0)
	{
		/*echo '<script language="javascript">alert("Item has been successfully deleted.");window.location =\'index.php?comp='.$comp.'\';</script>';*/
		$sucess_msg = '<div class="message success"><p>Item Has been successfully deleted!</p></div>';
	}
}
else if($action == 'publish')
{
	foreach($id as $item)
	{
		$sql = "UPDATE ai_articles SET publish = 'Y', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}
else if($action == 'unpublish')
{
	foreach($id as $item)
	{
		$sql = "UPDATE ai_articles SET publish = 'N', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}
else if($action == 'featured')
{
	foreach($id as $item)
	{
		$sql = "UPDATE ai_articles SET featured = 'Y', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}
else if($action == 'unfeatured')
{
	foreach($id as $item)
	{
		$sql = "UPDATE ai_articles SET featured = 'N', date_modified = ".time() ." WHERE id=" .$item;
		mysql_query ($sql);
	}
}
if($view == 'edit')
{
	if($pic_action == 'unpublish')
				{
					
						
						
						$sql_update = mysql_query("UPDATE tbl_lifestyle_content_slideshow SET
							publish = 'N',
							date_modified = ".time()."  
							WHERE id = " .$pic_action_id);
							
							
					
				}
				if($pic_action == 'publish')
				{
					
						
						
						$sql_update = mysql_query("UPDATE tbl_lifestyle_content_slideshow SET
							publish = 'Y',
							date_modified = ".time()."  
							WHERE id = " .$pic_action_id);
					
				}
				if($sql_update)
							{
								$view = 'edit';	
							}
	
	if(is_array($id))
	{
		$id	= $id[0]; // only get the first index for edit.
	}
	
	$sql = "SELECT * FROM ai_articles
			WHERE id = " . GetSQLValueString($id,"int");
	$query = mysql_query ($sql);
	$row = mysql_fetch_array($query);
	
	$content_type_id =  isset($_POST['content_type_id']) ? $_POST['content_type_id'] : $row['content_type_id'];
	$category_id 	= isset($_POST['category_id']) ? $_POST['category_id'] : $row['category_id'];
	$title			= isset($_POST['title']) ? $_POST['title'] : str_replace('"','&quot;',$row['title']);
	$description 	= isset($_POST['description']) ? $_POST['description'] : $row['description'];
	$details	 	= isset($_POST['details']) ? $_POST['details'] : $row['details'];
	$img_file 		= isset($_POST['img_file']) ? $_POST['img_file'] : $row['img_file'];
	$publish 		= isset($_POST['publish']) ? $_POST['publish'] : $row['publish'];
	$featured 		= isset($_POST['featured']) ? $_POST['featured'] : $row['featured'];
}
else if($view == 'add')
{
	$content_type_id    = $_POST['content_type_id'];
	$category_id		= $_POST['category_id'];
	$title				= $_POST['title'];
	$description		= $_POST['description'];
	$details			= $_POST['details'];
	$img_file 			= $_POST['img_file'];
	$publish 			= 'Y';
	
}

if(file_exists(TMP_UPLOAD. $uploaded_file))
{
	@unlink(TMP_UPLOAD.$uploaded_file);
}
// component block, will be included in the template page

$content_template = 'components/block/blk_com_water_activity_test.php';

?>