jQuery(document).ready(function($) {

    /* Enable Select 2 on select fields */
    jQuery('.wcd-select').select2({
        width: 'resolve'
    });

    /* Hide lost password label if not displaying */
    if (jQuery('#lost_password_link').is(':checked')) {
        jQuery('#lost_password_label').parent().parent().show();
    } else {
        jQuery('#lost_password_label').parent().parent().hide();
    }
    jQuery('#lost_password_link').click(function(){
        if (jQuery(this).is(':checked')) {
            jQuery('#lost_password_label').parent().parent().show();
        } else {
            jQuery('#lost_password_label').parent().parent().hide();
        }
    });

    /* Hide remember me label if not displaying */
    if (jQuery('#remember_me_link').is(':checked')) {
        jQuery('#remember_me_label').parent().parent().show();
    } else {
        jQuery('#remember_me_label').parent().parent().hide();
    }
    jQuery('#remember_me_link').click(function(){
        if (jQuery(this).is(':checked')) {
            jQuery('#remember_me_label').parent().parent().show();
        } else {
            jQuery('#remember_me_label').parent().parent().hide();
        }
    });

      // Get the element with id="defaultOpen" and click on it
    // jQuery('#defaultOpen').click();

});

// function openPage(pageName,elmnt,color) {
//     var i, tabcontent, tablinks;
//     tabcontent = document.getElementsByClassName("tabcontent");
//     for (i = 0; i < tabcontent.length; i++) {
//       tabcontent[i].style.display = "none";
//     }
//     tablinks = document.getElementsByClassName("tablink");
//     for (i = 0; i < tablinks.length; i++) {
//       tablinks[i].style.backgroundColor = "";
//       tablinks[i].classList.remove("active");
//     }
//     document.getElementById(pageName).style.display = "block";
//     //elmnt.style.backgroundColor = color;
//     elmnt.classList.add("active");
//   }

  jQuery(function($){
	/*
	 * Select/Upload image(s) event
	 */
	$('body').on('click', '.wcd_login_upload_image_button', function(e){
		e.preventDefault();
 
    		var button = $(this),
    		    custom_uploader = wp.media({
			title: 'Insert logo',
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id, 
				type : 'image'
			},
			button: {
				text: 'Use this logo' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:25%;display:block;" />').next().val(attachment.id).next().show();
			/* if you sen multiple to true, here is some code for getting the image IDs
			var attachments = frame.state().get('selection'),
			    attachment_ids = new Array(),
			    i = 0;
			attachments.each(function(attachment) {
 				attachment_ids[i] = attachment['id'];
				console.log( attachment );
				i++;
			});
			*/
		})
		.open();
	});
 
	/*
	 * Remove image event
	 */
	$('body').on('click', '.wcd_login_remove_image_button', function(){
		$(this).hide().prev().val('').prev().addClass('button').html('Upload logo');
		return false;
    });
    
    $('.color-field').wpColorPicker();
 
});