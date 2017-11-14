<?php


include_once("../../config.php");
include_once('../includes/functions_system.php');
include_once('../includes/functions_get.php');
include_once('../includes/functions_generate.php');
include_once("../includes/common.php");

$mod 			= $_GET['mod'];
$id 			= $_GET['id'];
$action 		= $_GET['action'];
$c_position 	= $_GET['c_position'];

if($action == 'inc')
{
	$n_position = $c_position - 1;
	$o_position = $c_position;
}
else if($action == 'dec')
{
	$n_position = $c_position + 1;
	$o_position = $c_position;
}

if($mod == 'sd')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_images WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_images SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE album_id = " .$row['album_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_images SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'magazine')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_magazine 
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_magazine SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_magazine 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_magazine SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'magazine_content_type')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_magazine_content_type
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_magazine_content_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine_content_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_magazine_content_type 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_magazine_content_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine_content_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'destination_type')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_destination_type
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_destination_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_destination_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_destination_type 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_destination_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_destination_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'destination_country')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_destination_hotlist_country
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_destination_hotlist_country SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_destination_hotlist_country SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_destination_hotlist_country 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_destination_hotlist_country SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_destination_hotlist_country SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}


else if($mod == 'lifestyle_content_type')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_lifestyle_content_type
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_lifestyle_content_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_lifestyle_content_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_lifestyle_content_type 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_lifestyle_content_type SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_lifestyle_content_type SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'slideshow')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_slideshow
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_slideshow SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_slideshow 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_slideshow SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'side_ads')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_ads_slidebar
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_ads_slidebar SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_ads_slidebar SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_ads_slidebar 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_ads_slidebar SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_ads_slidebar SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'contest_slideshow')
{
	if($action == 'dec')
	{
		$sql = "SELECT * FROM tbl_contest_slideshow
				WHERE sort_order > " .$o_position . " ORDER BY sort_order ASC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_contest_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_contest_slideshow SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}

	else if($action == 'inc')
	{
		$sql = "SELECT * FROM tbl_contest_slideshow 
				WHERE sort_order < " .$o_position . " ORDER BY sort_order DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$sql = "UPDATE tbl_contest_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int")."   
				WHERE sort_order = " .$row['sort_order'];
			
		mysql_query ($sql);

		$sql = "UPDATE tbl_contest_slideshow SET 
				sort_order = ".GetSQLValueString($row['sort_order'],"int")."   
				WHERE id = " .$id;
			
		mysql_query ($sql);		
	}
}

else if($mod == 'magazine_contents')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_magazine_contents WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_magazine_contents SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE category_id = " .$row['category_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine_contents SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'magazine_contents_slideshow')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_magazine_contents_slideshow WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_magazine_contents_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE category_id = " .$row['category_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_magazine_contents_slideshow SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'destination_hotlist_country_slideshow')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_destination_hotlist_country_slideshow WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_destination_hotlist_country_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE category_id = " .$row['category_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_destination_hotlist_country_slideshow SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}

else if($mod == 'country_destinations')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_country_destinations WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_country_destinations SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE category_id = " .$row['category_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_country_destinations SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'destination_slideshow')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_country_destination_slideshow WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_country_destination_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE content_type_id = " .$row['content_type_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_country_destination_slideshow SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'lifestyle_contents')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_lifestyle_contents WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_lifestyle_contents SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE content_type_id = " .$row['content_type_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_lifestyle_contents SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}



else if($mod == 'lifestyle_content_slideshow')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_lifestyle_content_slideshow WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_lifestyle_content_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE content_type_id = " .$row['content_type_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_lifestyle_content_slideshow SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}



else if($mod == 'traveloguepages')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_journal_contents_pages WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_journal_contents_pages SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE category_id = " .$row['category_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_journal_contents_pages SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


else if($mod == 'journal_content_slideshow')
{

	if($action == 'inc')
	{
		$n_position = $c_position - 1;
		$o_position = $c_position;
	}
	else if($action == 'dec')
	{
		$n_position = $c_position + 1;
		$o_position = $c_position;
	}

		$sql = "SELECT * FROM tbl_journal_content_slideshow WHERE id = " .$id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$sql = "UPDATE tbl_journal_content_slideshow SET 
				sort_order = ".GetSQLValueString($o_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE content_type_id = " .$row['content_type_id'] . " AND 
				sort_order = " . $n_position;

		mysql_query ($sql);

		$sql = "UPDATE tbl_journal_content_slideshow SET 
				sort_order = ".GetSQLValueString($n_position,"int").",   
				date_modified = ".GetSQLValueString(time(),"int")."  
				WHERE id = " .$id;

		mysql_query ($sql);
}


?>