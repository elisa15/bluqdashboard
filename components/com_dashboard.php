<?php


if(USER_IS_LOGGED != '1')
{
	echo '<script language="javascript">redirect(\'index.php\');</script>'; // No Access Redirect to main
}


$page_title = 'Welcome to BluQ Dashboard';
$pagination = '';
$parent_menu = 'dashboard';

$view = $view==''?'list':$view; // initialize action

$id	= $_REQUEST['id'];
$temp 	= $_REQUEST['temp'];


// component block, will be included in the template page
$content_template = 'components/block/blk_com_dashboard.php';
?>