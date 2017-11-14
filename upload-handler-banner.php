<?php



include_once("../config.php");
include_once('includes/functions_system.php');
include_once('includes/functions_get.php');
include_once('includes/functions_generate.php');
include_once("includes/common.php");


$new_filename = $_REQUEST['new_filename'];
$file_ext=explode(".",$_FILES['product_file']['name']);
$file_type=strtolower($file_ext[1]);
$uploaddir = TMP_UPLOAD;

$uploadfile = $uploaddir . $new_filename . '.' . $file_type;
$filename = $new_filename . '.' . $file_type;
//$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);


$image_size = getimagesize($_FILES['product_file']['tmp_name']);

if($image_size[0]>210)
{	
	if (move_uploaded_file($_FILES['product_file']['tmp_name'], $uploadfile)) {
			createthumb($uploadfile ,$uploaddir . $new_filename .  '.' . $file_type,190,200);
		echo $filename;
		}
	
}	
else 
{
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired

	if (move_uploaded_file($_FILES['product_file']['tmp_name'], $uploadfile)) {
		copy($uploadfile ,$uploaddir . $new_filename .  '.' . $file_type);
	echo $filename;
	}
}
