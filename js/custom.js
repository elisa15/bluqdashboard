// [+] AJAX


$.ajaxSetup ({
	cache: false
});

var loading = '<div id="loadingContents"></div>';


// [-] AJAX


function checkIfThereAreItemSelected()
{
	var itemFound = false;
	
	$('input[class=id]').each(
			function(intIndex ){
				if($(this).attr('checked') == true)
				{
					itemFound = true;
				}
			}
	);
	return itemFound;
}

function checkSelectedItem(obj)
{
	if(obj != '')
	{
		$('#id_' + obj).attr('checked','checked');
	}
}

function uncheckAllItem()
{
	$('input[name=id]').each(
			function(intIndex ){
				$(this).attr('checked','');
			}
	);	
}

// Our simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function updateCoords(c)
{
	$('#crop_x').val(c.x);
	$('#crop_y').val(c.y);
	$('#crop_w').val(c.w);
	$('#crop_h').val(c.h);
};

function checkCoords()
{
	if (parseInt($('#crop_w').val())) return true;
	alert('Please select a crop region then press submit.');
	return false;
};

$(function () {
	
	// Preload images
	$.preloadCssImages();
	
	
	// CSS tweaks
	$('#header #nav li:last').addClass('nobg');
	$('.block_head ul').each(function() { $('li:first', this).addClass('nobg'); });
	$('.block table tr:odd').css('background-color', '#fbfbfb');
	$('.block form input[type=file]').addClass('file');
			
	
	// Web stats
	$('table.stats').hide().visualize({		
		type: 'line',	// 'bar', 'area', 'pie', 'line'
		width: '780px',
		height: '240px',
		colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
	});
	
	
	// Check / uncheck all checkboxes
	$('.check_all').click(function() {
		$(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));   
	});
		
	
	// Set WYSIWYG editor
	$('.wysiwyg').wysiwyg({css: "css/wysiwyg.css"});
	
	
	// Modal boxes - to all links with rel="facebox"
	$('a[rel*=facebox]').facebox()
	
	
	// Messages
	$('.block .message').hide().append('<span class="close" title="Dismiss"></span>').fadeIn('slow');
	$('.block .message .close').hover(
		function() { $(this).addClass('hover'); },
		function() { $(this).removeClass('hover'); }
	);
		
	$('.block .message .close').click(function() {
		$(this).parent().fadeOut('slow', function() { $(this).remove(); });
	});
	
	
	// Form select styling
	$("form select.styled").select_skin();
	
	
	// Tabs
	$(".tab_content").hide();
	$("ul.tabs li:first-child").addClass("active").show();
	$(".block").find(".tab_content:first").show();

	$("ul.tabs li").click(function() {
		$(this).parent().find('li').removeClass("active");
		$(this).addClass("active");
		$(this).parents('.block').find(".tab_content").hide();

		var activeTab = $(this).find("a").attr("href");
		$(activeTab).show();
		return false;
	});
	
	
	// Block search
	$('.block .block_head form .text').bind('click', function() { $(this).attr('value', ''); });
	
	// Content Head search
	$('.block.withsidebar .block_content .sidebar_content .content_head .text')
		.bind('click', function() { 
										if($(this).val()=='Search')
										{
											$(this).attr('value', '');
											
										}
										else
										{	
											$(this).val(); 
											
										}
									})
		.bind('blur', function() { 
										if($(this).val()=='')
										{
											$(this).val('Search')
											
										}
										else
										{	
											$(this).val(); 
											
										}									
									});	
	
	
	// Image actions menu
	$('ul.imglist li').hover(
		function() { $(this).find('ul').css('display', 'none').fadeIn('fast').css('display', 'block'); },
		function() { $(this).find('ul').fadeOut(100); }
	);
	
		
	// Image delete confirmation
	$('ul.imglist .delete a').click(function() {
		if (confirm("Are you sure you want to delete this image?")) {
			return true;
		} else {
			return false;
		}
	});
	
	
	// Style file input
	$("input[type=file]").filestyle({ 
	    image: "images/upload.gif",
	    imageheight : 30,
	    imagewidth : 80,
	    width : 250
	});
	
	
	// File upload
	if ($('#fileupload').length) {
		new AjaxUpload('fileupload', {
			action: 'upload-handler.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 150, 150 ],
						aspectRatio: 1
					});
					this.enable();
				}	
		});
	}
		
	
	// Wide File upload
	if ($('#fileupload_wide').length) {
		new AjaxUpload('fileupload_wide', {
			action: 'upload-handler.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 335, 106 ],
						 aspectRatio: 16 / 5
					});
					this.enable();
				}	
		});
	}

	// Page Banner File upload
	if ($('#fileupload_page').length) {
		new AjaxUpload('fileupload_page', {
			action: 'upload-handler.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10,305, 85 ],
						aspectRatio: 16 / 4
					});
					this.enable();
				}	
		});
	}

	if ($('#fileupload_about').length) {
		new AjaxUpload('fileupload_about', {
			action: 'upload-who_we_are.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 0, 0, 701, 180 ],
						aspectRatio: 9.736 / 2.500
					});
					this.enable();
				}	
		});
	}
	
	
	// Side Banner File upload
	if ($('#fileupload_sidebanner').length) {
		new AjaxUpload('fileupload_sidebanner', {
			action: 'upload-handler-banner.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						/*
						onSelect: updateCoords,
						*/
						setSelect: [ 0, 0, 190, 200 ],
						/*
						aspectRatio: 7 / 6.51
						*/
					});
					this.enable();
				}	
		});
	}
	
	
	if ($('#fileupload_images').length) {
		new AjaxUpload('fileupload_images', {
			action: 'upload-images.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 0, 0, 600, 600 ],

					});
					this.enable();
				}	
		});
	}
	
	
	
	
	
	
	// Blog File upload
	if ($('#fileupload_blog').length) {
		new AjaxUpload('fileupload_blog', {
			action: 'upload-handler.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 260, 160 ],
						 aspectRatio: 16 / 6
					});
					this.enable();
				}	
		});
	}
	
	// Banner File upload
	if ($('#fileupload_banner').length) {
		new AjaxUpload('fileupload_banner', {
			action: 'upload-handler.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 700, 175 ],
						 aspectRatio: 16 / 4
					});
					this.enable();
				}	
		});
	}
	
	/*// Slide Show File upload
	if ($('#fileupload_slideshow').length) {
		new AjaxUpload('fileupload_slideshow', {
			action: 'upload-slideshow.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 0, 0, 940, 275 ],
						aspectRatio: 13.056 / 3.819
					});
					this.enable();
				}	
		});
	}
	*/
	
	//function  fileupload_slideshow_no_crop()
	//{
		
		/*
		if ($('#fileupload_slideshow_no_crop').length) {
			new AjaxUpload('fileupload_slideshow_no_crop', {
				action: 'upload-slideshow-no-crop.php?new_filename=' + $('#new_filename').val(),
				autoSubmit: true,
				name: 'product_file',
				responseType: 'text/html',
				onSubmit : function(file , ext) {
						$('#imgmsg').html('');
						$('#imgmsg').addClass('loading').text('Processing...');
						this.disable();	
					},
				onComplete : function(file, response) {
						$('#imgmsg').removeClass('loading').text('');
						$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
						$('#uploaded_file').val(response);
						this.enable();
					}	
			});
		}
	*/
	//}
	
	// Course File upload
	if ($('#fileupload_course').length) {
		new AjaxUpload('fileupload_course', {
			action: 'upload-course.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 700, 175 ],
						aspectRatio: 15 / 7.1
					});
					this.enable();
				}	
		});
	}
	
	// Why Our Courses File upload
	if ($('#fileupload_woc').length) {
		new AjaxUpload('fileupload_woc', {
			action: 'upload-whycourses.php?new_filename=' + $('#new_filename').val(),
			autoSubmit: true,
			name: 'product_file',
			responseType: 'text/html',
			onSubmit : function(file , ext) {
					$('#cropbox').attr('src','');
					$('#imgmsg').html('');
					$('#imgmsg').addClass('loading').text('Processing...');
					this.disable();	
				},
			onComplete : function(file, response) {
					$('#imgmsg').removeClass('loading').text('');
					$('#imgmsg').html('<img src="tmp/' + response + '?' + Math.random() + '" id="cropbox"/>');
					$('#uploaded_file').val(response);
					$('#cropbox').Jcrop({
						onChange: updateCoords,
						onSelect: updateCoords,
						setSelect: [ 10, 10, 100, 100 ],
						aspectRatio: 1 / 1
					});
					this.enable();
				}	
		});
	}



	// Date picker
	$.extend(DateInput.DEFAULT_OPTS, {
	  stringToDate: function(string) {
		var matches;
		if (matches = string.match(/^(\d{2,2})\/(\d{2,2})\/(\d{4,4})$/)) {
		  return new Date(matches[3], matches[2] - 1, matches[1]);
		} else {
		  return null;
		};
	  },

	  dateToString: function(date) {
		var month = (date.getMonth() + 1).toString();
		var dom = date.getDate().toString();
		if (month.length == 1) month = "0" + month;
		if (dom.length == 1) dom = "0" + dom;
		return date.getFullYear() + "-" + month + "-" + dom;
	  }
	});
	
	$('input.date_picker').date_input();
		

	// Navigation dropdown fix for IE6
	if(jQuery.browser.version.substr(0,1) < 7) {
		$('#header #nav li').hover(
			function() { $(this).addClass('iehover'); },
			function() { $(this).removeClass('iehover'); }
		);
	}
	
	// IE6 PNG fix
	$(document).pngFix();
		
});