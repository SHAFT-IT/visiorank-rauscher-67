<?php

/**
 * Get template by file ma,e
 * @param $filename file name in folder /st-framework/templates/
 * @return false if file not exists string aother case
 * @since 2.6
 */
function st_get_theme_template($filename=''){
    $tpl = ST_TEMPLATE_DIR.$filename;

    if(is_child_theme() ){
        if(is_file(ST_CHILD_TEMPLATE_DIR.$filename)){
            $tpl = ST_CHILD_TEMPLATE_DIR.$filename;
        }
    }

    if(is_file($tpl)){
        return $tpl;
    }
    return false;

}


/**
 * Include current template for  layout
*/
function st_page_template(){
     $default = 'list-post';
    if(is_singular()){
        if(is_page()){
           $file = 'page';
          }else{
            $file = 'single';
          }
       }elseif(is_author()){
           $file = 'author';
       }elseif(is_tag()){
            $file = 'tag';
       }elseif(is_tax()){
             $file = 'taxonomy';
       }elseif( (is_archive() || is_day() || is_date() || is_month() || is_year() || is_time()) && !is_category() ){
             $file = 'archive';
       }elseif(is_search() ){
             $file = 'search';
       }elseif(is_404() ){
             $file = '404';
       }

       $tpl = st_get_theme_template($file.'.php');

       if(!empty($file) && file_exists($tpl)){
            include($tpl);
       }else{
            $tpl = st_get_theme_template($default.'.php');
           if($tpl!==false){
               include($tpl);
           }else{
               include(ST_TEMPLATE_DIR.$default.'.php');
           }

       }   
}
/**
 * hook : st_page_template
*/
add_action('st_page_template','st_page_template');


/**
 * display sidebar depend each page
 */ 
function st_sidebar($sidebar ='',$positon ='right'){
    $sidebar ;
    
    $afterfix ='_r';
     if(strtolower($positon)=='left'){
        $afterfix='_l';
     }
    
    if(empty($sidebar)){
        // sidebar for tax
        if(is_category()|| is_tax() || is_tag()){
            $term = get_queried_object();
            $term_meta = get_option( "st_tax_meta_{$term->term_id}");
            if(!empty($term_meta['tax_sidebar'])){
                 $sidebar = $term_meta['tax_sidebar'];
            }
           
        }elseif(is_search()){
            $sidebar = st_get_setting("sidebar_search");
        }
    }
    
    if(empty($sidebar)){
       
        $sidebar  = st_get_setting('sidebar_'.$afterfix);
         // echo var_dump($sidebar);
    }
    
     if(empty($sidebar)){
        $sidebar = 'sidebar_default'.$afterfix;
     }
   
    do_action('st_before_sidebar'.$afterfix,$sidebar);
    dynamic_sidebar($sidebar); 
    do_action('st_atter_sidebar'.$afterfix,$sidebar);
}
/**
 * hook st_sidebar
 */ 
add_action('st_sidebar','st_sidebar',10,2);

function st_page_carousel(){
    if(is_singular()|| is_page()){
         global $post;
         $st_page_builder = get_page_builder_options($post->ID);
          //echo var_dump($st_page_builder['carousel_cates']);
          if(isset($st_page_builder) && $st_page_builder){
              if(!isset($st_page_builder['page_options']['carousel'])){
                $st_page_builder['page_options']['carousel'] ='';
              }
              if(isset($st_page_builder['page_options']['carousel']) && $st_page_builder['page_options']['carousel']==1){
                   $data = st_get_setup_post_slider_data($st_page_builder['carousel_data']);
                   // echo var_dump($data
                       st_carousel($data);
              }  
          
          }
           
    }
    return;
}

function st_tax_slider(){
    if( is_category() || is_tax()|| is_tag()){ 
         global $cat;
         $tax = get_queried_object();
        $tax_meta = get_option('st_tax_meta_'.$tax->term_id);
        if(!empty($tax_meta['enable_slider']) && $tax_meta['enable_slider']=='y'){
             $tax_meta['cats'][] = $cat;
              //echo var_dump($tax_meta);
              $slider_data = st_get_setup_post_slider_data($tax_meta);
              if($tax_meta['slider_type']=='s'){
                    st_slider($slider_data,array('class'=>'tax-slider b30'));
              }else{
                    st_carousel($slider_data,array('class'=>'tax-carousel'));
              }
        }  
    }
}

function st_tax_slider_postion(){
   
    if( is_category() || is_tax()|| is_tag()){ 
         $tax = get_queried_object();
        $tax_meta = get_option('st_tax_meta_'.$tax->term_id);
        if(!empty($tax_meta['slider_type']) && $tax_meta['slider_type']=='s'){
             add_action('st_before_page_template','st_tax_slider');
        }else{
             add_action('st_before_layout','st_tax_slider');
        }
    }
    
}
add_action('st_theme_init','st_tax_slider_postion');
// add carousel for page
add_action('st_before_layout','st_page_carousel');



function st_get_fexSlider_settings(){
    $default_settings = array();
    $default_settings['animation'] = st_get_setting('flex_animation','slide');
    $default_settings['animationLoop'] = st_get_setting('flex_animation','true');
    $default_settings['minItems'] = st_get_setting('flex_minItems',1);
    $default_settings['maxItems'] = st_get_setting('flex_maxItems',3);
    $default_settings['controlNav'] = st_get_setting('flex_controlNav','false');
    $default_settings['move'] = st_get_setting('flex_move',1);
    $default_settings['slideshow'] = st_get_setting('flex_slideshow','true');
    $default_settings['slideshowSpeed'] = st_get_setting('flex_slideshowSpeed',7000);
    $default_settings['animationSpeed'] = st_get_setting('flex_animationSpeed',6000);
    $default_settings['pauseOnHover'] = st_get_setting('flex_pauseOnHover','true');
    $default_settings['randomize'] = st_get_setting('flex_randomize','false');
    $default_settings['smoothHeight'] = st_get_setting('flex_smoothHeight','false');;
    return $default_settings;
}



/**
 * Return laoyout file by number
*/
function st_get_layout($number=3){
    
    switch(intval($number)){
        case  4 : 
            $l = 'layout-left-right-sidebar';
        break;
          case  3 : 
            $l =  'layout-left-sidebar';
        break;
        case  2 : 
            $l =  'layout-right-sidebar';
        break;
        case  1 : 
            $l =  'layout-no-sidebar';
        break;
        default :
          $l = 'layout-right-sidebar';
  }
  
  return  apply_filters('st_get_layout',$l,$number);
}

/**
 *  display slider
 */ 
function st_slider($data,$settings = array()){
    if(empty($data['images'])){
        return '';
    }
    $images = $data['images'];
    $metas = $data['meta'];
    $id =  'slider-'.uniqid();
    if(isset($settings['class']) && $settings['class']){
        $settings['class'] = ' '.trim($settings['class']);
    }else{
        $settings['class'] ='';
    }
    ?>
    <div class="row clearfix<?php echo $settings['class']; ?>">
    <div class="post-slider twelve columns b0">
    
    <div id="<?php echo $id; ?>" class="inside-post-slider flexslider">
        <ul class="slides">
            <?php
            foreach($images as $n=> $img_id){
                $col = array();
               // $col['img'] = $img_id;
                $meta  = $metas[$n];
                $attachment=wp_get_attachment_image_src($img_id, 'st_normal_thumb');
                
                $item = '<li> %1$s </li>';
                $img = sprintf('<img src="%1$s" alt="" />',$attachment[0]);
                if(isset($meta['url']) && $meta['url']!=''){
                        $img ='<a href="'.$meta['url'].'">'.$img.'</a></h3>';
                }
                
                $caption ='';
              
              if(isset($settings['show_caption']) && strtolower($settings['show_caption'])=='no'){
                
              }else{
                 if($meta['title']!='' || $meta['caption']!='' ){
                    if($meta['url']!=''){
                        $title ='<h3><a href="'.$meta['url'].'">'.esc_html($meta['title']).'</a></h3>';
                    }else{
                         $title = '<h3>'.esc_html($meta['title']).'</h3>';
                    }
                  if($meta['caption']!=''){
                     $caption = '
                        <div class="flex-caption">
                                    '.$title.'
                                   <div class="caption">'.balanceTags($meta['caption']).'</div>
                        </div>';
                  }else{
                      $caption = '
                        <div class="flex-caption">
                                    '.$title.'
                        </div>';
                  }

                }
                 
              }
               $item = sprintf($item, $img.$caption); 
               echo  apply_filters('st_slider_item',$item,$img_id,$meta);    
            }
            ?>
        </ul>
    </div><!-- inside-post-slider -->
    </div><div class="clear"></div>
    </div>
   <?php  
$sider_settings = array();

$default_setting =  st_get_fexSlider_settings();

$settings = array_merge($default_setting,$settings);

unset($settings['class']);

if(empty($settings['flexSlider'])){
    $settings['flexSlider'] = array();
}


if( !empty($settings['animation'])){
    $sider_settings['animation'] = '"'.$settings['animation'].'"';
}else{
    $sider_settings['animation']='"slide"';
}

if( !empty($settings['animationLoop']) && $settings['animationLoop']!='false' && ( $settings['animationLoop']==1 || $settings['animationLoop']=='y'  ||  $settings['animationLoop']=='true' || $settings['animationLoop']== true) ){
    $sider_settings['animationLoop']  ='true';
}else{
    $sider_settings['animationLoop']  ='false';
}

if(!empty($settings['pauseOnHover'])  && $settings['pauseOnHover']!='false' && ($settings['pauseOnHover']==1 || $settings['pauseOnHover']=='y'  || $settings['pauseOnHover']=='true' ||  $settings['pauseOnHover']== true )){
    $sider_settings['pauseOnHover']  ='true';
}else{
    $sider_settings['pauseOnHover']  ='false';
}


if(!empty($settings['minItems']) && intval($settings['minItems'])>0){
    $sider_settings['minItems']  =intval($settings['minItems']);
}else{
   $sider_settings['minItems'] =1;
}


if(!empty($settings['maxItems']) && intval($settings['maxItems'])>1){
    $sider_settings['maxItems']  =intval($settings['maxItems']);
}else{
   $sider_settings['maxItems'] = 3;
}


if(!empty($settings['move']) && intval($settings['move'])>0){
    $sider_settings['move']  =intval($settings['move']);
}else{
   $sider_settings['move'] =1;
}

if( !empty($settings['controlNav'])  && $settings['controlNav'] !='false' && (  $settings['controlNav']==1 ||$settings['controlNav']=='y' || $settings['controlNav'] ='true' || $settings['controlNav']== true) ){
    $sider_settings['controlNav']  ='true';
}else{
    $sider_settings['controlNav']  ='false';
}

if(!empty($settings['slideshow']) && $settings['slideshow']!='false' && (  $settings['slideshow']==1 || $settings['slideshow']=='y' ||  $settings['slideshow'] =='true' || $settings['slideshow']== true) ) {
    $sider_settings['slideshow']  ='true';
}else{
    $sider_settings['slideshow']  ='false';
}

if(!empty($settings['slideshowSpeed']) && intval($settings['slideshowSpeed'])>0 ){
    $sider_settings['slideshowSpeed']  = intval($settings['slideshowSpeed']);
}else{
  //  $sider_settings['slideshowSpeed']  ='700';
    unset($sider_settings['slideshowSpeed']);
}

if( !empty($settings['smoothHeight']) && $settings['smoothHeight']!='false' && ( $settings['smoothHeight']==1 || $settings['animationLoop']=='y'  ||  $settings['animationLoop']=='true' || $settings['smoothHeight']== true) ){
    $sider_settings['smoothHeight']  ='true';
}else{
   // $sider_settings['smoothHeight']  ='false';
   unset($sider_settings['smoothHeight']);
}

//$sider_settings['smoothHeight'] ='true';

//intval($sider_settings['class']);

    foreach($sider_settings as $k=> $v){
        $sider_settings[$k] = $k.': '.$v;  
    }
 ?>
    <script type="text/javascript">
     jQuery(document).ready(function(){
        jQuery('#<?php echo $id; ?>').flexslider({
        <?php  
           echo join(",\n",$sider_settings);
        ?>
        });
     });
    </script>
    
    <?php 
}


/**
 *  display slider
 */ 
function st_carousel($data,$settings = array()){
    if(empty($data['images'])){
        return '';
    }
    $images = $data['images'];

    $metas = $data['meta'];
    $id =  'carousel-'.uniqid();
    $class= esc_attr($settings['class']);
    if($class!=''){
        $class = ' '.$class;
    }
    
    $date ='';
    ?>
    
    <div id="<?php echo $id; ?>" class="carousel-wrapper twelve columns b0<?php echo $class; ?>">
    <div class="row">
        <ul class="carousel-slide clearfix">
            <?php
            foreach($images as $n=> $img_id){
                $col = array();
               // $col['img'] = $img_id;
                $meta  = $metas[$n];
                $attachment=wp_get_attachment_image_src($img_id, 'st_medium_thumb');
              
                $item = '<li class="four columns"> <div class="carousel-data-wrapper"> %1$s </div></li>';
                
                
                if($meta['url']!=''){
                     $img ='<div class="carousel-thumb"><a title="Permalink to '.esc_html($meta['title']).'" href="'.$meta['url'].'"><img src="'.$attachment[0].'" alt="" /></a><div class="carousel-post-meta">'.esc_html($meta['date']).'</div></div>';
                  }else{
                     $img ='<div class="carousel-thumb"<img src="'.$attachment[0].'" alt="" /><div class="carousel-post-meta">'.esc_html($meta['date']).'</div></div>';
                  }
                
               
                
                $caption ='';
              
               if($meta['title']!='' || $meta['caption']!='' ){
                  if($meta['url']!=''){
                     $title ='<a title="Permalink to '.esc_html($meta['title']).'" href="'.$meta['url'].'">'.esc_html($meta['title']).'</a>';
                  }else{
                    $title = esc_html($meta['title']);
                  }
                  
                  
                  $caption = sprintf('
                    
                                %2$s
                                %1$s
                                %3$s
                    ','<h2 class="carousel-post-title">'.$title.'</h2>',$date,'');
                    
               } 
               
               $item = sprintf($item, $img.$caption); 
               echo  apply_filters('st_slider_item',$item,$img_id,$meta);    
            }
            ?>
        </ul>
    <div class="carousel-nav-wrap">
      <a class="carousel-prev" href="#" style=""><i class="icon-angle-left"></i></a>
      <a class="carousel-next" href="#" style=""><i class="icon-angle-right"></i></a>
    </div>
   </div>
   </div>
   <div class="clear"></div>
   <script type="text/javascript">
   jQuery(document).ready(function(){
    
    function runCarousel() {
    jQuery('#<?php echo $id; ?> .carousel-slide').carouFredSel({
        responsive: true,
        prev: '#<?php echo $id; ?> .carousel-prev',
        next: '#<?php echo $id; ?> .carousel-next',

        circular: true,
        infinite: false,
        auto: {
            play : true,
            pauseDuration: 0,
            duration: 1000   },
        scroll: {
            items: 1,
            duration: 400,
            wipe: true
        },
        items: {
            visible: {
                min: 2,
                max: 3  },
            width: 390,
            height: 'variable'
        },
        onCreate : function (){
            jQuery('#<?php echo $id; ?>').css( {
                'height': 'variable',
                'visibility' : 'visible'
            });
        },
        onWindowResize : function(){
           jQuery('#<?php echo $id; ?>').css( {
                'height': 'variable',
                'visibility' : 'visible'
            });
        }
    });

    } // END runCarousel

    // Call Carousel when images are Loaded.
    jQuery('#<?php echo $id; ?> .carousel-slide').imagesLoaded(runCarousel); 


   });
   </script>

 <?php
}

/** 
 * Display review box in the content
*/
function st_show_review($data){

    $data = wp_parse_args($data,array(
        'enable'=>'', 'type'=>'','postion'=>'', 'title'=>'','r_desc'=>'','r_body'=>'','r_thing'=>'',
        'ratting_data'=>array()
                
    ));
    
    if($data['enable']!=1){
        return '';
    }
 
    $data['type'] = trim(strtolower($data['type']));
    
    $page_link = get_permalink($data['post_id']);
    
    $p='';
    switch(strtolower($data['postion'])){
        case 'tl' : case 'bl':
         $p ='left';
        break;
        case 'tr' : case 'br':
          $p ='right';
        break;
        default:
          $p = 'full';
    }
    
    if($data['type']=='s'){
        $p .=' review-stars';
    }
	
	
    ?>
    <div class="review-box-wrapper review-<?php echo $p; ?>"  >
        <div class="review-title"><?php echo $data['title']; ?></div>
        <?php if(!empty($data['ratting_data']['label'])):
        $total =0;
        $n=0;
         ?>
        <ul>
        <?php
          foreach($data['ratting_data']['label']  as $i => $label):
             
              if( ( empty($label) &&  empty($data['ratting_data']['score'][$i]) )  || ($label==''  && $data['ratting_data']['score'][$i]=='') ){
                 continue;
              }
              $score  = floatval($data['ratting_data']['score'][$i]);
              $total += $score;
              $n++;
              ?>
            <li>
          
               <?php if($data['type']!='s'): ?>
                <div class="review-score-detail clearfix">
                    <span class="left"><?php echo esc_html($label); ?></span>
                    <span class="right"><?php echo $score;  echo ($data['type']=='p') ? '%' : ""; ?></span>
                </div>
                <div class="review-score-under">
                    <div style="width:<?php echo $score; ?>%;" class="review-score-over"></div>
                </div>
                <?php else: ?>
                <div class="review-score-detail clearfix">
                
                    <span class="left"><?php echo esc_html($label); ?></span>
                    <span class="right">
                        <span class="ratting-star-under">
                            <span class="ratting-star-over" style="width:<?php echo $score; ?>%;"></span>
                        </span>
                    </span>
                </div>
               <?php endif; ?> 
            </li>
           <?php 
           endforeach; 
          ?>  
        </ul>
        <?php   endif; ?>
        
        
        <div class="review-total-score-wrapper clearfix">
            <span class="left total-text"><?php echo $data['score_label']; ?></span>
            <span class="right total-score">
            <?php
            $n = $n > 0 ? $n : 1;
              if($data['type']!='s'){
                
                if($data['type']=='p'){
                      echo round($total/$n,2).'%';
                }else{
                     echo $total; 
                }
                
              }else{
                if($n>0){
                     $pc = round($total/$n,2);
                }else{
                    $pc = 0;
                }
                ?>
                <span class="ratting-star-under">
                    <span class="ratting-star-over" style="width:<?php echo $pc; ?>%;"></span>
                </span>
                <?php
              }
            ?></span>
        </div>
 
    </div>
    
    <?php
   
   
     $post_id = $data['post_id'];
	 $title = get_the_title();
	 
	 $author=  get_the_author();
	 
	 //$excerpt = get_the_excerpt();
	 
	 $p = get_post( $post_id );

     $excerpt = ( $p->post_excerpt ) ? $p->post_excerpt :  wp_trim_words($p->post_content, 40 );


	 if($data['r_body']==''){
	 	$data['r_body'] = $excerpt;
	 }
	 
     if($data['r_desc']==''){
	 	$data['r_desc'] =$excerpt;
	 }
	 
    if($data['r_thing']==''){
	 	$data['r_thing']=  $title;
	 }
	 
	
     ?>
    
    <div class="schema-microdata" style="display: none;">
	    <div itemscope itemtype="http://schema.org/Review">
			<meta itemprop="name" content="<?php echo esc_attr($title); ?>">
			<meta itemprop="description" content="<?php echo esc_attr(stripslashes($data['r_desc'])); ?>">
			<meta itemprop="reviewBody" content="<?php echo esc_attr(stripslashes($data['r_body'])); ?>">
			<div itemprop="author" itemscope itemtype="http://schema.org/Person">
				 <meta itemprop="name" content="<?php echo esc_html($author); ?>">
			</div>
			<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">	
				<meta itemprop="name" content="<?php echo esc_attr(stripslashes($data['r_thing'])); ?>">
			</div>
		   <meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date()); ?>">
			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
				<?php 
				if($data['type']=='s'){
					// convert to star
					$star =  round($total/$n,2);
					$star =  round(($star*5)/100, 2); // max 5 star
					?>
					<meta itemprop="worstRating" content="0">
					<meta itemprop="ratingValue" content="<?php echo $star; ?>">
					<meta itemprop="bestRating" content="5">
					<?php
				}elseif($data['type']=='p'){ // review percent
					?>
					<meta itemprop="worstRating" content="0">
					<meta itemprop="ratingValue" content="<?php echo round($total/$n,2); ?>">
					<meta itemprop="bestRating" content="100">
					<?php
				}else{ // review number
				 	?>
					<meta itemprop="worstRating" content="0">
					<meta itemprop="ratingValue" content="<?php echo $total;  ?>">
					<meta itemprop="bestRating" content="<?php echo ($n*100); ?>">
					<?php 
				} ?>
			</div>
		</div>
   </div>
    <?php
   

}
  
 /**
  * Add review box to content
  */  
function st_add_box_content($content=''){
    global $post;
    $data = get_post_meta($post->ID,'st_page_review',true);
    if(!isset($data) || !isset($data['enable']) || $data['enable']!=1 ){  
        return $content;
    }
    
    $data['post_id'] = $post->ID ;
    
    $box_content = st_get_content_from_func('st_show_review',$data);
    if(!isset($data['postion'])){
        $data['postion'] ='';
    }
    
    switch(strtolower($data['postion'])) {
        case 'bl' : case 'b': case 'br':
             $content = $content.$box_content;
        break;
        default:
            $content = $box_content.$content;
    }
    
    return $content;
}
add_filter('the_content','st_add_box_content',99,1);


// this is call back for comments
function st_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" class="comment-item">
     
      <div class="comment-header">
      
        <?php echo get_avatar($comment->comment_author_email,$size='60',$default='' ); ?>
    
      <div class="comment-header-right">
            <p class="comment-date"><?php printf(__('%1$s','magazon'), get_comment_date()); ?></p>
            <a href="#" class="comment-author"><?php printf(__('<b class="author_name">%s</b>'), get_comment_author_link()) ?></a>
            <?php edit_comment_link(__('(Edit)','magazon'),'  ','') ?>
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
      
        <div class="clear"></div>
      </div>
      
      <div class="clear"></div>
      
      <div class='comment-content'>
          <?php comment_text() ?>
          <?php if ($comment->comment_approved == '0') : ?>
            <br /> <em><?php _e('Your comment is awaiting moderation.','magazon') ?></em>
          <?php endif; ?>

      </div>
     </div>
<?php
}



/**
 * parse Font
 * @return array
*/
function st_parse_font($font_url){
    $font_url  = urldecode($font_url);
    $args =  parse_url($font_url);
    $return = array('is_g_font'=> false, 'name'=>$font_url,'link'=>'');
    
    $args = wp_parse_args($args, array(
        'host'=>'',
        'query'=>''
    ));
    
    $font_data = wp_parse_args($args['query'], array('family'=>'','subset'=>''));
    
    if($args['host']=='fonts.googleapis.com' && $font_data['family']!='' ){
      //  echo var_dump($args) ; die();
        
        if(strpos($font_data['family'],':')!==false){
            $font_data['family'] = explode(':',$font_data['family']);
            $font_data['family'] =  (isset($font_data['family'][0])  && $font_data['family'][0]!='') ? $font_data['family'][0]  : '';
        }else{
            
        }
        
        if($font_data['family']!=''){
            $return['name'] = $font_data['family'];
              $return['is_g_font'] = true;
              $return['link'] = $font_url;   
        }
    }
        
  return $return;  
}




/**
 * make font style
 * Only use for header.php file
*/
function st_make_font_style($font,$css_selector,$show_font_size= true){
    
  
    
if($font['font-family']!=''){
    $font_data = st_parse_font($font['font-family']);
    
//$is_not_gfont = key_exists($font['font-family'],st_get_normal_fonts()); 
?>
<?php if($font_data['is_g_font']==true) : ?>
<link href='<?php echo  $font_data['link'] ?>' rel='stylesheet' type='text/css'>
<?php endif; ?>

<style type="text/css">

<?php echo $css_selector; ?>{ 
    font-family: '<?php echo $font_data['name']; ?>'; 
    <?php if(isset($font['font-style']) && $font['font-style']): ?>
    font-style: <?php echo $font['font-style']; ?>;
    <?php endif; ?>
    <?php if(isset($font['font-style']) && $font['font-style']): ?>
    font-style: <?php echo $font['font-style']; ?>;
    <?php endif; ?>
    <?php if(isset($font['font-weight']) && $font['font-weight']): ?>
    font-weight: <?php echo $font['font-weight']; ?>;
    <?php endif; ?>
    <?php if(isset($font['font-size']) && $font['font-size']): ?>
    font-size: <?php echo intval($font['font-size']); ?>px;
    <?php endif; ?>
    <?php if(isset($font['line-height']) && $font['line-height']): ?>
    line-height: <?php echo intval($font['line-height']); ?>px;
    <?php endif; ?>
    <?php if(isset($font['font-color'])  && $font['font-color']): ?>
    color: #<?php echo $font['font-color']; ?>;
    <?php endif; ?>
    
}
</style>
<?php
     }
}

/* for tax */

function st_get_tax_parent_meta($parent_id, $tax ='category'){
    if($parent_id>0){
         $term = get_term( $parent_id, $tax);
         if($term->term_id){
             $meta = get_option('st_tax_meta_'.$term->term_id);
              if(( $meta['bg_color']=='' || $meta['bg_img'] ) &&$term->parent > 0 ){
                    return st_get_tax_parent_meta($term->parent,$tax);
               }else{
                 return $meta;
               }
         }else{
            return array();
         }
    }else{
        return array();
    }
    
}


function st_get_tax_meta(){
    if(is_tax() || is_tag() ||  is_category()){
       $tax = get_queried_object();
       $meta = get_option('st_tax_meta_'.$tax->term_id);
       if($meta['bg_color']=='' && $meta['bg_img']==''){
         $p =  ($tax->taxonomy!='') ? $tax->taxonomy.'_parent' : 'parent';
         $pid =  (isset($tax->{$p}) && $tax->{$p} >0 ) ? $tax->{$p} : $tax->parent;
           return st_get_tax_parent_meta(intval($pid),$tax->taxonomy);
       }else{
        return $meta;
       }
    }else{
        return array();
    }
   
}

/** ************* ST Theme ads ********************/
/**
 *  auto add ads to hooks
*/
function st_auto_ads(){
    $ads = st_get_setting("ads");
    if(is_array($ads)){
        foreach($ads as $ad){
            if($ad['hook']!=''&& $ad['content']!=''){
                $ad['content'] = stripslashes($ad['content']);
                 $ad['content']=  str_replace("'","\'",  $ad['content']);
                $new_func = create_function('$c=""',' echo  \''.$ad['content'].'\' ; ');
                add_action($ad['hook'],$new_func);
            }
        }
    }
    
}
st_auto_ads(); // auto run


/**
*/
function st_theme_bg_head(){
// For background settings
 $bd_style= '';
 $bg_color = $bg_img = $bg_positon =$bg_repreat = $bg_fixed ='';
 if(is_tax() || is_tag() ||  is_category()){
    $tax_meta=  st_get_tax_meta();
  // echo var_dump(get_queried_object());

 }elseif(is_single()){
     $categories = get_the_category(); 
     $firt_cat = $categories[0]->term_id;
     $tax_meta = st_get_tax_parent_meta($firt_cat);
 }
 
 if(!empty($tax_meta)){
     $bg_color = $tax_meta['bg_color'];
     $bg_img = $tax_meta['bg_img'];
     $bg_positon = $tax_meta['bg_positon'];
     $bg_repreat = $tax_meta['bg_repreat'];
     $bg_fixed = $tax_meta['bg_fixed'];
 }

 if($bg_color==''){
     $bg_color = st_get_setting("bg_color",'');
 }
 
if($bg_img==''){
    $bg_img =  st_get_setting("bg_img",'');
    $bg_positon = st_get_setting("bg_positon",'');
    $bg_repreat = st_get_setting("bg_repreat",'');
    $bg_fixed = st_get_setting('bg_fixed','n');
}

  if($bg_color!='' ||  $bg_positon!=''){
      if($bg_color!=''){
          $bd_style .= ' #'.$bg_color; 
      }

       if($bg_img!=''){
          $bd_style .= ' url('.$bg_img.') '; 
         
              switch(strtolower($bg_positon)){
                    case 'tl':
                        $bd_style.=' top left ';
                    break;
                    
                    case 'tr':
                        $bd_style.=' top right ';
                    break;
                    
                    case 'tc':
                        $bd_style.=' top center ';
                    break;
                    
                    case 'cc':
                        $bd_style.=' center center';
                    break;
                    case 'bl':
                        $bd_style.=' bottom left ';
                    break;
                     case 'br':
                        $bd_style.=' bottom right ';
                    break;
                     case 'bc':
                        $bd_style.=' bottom center ';
                    break;
              }
              
           switch(strtolower($bg_repreat)){
                    case 'x':
                        $bd_style.=' repeat-x ';
                    break;
                    case 'y':
                        $bd_style.=' repeat-y ';
                    break;
                    case 'n':
                        $bd_style.=' no-repeat ';
                    break;
           }
           
           if($bg_fixed=='y'){
                $bd_style.=' fixed ';
           }
      } 
  }
  
  if($bd_style!=''){
  
     echo '<style type="text/css">body {background: '.$bd_style.'; }</style>';
    
  }

}


function st_theme_font(){
      $font_body = st_get_setting("body_font",array('font-family'=>'Droid Sans'));
      $heading_font = st_get_setting("heading_font",array('font-family'=>'Oswald'));
      $archive_heading_font = st_get_setting("archive_heading_font",array('font-family'=>'Oswald'));

      st_make_font_style($font_body,'body');
      st_make_font_style($heading_font,'.post-title,.widget-post-title');
      st_make_font_style($archive_heading_font,'.st-category-heading,.category .page-title,.search .page-title,.archive .page-title');

     
	 $skin ='';
      
      /**
       * $GLOBALS['_st_color'] is array of  current menu items
       * The first element is color of parent of current menu item depth = 0
       * The last element is color of  
       * @see ST_Walker_Nav_Menu::start_el()
       */ 
      if(!empty($GLOBALS['_st_color'])){
         $skin = end($GLOBALS['_st_color']);
      
      }
	 
	 // get current skin of menu shop
	 if(st_is_woocommerce() && $skin==''){
	 	global $wpdb;
		 $shop_id =   st_get_shop_page();
		 
		 // get shop menu id
		  $sql= "
	  				SELECT `$wpdb->postmeta`.*
					FROM `$wpdb->postmeta` 
					WHERE `$wpdb->postmeta`.`meta_key` = '_menu_item_object_id'
					       AND  `$wpdb->postmeta`.`meta_value` = $shop_id
		  ";
		 $menus = $wpdb->get_results($sql); 
		 $menus=  $menus[0];
		
		 $meta = get_post_meta($menus->post_id,'_color',true);
		 $skin = $meta['color'];
		 
		// echo var_dump($sql);
	 }


      
      if($skin==''){
           // Predefined Colors (pc) - Custom Color (cc)
          $pc   = st_get_setting("predefined_colors");
          $e_cc = st_get_setting("enable_custom_global_skin");
          $cc   =  st_get_setting("custom_global_skin");
            if($pc == ''){
            $skin = '16A1E7';
              } elseif($pc != '' and $e_cc != 'y'){
                    $skin = $pc;
              } elseif( $e_cc == 'y' ){
                if($cc ==''){
                  $skin = '16A1E7';
                } else { $skin = $cc; }
          }
      }
	  
	  
	  
      
    ?>    
    <style type="text/css">
      /************** Predefined Colors ********************/
        .primary-nav ul li a:hover,.primary-nav ul li.current-menu-item > a,.primary-nav ul li a:hover,.primary-nav ul li.current-menu-item > a,.carousel-post-meta,.read-more-button,.list-tabbed li.list-tabbed-active a,table#wp-calendar thead > tr > th,table#wp-calendar td#today,.carousel-wrapper .flex-direction-nav .flex-prev:hover,.carousel-wrapper .flex-direction-nav .flex-next:hover,.subs_submit:hover,.tagcloud a:hover,.author-text b,#submit,.page-tags a:hover,.categories a,.thumb-slider-wrapper .flex-direction-nav .flex-next:hover,.thumb-slider-wrapper .flex-direction-nav .flex-prev:hover,.review-score-over, .review-total-score-wrapper .right,.inside-post-slider .flex-direction-nav .flex-next:hover,.inside-post-slider .flex-direction-nav .flex-prev:hover,.inside-post-slider .flex-control-nav li a.flex-active,.inside-post-slider .flex-control-nav li a:hover,.btn.color,.btn:hover,.tab-title li.current,.acc-title-active,.acc-title:hover,.toggle-title:hover,.toggle_current,.st-pagination .page-current,.st-pagination li a:hover,.carousel-next:hover,.carousel-prev:hover,.content input[type=submit], .bg_color:hover, .button, a.button, .page-numbers.current{
   background-color: #<?php echo $skin ?>;
   -webkit-transition: all .2s linear;
   -moz-transition: all .2s linear;
   -o-transition: all .2s linear;
   transition: all .2s linear;
}
.footer-wrapper li.widget-post-wrapper:hover .widget-post-thumb img,.flickr_badge_image a img:hover{
    border: 1px solid #<?php echo $skin; ?>;
    -webkit-transition: all .2s linear;
    -moz-transition: all .2s linear;
    -o-transition: all .2s linear;
    transition: all .2s linear;
}
<?php if(st_is_woocommerce()): ?>
.woocommerce nav.woocommerce-pagination ul li span.current, 
.woocommerce-page nav.woocommerce-pagination ul li span.current, 
.woocommerce #content nav.woocommerce-pagination ul li span.current,
.woocommerce-page #content nav.woocommerce-pagination ul li span.current, 
.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce-page nav.woocommerce-pagination ul li a:hover, 
.woocommerce #content nav.woocommerce-pagination ul li a:hover,
.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:focus, 
.woocommerce #content nav.woocommerce-pagination ul li a:focus, 
.woocommerce-page #content nav.woocommerce-pagination ul li a:focus 
	{ background: #<?php echo $skin; ?>; }
.woocommerce .star-rating span, .woocommerce-page .star-rating span{ color:  #<?php echo $skin; ?>; }
<?php endif; ?>
    </style>
    <?php
}

// add to wp_head
add_action('wp_head','st_theme_font',30);
add_action('wp_head','st_theme_bg_head',31);


function st_header_tracking_code(){
    $code = st_get_setting('headder_tracking_code','');
    $code = stripslashes($code);
    if(is_string($code)){
         echo $code;
    }
}

function st_footer_tracking_code(){
    $code = st_get_setting('footer_tracking_code','');
    $code = stripslashes($code);
    if(is_string($code)){
         echo $code;
    }
}

add_action('wp_head','st_header_tracking_code',50);
add_action('wp_footer','st_footer_tracking_code',30);


 function st_back_totop(){
     echo '<div id="sttotop" class="bg_color"><i class="icon-angle-up"></i></div>';
 }
 add_action('wp_footer','st_back_totop');



