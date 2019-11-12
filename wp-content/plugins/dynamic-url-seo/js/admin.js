jQuery(document).ready(function() {
   if (jQuery('#tabs').length > 0) {
        jQuery('#tabs').tabs();
    }
	 
	var org_type = jQuery("#org_type").val();
	if(org_type == 'local_business') {
		jQuery(".local_business_types").show();
		jQuery(".local_business_description").show();
		jQuery(".org_main_number").show();
	} else {
		jQuery(".local_business_types").hide();
		jQuery(".local_business_description").hide();
		jQuery(".org_main_number").hide();
	}
	
	jQuery('#org_type').on('change', function() {
	  if(this.value == 'local_business') {
		jQuery(".local_business_types").show();
		jQuery(".local_business_description").show();
		jQuery(".org_main_number").show();
	  } else {
		jQuery(".local_business_types").hide();
		jQuery(".local_business_description").hide();
		jQuery(".org_main_number").hide();
	  }
	})
	
	jQuery('.metatitle_field_name').keyup(function() {
		var countTitleChar = this.value.length;
		if(countTitleChar > 60) {
			jQuery('.metatitle_field_name').css('color','#ff0000');
		} else {
			jQuery('.metatitle_field_name').css('color','#000');
		}
	});
	
	jQuery('.metades_field_name').keyup(function() {
		var countDesChar = this.value.length;
		if(countDesChar > 160) {
			jQuery('.metades_field_name').css('color','#ff0000');
		} else {
			jQuery('.metades_field_name').css('color','#000');
		}
	});
});

 function dus_continueOrNot() 
 {
	var metatitle_field_name = document.getElementById("metatitle_field_name").value; 
	var siteURL = document.getElementById("seo_siteURL").value; 
	var url_field_name = document.getElementById("url_field_name").value; 
	var url_field_name = url_field_name.split("/");
	
		if(url_field_name == '') {
			alert('Page/Post URL field is required.');
			return false;
		}
		if (siteURL.indexOf(url_field_name[2]) > -1) 
		{
			if(metatitle_field_name == '') {
				alert('Meta title is required.');
				return false;
			} else {
				return true;
			}
		}
		else 
		{
			alert('Page/Post URL is invalid.');
			return false;
		}
 }
 
 function dus_updateContinueOrNot() 
 {
	var metatitle_field_name = document.getElementById("metatitle_field_name").value; 
	var siteURL = document.getElementById("seo_update_siteURL").value; 
	var url_field_name = document.getElementById("url_field_name").value; 
	var url_field_name = url_field_name.split("/");
	
		if(url_field_name == '') {
			alert('Page/Post URL field is required.');
			return false;
		}
		if (siteURL.indexOf(url_field_name[2]) > -1) 
		{
			if(metatitle_field_name == '') {
				alert('Meta title is required.');
				return false;
			} else {
				return true;
			}
		}
		else 
		{
			alert('Page/Post URL is invalid.');
			return false;
		}
 }