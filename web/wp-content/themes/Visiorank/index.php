<?php 
do_action('st_theme_init');
get_header(); 

     $default_layout  =  intval(st_get_setting("layout",3));  
     if(is_singular()):
          global $post;
          $st_page_builder = get_page_builder_options($post->ID);
          $layout = isset($st_page_builder['layout']) ?  intval($st_page_builder['layout']) : 2;
          if(in_array($layout,array(1,2,3,4))){
             $default_layout = $layout  ;
          }    
      endif;
      do_action('st_before_layout');
     // $file  = ST_TEMPLATE_DIR.'/layout/'.st_get_layout($default_layout).'.php';
    //  include($file);
     get_template_part('st-framework/templates/layout/'.st_get_layout($default_layout),'');
      do_action('st_after_layout');

get_footer();



