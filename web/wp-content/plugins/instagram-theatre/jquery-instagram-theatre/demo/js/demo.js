/*
 * Instagram Theatre Site Scripts
 * Version: 1.0
 *
 * Author: Chris Rivers
 * http://chrisriversdesign.com
 *
 *
 * Changelog: 
 * Version: 1.0
 *
 */


$(document).ready(function(){
	
	/* Navigation
	------------------------*/
	$(".nav ul li a").mouseover(function(){
		$('.nav-pointer').show().stop().animate({ top: $(this).position().top + 5 }, 500, 'easeOutBack');
        $('.nav-pointer').find('#pointer-left').stop().animate({left: $(this).position().left -20}, 500);
        $('.nav-pointer').find('#pointer-right').stop().animate({left: $(this).position().left + $(this).width() + 15}, 500);
	});
	
	$(".bottom-bar .close-sidebar").click(function(){
		
		$(this).toggleClass("closed");
		
		if( $(this).hasClass("closed") ){
			$("div.sidebar-nav").stop().animate({
				left: ["-288", "easeOutQuad"]
			}, 600);
		
			$(".photo-nav a.prev").stop().animate({
				left: ["-288", "easeOutQuad"]
			}, 600);
			
			$(".instagram-theatre").stop().animate({
				marginLeft: ["67px", "easeOutQuad"],
				width: ["1303px", "easeOutQuad"]
			}, 1000);
			
		} else {
			$("div.sidebar-nav").stop().animate({
				left: ["0", "easeOutQuad"]
			}, 600);
		
			$(".photo-nav a.prev").stop().animate({
				left: ["0", "easeOutQuad"]
			}, 600);
			
			$(".instagram-theatre").stop().animate({
				marginLeft: ["370px", "easeOutQuad"],
				width: ["863px", "easeOutQuad"]
			}, 1000);
		}
			
	});
	
	$("body").keyup(function(e){
		if(e.which == 13){
			$(".bottom-bar .close-sidebar").trigger("click");
		}
	});
	
	$(".enterFullscreen").click(function(){
		$(".bottom-bar .close-sidebar").trigger("click");
		return false;
	});
	
	var curHeight = 100; // Default
	
	$("a.caption-close").click(function(){
		
		curHeight = $(".caption-container").height();
		
		$(this).parent().animate({
			height: ["0", "easeOutBack"],
			width: ["0", "easeOutBack"],
		}, 1000, function(){
			$(this).addClass("event-ui");
		});
		
		$(this).parent().addClass("closed-cap").find("*").fadeOut();		
		
	});
	
	$(".event-ui").live("click", function(){
		$(this).animate({
			height: [curHeight, "easeOutBack"],
			width: ["500", "easeOutBack"],
		}, 1000, function(){
			$(this).css("height","auto");
		});
		
		$(this).removeClass("event-ui").removeClass("closed-cap").find("*").fadeIn();
	});
	
	// Color Swapper
	$(".customization-bar .colors a").click(function(){
		
		$("body").attr("class", "").addClass($(this).attr("class"));
	
		if( $(this).attr("data-color") == "#000000"){
			$(".sidebar-nav").removeAttr("style");
			$(".top-bar, .bottom-bar").css("background", $(this).attr("data-color"));
		} else {
			$(".sidebar-nav, .top-bar, .bottom-bar").css("background", $(this).attr("data-color"));
		}
	});
	
});