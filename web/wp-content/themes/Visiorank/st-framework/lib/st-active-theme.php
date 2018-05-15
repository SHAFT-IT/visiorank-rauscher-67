<?php
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
      // your code here
      st_theme_activate();
}

function st_theme_activate() {
  
 //  $options = @unserialize($options);
  // update_option(ST_SETTINGS_OPTION,$options);
  st_theme_default_options();
   ob_start();
   header('Location: '.admin_url('admin.php?page='.ST_PAGE_SLUG));
}


function st_theme_default_options($overwrite= false){
    $is_update=  true; 
    if($overwrite== false){
        $set  = get_option(ST_SETTINGS_OPTION);
        $is_update = empty($set) ? true : false;
    }
    
    if($is_update){
    
        $default_options = 'a:53:{s:15:"page_full_boxed";s:1:"b";s:6:"layout";s:1:"2";s:8:"page_rtl";s:1:"n";s:9:"sidebar_l";s:0:"";s:9:"sidebar_r";s:17:"sidebar_default_r";s:14:"sidebar_search";s:0:"";s:18:"show_footer_widget";s:1:"y";s:15:"show_footer_nav";s:1:"y";s:9:"site_logo";s:72:"http://demo.smooththemes.com/magazon/wp-content/uploads/2013/01/logo.png";s:16:"logo_padding_top";s:2:"20";s:19:"logo_padding_bottom";s:2:"20";s:14:"enable_favicon";s:1:"y";s:12:"site_favicon";s:74:"http://localhost/magazon/magazon-wp/wp-content/uploads/2013/02/favicon.ico";s:8:"sidebars";a:2:{i:0;a:2:{s:5:"title";s:10:"Contact Us";s:2:"id";s:15:"id1360136022582";}i:1;a:2:{s:5:"title";s:16:"Reviews Category";s:2:"id";s:15:"id1361426253157";}}s:9:"body_font";a:5:{s:9:"font-size";s:2:"12";s:14:"font-size-unit";s:2:"px";s:11:"line-height";s:2:"22";s:16:"line-height-unit";s:2:"px";s:11:"font-family";s:76:"http://fonts.googleapis.com/css?family=Droid+Sans:regular%2C700&subset=latin";}s:12:"heading_font";a:3:{s:11:"font-family";s:76:"http://fonts.googleapis.com/css?family=Droid+Sans:regular%2C700&subset=latin";s:10:"font-style";s:6:"normal";s:11:"font-weight";s:6:"normal";}s:20:"archive_heading_font";a:3:{s:11:"font-family";s:90:"http://fonts.googleapis.com/css?family=Oswald:300%2Cregular%2C700&subset=latin%2Clatin-ext";s:10:"font-style";s:6:"normal";s:11:"font-weight";s:6:"normal";}s:17:"predefined_colors";s:6:"16A1E7";s:25:"enable_custom_global_skin";s:1:"n";s:18:"custom_global_skin";s:6:"800a80";s:8:"bg_color";s:6:"CCCCCC";s:6:"bg_img";s:75:"http://demo.smooththemes.com/magazon/wp-content/uploads/2013/02/body_bg.jpg";s:10:"bg_positon";s:2:"cc";s:10:"bg_repreat";s:1:"n";s:8:"bg_fixed";s:1:"y";s:18:"enable_share_entry";s:1:"y";s:18:"enable_author_desc";s:1:"y";s:12:"enable_re_re";s:1:"y";s:15:"disable_s_thumb";s:1:"n";s:20:"disable_single_media";s:1:"n";s:25:"disable_single_categories";s:1:"n";s:30:"display_single_author_metadata";s:1:"y";s:28:"display_single_date_metadata";s:1:"y";s:31:"display_single_comment_metadata";s:1:"y";s:8:"facebook";s:1:"#";s:7:"twitter";s:1:"#";s:11:"google_plus";s:1:"#";s:8:"linkedin";s:1:"#";s:9:"pinterest";s:0:"";s:18:"social_link_target";s:6:"_blank";s:16:"footer_copyright";s:129:"&copy; 2012. All Rights Reserved. Created with love by <a target=\"_blank\" href=\"http://www.smooththemes.com\">SmoothThemes</a>";s:14:"flex_animation";s:4:"fade";s:17:"flex_smoothHeight";s:5:"false";s:18:"flex_animationLoop";s:4:"true";s:14:"flex_slideshow";s:4:"true";s:19:"flex_slideshowSpeed";s:4:"7000";s:19:"flex_animationSpeed";s:4:"6000";s:18:"flex_pauseOnAction";s:4:"true";s:17:"flex_pauseOnHover";s:4:"true";s:15:"flex_controlNav";s:4:"true";s:14:"flex_randomize";s:5:"false";s:21:"headder_tracking_code";s:0:"";s:20:"footer_tracking_code";s:0:"";}';
     
        $options = maybe_unserialize($default_options);
        $options['site_logo'] = st_img('logo.png', false);
     
        update_option(ST_SETTINGS_OPTION,$options);
        
        if(st_is_wpml()){
            $langs = icl_get_languages('skip_missing=0&orderby=KEY&order=asc');
            foreach($langs as $l){
               update_option(ST_SETTINGS_OPTION.'_'.$l['language_code'],$default);
            }
        }
    
    }
}



