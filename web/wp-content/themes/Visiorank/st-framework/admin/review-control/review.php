<?php
;

function st_page_review_support($post_type=array()){
    $post_types = array('post');
   return  $post_types;
}

add_filter('st_page_review_support','st_page_review_support');

/**
 * Add page builder to post type , support all post type
 */ 
function st_add_page_review_support($settings = array()){
    
    $box = array(
        'box_name'=>'st_page_review',
        'box_title'=>__('Review Control','magazon'),
        'context'=>'normal',
        'priority'=>'high',
        'settings'=>array(),
        'function_callback'=>'st_page_review_box'
    );
    
    $post_types = apply_filters('st_page_review_support','');
    $box = apply_filters('st_page_review_options',$box);
    if(is_array($post_types)){
     //echo  var_dump(function_exists($box['function_callback'])) ;
        foreach($post_types as $pt){
            add_meta_box($box['box_name'], $box['box_title'], $box['function_callback'], $pt , $box['context'], $box['priority'],$box['settings']);
        }
    }  
}

function st_review_js(){
    global $ajax_nonce;
     wp_localize_script('jquery','STreview_options',array(
           'starOn' =>st_asset('raty/img/star-on.png'),
           'starOff' =>st_asset('raty/img/star-off.png'),
           'path'=>st_asset('raty/img/')
        ));
        // st_asset
     wp_enqueue_script('jquery-ui-slider');
     wp_enqueue_script('jRating',st_asset('raty/js/jquery.raty.min.js'),array('jquery'));
     wp_enqueue_script('page-review',ST_ADMIN_URL.'/review-control/review.js',array('jquery'));
}

function st_review_css(){
    //  wp_enqueue_style('jRating',st_asset('raty/jRating.jquery.css'),array('jquery'));
      wp_enqueue_style('page-review',ST_ADMIN_URL.'/review-control/review.css');
}

add_action("admin_print_styles-post-new.php","st_review_css"); 
add_action("admin_print_scripts-post-new.php","st_review_js");
add_action("admin_print_styles-post.php","st_review_css"); 
add_action("admin_print_scripts-post.php","st_review_js");



function  st_page_review_box(){
     global $post, $pagenow,  $wp_registered_sidebars;;
      $name ='st_page_review';
      echo '<input type="hidden" name="st_page_review_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
     $values = get_post_meta($post->ID,$name,true);
 ?>
 <table class="st_page_review_tb">
     <tr>
       <td class="th">
        <?php _e('Enable review','magazon'); ?>
       </td>
       <td class="c">
             <label><input value="1" name="<?php echo $name.'[enable]'; ?>" <?php echo (isset($values['enable']) && $values['enable']==1) ? ' checked="checked" ' : ''; ?> type="checkbox" /><?php _e('Check this to enable review system for this post','magazon'); ?></label>
       </td>
     </tr>
     
     <tr>
      <td class="th"><?php _e('Rating Type','magazon'); ?></td>
      <td class="c">
      <?php 
       $types = array(
            'n'=>__('Number','magazon'),
            's'=>__('Stars','magazon'),
            'p'=>__('Percent','magazon')
       
       ); 
       
       if(empty($values['type'])){
         $values['type'] ='';
       }
       
       ?>
       
        <select  name="<?php echo $name.'[type]'; ?>" class="chzn-select">
        <?php foreach($types as $k=>$t):
             
             $selected="";
             if($values['type']==$k){
                $selected = ' selected ="selected" ';
             }
             
              ?>
             <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($t); ?></option>
             <?php endforeach; ?>
        </select>
      
      </td>
     </tr>
     
     
     <tr class="ratting_criteria">
      <td class="th"><?php _e('Rating Criteria','magazon'); ?></td>
      <td class="c">
       <?php // echo var_dump($values['ratting_data']); ?>
      
         <div class="list_item">
          <?php if(!empty($values['ratting_data']['label'])):
          
          foreach($values['ratting_data']['label']  as $i => $lable):
              $score  = floatval($values['ratting_data']['score'][$i]);
              if($lable==''  &&  $score<=0){
                continue;
              }
          
               ?>
               <div class="ritem">
                    <div class="l">
                        <span class="handle"></span>
                        <label><?php _e('Label:','magazon'); ?><input value="<?php echo esc_attr($lable); ?>" name="<?php echo $name.'[ratting_data][label][]' ?>" type="text" /></label>
                    </div>
                     <div class="r">
                         <label><?php _e('Score:','magazon'); ?><input size="2" maxlength="3" value="<?php echo esc_attr($score); ?>" class="score" name="<?php echo $name.'[ratting_data][score][]' ?>" type="text"  /></label>
                         <!--
                          <div class="jrating"></div>
                          -->
                         <div class="sider"></div>
                         <button  class="remove" title="<?php _e('Remove','magazon'); ?>"></button>
                     </div>
                    <div class="clear"></div>
                 </div>
            <?php endforeach; endif; ?> 
         </div>
         
         <div class="tpl_rate" style="display: none;">
         
             <div  class="ritem">
               <div class="l">
                        <span class="handle"></span>
                        <label><?php _e('Label:','magazon'); ?><input value="" name="<?php echo $name.'[ratting_data][label][]' ?>" type="text" /></label>
                    </div>
                     <div class="r">
                         <label><?php _e('Score:','magazon'); ?><input size="2" maxlength="3" class="score" value="0" name="<?php echo $name.'[ratting_data][score][]' ?>" type="text"  /></label>
                          
                          <!--
                          <div class="jrating"></div>
                          -->
                         <div class="sider"></div>
                         <button  class="remove" title="<?php _e('Remove','magazon'); ?>"></button>
                     </div>
                    <div class="clear"></div>
             </div>
         </div>
         
         <p class="btns">
             <a href="#" class="add_more_r button-secondary"><?php _e('Add more','magazon'); ?></a>
         </p>
      </td>
     </tr>
     
     
      <tr>
      <td class="th"><?php _e('Review box position','magazon'); ?></td>
      <td class="c">
       <?php 
       $postions = array(
            'tl'=>__('Top left','magazon'),
            'tr'=>__('Top right','magazon'),
            't'=>__('Top','magazon'),
            'bl'=>__('Bottom left','magazon'),
            'br'=>__('Bottom right','magazon'),
            'b'=>__('Bottom','magazon'),
       
       ); 
       
       if(empty($values['postion'])){
        $values['postion'] ='';
       }
       
       ?>
        <select  name="<?php echo $name.'[postion]'; ?>" class="chzn-select">
        <?php foreach($postions as $k=>$t):
             
             $selected="";
             if($values['postion']==$k){
                $selected = ' selected ="selected" ';
             }
             
              ?>
             <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($t); ?></option>
             <?php endforeach; ?>
        </select>
      </td>
     </tr>
     
     <tr>
      <td class="th"><?php _e('Review box title','magazon'); ?></td>
      <td class="c">
         <input type="text" name="<?php echo $name.'[title]'; ?>" value="<?php echo (isset($values['title'])) ?  esc_attr($values['title']) : ''; ?>"  />
      </td>
     </tr>
     
     <tr>
      <td class="th"><?php _e('Total score label','magazon'); ?></td>
      <td class="c">
            <input type="text" name="<?php echo $name.'[score_label]'; ?>" value="<?php echo (isset($values['score_label'])) ? esc_attr($values['score_label']) : ''; ?>" />
            <div class="desc"><?php _e('Total score label of reiew box in the single post.','magazon'); ?></div>
      </td>
     </tr>
     
     <tr>
     	
     	<td class="th" colspan="2">
     		<h4>Schema Microdata Settings</h4>
     		<p>You can find more info <a href="http://schema.org/Review" target="_blank">Here</a></p>
     	</td>
     </tr>
     
     
     <tr>
      <td class="th"><?php _e('Review Description','magazon'); ?></td>
      <td class="c">
           
            <textarea name="<?php echo $name.'[r_desc]'; ?>" style="width: 100%;" row ="5" ><?php echo (isset($values['r_desc'])) ? esc_attr($values['r_desc']) : ''; ?></textarea>
      	
      </td>
     </tr>
     
     <tr>
      <td class="th"><?php _e('Review Body','magazon'); ?></td>
      <td class="c">
           
            <textarea name="<?php echo $name.'[r_body]'; ?>" style="width: 100%;" row ="5" ><?php echo (isset($values['r_body'])) ? esc_attr($values['r_body']) : ''; ?></textarea>
      	
      </td>
     </tr>
     
     <tr>
      <td class="th"><?php _e('Item reviewed','magazon'); ?></td>
      <td class="c">
           
            <textarea name="<?php echo $name.'[r_thing]'; ?>" style="width: 100%;" row ="5" ><?php echo (isset($values['r_thing'])) ? esc_attr($values['r_thing']) : ''; ?></textarea>
      	
      </td>
     </tr>
     
     
     
 </table>
    
 <?php
}
//  add meta post to post type
add_action('admin_init','st_add_page_review_support',10,2);

// Save data froms t_save_page_builder
function st_save_page_review($post_id) {
    global $meta_box,$smooththemes_sidebar;
    
    // verify nonce

    if (!isset($_POST['st_page_review_nonce']) || !wp_verify_nonce($_POST['st_page_review_nonce'], basename(__FILE__))) {
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
        $meta_name = 'st_page_review';
        $old = get_post_meta($post_id, $meta_name, true);
        $new = $_POST[$meta_name];
        if ($new && $new != $old) {
            update_post_meta($post_id, $meta_name, $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $meta_name, $old);
        }
}

// save metabox data
add_action('save_post', 'st_save_page_review');