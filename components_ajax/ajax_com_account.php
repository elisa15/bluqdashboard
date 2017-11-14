<?php



include_once("../../config.php");
include_once('../includes/functions_system.php');
include_once('../includes/functions_get.php');
include_once('../includes/functions_generate.php');
include_once("../includes/common.php");

$sql = "SELECT * FROM tbl_user where id = '1'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);

?>
<div class="no-padding">
<p>
    <label>Title:</label><br />
    <?=$row['title']==""?'N/A':$row['title']?>
</p>
<br />

<p >
    <label>Details:</label><br />
    <?=$row['details']?>
</p>

<br />
<p>
    <label>Last Modified Date:</label><br />
    <?=date('F d, Y',$row['date_modified'])?>
</p>
</div>

<hr />