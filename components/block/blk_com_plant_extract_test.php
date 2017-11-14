<script type="text/javascript">
$(document).ready(function(){  

	// Initialize the Actions
	$('#add_item').click(function(){
		$('#view').val('add');
		$('#action').val('add');
		$("#cmsForm").submit();
	});	

	$('#edit_item').click(function(){
		if(checkIfThereAreItemSelected())
		{
			$('#view').val('edit');
			$('#action').val('edit');
			$("#cmsForm").submit();
		}
		else
		{
			alert('No item is selected.');
			return false;
		}
	});

	

	$('#save').click(function(){
		$('#view').val('add');
		$('#action').val('save');
		$("cmsForm").submit();
	});	

	$('#update').click(function(){
		$('#view').val('edit');
		$('#action').val('update');
		$("cmsForm").submit();
	});		

	$('#cancel').click(function(){
		$('#view').val('list');
		$('#action').val('list');
		$("cmsForm").submit();
	});	
		
	$("#search_key").keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);

		if(code== 13){
			$('#view').val('list');
			$('#action').val('list');
			updateList();
			return false;
		}

	}).bind('blur',function(e){
		$('#view').val('list');
		$('#action').val('list');
		updateList();
		return false;
	});
	
		


	$('#delete_image').click(function(){
		if(confirm('Are you sure you wish to permanently delete this image?'))
		{
			$.ajax({
				type: "GET",
				data: "tbl_name=ai_articles&id="+$(this).attr('returnId')+"&path="+$(this).attr('path'),
				url: "components_ajax/ajax_delete_content_image.php",
				success: function(msg){
					//alert(msg);
					$('#imgmsg').html("");
				}
			});	
		}
		else
		{
			return false;
		}
	});
	
	$('#result_type').change(function(){
		$('#view').val('list');
		$('#action').val('list');
		updateList();
		return false;
	});
	
	// Initialize the list
	<?php
	if($view != 'add' && $view != 'edit')
	{
		echo 'updateList();'; 
	}
	?>
});	

function updateList(pageNum)
{
	var param = '';
		
	if(pageNum != '' && pageNum != undefined)
	{
		param = param + '&pageNum=' + pageNum;
	}
	else
	{
		param = param + '&pageNum=' + <?=$_SESSION[SITE_U_CODE]['pageNum']?>;
	}

	if($('#page_rows').val() != undefined)
	{
		param = param + '&page_rows=' + $('#page_rows').val();
	}
	else
	{
		param = param + '&page_rows=' + <?=$_SESSION[SITE_U_CODE]['page_rows']?>;
	}


	if($('#search_key').val() != '' && $('#search_key').val() != 'Search')
	{
		param =  param + '&search_key=' + $('#search_key').val();
	}
	
	if($('#result_type').val() != '' && $('#result_type').val() != 'All')
	{
		param =  param + '&result_type=' + $('#result_type').val();
	}

	$('#list_container').html(loading);
	$('#list_container').load('components_ajax/ajax_com_plant_extract_test.php?param=1' + param, null);
	console.log( "test");

}

function updateImageList(product_id)
{
	var param = '';
	if(product_id != '' && product_id != undefined)
	{
		param = param + '&id=' + product_id;
	}
	$('#img_list').load('components_ajax/ajax_com_product_images.php?param=1' + param, null);
}

</script>

<!-- ERROR MESSAGES



<div class="message errormsg"><p>An error message goes here</p></div>

<div class="message success"><p>A success message goes here</p></div>

<div class="message info"><p>An informative message goes here</p></div>

<div class="message warning"><p>A warning message goes here</p></div>

-->  


<?php
if($err_msg != '')
{
?>
	<div class="message errormsg"><p><?=$err_msg?></p></div>
<?php
}
echo $sucess_msg;
?>

<form name="cmsForm" id="cmsForm" method="post" action="" enctype="multipart/form-data">
<div class="content_head">

    <h3><?=$content_title?></h3>
    <?php
	if($view == 'list')
	{
	?>
        <ul style="display:none">
            <li id="edit_item"><a href="#">Edit item</a></li>
            <li id="add_item"><a href="#">Add item</a></li>
        </ul>                        
        <input type="text" class="text" value="<?=$search_key==''?'Search':$search_key?>" id="search_key" name="search_key" />
    <?php
	}
	?>

</div>		<!-- .content_head ends -->
<?php
if($view == 'list')
{
?>
    <p>
        	<label>Sort by Result Type:</label><br />
            <select name="result_type" id="result_type" class="select" >
                <option value="">Select Result Type</option>
                 <?=generateResults($result_type)?>
            </select>
     	</p>
 <?php
 } ?>
<?php
	if($view == 'edit' || $view == 'add')
	{
?>
        
        <hr />

        <p>
            <input type="hidden" name="id" id="id" value="<?=$id?>" />
            <input type="hidden" name="search_key" id="search_key" value="<?=$search_key?>" />
        	<?php
            if($view == 'add')
            {
            ?>
                 <input id="save" name="save" type="submit" class="submit small" value="Save" />
            <?php
            }
            else if($view == 'edit')
            {
            ?>
                 <input id="update" name="update" type="submit" class="submit small" value="Update" />
            <?php
			}
			?>
            <input id="cancel" name="save" type="submit" class="submit small" value="Cancel" />
        </p>
<?php
	}
	else
	{ // VIEW IS LIST SO SHOW THE TABLE LIST CONTAINER
?>   
	    <div id="list_container"><!-- WILL CONTAIN THE LIST TABLE --></div>  
<?php
	}
?> 
   <input type="hidden" name="slide_id" id="slide_id" value="">
    <input type="hidden" name="action" id="action" value="<?=$action==''?'list':$action?>" />
    <input type="hidden" name="view" id="view" value="<?=$view==''?'list':$view?>" />
    <input type="hidden" name="comp" id="comp" value="<?=$comp?>" />
    <input type="hidden" name="pic_action" id="pic_action" value="<?=$pic_action?>" />
    <input type="hidden" name="pic_action_id" id="pic_action_id" value="" />
    <input type="hidden" name="count" id="count" value="<?=$count?>" />
    
    

</form>