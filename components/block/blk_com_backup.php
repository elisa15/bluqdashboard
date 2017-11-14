<script type="text/javascript">
$(document).ready(function(){  

	// Initialize the Actions
	$('#add_item').click(function(){
		$('#view').val('add');
		$('#action').val('add');
		$("#cmsForm").submit();
	});

	$('#backup').click(function(){
		$('#view').val('backup');
		$('#action').val('backup');
		$("#cmsForm").submit();
	});	

	$('#cancel').click(function(){
		$('#view').val('list');
		$('#action').val('list');
		$("#cmsForm").submit();
	});	
	
	// Initialize the list
	<?php
	if($view != 'backup')
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
		param = '&search_key=' + $('#search_key').val();
	}

	$('#list_container').html(loading);
	$('#list_container').load('components_ajax/ajax_com_backup.php?param=1' + param, null);
}

</script>


<!-- ERROR MESSAGES

<div class="message errormsg"><p>An error message goes here</p></div>

<div class="message success"><p>A success message goes here</p></div>

<div class="message info"><p>An informative message goes here</p></div>

<div class="message warning"><p>A warning message goes here</p></div>

-->  
<form name="cmsForm" id="cmsForm" method="post" action="" enctype="multipart/form-data">
<div class="content_head">
    
    <h3><?=$content_title?></h3>
    
    <?php
	if($view == 'list')
	{
	?>
        <ul>
            <li id="backup"><a href="#">Create new Backup File</a></li>
        </ul>                        
    <?php
	}
	?>

</div>		<!-- .content_head ends -->


	<div id="list_container"><!-- WILL CONTAIN THE LIST TABLE --></div>  

    <input type="hidden" name="action" id="action" value="<?=$action==''?'list':$action?>" />
    <input type="hidden" name="view" id="view" value="<?=$view==''?'list':$view?>" />
    <input type="hidden" name="comp" id="comp" value="<?=$comp?>" />

</form>

                                        

