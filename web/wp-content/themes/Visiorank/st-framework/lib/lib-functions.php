<?php 

function st_make_safe_name($string_name) {
		$regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_]#', '#^\.#');
		return preg_replace($regex, '', $string_name);
}

/**
 * return substring
*/
 function st_get_substr($str,$n=150,$more='...')
     {
         if(strlen($str)<$n) return $str;
         $html = substr($str,0,$n);
         $html = substr($html,0,strrpos($html,' '));
         return $html.$more;
     }

/**
 * Get title
*/
function st_title(){
    global $page, $paged;
    wp_title( '|', true, 'right' );
    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'magazon' ), max( $paged, $page ) );
}

/**
 * get site favicon
*/
function st_favicon(){
    if(st_get_setting("enable_favicon") == 'y'){
    if(st_get_setting("site_favicon") != ''){
    ?>
<link rel="shortcut icon" href="<?php echo st_get_setting("site_favicon"); ?>" title="Favicon" />
    <?php
    }
    }
}

/**
 * Get Full Width or Boxed Layout
*/
function st_boxed_full(){
  $bf_layout = st_get_setting("page_full_boxed",'b');
  if($bf_layout == 'f' or $_REQUEST['layout'] == 'fullwidth'){
    $bf_layout = 'full-width-mode';
    } else {
    $bf_layout = 'boxed-mode';
  }
  return $bf_layout;
}

/**
* Get full url of js file
*/
function st_js($file, $echo = false){
    $js = ST_THEME_URL.'assets/js/'.$file;
    if($echo){
        echo   $js;
    }else{
        return $js;
    }
}

/**
* Get full url of css file
*/
function st_css($file, $echo = false){
    $css = ST_THEME_URL.'assets/css/'.$file;
    if($echo){
        echo   $css;
    }else{
        return $css;
    }
}

/**
* Get full url of image file
*/
function st_img($file, $echo = false){
    $img = ST_THEME_URL.'assets/images/'.$file;
    if($echo){
        echo   $img;
    }else{
        return $img;
    }
}


/**
* Get file url from asset url
*/
function st_asset($file, $echo = false){
    $file = ST_THEME_URL.'assets/'.$file;
    if($echo){
        echo   $file;
    }else{
        return $file;
    }
}


/**
* return content from php file
*/

function st_get_content($file,$data= array(),$settings = array()){
    if(!is_file($file)){ 
        return   false;
    }
    ob_start();
    $old_cont =  ob_get_contents();
    ob_end_clean();
    ob_start();
    include($file);
    $content = ob_get_contents();
    ob_end_clean();
    echo $old_cont;
    return $content;
}


/**
 *Get content from  function  
 */ 
function st_get_content_from_func($function,$data = array(),$settings = array()){
    if(!function_exists($function) || !is_string($function)){ 
        return   false;
    }
    
    ob_start();
    $old_cont =  ob_get_contents();
    ob_end_clean();
    ob_start();
       call_user_func($function,$data,$settings);
    $content = ob_get_contents();
    ob_end_clean();
    echo $old_cont;
    return $content;
    
}



global  $st_post_meta;

/**
 * Get option of post meta
 */
function st_get_post_meta($post_id,$meta_name,$key='',$default= false){
    global $st_post_meta;
    $mt = false;
    if(empty($st_post_meta[$post_id][$meta_name])){
        //cache query to global $st_post_meta
      $st_post_meta[$post_id][$meta_name] =  get_post_meta($post_id,$meta_name, true);
    }
    if($key==''){
        return (!empty($st_post_meta[$post_id][$meta_name])) ?  $st_post_meta[$post_id][$meta_name] : $default; 
    }
    return (!empty($st_post_meta[$post_id][$meta_name][$key])) ?  $st_post_meta[$post_id][$meta_name][$key] : $default; 
}

/**
 * get Setting option
 */ 
function st_get_setting($name,$default= false){
    global $st_options;
    return ( isset($st_options[$name]) && !empty($st_options[$name]) ) ?  $st_options[$name] :  $default;
}

/**
* Get settings from page builder
*/
function  get_page_builder_options($post_id,$cache=true){
    
    $values = false;
    
    $cache_key ='_st_page_builder_'.$post_id;
    if($cache){ 
          if($values = wp_cache_get( $cache_key ) ) {
               
                 return $values;
          }
     }
     
    $values = get_post_meta($post_id,'_st_page_builder',true);
    
   //  echo var_dump($post_id, unserialize(base64_decode($values)));
    
    // try with old version if  data is empty
    if(empty($values)){
        $values = get_post_meta($post_id,'st_page_builder',true);
    }
    
    if(!is_array($values) &&  !is_object($values)){
        $values =  maybe_unserialize(base64_decode($values));
    }
    
    $values= st_stripslashes($values);
    
    $values = apply_filters('st_page_builder_options',$values);
    if($cache){ // cache to WP
         wp_cache_add( $cache_key, $values );
    }

    return $values;
    
   
}



/**
 * Get WC shop page id 
 * @return page id
 */ 
function st_get_shop_page(){
    $post_id  = get_option('woocommerce_shop_page_id'); 
    if(st_is_wpml()){
      $post_id=   icl_object_id($post_id, 'page', true);
    }
    return $post_id;
}







/**
* Get content from page builder generated
*/
function  get_page_builder_content($post_id){
    $values =  get_post_meta($post_id,'_st_page_builder_content',true);
    return apply_filters('st_page_builder_content',$values);
}

/**
 * Include Template part
 * Include file from them folder/templates/$file
*/

function st_get_template($file,$data = array()){
    $file = ST_DIR.'/templates/'.$file;
    if(file_exists($file)){
         include($file); return true;
    }
    return false;
}


/**
 *  Display page pagination
 */
 function st_post_pagination($pages = '', $range = 2,$echo = true)
{  
     $showitems = ($range * 2)+1;  
     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     
     $html = '';

     if(1 != $pages)
     {
         $html .= "<ul class='st-pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
            $html .=  "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
         if($paged > 1 && $showitems < $pages) 
           $html .=  "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 $html .=  ($paged == $i)? "<li><a href=\"#\" class='page-current'>".$i."</a></li>" : "<li><a href='".get_pagenum_link($i)."'  >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) 
            $html .=  "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
              $html .=  "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
         $html .=  "</ul>\n";
     }
     
     if($echo){
        echo $html;
        return $html;
     }else{
        return $html;
     }
     
} 

function st_caption_excerpt_length( $length ) {
	return 14;
}

/**
* @return return the slider data for function st_slider
*/
function st_get_setup_post_slider_data($get_posts_args= array()){
    if(empty($get_posts_args)){
        return array();
    }
    
     $r = wp_parse_args($get_posts_args,array(
        'cats' =>'',
        'numpost'=>5,
        'include'=>'',
        'exclude'=>'',
        'orderby'=>'ID',
        'order'=>'DESC'
    ));


    extract($r);
    
      if($numpost<=0){
            $numpost =5;
      }
      
      
      if(!is_array($cats)){
        $cats = explode(',',$cats);
      }

    /**
    * @Since ver 1.3
    */ 
    $args = array();
    //$args = array( 'posts_per_page' => $number );
    $args['posts_per_page'] = $numpost;

    if ($include != '') {
        $include = explode(',',$include);
        $args['post__in'] = $include;
    }


    if(!empty($cats) ){
        // $args['category__in'] =  array($cats);
        $args['category__in'] =  $cats;
    }

    if($exclude!=''){
        $exclude= explode(',',$exclude);
        $args['post__not_in'] = $exclude;
    }

    $args['meta_key'] 		 = '_thumbnail_id';
    $args['meta_query'] = array(
		array(
			'key' => '_thumbnail_id',
			'value' => 0,
			'type' => 'numeric',
			'compare' => '>'
		)
	);
    
    $args['orderby'] = $orderby;
    $args['order'] = $order;
    $args['post_status'] = 'publish';
  
    if(st_is_wpml() ){
            
             if(is_admin()){ // this function calling in admin page
                 global $post;
                 $lang_data = wpml_get_language_information($post->ID);
                //  echo var_dump($lang_data,$post->ID); die();
                  $args['language'] = $lang_data['locale'];
             }else{
                  $args['language'] = get_bloginfo('language');
             }
        
          $args['sippress_filters'] = true;
    }

    $new_query = new WP_Query(apply_filters('st_get_setup_post_slider_data_args', $args));
    $myposts =  $new_query->posts;

    $data['images'] = array();
    $data['meta'] = array();
    

   remove_filter( 'excerpt_length', 'st_excerpt_length' );
    // st_caption_excerpt_length
    add_filter( 'excerpt_length', 'st_caption_excerpt_length', 999 );
    
    
    if(count($myposts)){
        global $post;
        $i = 0;
        $date_format =  get_option('date_format');
        foreach($myposts as $post){
            setup_postdata($post);
            $id = get_post_thumbnail_id( $post->ID );
            if($id>0){
                $data['images'][$i]= $id;
                $data['meta'][$i]['title'] =  get_the_title($post->ID);
                $data['meta'][$i]['url'] = get_permalink($post->ID);
                $data['meta'][$i]['date'] =  mysql2date($date_format, $post->post_date);
                $content ='';
              
                $content = get_the_excerpt(); // the_excerpt();

                 $data['meta'][$i]['caption'] = $content;
                $i++;
            }
        }
    }
    
    wp_reset_query();
    add_filter( 'excerpt_length', 'st_excerpt_length', 99 );
    remove_filter('excerpt_length','st_caption_excerpt_length');
    
    return $data;
    
}


function st_get_video($url,&$return=array()){
	$url_lower = strtolower($url);
		if(strpos($url_lower,'youtube')){		
                preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$id);
                $return['type']='youtube';
                $return['video_id']=$id[1];
                if($id[1]==''){
                    return '';
                }
                return '<iframe width="306" height="160" src="http://www.youtube.com/embed/'.$id[1].'?wmode=transparent" frameborder="0"></iframe>';
		}else if(strpos($url_lower,'youtu.be') ){
		      preg_match('/youtu.be\/([^\\?\\&]+)/', $url, $id);
              $return['type']='youtube';
              $return['video_id']=$id[1];
              if($id[1]==''){
                    return '';
                }
              return '<iframe width="306" height="160" src="http://www.youtube.com/embed/'.$id[1].'?wmode=transparent" frameborder="0"></iframe>';
			
		}else if(strpos($url_lower,'vimeo.com') ){
			preg_match('/http:\/\/vimeo.com\/(\d+)$/', $url, $id);
            $return['type']='vimeo';
            $return['video_id']=$id[1];
            if($id[1]==''){
                    return '';
            }
            return '<iframe width="306" height="160" src="http://player.vimeo.com/video/'.$id[1].'?title=0&amp;byline=0&amp;portrait=0" frameborder="0"></iframe>';
		}
		 return '';
	}


function st_post_thumbnail($post_id='', $size ='st_small_thumb',$rand_if_slider= false,$small_video_thumb = false){
     $st_page_options = get_page_builder_options($post_id);
     $html ='';
            switch(strtolower($st_page_options['thumbnail_type'])){
            case 'video':
              
               $video = st_get_video($st_page_options['video_code'],$data);
               // echo var_dump($data);
                if(($size=='st_small_thumb' || $small_video_thumb ) && !empty($data)){
                      $html ='<span class="video-thumb" video="'.$data['type'].'" video-id="'.$data['video_id'].'"></span>';
                     
                }else{
                    $html = $video ;
                    if($html==''){
                        $html =  '<span class="video-thumb no-thumb"></span>';
                    }
                }
                
            break;
            case 'slider':
                //st_slider($st_page_options['thumbnails'],array('show_caption'=>'no')); // images
                
                if(count($st_page_options['thumbnails']['images'])){
                    if($rand_if_slider===true || $size =='st_small_thumb'){ // show rand image
                       $rand_key = array_rand($st_page_options['thumbnails']['images'], 1);
                       $thumb_image_url = wp_get_attachment_image_src( $st_page_options['thumbnails']['images'][$rand_key],$size);
                       $title = 'title="'. esc_attr (sprintf(__( 'Permalink to %s', 'magazon' ) , get_the_title($post_id) ) ). '"  rel="bookmark" ';
                       $html = '<span class="had-thumb">
						<a href="'.get_permalink($post_id).'" '.$title.'><img alt="" src="'.$thumb_image_url[0].'" ></a>                           		
                        </span>';
                    }else{
                        st_slider($st_page_options['thumbnails'],array('show_caption'=>'no')); // slider
                    }
                }else{
                    $html = ' <span class="no-thumb no-slider"></span>';
                }
               

            break;
            default;
                 if ( has_post_thumbnail($post_id) ) {
                      $thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size);
                     $title = 'title="'. esc_attr (sprintf(__( 'Permalink to %s', 'magazon' ) , get_the_title($post_id) ) ). '"  rel="bookmark" ';
                      $html = '<span class="had-thumb">
						<a href="'.get_permalink($post_id).'" '.$title.'><img alt="" src="'.$thumb_image_url[0].'" ></a>                           		
                        </span>';
               
                }else{
                    $html = ' <span class="no-thumb"></span>';
            }
         } 
         return apply_filters('st_post_thumbnail',$html, $post_id);
}



function st_get_normal_fonts(){
   return  array(
                'Arial'=>'', //  array('value', font_url)
                'Arial Black'=>'',
                'Arial Narrow'=>'',
                'Courier New'=>'',
                'Georgia'=>'',
                'Times New Roman'=>'',
                'Trebuchet MS'=>'',
                'Verdana'=>'',
                'Andale Mono'=>'',
                'Baskerville'=>'',
                'Bookman Old Style'=>'',
                'Calibri'=>'',
                'Cambria'=>'',
                'Candara'=>'',
                'Century Gothic'=>'',
                'Century Schoolbook'=>'',
                'Consolas'=>'',
                'Constantia'=>'',
                'Corbel'=>'',
                'Franklin Gothic'=>'',
                'Garamond'=>'',
                'Gill Sans'=>'',
                'Helvetica'=>'',
                'Hoefler'=>'',
                'Lucida Bright'=>'',
                'Lucida Grande'=>'',
                'Palatino'=>'',
                'Rockwell'=>'',
                'Tahoma'=>''
            );
}


function st_shortcode_attr($array){
    if(!is_array($array)){
        return '';
    }
     $attr = array();
     foreach($array as $k=> $v){
        if(is_array($v)){
            $attr[] = $k.'="'.htmlspecialchars(join(',',$v)).'"';
        }else{
            $attr[] = $k.'="'.htmlspecialchars($v).'"';
        }
        
     }
     
      return join(' ',$attr);
}

/**
 * Return number
*/
function  st_get_paging_in_home(){
       global $wp_rewrite;
       if($wp_rewrite->permalink_structure!=''){
             @preg_match('/^(.*?)page\/([0-9]+)\/?$/',$_SERVER['REQUEST_URI'],$matches);
             if(isset($matches[2])){
                 return $matches[2];
             }
       }
       return 1;
} 

