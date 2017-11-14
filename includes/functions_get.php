<?php



function getUserFullName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_user WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['user_username'];
	}

}

function getProductCategoryName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_product_category WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['product_category'];
	}
}

function getAlbumName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_album WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['album'];
	}
}

function getServiceName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_services_category WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['category'];
	}
}



function getMagazineName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_magazine WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}

}

function getMagazineContentTypeName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_magazine_content_type WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}

}

function getMagazineContentName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_magazine_contents WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return '('.getMagazineName($row['category_id']).') '.$row['title'];
	} 

}

function getDestination($id)
{
	if($id != '')
	{
		 $sql = "SELECT * FROM tbl_country_destinations WHERE 
				id = ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return '('.getDestinationCountryName($row['category_id']).') '.$row['title'];
	} 

}

function getLifestyleContentWithType($id)
{
	if($id != '')
	{
		 $sql = "SELECT * FROM tbl_lifestyle_contents WHERE 
				id = ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return '('.getLifestyleType($row['content_type_id']).') '.$row['title'];
	} 

}

function getJournalContentWithType($id)
{
	if($id != '')
	{
		 $sql = "SELECT * FROM tbl_journal_contents WHERE 
				id = ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	} 

}

function countMagazineContentForSort($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_magazine_contents WHERE category_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function countMagazineContentSlideshowForSort($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_magazine_contents_slideshow WHERE category_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function countDestinationSlideshow($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_country_destination_slideshow WHERE content_type_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}



function countLifestyleContents($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_lifestyle_contents WHERE content_type_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}


function countLifestyleContentsSlide($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_lifestyle_content_slideshow WHERE content_type_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function getDestinationCountryName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_destination_hotlist_country WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}
}

function getDestinationType($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_destination_type WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}
}

function getLifestyleType($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_lifestyle_content_type WHERE 
				id= ".GetSQLValueString($id,"int")
				;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}
}

function countDestinationHotlistSlideshowForSort($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_destination_hotlist_country_slideshow WHERE category_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function countCountryDestinations($cat_id)
{
	$sql = "SELECT count(*) as ctr FROM tbl_country_destinations WHERE category_id = " .$cat_id;
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	return $row['ctr'];
}

function getSlideType($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_slide_type WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}

}

function getAdsSideTypeName($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_side_ads_type WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}

}

function getAccessId($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_user WHERE 
				id = ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['access_id'];
	}

}

function getTravelogueParent($id)
{
	if($id != '')
	{
		$sql = "SELECT * FROM tbl_journal_contents WHERE 
				id= ".GetSQLValueString($id,"int")
				;
				
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);	
		return $row['title'];
	}

}

?>