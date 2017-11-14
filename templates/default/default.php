<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
    <title>Content Management System</title>
    <link type="text/css" href="css/style.css" rel="stylesheet" media="all" />	
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>
	
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=7" /><![endif]-->
	<!--[if lt IE 8]><style type="text/css" media="all">@import url("css/ie.css");</style><![endif]-->
	<!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
	<script type="text/javascript" src="js/jquery.js"></script>
   	<script type="text/javascript" src="js/jquery_jcrop/jquery.Jcrop.js"></script>
	<script type="text/javascript" src="js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="js/jquery.date_input.js"></script>
	<script type="text/javascript" src="js/facebox.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.js"></script>
	<script type="text/javascript" src="js/jquery.select_skin.js"></script>
	<script type="text/javascript" src="js/ajaxupload.js"></script>
	<script type="text/javascript" src="js/jquery.pngfix.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<link rel="stylesheet" id="wpex-font-awesome-css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" media="all">
     
    
    
    <!-- TinyMCE -->
	<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            // General options
            mode : "specific_textareas",
			editor_selector  : "tinymce",
            theme : "advanced",
			content_css: "css/content.css",
			theme_advanced_fonts : "Maven Pro=Maven Pro,helvetica,sans-serif;"+"DINNeuzeitGrotesk-BoldCond=DINNeuzeitGrotesk-BoldCond;"+"Arial=arial,helvetica,sans-serif;"+
                "Arial Black=arial black,avant garde;"+
                "Book Antiqua=book antiqua,palatino;"+
                "Comic Sans MS=comic sans ms,sans-serif;"+
                "Courier New=courier new,courier;"+
                "Georgia=georgia,palatino;"+
                "Helvetica=helvetica;"+
                "Impact=impact,chicago;"+
                "Symbol=symbol;"+
                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                "Terminal=terminal,monaco;"+
                "Times New Roman=times new roman,times;"+
                "Trebuchet MS=trebuchet ms,geneva;"+
                "Verdana=verdana,geneva;"+
                "Webdings=webdings;"+
                "Wingdings=wingdings,zapf dingbats",
			height: '500px',
			/*width: '600px',*/
			plugin_preview_width : "653",
            plugin_preview_height : "600",
			
            plugins : "imagemanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
    
            // Theme options
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,insertimage,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
    
            relative_urls : false,
			remove_script_host : true,
			document_base_url : "/",
			convert_urls : true, 
			
			// Example content CSS (should be your site CSS)
            content_css : "css/content.css",
    
            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",
    
            // Style formats
            style_formats : [
                {title : 'Bold text', inline : 'b'},
                {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                {title : 'Drop Cap', block : 'p', classes : 'firstletter'},
				{title : 'All Caps', block : 'p', classes : 'all_caps'}
            ],
    
            // Replace values for the template plugin
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        });
    </script>
    <!-- /TinyMCE -->
    </head>

<body>

	<div id="hld">
	
		<div class="wrapper">		<!-- wrapper begins -->
	
			
			<?php
				// Header
                require_once('includes/page_header.php');
            ?>
			
            <div class="block withsidebar">
                        
            	<div class="block_head">
                
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>
                    
                    <h2><?=$parent_menu?></h2>
				
                </div>		<!-- .block_head ends -->
                <div class="block_content">
                    
                    <div class="sidebar">
                        <?php
							// Page Left
                            require_once('includes/page_left.php');
						?>
                    </div>		<!-- .sidebar ends -->
                    
                    <div class="sidebar_content">  

                        <?php
                            // Contents
                            require_once($content_template);
                        ?>

                    </div><!-- .sidebar_content ends -->   
                    
                </div>		<!-- .block_content ends -->
				
				<div class="bendl"></div>
				<div class="bendr"></div>
                
			</div> <!-- .block ends -->

			<?php
				// Footer
                require_once('includes/page_footer.php');
            ?>
		
		
		</div>	<!-- wrapper ends -->
		
	</div>	<!-- #hld ends -->
</body>
</html>