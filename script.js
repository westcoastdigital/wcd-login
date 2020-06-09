jQuery(document).ready(function() {

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


});