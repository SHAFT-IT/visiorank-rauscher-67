<?php
/** ******************** Shorcode for page builder******************************** */
function st_blog_post_func( $atts, $content='' ) {
    
	extract( shortcode_atts( array(
		'title' => '',
		'cats' => array(),
        'numpost'=>5,
        'include'=>'',
        'exclude'=>'',
        'orderby'=>'ID',
        'order'=>'DESC',
        'pbwith'=>'1_1',
        'type'=>1,
        'show_title'=>'n',
        'show_paging'=>'n'
	), $atts ) );
    
    $wc = $pbwith;
     $w=  explode('_',$wc);
     $t = intval($w[0]);
     $m = intval($w[1]);
     
     if($m>0 and $t>0){
         $c = $t/$m;
     }else{
        $c=1;
     }

    global $post , $paged;
    
        $tmp_post = $post;
        $html = $cat_link ='';
        
        // just only for one cate
        //$cats =  $cats[0];


    $cat_link='';
    $args = array( 'posts_per_page' => $numpost );
    if ($include != '') {
        $include = explode(',', $include);
        $args['post__in'] = $include;
    }else {

        $list_cate = $cats;
        $cats =  (is_array($cats)) ? $cats[0]  : intval($cats);

        if($cats>0){
            $cat_link = get_category_link($cats);
            $cat_title = get_cat_name($cats);
        }else{
            // do some thing
        }

        if($list_cate>0){
            // $args['category__in'] =  array($cats);
            $args['category__in'] =  explode(',', $list_cate);

        }

    }


    if($show_title =='y' and $title!=''){
        //   $html .='<h1 class="st-category-heading blog-post">'.esc_html($title).'</h1>';
        if($cat_link!=''){
            $html ='<h1 class="st-category-heading"><a href="'.$cat_link.'" >'.esc_html($title).'</a></h1>';
        }else{
            $html ='<h1 class="st-category-heading">'.esc_html($title).'</h1>';
        }

    }else{
        if($cat_link!=''){
            $html ='<h1 class="st-category-heading"><a href="'.$cat_link.'" >'.esc_html($cat_title).'</a></h1>';
        }else{
            $html ='<h1 class="st-category-heading">'.esc_html($title).'</h1>';
        }
    }
        
    if($exclude!=''){
        $exclude= explode(',',$exclude);
    }
        
    $args['post__not_in'] = $exclude;
    $args['orderby'] = $orderby;
    $args['order'] = $order;

    $page_num = 1;

    // ver 1.4
    if($show_paging=='y'){
        if($paged>0){
             $page_num =  $paged;
        }else{
            $page_num  = $paged = intval($_REQUEST['paged']);
        }
        // try get page if page <=1
        if($page_num<=1){
            $page_num = $paged = st_get_paging_in_home();
        }
    }

    if($page_num<=0){
         $page_num = 1;
    }
        
        $args['paged'] =  $page_num;

        // added in ver 1.3
        if(st_is_wpml()){
          $args['sippress_filters'] = true;
          $args['language'] = get_bloginfo('language');
         }

         $new_query = new WP_Query($args);
         $myposts =  $new_query->posts;
        
        $i = 0;
        if($type == 2){
                
        }
        
        $e = '';
        $c =0;
        if($type==3 && count($myposts)%2!=0){
            $myposts[] =  false;
        }

        //$tpl = ST_DIR.'/templates/loop/loop-post.php';
       $tpl = st_get_theme_template('loop/loop-post.php');

        foreach( $myposts as $post ) : setup_postdata($post);
         //$class=get_post_class();
         if($type==3){
            if($c==0){
                $e.='<div class="row">';
                $e.='<div class="six columns">'.st_get_content($tpl,$post,array('display_type'=>$type,'i'=>$i)).'</div>';
                $c++;
            }else{
                
                $e.='<div class="six columns">'.st_get_content($tpl,$post,array('display_type'=>$type,'i'=>$i)).'</div>';
                $e.='<div class="clear"></div></div>';
            
               $c=0;
            }
         }else{
            $e.=st_get_content($tpl,$post,array('display_type'=>$type,'i'=>$i));
         }
         
        $i++;
        endforeach; 
      
       wp_reset_postdata();
      
        $html .=$e;
        $p ='';
        
        
         if($show_paging=='y'){
                 $p= st_post_pagination($new_query->max_num_pages,2,false);
                  if($p!=''){
                      $p = '<div class="pagination text-center t0 shortcode">'.$p.'</div>';
                  }
               } 
        
        
           
  return '<div class="blog-wrap blog-type-'.$type.'">'.do_shortcode($html).$p.'</div>';
}


add_shortcode( 'blog_post', 'st_blog_post_func' );




function st_img_func( $atts, $caption='' ) {
    
	extract( shortcode_atts( array(
		'img_id' => 0,
		'title' => array(),
        'url'=>''
	), $atts ) );
    
    extract($atts);
    
    $attachment=wp_get_attachment_image_src($img_id, array(400,200));
    
    $html_format ='<div class="gird-box"> %1$s </div>';
    $img = '<img src="'.$attachment[0].'" alt="'.esc_attr($title).'">';
    
    
    if($url!=''){
      
        $a = '<a href="'.esc_attr($url).'" title="'.esc_attr($title).'"> %1$s </a>';
        $img = sprintf($a,$img);
    }else{
        $a =' %1$s  ';
    }
    
    if($title!=''){
         $title ='<h4 class="im-title">'.sprintf($a,esc_html($title)).'</h4>';
    }
    
    if($caption!=''){
        $caption ='<div class="caption">'.esc_html($caption).'</div>';
    }
    
    
    return  sprintf($html_format, $img.$title .$caption);
    
    
 }

add_shortcode( 'st_img', 'st_img_func' );


function st_widget_func( $atts, $caption='' ){
    
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
    
    if($id==''){
        return '';
    }
    return st_get_content_from_func('dynamic_sidebar',$id);
    
}

add_shortcode( 'st_widget', 'st_widget_func' );

/** ======================================== EDITOR SHORTCODE =============================================== */
function st_heading_shortcode($number,$atts,$content=''){
    	extract( shortcode_atts( array(
        'class'=>''
	), $atts ) );
    if($class==''){
        $class ='st-h1';
    }else{
        $class  ='st-h1 '.$class;
    }
    return  '<h'.$number.' class="'.esc_attr($class).'">'.$content.'</h'.$number.'>';
}
function st_h1_func($atts, $content='' ){
    return st_heading_shortcode(1,$atts,$content);
}
add_shortcode( 'h1', 'st_h1_func' );
///===
function st_h2_func($atts, $content='' ){
	return st_heading_shortcode(2,$atts,$content);
}
add_shortcode( 'h2', 'st_h2_func' );
///===
function st_h3_func($atts, $content='' ){
	return st_heading_shortcode(3,$atts,$content);
}
add_shortcode( 'h3', 'st_h3_func' );

///===
function st_h4_func($atts, $content='' ){
	return st_heading_shortcode(4,$atts,$content);
}
add_shortcode( 'h4', 'st_h4_func' );

///===
function st_h5_func($atts, $content='' ){
	return st_heading_shortcode(5,$atts,$content);
}
add_shortcode( 'h5', 'st_h5_func' );

///===
function st_h6_func($atts, $content='' ){
	return st_heading_shortcode(6,$atts,$content);
}
add_shortcode( 'h6', 'st_h6_func' );

// buttons
function st_button_func( $atts, $content='' ){
    
	extract( shortcode_atts( array(
		'type' => '',
        'color'=>'',
        'link'=>'',
        'target'=>'',
        'rounded'=>0,
	), $atts ) );
    $class=' color';
    if($type){
        $class.=' '.$type;
    }
     if($color){
        $class.=' '.$color;
    }
    if(intval($rounded)>0){
        $class.=' rounded';
    }
    
    if($target!=''){
        $target = ' target="'.esc_attr($target).'" ';
    }
    
   if(trim($link)==''){
        return '<button class="btn'.esc_attr($class).'">'.$content.'</button>';
   }else{
        return '<a class="btn'.esc_attr($class).'" '.$target.' href="'.$link.'">'.$content.'</a>';
   }
    
}

add_shortcode( 'button', 'st_button_func' );

// for columns and rows
function st_row( $atts, $content='' ){
    extract( shortcode_atts( array(
		'class' => '',
        'id'=>'',
	), $atts ) );
    $attr ='';
    
    if($id!=''){
        $attr.' id="'.esc_attr($id).'" ';
    }
    if($class!=''){
        $class .='row '.$class;
    }else{
        $class ='row';
    }
    
    $attr.=' class="'.esc_attr($class).'"';
    
    return  '<div class="row-wrapper row-column"><div '.$attr.'>'.do_shortcode($content).' <div class="clear"></div> </div> </div>';
    
}
add_shortcode( 'row', 'st_row' );


// for columns and rows
function st_col( $atts, $content='' ){
    extract( shortcode_atts( array(
		'class' => '',
        'id'=>'',
        'width'=>''
	), $atts ) );
    $attr ='';
    
    if($id!=''){
        $attr.' id="'.esc_attr($id).'" ';
    }
    if($class!=''){
        $class .='columns '.$class;
    }else{
        $class ='columns';
    }
    if($width!=''){
        $class =$width.' '.$class;
    }else{
         $class =$width.' twelve';
    }
    
    $attr.=' class="'.esc_attr($class).'"';
    
    return  '<div '.$attr.'>'.do_shortcode($content).'</div>';
    
}
add_shortcode( 'col', 'st_col' );
// other shortcode
function st_clear_func($atts, $content='' ){
	return '<div class="clear"></div>';
}
add_shortcode( 'clear', 'st_clear_func' );

function st_divider_func($atts, $content='' ){
	return '<div class="divider-1"></div>';
}
add_shortcode( 'divider', 'st_divider_func' );


function st_space_func($atts, $content='' ){
    
    if(intval($atts['height'])>0){
        $style = ' style="height: '.intval($atts['height']).'px; display: block;" ';
    }else{
        $style ='';
    }
	return '<div '.$style.' class="space"></div>';
}
add_shortcode( 'space', 'st_space_func' );


// for video 
function st_video_func($atts, $content='' ){
    $link = $atts['link'];
    if($link==''){
        return '';
    }else{
        return st_get_video($link);
    }
   
}
add_shortcode( 'video', 'st_video_func' );


// for  Accordion
function st_accordion_func($atts, $content=''){
    $class= $atts['class'];
    if($class==''){
        $class = 'st-accordion';
    }else{
        $class ='st-accordion '.$class;
    }
    return  '<ul class="'.esc_attr($class).'">'.do_shortcode($content).'</ul>';
    
}

function st_accordion_item_func($atts, $content=''){
    
    	extract( shortcode_atts( array(
		'title' => '',
	), $atts ) );
    
    $title ='<h3 class="acc-title">'.esc_html($title).'<i class="ui-icon icon-chevron-down"></i></h3>';
    
    return  '<li class="'.esc_attr($class).'">'.$title.'
    <div class="acc-content" style="display: none;"><div class="txt-content">'.do_shortcode($content).'</div></div>
    </li>';
    
}
add_shortcode( 'accordion', 'st_accordion_func' );
add_shortcode( 'accordion_item', 'st_accordion_item_func' );

// for  Toggle
function st_toggle_func($atts, $content=''){
    $class= $atts['class'];
    if($class==''){
        $class = 'st-toggle';
    }else{
        $class ='st-toggle '.$class;
    }
    return  '<ul class="'.esc_attr($class).'">'.do_shortcode($content).'</ul>';
    
}

function st_toggle_item_func($atts, $content=''){
    
    	extract( shortcode_atts( array(
		'title' => '',
	), $atts ) );
    
    $title ='<h3 class="toggle-title">'.esc_html($title).'<i class="icon-plus"></i><i class="icon icon-minus"></i></h3>';
    
    return  '<li class="'.esc_attr($class).'">'.$title.'
    <div class="toggle-content" style="display: none;"><div class="txt-content">'.do_shortcode($content).'</div></div>
    </li>';
    
}
add_shortcode( 'toggle', 'st_toggle_func' );
add_shortcode( 'toggle_item', 'st_toggle_item_func' );

// for tabs

function st_do_shortcode($content, $autop = FALSE) 
{ 
	/*$content = do_shortcode( shortcode_unautop( $content ) ); 
	$content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);*/
	
	$content = do_shortcode( $content ); 
	
	if ( $autop ) {
		//$content = wpautop($content);
	}
	
	return $content;
}


function st_tabs_func($atts, $content = null)
{	
	extract(shortcode_atts(array(
		'position' => ''
	), $atts));
	
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	}
	else
	{
		for ($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		
		$tabs_post = ( $position == 'left' ) ? 'tabs-left' : '';
		
		$out = '<div class="st-tabs '. $tabs_post .'">';
		
		$out.= '<ul class="tab-title">';
		for ($i = 0; $i < count($matches[0]); $i++) {
			$out.= '<li tab-id="tab-'. $i .'"><span>'. $matches[3][$i]['title'] .'</a></li>';
		}
		$out.= '</ul>';
		
		$out.= '<div class="tab-content-wrapper">';
		for ($i = 0; $i < count($matches[0]); $i++) {
			$out.= '<div id="tab-'. $i .'" class="tab-content"><div class="txt-content">'. st_do_shortcode(trim($matches[5][$i]), TRUE) .'</div></div>';
		}
		$out.= '</div>';
		
		$out.= '</div>';
		
		return $out;
	}
}
add_shortcode('tabs', 'st_tabs_func');



function st_shortcode_slider($atts, $content = null){
    return st_get_content_from_func('st_slider',st_get_setup_post_slider_data($atts), array('class'=>'posts-slider'));
}
add_shortcode('st_slider', 'st_shortcode_slider');


function st_shortcode_carousel($atts, $content = null){
    return st_get_content_from_func('st_carousel',st_get_setup_post_slider_data($atts), array('class'=>'posts-carousel'));
}
add_shortcode('st_carousel', 'st_shortcode_carousel');




function  st_shorcode_alert_func($atts,$content =''){

    extract(shortcode_atts(array(
		'alert_type' => ''
	), $atts));
    
  
   
   
    
    if($alert_type!=''){
        $alert_type =' alert-'.$alert_type;
    }
    $html  = '<div class="alert'.$alert_type.'"><button type="button" class="close">'.esc_html(__('&#215;','magazon')).'</button>'.do_shortcode($content).'<div class="clear"></div></div>';
    return $html;
    
}

add_shortcode('alert', 'st_shorcode_alert_func');

