function removeChar(item)
	{ 
		//alert();
		var val = item.value;
		val = val.replace(/[^0-9,.]/g, "");  
		if (val == ' '){val = ''};   
		item.value=val;
	}
	
function removeDate(item)
{ 
	//alert();
	var val = item.value;
	val = val.replace(/[^0-9-]/g, "");  
	if (val == ' '){val = ''};   
	item.value=val;
}

function removeSpace(item)
{ 
	var val = item.value;
	val = val.replace(/[^A-Za-z0-9@_.-=>%^*()<!&#$]/g, "");
	if (val == ' '){val = ''};   
	item.value=val;
	//alert();
}

function custom_folder_aws(dat){
	var cusValue = dat.value;
	var divId = document.querySelector('#aws_path_folder_div');
	if(cusValue == 'custom'){
		divId.style.display = 'block';
	}else{
		divId.style.display = 'none';
	}
}

function enable_crop_status(dat){
	var idData = document.getElementById('themeDev_div_enable__'+dat.id);
	if(idData){
		idData.classList.toggle('enable_themeDev_div');
	}
}

function copyLinkItem(idData) {
  var copyText = document.getElementById("copyLinkText__"+idData);
  copyText.select();
  document.execCommand("copy");
}

function themedev_download_link(idda){
	//event.preventDefault();
	if(idda){
		var getLink = idda.getAttribute('themedev-link');
		var getStore = idda.getAttribute('themedev-store');
		if(getLink){
			var dataForm = 'link='+getLink+'&store='+getStore;
			jQuery.ajax({           
				data : dataForm,
				type : 'get',
				url : themedev_aws_url.siteurl+'/wp-json/themedev-submit-form/download-files/1',
				success : function( response ) {
					alert(response);
				}
			});
		}
	}
}