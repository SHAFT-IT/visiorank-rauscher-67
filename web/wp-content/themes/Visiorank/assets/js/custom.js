jQuery.noConflict();
jQuery(document).ready(function(){
    // load video thumbnail 
    jQuery('.video-thumb').each(function(){
        var obj = jQuery(this);
        var v = obj.attr('video');
        var vi = obj.attr('video-id');
        if(typeof(v)!='undefined' && v !=''&& typeof(vi)!='undefined' && vi !=''){
            if(v=='youtube'){
                obj.html('<img src="http://img.youtube.com/vi/'+vi+'/3.jpg" alt="" />');
            }else{
                 jQuery.getJSON('http://vimeo.com/api/v2/video/'+vi+'.json?callback=?',{format:"json"},function(data,status){
                    var small_thumb=  data[0].thumbnail_small;
                    obj.html('<img src="'+small_thumb+'" alt="" />');
                });
            }
        }
    });

    // Top Navigation for mobile.
    var top_nav_mobile_button = jQuery('#top-nav-mobile');
    var top_nav_cloned;
    var top_nav = jQuery('#top-nav-id > ul');

    top_nav.clone().attr('id','top-nav-mobile-id').removeClass().appendTo( top_nav_mobile_button );
    top_nav_cloned = top_nav_mobile_button.find('> ul');
        top_nav_mobile_button.click(function(){
            if(jQuery(this).hasClass('top-nav-close')){
                jQuery(this).removeClass('top-nav-close').addClass('top-nav-opened');
                top_nav_cloned.slideDown( 400 );
            } else {
                jQuery(this).removeClass('top-nav-opened').addClass('top-nav-close');
                top_nav_cloned.slideUp( 400 );
            }
            return false;
        });
        top_nav_mobile_button.find('a').click(function(event){
            event.stopPropagation();
        });
    
    // Primary Navigation for mobile.
    var primary_nav_mobile_button = jQuery('#primary-nav-mobile');
    var primary_nav_cloned;
    var primary_nav = jQuery('#primary-nav-id > ul');

    primary_nav.clone().attr('id','primary-nav-mobile-id').removeClass().appendTo( primary_nav_mobile_button );
    primary_nav_cloned = primary_nav_mobile_button.find('> ul');
        jQuery('#primary-nav-mobile-a').click(function(){
            if(jQuery(this).hasClass('primary-nav-close')){
                jQuery(this).removeClass('primary-nav-close').addClass('primary-nav-opened');
                primary_nav_cloned.slideDown( 400 );
            } else {
                jQuery(this).removeClass('primary-nav-opened').addClass('primary-nav-close');
                primary_nav_cloned.slideUp( 400 );
                
                
            }
            return false;
        });
        primary_nav_mobile_button.find('a').click(function(event){
            event.stopPropagation();
        });

    //ddsmoothmenu for top nav
    ddsmoothmenu.init({
    	mainmenuid: "top-nav-id", //menu DIV id
    	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    	classname: 'top-nav slideMenu', //class added to menu's outer DIV
    	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    });

    //ddsmoothmenu for primary nav
    ddsmoothmenu.init({
        mainmenuid: "primary-nav-id", //menu DIV id
        orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
        classname: 'primary-nav slideMenu', //class added to menu's outer DIV
        contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    });
    
    // nav custom color 
    jQuery('.primary-nav li.current-menu-item, .primary-nav li.current-menu-parent, .primary-nav li.current_page_parent').each(function(){
        var li = jQuery(this);
          var color = li.attr('color');
          if(typeof(color)!='undefined' && color!='' && (li.hasClass('current-menu-item') || li.hasClass('current-menu-parent') ||  li.hasClass('current_page_parent')) ){
                li.css({'background':'#'+color});
                jQuery('>a',li).css({'background':'#'+color});
                jQuery('ul',li).css({'background':'#'+color+' !important'});
          }
    });
    
  

    // Widget Content Tabbed
    jQuery(".content-tabbed .list-tabbed li").click(function() {
        var  p = jQuery(this).parents('.content-tabbed');
        //  First remove class "active" from currently active tab
        jQuery(".list-tabbed li",p).removeClass('list-tabbed-active');
 
        //  Now add class "active" to the selected/clicked tab
        jQuery(this).addClass("list-tabbed-active");
 
        //  Hide all tab content
        jQuery(".tabbed_content",p).hide();
 
        //  Here we get the href value of the selected tab
        //var selected_tab = jQuery(this).find("a").attr("href");
        var selected_tab = jQuery(this).find("a").attr("for-tab");
 
        //  Show the selected tab content
       
        if(typeof(selected_tab)!='undefined'){
            jQuery('.'+selected_tab,p).fadeIn();
        }
        
 
        //  At the end, we add return false so that the click on the link is not executed
        return false;
    });

    // Fitvideos
    jQuery(".body-outer-wrapper").fitVids();

    // Social Hover 
    jQuery(".social-block a img").hover(function(){
        jQuery(this).animate({ opacity: 0.6 }, 250);
    }, function(){
        jQuery(this).animate({ opacity: 1 }, 250);
    });


         // Shortcodes
        // Alert 
        jQuery('.close').click(function(){
            jQuery(this).parent().fadeOut("slow");
        });
        
        jQuery('.st-tabs').each(function(){
            var  t = jQuery(this);
            // for defaul when load;
            if(jQuery('.tab-title .current',t).length>0){
               var tab_id = jQuery('.tab-title .current',t).eq(0).attr('tab-id');
            }else{
                var tab_id = jQuery('.tab-title > li',t).eq(0).addClass('current').attr('tab-id');
            }
            
             t.find('div.active').removeClass('active').css('display','none');
             t.find('#' + tab_id ).fadeIn().addClass('active');
        });
        // when click
        jQuery('.st-tabs .tab-title > li').click(function(){
              var  t = jQuery(this).parents('.st-tabs');
                if(jQuery(this).hasClass('current')) return;
               
                var tab_id = jQuery(this).attr('tab-id');
                // hide all ative content
                jQuery('.tab-title li',t).removeClass('current');
                jQuery('.tab-content',t).css('display','none').removeClass('active');
                 jQuery(this).addClass('current');
                jQuery('#' + tab_id,t).fadeIn().addClass('active');
               
            });
        
        

        // Accordion
        
        jQuery('.st-accordion').each(function(){
            var p = jQuery(this);
        
            jQuery('.acc-title',p).toggleClass('acc-title-inactive');
            //Open accordion by default by class "acc-opened".
            jQuery('.acc-opened .acc-title',p).toggleClass('acc-title-active').toggleClass('acc-title-inactive');
            jQuery('.acc-opened .acc-content',p).slideDown().toggleClass('open-content');
    
            jQuery('li .acc-title',p).click(function(){                
               var  t =  jQuery(this);
               var  li = jQuery(this).parents('li');
               
                t.toggleClass('acc-title-active').toggleClass('acc-title-inactive');
                jQuery('.acc-content',li).slideToggle().toggleClass('open-content');
                
                jQuery('li',p).not(li).each(function(){
                    var e = jQuery(this);
                
                    jQuery('.acc-title',e).removeClass('acc-title-active');
                    jQuery('.acc-content',e).slideUp(400,function(){
                          jQuery('.acc-content',e).removeClass('open-content');
                    });
                
                });
            });
            
        })
       

        // Toggle
        jQuery('.toggle-title').click(function(){
            var toggle_tab = jQuery(this).parent();
            toggle_tab.find('> :last-child').stop(true, true).slideToggle();
            if (jQuery(this).hasClass('toggle_current'))
            {
                jQuery(this).removeClass('toggle_current');
            }
            else
            {
                jQuery(this).addClass('toggle_current');
            }
        });
        
        
            // for Socials

           // facebook
            
           jQuery('.connect-widget-social .connect-facebook').each(function(){
                var o = jQuery(this);
                var id=  o.attr('facebook-id');
                if(typeof(id)!='undefined' && id!=''){
                    //send request 
                    jQuery.ajax({
                       url: 'http://graph.facebook.com/'+id,
                       dataType: 'json',
                       data : { }, 
                       type: 'get',
                       cache: false,
                       
                       timeout: 30000, // 30 sec
                       success: function(data){
                            try{
                                  var num = data.likes;
                                  var text= (num>1) ? o.attr('plural-text'): o.attr('one-text');
                                 jQuery('.num',o).html(num);
                                 jQuery('.txt',o).html(text);
                            }catch(e){
                            }
                       } 
                    });
                } 
            }); 
            
        // end for Socials
        
        // back to top
        jQuery(window).scroll(function() {
    		if(jQuery(this).scrollTop() != 0) {
    			jQuery('#sttotop').fadeIn();	
    		} else {
    			jQuery('#sttotop').fadeOut();
    		}
    	});
     
    	jQuery('#sttotop').click(function() {
    		jQuery('body,html').animate({scrollTop:0},800);
    	});	
    	
    	
    	
    	// for NAV search

    	jQuery('#nav-searchform').each(function(){
    		 var f = jQuery(this);
    		 var inputw = jQuery(window).width() >  300 ?  200 :  120;
    		if(jQuery('.s',f).hasClass('closed')){ // open text box
    			
    			jQuery('.s',f).css({'padding' : '0px 0px'}); 
    			
    		}
    		
    		f.show();
    		
    		
    		
    		jQuery('.search-submit',f).click(function(){
    			var btn =  jQuery(this);
    			if(jQuery('.s',f).hasClass('closed')){
    				
    				
					jQuery('.s',f).animate({
						
						width: inputw+'px'
					}, 600, function() {
					// Animation complete.
					 
						jQuery('.s',f).css({'padding' : '0px 10px'}).removeClass('closed'); 
						jQuery('.s',f).focus();
					});
					
					
    				return false;
    			}else{ // submit form
    				
    			}
    		
    		});
    		
    		
    		jQuery(document).click(function(e) {
	            
	            if (f.has(e.target).length === 0) {
	                jQuery('.s',f).css({'padding' : '0px 0px'}).addClass('closed'); 
	                
	                jQuery('.s',f).animate({
						width: '0px'
					}, 600, function() {
					// Animation complete.
					});
	            }
	        });
    		
    		
    		
    		 
    	});
        
        
        
    
}); // End of Jquery DOM ready

