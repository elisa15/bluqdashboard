<?php



include_once("../../config.php");
include_once('../includes/functions_system.php');
include_once('../includes/functions_get.php');
include_once('../includes/functions_generate.php');
include_once("../includes/common.php");

$search_key = $_GET['search_key'];
$page_rows = $_GET['page_rows'];
$pageNum = $_GET['pageNum'];

if($search_key != '')
{
	$and = " WHERE product_name LIKE '%$search_key%' ";
}


//Here we count the number of results 

//Edit $data to be your query 
	$sql_pagination = " SELECT * FROM 
							tbl_user  " . $and . " 
						ORDER BY 
							user_username ASC ";
			//echo $sql_pagination;
$query_pagination  = mysql_query ($sql_pagination);
$row_ctr = mysql_num_rows($query_pagination ); 

// [+] initialize the number of rows to display

	$page_rows = $page_rows ==''?$_SESSION[SITE_U_CODE]['page_rows']:$page_rows; 


	if($_SESSION[SITE_U_CODE]['page_rows'] != $page_rows)
	{
		$_SESSION[SITE_U_CODE]['page_rows'] = $page_rows;
		$pageNum = 1;
	}

// [-] initialize the number of rows to display

// [+] initialize the current page of the pagination

	if($pageNum!='')
	{
		$limitFrom = ($pageNum*$page_rows) - $page_rows; 
		$_SESSION[SITE_U_CODE]['pageNum'] = $pageNum;
	}
	else if($_SESSION[SITE_U_CODE]['pageNum'] != '')
	{
		$limitFrom = ($_SESSION[SITE_U_CODE]['pageNum']*$page_rows) - $page_rows; 
	}
	else
	{
		$limitFrom = '1';
	}
// [-] initialize the current page of the pagination

//This tells us the page number of our last page 
$last = ceil($row_ctr/$page_rows); 

		$max = 'limit ' .$limitFrom .',' .$page_rows; 	

?>
<script type="text/javascript">
$(document).ready(function(){  

	// Initialize the Actions
	$('#btn_do_action').click(function(){

			if($('#action_select').val() == 'add')
			{
				$('#view').val($('#action_select').val());
				$('#action').val($('#action_select').val());
				$("cmsForm").submit();
			}
			else if(checkIfThereAreItemSelected())
			{
				if($('#action_select').val() == 'delete' && $('#check_all').is(':checked'))
				{
					if(alert('Deleting all users is prohibited.'))
					{
						$('#view').val('list');
					}
					return false;
				}
				if($('#action_select').val() == 'delete')
				{
					if(confirm('Are you sure you wish to permanently remove this item?'))
					{
						$('#view').val('list');
						$('#action').val($('#action_select').val());
						$("cmsForm").submit();
					}
					else
					{
						uncheckAllItem();
						return false;
					}
				}
				else if($('#action_select').val() == 'publish' && $('#check_all').is(':checked'))
				{
					 if(alert('Blocking all users is prohibited.'))
	   				 {
						$('#view').val('list');
					 }
					 return false;
					 
				}
				else if($('#action_select').val() == 'publish')
				{
					 if(confirm('Are you sure you wish to block this user?'))
	   				 {
						$('#view').val('list');
						$('#action').val($('#action_select').val());
						$("cmsForm").submit();
					 }
				}	
				else if( $('#action_select').val() == 'unpublish')
				{
						$('#view').val('list');
						$('#action').val($('#action_select').val());
						$("cmsForm").submit();
				}	
				else
				{
						$('#view').val('list');
						$('#action').val($('#action_select').val());
						$("cmsForm").submit();
				}	
			}
			else if(($('#action_select').val() != 'add' || $('#action_select').val() != 'list') && !checkIfThereAreItemSelected())
			{
				alert('No item is selected.');
				return false;
			}
	});	

	$("#check_all").click(function()				
	{
		var checked_status = this.checked;
		$(".id").each(function()
		{
			this.checked = checked_status;
		});
	});	


	$('.arrowup').click(function(){
		$.ajax({
			type: "GET",
			data: "mod=category&id="+$(this).attr('returnId')+"&action=inc&c_position="+$(this).attr('returnPosition'),
			url: "components_ajax/ajax_update_sort.php",
			success: function(msg){
				updateList(<?=$pageNum?>);
			}
		});		
	});	

	$('.arrowdown').click(function(){
		$.ajax({
			type: "GET",
			data: "mod=category&id="+$(this).attr('returnId')+"&action=dec&c_position="+$(this).attr('returnPosition'),
			url: "components_ajax/ajax_update_sort.php",
			success: function(msg){
				updateList(<?=$pageNum?>);
			}
		});	
	});	

	$('.do_edit_action').click(function(){
		checkSelectedItem($(this).attr('returnId'));
		$('#view').val('edit');
		$('#action').val('edit');
		$("#cmsForm").submit();
	});	

	$('.do_delete_action').click(function(){
		if(confirm('Are you sure you wish to permanently remove this item?'))
		{
			checkSelectedItem($(this).attr('returnId'));
			$('#view').val('list');
			$('#action').val('delete');
			$("#cmsForm").submit();
		}
	});	
	
	$('.publish').click(function(){
	   if(confirm('Are you sure you wish to block/unblock this user?'))
	   {
			checkSelectedItem($(this).attr('returnId'));
			$('#view').val('list');
			$('#action').val($(this).attr('returnAction'));
			$("#cmsForm").submit();
	   }
	});		


	$('a[name=pageCtr]').click(function(){
		updateList($(this).attr('returnNum'));
	});	

	$('#page_rows').change(function(){
		updateList();
	});		

});	

</script>

<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="20"><input type="checkbox" value="all" class="check_all" name="check_all" id="check_all" /></td>
        <th width="216">User Name</th>   
        <th width="222">Full Name</th>
        <th width="130">Access Level</th>
        <th width="130">Blocked</th>
        <th width="170">Date created</th>
        <th width="170">Date modified</th>        
      	<td width="39">&nbsp;</td>
  	</tr>
    <?php

	if($row_ctr > 0)
	{

		$sql = "SELECT * FROM 
					tbl_user  " . $and . " 
				ORDER BY 
					user_username ASC "  . $max;

		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query))
		{
    	?>
        <tr>
            <td><input type="checkbox" id="id_<?=$row['id']?>" name="id[]" class="id" value="<?=$row['id']?>" /></td>
            <td><a href="#" class="do_edit_action" returnId="<?=$row['id']?>"><?=$row['user_username']?></a></td>
            <td><a href="#" class="do_edit_action" returnId="<?=$row['id']?>"><?=$row['user_fname']?> <?=$row['user_lname']?></a></td>
            <td><span class="text"><?=$row['access_id']=='1'?'Admin':'User'?></span></td>
            <td><span class="text"><?=$row['user_isblocked']=='Y'?'Yes':'No'?></span><span class="publish" returnId="<?=$row['id']?>" returnAction="<?=$row['user_isblocked']=='Y'?'unpublish':'publish'?>" title="switch">&nbsp;</span></td>
            <td><?=date('F d, Y',$row['date_created'])?></td>
            <td><?=date('F d, Y',$row['date_modified'])?></td>
            <td class="delete"><a href="#" class="do_delete_action" returnId="<?=$row['id']?>">Delete</a></td>
        </tr>
    <?php
		}
	} // end of IF
	else
	{
    ?>
    	<tr>
            <td colspan="9">
            	No item found
            </td>
        </tr>
    <?php
	}
	?>

</table>

<div class="tableactions">
    <select id="action_select" name="action_select">
        <option value="list">List View</option>
        <option value="add">Add</option>
        <option value="edit">Edit</option>
        <option value="delete">Delete</option>
        <option value="publish">Block</option>
        <option value="unpublish">Unblock</option>
    </select>    

    <input name="btn_do_action" id="btn_do_action" type="submit" class="submit tiny" value="Apply to selected" />
</div>		<!-- .tableactions ends -->

<div class="paggination right">    
	<select id="page_rows" name="page_rows">
        <option value="1" <?=$page_rows=='5'?'selected="selected"':''?>>1</option>
        <option value="10" <?=$page_rows=='10'?'selected="selected"':''?>>10</option>
        <option value="20" <?=$page_rows=='20'?'selected="selected"':''?>>20</option>
        <option value="50" <?=$page_rows=='50'?'selected="selected"':''?>>50</option>
        <option value="100" <?=$page_rows=='100'?'selected="selected"':''?>>100</option>        
    </select>


	<?php
	$max_nums = 3;
	$nums = $last;
	$first_num = 1;

	if($pageNum > 1)
	{
    	echo '<a href="#" name="pageCtr" returnNum="1">&laquo; first</a>';
	}

	if($nums > $max_nums)
	{
		$div = ceil($last / $max_nums);

		if(($pageNum + $max_nums) > $max_nums && ($pageNum + $max_nums) <= $last)
		{	
			$nums = $pageNum + $max_nums;
			$first_num = $pageNum  - 1; 

			if($first_num < 1)
			{
				$first_num = 1;
			}
		}
		else
		{
			$prev = ($nums - $max_nums) - 2 ;
			echo '<a href="#" name="pageCtr" returnNum="'. $prev. '">'. $prev .'</a> ... ';
			$nums = $last;
			$first_num = $nums - $max_nums; 
		}
	}
	else
	{
		$nums = $last;
	}

    for($x=$first_num ;$x<=$nums;$x++) {
        if ($pageNum == $x) {
    ?>	
        <a href="#" name="pageCtr" returnNum="<?=$x?>" class="active"><?=$x?></a>
    <?php		
        } else {
    ?>
        <a href="#" name="pageCtr" returnNum="<?=$x?>"><?=$x?></a>
    <?php } 
    } 
	if($nums < $last)
	{
    	echo '<a href="#" name="pageCtr" returnNum="'.$last.'">last &raquo;</a>';
	}
	?>    
</div>		<!-- .paggination ends -->
