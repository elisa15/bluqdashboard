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

	$('#img_upload').click(function(){

		if($('#uploaded_file').val() != '')
		{
			$('#imgmsg').html(loading);
			<? 
			if($id!= '')
				$param = ' + "&id='.$id.'"';
			else
				$param = '';
			?>
			$.ajax({
			type: "GET",
			data: "filename="+$('#uploaded_file').val() + "&crop_x=" +$('#crop_x').val() + "&crop_y=" +$('#crop_y').val() + "&crop_w=" +$('#crop_w').val() + "&crop_h=" +$('#crop_h').val() <?=$param ?>,
			url: "upload-action.php",
			success: function(msg){
				alert(msg);
				updateImageList(<?=$id?>);
				$('#imgmsg').html('');
				$('#uploaded_file').val('');
			}
			});	
		}
		else
		{
			alert('No image to upload.');
		}
		return false;
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

	$('#update').click(function(){
		if($('#user_isblocked').is(':checked'))
		{
			if(confirm('This user is blocked. Do you wish to continue?'))
			{
				$('#view').val('edit');
				$('#action').val('update');
				$("cmsForm").submit();
			}
			else
			{
				return false;
			}
		}
	});	
	
	
	
	// Initialize the list
	<?php
	if($view != 'add' && $view != 'edit')
	{
		echo 'updateList();'; 
	}
	else
	{
		echo 'updateImageList('.$id.');';
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
		param = '&search_key=' + $('#search_key').val();
	}

	$('#list_container').html(loading);
	$('#list_container').load('components_ajax/ajax_com_account.php?param=1' + param, null);

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
?>

<form name="cmsForm" id="cmsForm" method="post" action="" enctype="multipart/form-data">
<div class="content_head">

    <h3><?=$content_title?></h3>
    <?php
	if($view == 'list')
	{
	?>
        <ul>
            <li id="edit_item"><a href="#">Edit item</a></li>
            <li id="add_item"><a href="#">Add item</a></li>
        </ul>                        
        <input type="text" class="text" value="<?=$search_key==''?'Search':$search_key?>" id="search_key" name="search_key" />
    <?php
	}
	?>

</div>		<!-- .content_head ends -->

<?php
	if($view == 'edit' || $view == 'add')
	{
?>
        <p>
        	<label>First Name:</label> <br />
			<input name="user_fname" id="user_fname" type="text" class="text small" value="<?=$user_fname?>" /> 
        </p>
        
        <p>
        	<label>Last Name:</label> <br />
			<input name="user_lname" id="user_lname" type="text" class="text small" value="<?=$user_lname?>" /> 
        </p>
        
        <p>
        	<label>Email Address:</label> <br />
			<input name="user_email" id="user_email" type="text" class="text small" value="<?=$user_email?>" /> 
        </p>
        
        <p>
        	<label>User Name:</label> <br />
			<input name="user_username" id="user_username" type="text" class="text small" value="<?=$user_username?>" /> 
        </p>   

        <p>
            <label>Password:</label><br />
            <input name="user_password" id="user_password" type="password" class="text small" value="" /> 
        </p>
        
        <p>
            <label>Re-type Password:</label><br />
            <input name="user_re_password" id="user_re_password" type="password" class="text small" value="" /> 
        </p>  
		<?php /*?>
        <p>
            <input name="user_isblocked" id="user_isblocked" type="checkbox" class="checkbox" value="Y" <?=$user_isblocked == 'Y'?'checked="checked"':''?> /> 
            <label for="publish">Blocked</label>
        </p>
       
<?php */?>
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
    <input type="hidden" name="action" id="action" value="<?=$action==''?'list':$action?>" />
    <input type="hidden" name="view" id="view" value="<?=$view==''?'list':$view?>" />
    <input type="hidden" name="comp" id="comp" value="<?=$comp?>" />

</form>



                                        



