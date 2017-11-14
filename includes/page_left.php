<ul class="sidemenu">
<?php
if($parent_menu == 'dashboard')
{
?>
	<li><a href="index.php?comp=com_dashboard" <?=$comp=='com_dashboard'?'class="active"':''?>>Charts</a></li>
    <li><a href="index.php?comp=com_water_activity_test" <?=$comp=='com_water_activity_test'?'class="active"':''?>>Water Activity Test Results</a></li>
    <li><a href="index.php?comp=com_plant_extract_test" <?=$comp=='com_plant_extract_test'?'class="active"':''?>>Plant Extract Profile Test Results</a></li>
<?php
}
?>
</ul>

<br /><BR />
