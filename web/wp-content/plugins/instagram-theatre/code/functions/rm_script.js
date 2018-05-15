jQuery(document).ready(function(){
	jQuery('.rm_options').slideUp();

	jQuery('.rm_section h3').click(function(){		
		if(jQuery(this).parent().next('.rm_options').css('display')=='none')
			{	jQuery(this).removeClass('inactive');
				jQuery(this).addClass('active');
				jQuery(this).children('img').removeClass('inactive');
				jQuery(this).children('img').addClass('active');
			
			}
		else
			{	jQuery(this).removeClass('active');
				jQuery(this).addClass('inactive');		
				jQuery(this).children('img').removeClass('active');			
				jQuery(this).children('img').addClass('inactive');
			}
		
		jQuery(this).parent().next('.rm_options').slideToggle('slow');
	});
	
	// On Load
	if( jQuery(".rm_instagram_mode").attr("rel") == "" ){
		jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
		
	} else if( jQuery(".rm_instagram_mode").attr("rel") == "user" ){
		jQuery(".rm_instagram_userid").slideDown();
		jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
	
	} else if( jQuery(".rm_instagram_mode").attr("rel") == "tag" ){
		jQuery(".rm_instagram_tag").slideDown();
		jQuery(".rm_instagram_userid, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
	
	} else if( jQuery(".rm_instagram_mode").attr("rel") == "multiuser" ){
		jQuery(".rm_instagram_userid").slideDown();
		jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
	
	} else if( jQuery(".rm_instagram_mode").attr("rel") == "location" ){
		jQuery(".rm_instagram_location").slideDown();
		jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_userid").slideUp();
	}
	
	// On Change
	jQuery(".rm_instagram_mode input").click(function(){ 
		if( jQuery(this).val() == "user" ){
			jQuery(".rm_instagram_userid").slideDown();
			jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
		
		} else if( jQuery(this).val() == "tag" ){
			jQuery(".rm_instagram_tag").slideDown();
			jQuery(".rm_instagram_userid, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
		
		} else if( jQuery(this).val() == "multiuser" ){
			jQuery(".rm_instagram_userid").slideDown();
			jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_location").slideUp();
		
		} else if( jQuery(this).val() == "location" ){
			jQuery(".rm_instagram_location").slideDown();
			jQuery(".rm_instagram_tag, .rm_instagram_gallery_photos, .rm_instagram_userid").slideUp();
		}
	});
	
	// On Load
	if( jQuery(".rm_instagram_gallery_mode input").val() == "fullscreen" ){
		jQuery(".rm_instagram_gallery_photos").slideDown();
	} else {
		jQuery(".rm_instagram_gallery_photos").slideUp();
	}
	
	// On Change
	jQuery(".rm_instagram_gallery_mode input").click(function(){ 
		if( jQuery(this).val() == "fullscreen" ){
			jQuery(".rm_instagram_gallery_photos").slideDown();
		} else {
			jQuery(".rm_instagram_gallery_photos").slideUp();
		}
	});
});