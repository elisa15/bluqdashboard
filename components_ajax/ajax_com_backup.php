<?php



include_once("../../config.php");
include_once('../includes/functions_system.php');
include_once('../includes/functions_get.php');
include_once('../includes/functions_generate.php');
include_once("../includes/common.php");

$search_key = $_GET['search_key'];
$page_rows = $_GET['page_rows'];
$pageNum = $_GET['pageNum'];


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

	$('.do_delete_action').click(function(){
		if(confirm('Are you sure you wish to permanently remove this item?'))
		{
			checkSelectedItem($(this).attr('returnId'));
			$('#view').val('list');
			$('#action').val('delete');
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
        <td width="10"><input type="checkbox" class="check_all" name="check_all" id="check_all" /></td>
        <th>Date Created</th>
        <th>Created By</th>
        <td>&nbsp;</td>
    </tr>
    <?php
	$myFile = '../'.DATABASE_BACKUP_PATH . "backup_logs.log";
	
	if(file_exists($myFile))
	{
		$fh = @fopen($myFile, 'r');
		$theData = @fread($fh, filesize($myFile));
		@fclose($fh);
		if($theData != '' )
		{
			$backup_logs = @explode("|",$theData);
		}	
	}

	//$dir = new DirectoryIterator( '/'.DATABASE_BACKUP_PATH );

	if(count($backup_logs)> 0)
	{
	
		
		foreach($backup_logs  as $logs ) 
		{
			if($logs != '')
			{
				list($filename,$author,$time_logs) = explode(",",$logs);
	?>
        <tr>
            <td><input type="checkbox" id="id_<?=$time_logs?>" name="id[]" class="id" value="<?=$filename?>" /></td>
            <td><?=date('F d, Y H:i:s',$time_logs)?></td>
            <td><?=getUserFullName($author)?></td>         
            <td class="delete"><a href="<?=DATABASE_BACKUP_PATH . $filename ?>" >Download</a>&nbsp;|&nbsp;<a href="#" class="do_delete_action" returnId="<?=$time_logs?>">Delete</a></td>
        </tr>
    <?php
			}
		}
	} // end of IF
	else
	{
    ?>
    	<tr>
            <td colspan="8">
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
        <option value="delete">Delete</option>
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
    
    

                                        

