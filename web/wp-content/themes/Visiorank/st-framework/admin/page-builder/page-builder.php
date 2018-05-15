<?php 

include(ST_ADMIN_PATH.'/page-builder/page-builder-ajax-media.php');
include(ST_ADMIN_PATH.'/page-builder/page-builder-functions.php');
include(ST_ADMIN_PATH.'/page-builder/page-builder-generate-code.php');

function filter_video($settings= array()){
    return $settings;
}
add_filter('st_page_builder_save','filter_video');


function st_page_builder_support($post_type=array()){
    $post_types = array('post','page');
   return  $post_types;
}

add_filter('st_page_builder_support','st_page_builder_support');


//  add meta post to post type
add_action('add_meta_boxes','st_add_support_page_builder',10,2);


/**
 * Add page builder to post type , support all post type
 */
function st_add_support_page_builder($settings = array()){
    
    
    
    $box = array(
        'box_name'=>'st_page_builder',
        'box_title'=>'Page builder',
        'context'=>'advanced',
        'priority'=>'high',
        'settings'=>array(),
        'function_callback'=>'st_page_builder_box'
    );
    $post_types ='';
    $post_types = apply_filters('st_page_builder_support',$post_types);
    $box = apply_filters('st_page_builder_options',$box);
    if(is_array($post_types)){
     //echo  var_dump(function_exists($box['function_callback'])) ;
        foreach($post_types as $pt){
            add_meta_box($box['box_name'], $box['box_title'], $box['function_callback'], $pt , $box['context'], $box['priority'],$box['settings']);
        }
    }  
}


function st_builder_js(){
     $screen = get_current_screen();
         if(!in_array($screen->id,array('post','page')) &&  strpos($screen->id,ST_PAGE_SLUG)===false){
            return false;
         }
    
    global $ajax_nonce;

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-sortable');

     wp_enqueue_script('page-builder',ST_ADMIN_URL.'/page-builder/page-builder.js',array('jquery'));
       wp_localize_script('page-builder','STpb_options',array(
            'view_full_image'=> __('View full image','magazon'),
            'remove'=>__('Remove','magazon'),
            'seletc_image'=>__('Seletc Image','magazon'),
            'ajax_nonce'=>$ajax_nonce,
            'uploadID'=>''
        ));
}

function st_builder_css(){
      wp_enqueue_style('page-builder',ST_ADMIN_URL.'/page-builder/page-builder.css');
}

add_action("admin_print_styles-post-new.php","st_builder_css"); 
//add_action("admin_print_scripts-post-new.php","st_builder_js");
add_action("admin_print_styles-post.php","st_builder_css"); 
//add_action("admin_print_scripts-post.php","st_builder_js");

add_action('admin_enqueue_scripts','st_builder_js');


function get_page_builder_items(){
    global $post;
    $items = array(  // stpb_toggle
        'stpb_accordion'=>array(
                'title'=>__('Accordions','magazon'),
                'generate_func' =>'stpb_accordion_generate'
            ),
            
         'stpb_toggle'=>array(
                'title'=>__('Toggle','magazon'),
                'generate_func' =>'stpb_toggle_generate'
            ),
            
         'stpb_text'=>array(
            'title'=>'Text',
              'generate_func' =>'stpb_text_generate'
            ),
            
         'stpb_tabs'=>array(
                'title'=>'Tabs',
                 'generate_func' =>'stpb_tabs_generate'
            ),
            
          // 'stpb_image_grid'=>array(
          //       'title'=>'Image grid',
          //       'generate_func' =>'stpb_image_grid_generate'
          //   ),
            
         // 'stpb_slider'=>array(
         //     'title'=>'Slider',
         //     'generate_func' =>'stpb_slider_generate'
         //    ),
            
         'stpb_post_slider' => array(
                'title'=>__('Blog Post Slider','magazon'),
                'generate_func' =>'stpb_post_slider_generate'
         ),
         
         'stpb_post_carousel' => array(
                'title'=>__('Blog Post Carousel','magazon'),
                'block'=>true,
                'generate_func' =>'stpb_post_carousel_generate'
         ),
            /*
         'stpb_carousel'=>array(
               'title'=>'Carousel',
               'generate_func' =>'stpb_carousel_generate'
            ),
            */
        
           'stpb_widget'=>array(
                 'title'=>'Widget',
                 'block'=>false,
                 'default_with'=>'1_4',
                 'generate_func' =>'stpb_widget_generate'
            ),
            
          // 'stpb_service'=>array(
          //       'title'=>'Service Column',
          //       'default_with'=>'1_3',
          //       'block'=>false,
          //       'generate_func' =>'stpb_text_generate' // stpb_service_generate
          //   ),
            
            'stpb_alert'=>array(
                'title'=>'Alert',
                'block'=>false,
                'generate_func' =>'stpb_alert_generate'
            )

    );
    
    if($post->post_type=='page'){
        $items['stpb_blog'] = array(
               'title'=>'Blog Posts',
               'generate_func' =>'stpb_blog_generate'
            );
    }
    
    return apply_filters('get_page_builder_items',$items);
}


function st_page_builder_box($options= array()){
      global $post, $pagenow,  $wp_registered_sidebars;;
      $name ='_st_page_builder';
      echo '<input type="hidden" name="st_page_builder_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

     $values = get_page_builder_options($post->ID);
     

     
     if(empty($values)  || !count($values)){
        $no_value = true;
     }else{
         $no_value = false;
     }
     
      

    $builder_items = get_page_builder_items();
        
        if(isset($values['builder'])){
            $builder_save = $values['builder'];
        }else{
            $builder_save = array();
        }
        
        
        if(empty($builder_save)){
            $builder_save = array();
        }
        
        $builder_name =$name.'[builder]';
        
        $pd_item_width = array(
                             '1_1'=>0,     '3_4'=>1,
                             '2_3'=>2,   '1_2'=>3,
                             '1_3'=>4,   '1_4'=>5,
                             
                 );
    
	   $is_shop_page = false;
	  if(st_is_woocommerce()){
	  	 if($post->ID==st_get_shop_page()){
	  	 	$is_shop_page = true;
	  	 }
	  }
	
       ?>
       <div class="stpb_pd_w">
      
       <?php // echo get_post_meta($post->ID,'_st_page_builder_content',true); ?>
       
       <?php  if('post'!= strtolower($post->post_type) && !$is_shop_page):  ?>
       
       <div class="stbuilder">
             <input type="hidden"  class="builder_pre_name" value="<?php echo $builder_name; ?>" />
            <div class="stbuilder-items">
                <h4 class="sttitle"><?php _e('Add Items','magazon'); ?></h4>
                <p class="stdesc" ><?php _e('Click "add" to add item to cavan'); ?></p>
                <div class="notifications">
                    <span class="n success"><?php _e("Item Added",'magazon') ;?></span>
                    <span class="n warning"><?php _e("Item removed",'magazon') ;?></span>
                </div>
                <div class="clear"></div>
                <div class="stbuilder-o-items">
                    
                    <?php foreach($builder_items as $function => $item): ?>
                    <div class="bd-item">
                        <div class="add-btn">
                            <span class="n"><?php echo esc_html($item['title']); ?></span>
                            <a href="#" class="act-add"><?php echo _e('Add','magazon'); ?></a>
                        </div><!-- add-btn -->
                        
                        <div class="item-js-options">
                      
                      <?php 
                         $w = (isset($item['default_with']) &&  $item['default_with']!='' ) ? $item['default_with'] : '1_1';
                         
                      ?>
                            
                        <div class="obj-item  col_<?php echo $w; ?>" numc="<?php echo $pd_item_width[$w]; ?>">
                        <div class="obj-item-inner">
                                    <input type="hidden"  class="group-name builder-with"  group-name="[pbwith]" value="<?php echo $w; ?>" />
                                   <?php if(!isset($item['block']) || !$item['block']): ?>
                                    <span class="up">+</span>
                                    <span class="down">-</span>
                                    <?php endif; ?>
                                    <span class="with-info"><?php echo str_replace('_','/',$w); ?></span>
                                    <span class="pbedit" title="<?php _e('Click here to edit','magazon'); ?>">Edit</span>
                                    <span class="pbremove" title="<?php _e('Remove','magazon'); ?>"></span>
                                    
                                     <div class="t"><div><?php echo esc_html($item['title']); ?></div></div>
                             
                                 <div class="obj-js-edit">
                                    <?php 
                                     if(function_exists($function)){
                                        call_user_func($function, $function);
                                     }
                                    ?>
                                    
                                    <div class="pb-btns">
                                         <input type="button" value="<?php _e('Save','magazon'); ?>" class="pbdone pbbtn button-primary" />
                                         <input type="button" value="<?php _e('Cancel','magazon'); ?>" class="pbcancel pbbtn button-secondary" />
                                    </div>
                                 </div><!-- obj-js-edit -->
                            </div>
                                
                         </div><!--  /.obj-item  -->
                            
                            
                        </div><!-- item-js-options -->  
                    </div><!-- bd-item -->
                    <?php endforeach; ?>
                    
                    <div class="clear"></div>
                </div><!-- stbuilder-o-items -->
            </div><!-- stbuilder-items -->
            
            <div class="stbuilder-area-wprap">
            <div class="stbuilder-edit-box" style="display: none;">
            
            </div><!-- stbuilder-edit-box -->
            
            <div class="stbuilder-area row-fluid sortable">

                 <?php 
                 
                 foreach($builder_save as $i => $item): 
                 
                 $func = $builder_items[$item['function']];
                     $w = $item['pbwith'];
                     if($w==''){
                        $w='1_1';
                     }
                 ?>
                 
                 <div class="obj-item  col_<?php echo $w; ?>" numc="<?php echo $pd_item_width[$w]; ?>">
                        <div class="obj-item-inner">
                                    <input type="hidden"  class="group-name builder-with"  group-name="[pbwith]" value="<?php echo $w; ?>" />
                                     <?php if(!isset($func['block']) || !$func['block']): ?>
                                    <span class="up">+</span>
                                    <span class="down">-</span>
                                    <?php endif; ?>
                                    <span class="with-info"><?php echo str_replace('_','/',$w); ?></span>
                                    <span class="pbedit" title="<?php _e('Click here to edit','magazon'); ?>">Edit</span>
                                    <span class="pbremove" title="<?php _e('Remove','magazon'); ?>"></span>
                                     <div class="t"><div><?php echo esc_html($func['title']); ?></div></div>
                             
                                 <div class="obj-js-edit">
                                    <?php 
                                     if(function_exists($item['function'])){
                                             call_user_func($item['function'],$item['function'],$builder_name,$item);
                                        }
                                    ?>
                                    
                                    <div class="pb-btns">
                                         <input type="button" value="<?php _e('Save','magazon'); ?>" class="pbdone pbbtn button-primary" />
                                         <input type="button" value="<?php _e('Cancel','magazon'); ?>" class="pbcancel pbbtn button-secondary" />
                                    </div>
                                 </div><!-- obj-js-edit -->
                            </div>
                                
                    </div><!--  /.obj-item  -->
                 
                  
                  <?php endforeach; ?>
                
            </div><!-- stbuilder-area -->
            </div>
       
       </div><!-- stbuilder -->
       
        <div class="stdive"></div>
       
       <?php endif; ?>
       
       
       
       <?php if(!$is_shop_page): ?>
       
       <div class="layout">
       <h4><?php _e('Layout','magazon'); ?></h4>
        <?php
        
        $layouts = array(
          //  '4'=>  array('title'=>'Three columns, left & right sidebar','img'=>ST_ADMIN_URL.'/page-builder/images/layout/3.png'),
            '3'=>  array('title'=>'Two columns, left sidebar','img'=>ST_ADMIN_URL.'/page-builder/images/layout/2.png'),
            '2'=>  array('title'=>'Two columns, right sidebar','img'=>ST_ADMIN_URL.'/page-builder/images/layout/1.png'),
            '1'=>  array('title'=>'One column, no sidebar','img'=>ST_ADMIN_URL.'/page-builder/images/layout/0.png')
        );
        
        $layout_name = $name.'[layout]';
        $current_layout = (isset($values['layout'])) ?  $values['layout'] : '';
        if(empty($current_layout)){
            $values['layout'] = $current_layout = st_get_setting("layout",2) ;// default right sidebar
        }
        $input ='';
         foreach($layouts as $k => $item){
            // $check=$this->radio_checked($k);
             $class="";
             $check = "";
             if($k!='' && $k== $current_layout){
                $class=" label-checked";
                $check ='  checked="checked" ';
             }
             
             $image = $item['img'];
             
             $input.='<div class="stpb-layout-item'.$class.'">';
             $input.='
             <label class="label" title="'.esc_attr($item['title']).'">
                 <input value="'.htmlspecialchars($k).'" class="STpanel-radio-input" type="radio" '.$check.' name="'.$layout_name.'" />
                 <img src="'.$image.'" alt =""/>
             </label>';
             $input.='</div>';
         }
         
          echo $input;
        
        ?>
        <div class="clear"></div>
       </div><!-- layout -->
       
      
       <?php 
       
         // default sidebar 
         
         $values['left_sidebar'] = (isset($values['left_sidebar']) && $values['left_sidebar']!='') ? $values['left_sidebar']  : 'sidebar_default_l' ;
         $values['right_sidebar'] = (isset($values['right_sidebar'])  && $values['right_sidebar']!='') ? $values['right_sidebar']  : 'sidebar_default_r' ;
       
       ?>
       
        <div class="sidebar" <?php echo ($values['layout']!=1) ? '' : ' style="display:none;" '; ?>>
        <h4><?php _e('Sidebar','magazon'); ?></h4>
        <span  <?php echo ($values['layout']==3  || $values['layout']==4) ? ' ' : ' style="display:none;" '; ?> class="left_sidebar">
        <span class="chzn-select-lb"><?php _e('Left sidebar','magazon'); ?></span>
         <select name="<?php echo $name.'[left_sidebar]'; ?>" class="chzn-select">
             <?php foreach($wp_registered_sidebars as $sb):
             
             $selected="";
             if($values['left_sidebar']==$sb['id']){
                $selected = ' selected ="selected" ';
             }
             
              ?>
             <option value="<?php echo esc_attr($sb['id']); ?>" <?php echo $selected; ?> ><?php echo esc_html($sb['name']); ?></option>
             <?php endforeach; ?>
          </select>
           <div class="clear"></div>
         </span>
          
          
         <span <?php echo ($values['layout']==2  || $values['layout']==4) ? ' ' : ' style="display:none;" '; ?> class="right_sidebar">
         <span class="chzn-select-lb"><?php _e('Right sidebar','magazon'); ?></span>
       
         <select name="<?php echo $name.'[right_sidebar]'; ?>" class="chzn-select">
             <?php foreach($wp_registered_sidebars as $sb):
             
             $selected="";
             if($values['right_sidebar']==$sb['id']){
                $selected = ' selected ="selected" ';
             }
             
              ?>
             <option value="<?php echo esc_attr($sb['id']); ?>" <?php echo $selected; ?> ><?php echo esc_html($sb['name']); ?></option>
             <?php endforeach; ?>
         </select>
           <div class="clear"></div>
          </span>
          
             <div class="clear"></div>
        </div><!--  /. sidebar -->
        
        <?php endif;  //end if is shop page ; ?>
        
        
        
        
       
       
       <?php  if('post'!= strtolower($post->post_type) && !$is_shop_page):  ?>
         <div class="stdive"></div>
       <?php
       
        if($no_value){
            $values['page_options'] = array('show_title'=>1,'show_content'=>1 );
        }
        ?>
        <div class="page_options">
        
            <div>
             <h4><?php _e('Show page Title','magazon'); ?><small>(<?php _e('Enable title for this page','magazon'); ?>)</small></h4>
                <input type="checkbox" class="ibutton" name="<?php echo $name.'[page_options][show_title]'; ?>" <?php  echo (isset($values['page_options']['show_title'] )  && $values['page_options']['show_title'] ==1) ? '  checked="checked" ':''; ?> value="1" />
                <!--
                <label><input type="radio" name="<?php echo $name.'[page_options][show_title]'; ?>" <?php  echo (isset($values['page_options']['show_title']) && $values['page_options']['show_title'] == 0) ? '  checked="checked" ':''; ?>  value="0" />No</label>
                -->
            </div>
            <div class="stdive"></div>
            
            <div>
             <h4><?php _e('Show page content','magazon'); ?><small>(<?php _e('Enable content for this page','magazon'); ?>)</small></h4>
                <input type="checkbox"  class="ibutton" name="<?php echo $name.'[page_options][show_content]'; ?>" <?php  echo (isset($values['page_options']['show_content']) && $values['page_options']['show_content'] == 1) ? '  checked="checked" ':''; ?> value="1" />
            </div>

        </div>
        <div class="stdive"></div>
       <?php endif; ?>
       
       
       <?php
       if('page'!= strtolower($post->post_type)): 
        if(empty($values['thumbnail_type'])){
            $values['thumbnail_type'] ='image';
        }
        ?>
          <div class="stdive"></div>
          
        <div class="thumbnail">
            <h4><?php _e('Thumbnail','magazon'); ?></h4>
            <p>
                <label><input class="tt" type="radio" name="<?php echo $name.'[thumbnail_type]'; ?>" <?php  echo $values['thumbnail_type'] == 'image' ? '  checked="checked" ':''; ?> value="image" /><?php _e('Image (use featured Image)','magazon'); ?></label>
            </p>
            
            <p>
                <label><input class="tt" type="radio" name="<?php echo $name.'[thumbnail_type]'; ?>" <?php  echo $values['thumbnail_type'] == 'slider' ? '  checked="checked" ':''; ?> value="slider" /><?php _e('Slider','magazon'); ?></label>
            </p>
            
            <p>
                <label><input class="tt" type="radio" name="<?php echo $name.'[thumbnail_type]'; ?>" <?php  echo $values['thumbnail_type'] == 'video' ? '  checked="checked" ':''; ?> value="video" /><?php _e('Video','magazon'); ?></label>
            </p>
            
            <div class="thumbnail_images gallery-builder" <?php  echo ($values['thumbnail_type'] == 'video'  || $values['thumbnail_type'] == 'image' ) ? ' style="display: none" ' : ''; ?>>
                <?php
                   stpb_images($name.'[thumbnails]',$values['thumbnails']);
                ?>
            </div>
            
            <div class="thumbnail_video" <?php  echo ($values['thumbnail_type'] != 'video')? ' style="display: none" ' : ''; ?>>
                <label>
                <strong><?php echo _e('Video URL (Youtube or Vimeo only)','magazon'); ?></strong><br />
                <input type="text" class="regular-text"  name="<?php echo $name.'[video_code]'; ?>" value="<?php echo esc_attr($values['video_code']); ?>" />
                </label>
            </div>
            
            
        </div>
         <?php endif; ?>
         
         
         <?php 
         // Carousel for page (top of page )
         if('page'==$post->post_type && !$is_shop_page): 
         
         if(!isset($values['carousel_data']['cats'])){
            $values['carousel_data']['cats'] = array();
         }
         
         if(!isset($values['carousel_data']['numpost']) || intval($values['carousel_data']['numpost'])<=0){
            $values['carousel_data']['numpost'] = 5;
         }else{
            $values['carousel_data']['numpost'] = intval($values['carousel_data']['numpost']);
         }
         
        
         ?>
            <div class="carousel">
                <h4><?php _e('Show top carousel','magazon'); ?><small> (<?php _e('Enable carousel for this page','magazon'); ?>)</small></h4>
                <input type="checkbox"  class="carousel_ibutton show_carousel" name="<?php echo $name.'[page_options][carousel]'; ?>" <?php  echo (isset($values['page_options']['carousel']) && $values['page_options']['carousel'] == 1) ? '  checked="checked" ':''; ?> value="1" />
            </div>
            
            <div class="carousel_cate" <?php echo (isset($values['page_options']['carousel']) && $values['page_options']['carousel'] == 1) ? '' : ' style="display: none;" '; ?>>
                <h4><?php _e('Select categories to display','magazon'); ?></h4>
                <?php 
         
                  $select = wp_dropdown_categories('id=&show_count=1&orderby=name&echo=0&&hierarchical=1');
                    $select = preg_replace("#<select([^>]*)>#", "<select data-placeholder=\"".esc_attr(__('Select categories','magazon'))."\" class=\"lt-chzn-select\"  multiple=\"multiple\" selected-ids=\"".join(',',$values['carousel_data']['cats'])."\"  name=\"{$name}[carousel_data][cats][]\">", $select);
                    echo $select;
                 ?>
                 
                  <h4><?php _e('How many posts to show ?','magazon'); ?></h4>
                  <input type="text" name="<?php echo "{$name}[carousel_data][numpost]" ?>" value="<?php echo  $values['carousel_data']['numpost']; ?>" />

                <div class="item-gr-b">
                    <label>
                        <h4><?php _e('Include','magazon'); ?></h4>
                        <input type="text"   name="<?php echo $name.'[carousel_data][include]'; ?>" value="<?php echo esc_attr($values['carousel_data']['include']); ?>" />
                    </label>
                    <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
                </div>

                <div class="item-gr-b">
                 <label>
                     <h4><?php _e('Exclude','magazon'); ?></h4>
                    <input type="text"   name="<?php echo $name.'[carousel_data][exclude]'; ?>" value="<?php echo esc_attr($values['carousel_data']['exclude']); ?>" />
                 </label>
                 <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
                </div>
                
                
                 <?php 
                 $orderby = array(''=>'Default','title'=>'Title','comment_count'=>'Comment count', 'date'=>'Date' ,'rand'=>'Random', 'post__in' => 'Id Include');
                 ?>
                 <div class="item-gr-b">
                     <h4><?php _e('Order by','magazon'); ?></h4>
                    <select name="<?php echo $name.'[carousel_data][orderby]'; ?>"  class="chzn-select" >
                    <?php foreach($orderby as $k => $a):
                         
                         $selected="";
                         if($values['carousel_data']['orderby']==$k){
                            $selected = ' selected ="selected" ';
                         }
                    ?>
                         <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                         <?php endforeach; ?>
                        
                    </select>
                    
                 </div>
                 
                 <?php 
                 $order = array('DESC'=>'Descending ','ASC'=>'Ascending');
                 ?>
                 <div class="item-gr-b">
                     <h4><?php _e('Order','magazon'); ?></h4>
                    <select name="<?php echo $name.'[carousel_data][order]'; ?>"  class="chzn-select" >
                    
                      <?php foreach($order as $k => $a):
                         
                         $selected="";
                         if($values['carousel_data']['order']==$k){
                            $selected = ' selected ="selected" ';
                         }
                          ?>
                         <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                         <?php endforeach; ?>
                        
                    </select>
                 </div>
                  
                  
            </div>
         
         <?php endif; ?>
       </div><!-- end stpb_pd_w -->
        
       <?php
      
        
} // end st_page_builder


/** ============================================================== */

function stpb_number_to_text($n){
     switch($n){
          case 1:
             $class ='one';
        break;
          case 2:
             $class ='two';
        break;
        case 3:
             $class ='three';
        break;
        case 4:
             $class ='four';
        break;
        case 5:
             $class ='five';
        break;
        case 6:
             $class ='six';
        break;
        case 7:
             $class ='seven';
        break;
        case 8:
          $class ='eight';
        break;
        case 9:
          $class ='nine';
        break;
        case 10:
          $class ='ten';
        break;
        case 10:
          $class ='eleven';
        break;
        
        default :
          $class ='twelve';
        
    }
    return $class;
}


function  stpb_column_class($pbwith){
    $class ="";
    $w = explode('_',$pbwith);
    $w[0] = intval($w[0]);
    $w[1] = intval($w[1]);
     if( $w[0] ==0 or  $w[1] == 0){
        $n = 12;
     }else{
        $n= 12*($w[0]/$w[1]); // 12 columns
     }
    
   $class =stpb_number_to_text($n); 
    
    $class.=' columns';
    $class = apply_filters('stpb_column_class',$class,$n);
    return $class;
}



// Save data froms t_save_page_builder
function st_save_page_builder($post_id) {
    global $meta_box,$smooththemes_sidebar;
    
    // verify nonce
    if (!isset($_POST['st_page_builder_nonce']) || !wp_verify_nonce($_POST['st_page_builder_nonce'], basename(__FILE__))) {
        
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
         
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        
        return $post_id;
    }
    
      
      // save post meta to each box
        $meta_name = '_st_page_builder';
        $old = get_post_meta($post_id, $meta_name, true);
        $new = $_POST[$meta_name];
        
      //  echo var_dump($new) ; die();
         $new = apply_filters('st_page_builder_save',$new);
         
         
         
         $b64_new =  base64_encode(serialize($new));
          
       
        // save as base 64 encode beacase WP import
        update_post_meta($post_id, $meta_name, $b64_new);
        
        
        // save  as a string shortcode
        
        $builder = $new['builder'];
        
        if(empty($builder)){
            $builder = array();
        }
        
        
        $rows = array();
        
        $ri=$i=0;
        $n= count($builder);
       // $tmp_builder=  $builder;
        while($i<$n){
            
             $wc = $builder[$i]['pbwith'];
             $w=  explode('_',$wc);
             $t = intval($w[0]);
             $m = intval($w[1]);
             
             if($m>0 and $t>0){
                 $c = $t/$m;
             }else{
                $c=1;
             }
             
             if($rows[$ri]['total']+$c<=1){
                 $rows[$ri]['total'] += $c;
                 $rows[$ri]['cols'][] = $builder[$i];
             }else{
                $ri++;
                $rows[$ri]['total'] += $c;
                $rows[$ri]['cols'][] = $builder[$i];
             }
            $i++;
        }// end while
        
        $string_shortcode = array();
        
        $builder_items = get_page_builder_items();
       
        
        // generate code to display: maybe html or shortcode
        foreach($rows as $row){
            $format = "<div class=\"row\">\n".'%1$s'."\n</div>";
            $str_cols =  array();
            foreach($row['cols'] as $data){
                
                $item = $builder_items[$data['function']];
                if(function_exists($item['generate_func'])){
                   $str_cols[]="\t<div class=\"".stpb_column_class($data['pbwith'])."\">".call_user_func($item['generate_func'],$data)."</div>";
                }else{
                     $str_cols[]="\t<div class=\"".stpb_column_class($data['pbwith'])."\"> </div>";
                }
            }
            
            $str_cols= join("\n",$str_cols);
            $str_cols.='<div class="clear"></div>';
            $string_shortcode[] = sprintf($format,$str_cols);  
        }
        
        $string_shortcode = join("\n",$string_shortcode);
        
        if ($string_shortcode!='') {
            update_post_meta($post_id, '_st_page_builder_content', $string_shortcode);
        } else {
            delete_post_meta($post_id, '_st_page_builder_content');
        }
        
         $cache_key ='_st_page_builder_'.$post_id;
         wp_cache_decr($cache_key);
        // echo var_dump($rows); die();
     
}

// save metabox data
//save_post();
add_action('save_post', 'st_save_page_builder',9999);
