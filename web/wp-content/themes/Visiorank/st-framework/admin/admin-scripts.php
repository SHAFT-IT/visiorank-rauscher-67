<?php


function st_admin_scripts(){
    if(isset($_REQUEST['page'])){
        $page=$_REQUEST['page'];
    }else{
        $page ='';
    }
    if($page==ST_PAGE_SLUG){
        st_options_admin_js();
        st_options_admin_css();
    }
    
}

    
add_action('admin_init','st_admin_scripts');

function st_options_admin_js(){
         $screen = get_current_screen();
         if(!in_array($screen->id,array('post','page')) &&  strpos($screen->id,ST_PAGE_SLUG)===false  && $screen->base!='edit-tags' ){
            return false;
         }
         
        global $ajax_nonce;
    
        wp_enqueue_script('jquery');
        // for upload
       // wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-sortable');

        if(function_exists( 'wp_enqueue_media' )){
            wp_enqueue_media();
        }
        
        wp_enqueue_style('thickbox');
        
        wp_deregister_script('colorpicker');
        
        wp_enqueue_script('colorpicker',ST_ADMIN_URL."/js/colorpicker/js/colorpicker.js",array('jquery'));
        wp_enqueue_script('eye',ST_ADMIN_URL."/js/colorpicker/js/eye.js",array('jquery','colorpicker'));
        wp_enqueue_script('utilsa',ST_ADMIN_URL."/js/colorpicker/js/utils.js",array('jquery','colorpicker'));
        
        // for buttons // select
        wp_enqueue_script('chosen.jquery',ST_ADMIN_URL."/js/chosen.jquery.min.js",array('jquery'));
        wp_enqueue_script('sa-chosen',ST_ADMIN_URL."/js/sa-chosen.js",array('jquery','chosen.jquery'));
     
        wp_enqueue_script('ibutton',ST_ADMIN_URL."/js/ibutton.js",array('jquery'));
        wp_enqueue_script('easing',ST_ADMIN_URL."/js/easing.js",array('jquery'));
        wp_enqueue_script('easing',ST_ADMIN_URL."/js/metadata.js",array('jquery'));
        
        wp_enqueue_script('st-admin-js',ST_ADMIN_URL."/js/admin-js.js",array('jquery','media-upload','colorpicker'));
        
         wp_localize_script('st-admin-js','STpanel_options',array(
            'view_full_image'=> __('View full image','magazon'),
            'remove'=>__('Remove','magazon'),
            'seletc_image'=>__('Seletc Image','magazon'),
            'ajax_nonce'=>$ajax_nonce,
            'uploadID'=>''
        ));
}

function st_options_admin_css(){ 
        wp_enqueue_style(ST_PAGE_SLUG.'-css',ST_ADMIN_URL."/css/smoothness/jquery-ui-1.7.3.custom.css");
        wp_enqueue_style(ST_PAGE_SLUG.'-jquery-ui',ST_ADMIN_URL."/css/admin-style.css");
        wp_enqueue_style(ST_PAGE_SLUG.'-font-awesome',ST_ADMIN_URL."/css/font-awesome.min.css");
        wp_enqueue_style(ST_PAGE_SLUG.'-colorpicker-css',ST_ADMIN_URL."/js/colorpicker/css/colorpicker.css");
        wp_enqueue_style(ST_PAGE_SLUG.'-colorpicker-layout-css',ST_ADMIN_URL."/js/colorpicker/css/layout.css");
}

 //   add_options_page();
//add_action("admin_print_scripts-post-new.php","st_options_admin_js");
add_action("admin_print_styles-post-new.php","st_options_admin_css"); 
//add_action("admin_print_scripts-post.php","st_options_admin_js");
add_action("admin_print_styles-post.php","st_options_admin_css"); 

add_action('admin_enqueue_scripts','st_options_admin_js');

add_action("admin_print_scripts-media-upload-popup","st_upload_popup_js");
//add_action("admin_print_styles-media-upload-popup","st_upload_popup_css");
    
function st_upload_popup_js(){
    if($_REQUEST['st_upload']==1){ // only ad if media open  by STFrameWork
        wp_enqueue_script('st-media-popup',ST_ADMIN_URL.'/js/media-popup.js',array('jquery'));
    }
    
}

function st_upload_popup_css(){
    wp_enqueue_style('sa-css',plugins_url( 'css/sa.css' , __FILE__ ));
    wp_enqueue_style('thickbox');
}
    
// add to upload box
//add_action("admin_print_scripts-media-upload-popup","st_upload_popup_js");
//add_action("admin_print_styles-media-upload-popup","st_upload_popup_css");

    