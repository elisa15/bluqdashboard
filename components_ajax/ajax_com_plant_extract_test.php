<?php

include_once("../config.php");
include_once('../includes/functions_system.php');
include_once('../includes/functions_get.php');
include_once('../includes/functions_generate.php');
include_once("../includes/common.php");

$search_key = $_GET['search_key'];
$page_rows = $_GET['page_rows'];
$pageNum = $_GET['pageNum'];
$result_type = $_GET['result_type'];

if($search_key != '')
{
	$and_search_key= " AND plant  LIKE '%".str_replace("'","''",$search_key)."%' ";
}
if($result_type != '')
{
	$and_result_type= " AND result  = '".$result_type."' ";
}



//Here we count the number of results 

//Edit $data to be your query 
	$sql_pagination = " SELECT 
					*
				FROM 
				default_transaction  where id != ''  AND farmer_id = '".USER_ID."'  AND type='tlc' ".$and_search_key." ".$and_result_type."
				ORDER BY 
					id DESC  ";
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
				else if($('#action_select').val() == 'publish' || $('#action_select').val() == 'unpublish')
				{
						$('#view').val('list');
						$('#action').val($('#action_select').val());
						$("cmsForm").submit();
				}				
				else
				{
					$('#view').val($('#action_select').val());
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
			data: "mod=lifestyle_contents&id="+$(this).attr('returnId')+"&action=inc&c_position="+$(this).attr('returnPosition'),
			url: "components_ajax/ajax_update_sort.php",
			success: function(msg){
				updateList(<?=$pageNum?>);
			}
		});		
	});	

	$('.arrowdown').click(function(){
		$.ajax({
			type: "GET",
			data: "mod=lifestyle_contents&id="+$(this).attr('returnId')+"&action=dec&c_position="+$(this).attr('returnPosition'),
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
		checkSelectedItem($(this).attr('returnId'));
		$('#view').val('list');
		$('#action').val($(this).attr('returnAction'));
		$("#cmsForm").submit();
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
    <tr class="thead">
        <th>Type</th>
        <th>Plant</th>
        <th>Sample ID</th>
        <th>Batch ID</th>
        <th>Lot ID</th>
        <th>Temperature</th>
        <th>Test Result</th>
        <th>Test Value</th>
        <th>Location</th>
        <th>Date Taken</th>
        <th>Raw Image</th>
    </tr>
    
    <?php

	if($row_ctr > 0)
	{

		 $sql = "SELECT 
					*
				FROM 
					default_transaction  where id <> ''  AND farmer_id = '".USER_ID."'   AND type='tlc' ".$and_search_key." ".$and_result_type."
				ORDER BY 
					id DESC "  . $max;

		$query = mysql_query($sql);
		$ctr = mysql_num_rows($query);
		while($row = mysql_fetch_array($query))
		{
    	?>
        <tr>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['type']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['plant']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['sample_id']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['batch_id']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['lot_id']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['temperature']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['result']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['status']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['location']?></a></td>
            <td><a href="#" class="do_edit_action2" returnId="<?=$row['id']?>"><?=$row['date_created']?></a></td>
            <td><a href="<?=$row['image']?>" class="do_edit_action2" returnId="<?=$row['id']?>"><img src="<?=$row['image']?>" width="150px"/></a></td>
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
        <option value="publish">Publish</option>
        <option value="unpublish">Unpublish</option>
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