<?php
/**
 * @author Sa Truong - Http://www.smooththemes.com
 * @copyright 2012
 */

#-----------------------------------------------------------------
# Enqueue Style
#-----------------------------------------------------------------
if( !function_exists('st_enqueue_styles')){
    function st_enqueue_styles(){
        if(!is_admin()){
        	
			if(st_is_woocommerce()){
				wp_register_style('woocommerce',st_css('woocommerce.css'));
				wp_enqueue_style('woocommerce');
			}
            //Register styles
            wp_register_style('st_style', get_bloginfo( 'stylesheet_url' ),false, ST_VERSION);
            wp_register_style('flexslider', st_css('flexslider.css'));
            wp_register_style('custom_css', ST_THEME_URL.'custom.css');
            wp_register_style('font-awesome',st_css('font-awesome.min.css'));
            wp_register_style('flexslider',st_css('flexslider.css'));
            wp_register_style('ddsmoothmenu',st_css('ddsmoothmenu.css'));
            wp_register_style('responsive',st_css('responsive.css'));
            wp_register_style('rtl',st_css('rtl.css'));
            

            
            // Load Styles
            wp_enqueue_style('st_style');
            wp_enqueue_style('font-awesome');
            wp_enqueue_style('ddsmoothmenu');
            wp_enqueue_style('flexslider');
            wp_enqueue_style('responsive');

            $rtl = st_get_setting('page_rtl');
            if($rtl =='y' or $_REQUEST['rtl'] == 'true'){
                wp_enqueue_style('rtl');
                // Add specific CSS class by filter
                add_filter('body_class','rtl_function');
                function rtl_function($classes) {
                    // add 'class-name' to the $classes array
                    $classes[] = 'rtl';
                    // return the $classes array
                    return $classes;
                }
            }

            wp_enqueue_style('custom_css');

        }
    }
}
add_action('wp_print_styles','st_enqueue_styles');

#-----------------------------------------------------------------
# Enqueue Scripts
#-----------------------------------------------------------------
if(!function_exists('st_enqueue_scripts')){
    function st_enqueue_scripts(){
        if(!is_admin()){

            // Load Scripts
            wp_enqueue_script("jquery",st_js('jquery.js'));
            if ( is_singular() && get_option( 'thread_comments' ) ){ wp_enqueue_script( 'comment-reply' );}

             wp_register_script( 'fitvids', st_js('jquery.fitvids.js'), array('jquery'),ST_VERSION);
             wp_register_script( 'ddsmoothmenu', st_js('ddsmoothmenu.js'), array('jquery'),ST_VERSION);
             wp_register_script( 'flexslider', st_js('jquery.flexslider.js'), array('jquery'),ST_VERSION);
             wp_register_script( 'st_custom', st_js('custom.js'), array('jquery'),ST_VERSION);
             wp_register_script( 'caroufredsel', st_js('jquery.carouFredSel-6.2.0-packed.js'), array('jquery'),'6.0.2');
             wp_register_script( 'imagesloaded', st_js('jquery.imagesloaded.min.js'), array('jquery'),'6.0.2');

            wp_enqueue_script("fitvids",st_js('jquery.fitvids.js'),false,ST_VERSION,true);
            wp_enqueue_script("flexslider",st_js('jquery.flexslider.js'),false,ST_VERSION,true);
            wp_enqueue_script("ddsmoothmenu",st_js('ddsmoothmenu.js'),false,ST_VERSION,true);
            wp_enqueue_script("caroufredsel",st_js('jquery.carouFredSel-6.2.0-packed.js'),false,'6.2.0',true);
            wp_enqueue_script("imagesloaded",st_js('jquery.imagesloaded.min.js'),false,ST_VERSION,true);
            wp_enqueue_script("st_custom",st_js('custom.js'),false,ST_VERSION,true);

        }
    }
}
add_action('wp_print_scripts','st_enqueue_scripts');