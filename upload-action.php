<?php



include_once("../config.php");
include_once('includes/functions_system.php');
include_once('includes/functions_get.php');
include_once('includes/functions_generate.php');
include_once("includes/common.php");


if(isset($_REQUEST['id']) && $_REQUEST['id'] != '')
{
	$id = $_REQUEST['id'];
}
else
{
	$id = '0';
}

$filename 			= $_REQUEST['filename'];
$file_description 	= $_REQUEST['file_description'];
$crop_x 			= $_REQUEST['crop_x'];
$crop_y 			= $_REQUEST['crop_y'];
$crop_w 			= $_REQUEST['crop_w'];
$crop_h 			= $_REQUEST['crop_h'];

$img_param_arr	= array($crop_x,$crop_y,$crop_w,$crop_h);

$file_ext			= explode(".",$filename);
$file_type			= strtolower($file_ext[1]);

$new_filename 		= time() . '.' . $file_type;

$img_data = generateImage($img_param_arr,TMP_UPLOAD.$filename,PRODUCT_THUMB_PATH.$new_filename,150,150);
$img_data = generateImage($img_param_arr,TMP_UPLOAD.$filename,PRODUCT_FULL_PATH.$new_filename,350,350);

unlink(TMP_UPLOAD.$filename);

$sql = "SELECT * FROM tbl_shop_products_image WHERE products_id = $id AND img_primary = 'Y'";
$query = mysql_query($sql);
$ctr_primary = mysql_num_rows($query);

$img_primary = $ctr_primary > 0 ? 'N' : 'Y';

$sql = "INSERT INTO tbl_shop_products_image 
		(
			products_id, 
			img_file,
			img_description,
			img_primary,
			publish, 
			date_created,
			date_modified
		) 
		VALUES 
		(
			".GetSQLValueString($id,"int").", 
			".GetSQLValueString($new_filename ,"text").",  
			".GetSQLValueString($img_description,"text").", 
			".GetSQLValueString($img_primary,"text").",
			".GetSQLValueString('Y',"text").",
			".time().",
			".time()."
		)";

if (mysql_query ($sql)) {
	echo 'successfully uploaded.';
} else {
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired
	echo "error";
}
