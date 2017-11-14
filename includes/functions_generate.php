<?php

function generateResults($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT result FROM default_transaction WHERE result != '' GROUP BY result";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['result'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['result'].'" '.$selected.' >'.$row['result'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateProduct($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_shop_products ";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['product_name'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateProductCategory($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_product_category";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['product_category'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateAlbum($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_album";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['album'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateService($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_services_category";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['category'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateMagazineContentTypes($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_magazine_content_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateLifestyleContentTypes($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_lifestyle_content_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateJournalContents($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_journal_contents";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateMagazines($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_magazine";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateMagazineContents($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_magazine_contents";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >('.getMagazineName($row['category_id']).'-'.getMagazineContentTypeName($row['content_type_id']).') '.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateDestinationHotlistCountry($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_destination_hotlist_country";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateSlideType($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_slide_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateSideAdsTypes($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_side_ads_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateLifetyleContentType($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_lifestyle_content_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateLifetyleContent($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_lifestyle_contents";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >('.getLifestyleType($row['content_type_id']).') '.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateJournalContent($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_journal_contents";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateDestinationType($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_destination_type";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}

function generateCountryDestinations($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_country_destinations";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}



function generateCountryDestinationsWithcountry($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_country_destinations";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >('.getDestinationCountryName($row['category_id']).') '.$row['title'].'</option>';

	}
	
	return implode('',$arr_str);
}


function generateContestantEmails($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_contestants";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		$arr_str[] = '<option value="'.$row['id'].'" '.$selected.' >'.$row['fname']." ".$row['lname'].'</option>';

	}
	
	return implode('',$arr_str);
}




function generateUserLevel($selected_item)
{
	$arr_str = array();
	
	$sql = "SELECT * FROM tbl_user";				
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		if($row['id'] == $selected_item)
		{
			$selected = 'selected="selected"';
		}
		else
		{
			$selected = '';
		}
		
		if($row['access_id'] == '1')
		{
				$user_level = 'Admin';
		}
		else
		{
				$user_level = 'User';	
		}
		
		$arr_str[] = '<option value="'.$row['access_id'].'" '.$selected.' >'.$user_level.'</option>';

	}
	
	return implode('',$arr_str);
}

?>