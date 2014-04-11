/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2009 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 212 2009-09-03 05:33:44Z emartin24 $
 *
 */
jQuery.noConflict();
jQuery(document).ready(function () {
	jQuery('a.c_sendtofriend').click(function (e) {
   		jQuery(document).ready(function() {
			// Duplicate our reCapcha 
			var captcha = jQuery('#capsaved').val();
			if(claim == 'Yes')
			{
				jQuery('#owner_frm').html(captcha);
				jQuery('#commentform').html('');
			}
			jQuery('#myrecap').html('');
			jQuery('#inquiry_frm_popup').html('');
			jQuery('#popup_frms').html('');
			
		});
		e.preventDefault();
		jQuery('#claim_listing').modal();
	});

jQuery('a.b_sendtofriend').click(function (e) {
		
		var captcha = jQuery('#capsaved').val();
		if(sendtofriend == 'Yes')
		{
			jQuery('#popup_frms').html(captcha);
			jQuery('#commentform').html('');
		}
			jQuery('#myrecap').html('');
			jQuery('#inquiry_frm_popup').html('');
			jQuery('#owner_frm').html('');

		e.preventDefault();
		jQuery('#basic-modal-content').modal();	
	});
	
jQuery('a.b_send_inquiry' ).click(function (e) {
		
		jQuery(document).ready(function() {
			// Duplicate our reCapcha 
			var captcha = jQuery('#capsaved').val();
			if(inquiry == 'Yes')
			{
				jQuery('#inquiry_frm_popup').html(captcha);
				jQuery('#commentform').html('');
			}
			jQuery('#myrecap').html('');
			jQuery('#owner_frm').html('');
			jQuery('#popup_frms').html('');
		});

		e.preventDefault();
		jQuery('#basic-modal-content2').modal();
	});
});