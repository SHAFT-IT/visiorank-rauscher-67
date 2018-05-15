<?php 
function stpb_images($name,$values = array()){
    $affter_name ='';
    $meta_name= $name.'[meta]';
    $uniqid= 'g-'.uniqid();
    
    ?>
    
    <div class="box-inner stpb-gallery" >
          <input class="gallery-name"  type="hidden" value="<?php echo $name.'[images][]'; ?>" />
          <input class="gallery-meta-name"  type="hidden" value="<?php echo $meta_name; ?>" />
          
          <div style="display: none;" class="stpb-gallery-editct">
                     <div class="stpb-meta media-item">
                        <h2>Edit Image</h2>
                         <input type="hidden" value="" class="for-img-index">
                        
                          <table class="slidetoggle ">
                            <tbody><tr class="postpb_title">
                            
                    			<th valign="midle" scope="row" class="label">
                                    <label><span class="alignleft">Image</span></label>
                                </th>
                    			<td class="field image_preview">
                                    
                                </td>
                    		</tr>
                          
                            <tr class="postpb_title form-required">
                            
                    			<th valign="top" scope="row" class="label">
                                    <label><span class="alignleft">Title</span></label>
                                </th>
                    			<td class="field">
                                    <input type="text" value="" class="stpbn-title">
                                </td>
                    		</tr>
                            
                            <tr class="postpb_title form-required">
                    			<th valign="top" scope="row" class="label">
                                    <label><span class="alignleft">Caption</span></label>
                                </th>
                    			<td class="field">
                                    <textarea class="stpbn-caption"></textarea>
                                </td>
                    		</tr>
                            
                             <tr class="postpb_title form-required">
                    			<th valign="top" scope="row" class="label">
                                    <label><span class="alignleft">URL</span></label>
                                
                                </th>
                    			<td class="field">
                                    <input type="text" value="" class="stpbn-url"><br>
                                    <small>Example: http://goole.com</small>
                                </td>
                    		</tr>
                            
                            
                          </tbody></table>
                         
                          <button class="button-primary g-save-meta">Save</button>
                          <button onclick=" return false;" class="button-secondary close">Close</button>
                      </div>
                  </div>
          
          
          <div class="stpb-iws">
          
          <?php
          $ulc= '';
           if(empty($values['images'])){
            $ulc =' no-image';
            $values['images'] = array();
           }
           ?>
           
          <ul class="stpb-img-items images sortable <?php echo $ulc; ?>">
           <?php 
           
           
           foreach($values['images'] as $k => $img): 
           	$attachment=wp_get_attachment_image_src($img, 'stpb-thumb');
            $meta =  $values['meta'][$k];
           ?>
            <li>
                <div class="imw">
                     <input type="hidden" class="hidden_id" name="<?php echo $name.'[images][]'; ?>" value="<?php echo $img; ?>" />
                     <img class="imgid"  src="<?php echo $attachment[0]; ?>"  width="<?php echo $attachment[1]; ?>" height="<?php echo $attachment[2]; ?>" />
                     <a href="#" class="stpb_edit stpb_img_tbtn">Edit</a>
                     <a href="#" class="stpb_delete stpb_img_tbtn">Del</a>
                     <input type="hidden" class="gtitle" value="<?php echo esc_html($meta['title']); ?>" />
                     <input type="hidden" class="gcaption" value="<?php echo htmlspecialchars($meta['caption']); ?>" />
                     <input type="hidden" class="gurl" value="<?php echo esc_html($meta['url']); ?>" />
                </div>
            </li>
           <?php endforeach; ?> 
            
          </ul>
          <div class="clear"></div>
          </div>
          
          
         <div class="clear"></div>
         <div class="btn-actions">
            <a href="#" class="add_more_image button-secondary"><span></span><?php  _e('Add image','magazon'); ?></a> <a href="#" class="close_ajax_images">Close</a>
            
            <div class="clear"></div>
         </div>
         <div class="ajax-media-cont"></div>
         <div class="clear"></div>
         </div><!--box-inner-->
    
    <?php
}


/** ============= for page builder items ================== */





function stpb_ui($function_name,$name='',$values= array()){
     $affter_name ='';
     global $post, $pagenow;
     
        $mata_name= $name.'[meta]';
        $uniqid= 'ui-'.uniqid();
        
        $supports = array('image','content','id' , 'url');
        
       
       
       foreach($supports as $k => $v){
            if(in_array($v,$supports)){
                $current_support[$v] = true;
            }else{
                 $current_support[$v] = false;
            }
       }
       
       
         $affter_name = '';
         $ui_name =  $affter_name."[data]";
        
             $data = $values['data'];
             
             // echo var_dump(  $values);
          ?>

          <div class="box-inner stpb-ui" >
            
             <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
             
             <input type="hidden" class="val-only group-name stpb-ui-name" group-name="<?php echo $ui_name; ?>" value="<?php echo $ui_name; ?>" />

            <ul class="sortable stpb-ui-list">
                
                <?php 
               
                 $n = count($data);
                 for($i=0; $i<$n; $i++){
                    $v =  $data[$i];
                ?>
            
                <li>
                    
                    <div class="stpb-widget widget closed">	
                        <div title="Click to toggle" class="ui-handlediv"><br/></div>
                         <a href="#" class="remove stwrmt button-secondary">Remove</a>
                        <h3 class="stpb-hndle">Title:<span><?php  echo esc_html($v['title']); ?></span></h3>
                        
                    	<div class="inside">
                    
                        	<div class="widget-content">
                                
                                <div class="widget-content">
                        		<p><label >Title:</label>
                        		<input type="text" value="<?php  echo esc_attr($v['title']); ?>" class="ui-title" ></p>
                                
                                <?php if($current_support['image']): ?>
                                <div class="pb-box-upload ui-img-w"><label >Image:</label>
                            		<input type="text" value="<?php  echo esc_attr($v['img']); ?>"  class="ui-img pb-input-upload" >
                                    <a href="#"  class="pb-upload-button button-secondary"><span></span><?php echo __('Select Image','magazon'); ?></a>
                                    <a href="#" class="remove_image button-secondary"><span></span><?php echo __('Remove','magazon'); ?></a>
                                    <div class="clear"></div>
                                </div>
                                 <?php endif; ?>
                                 
                                 <?php if($current_support['url']): ?>
                                 <p><label >url:</label>
                        		<input type="text" value="<?php  echo esc_attr($v['url']); ?>" class="ui-url"  ></p>
                                 <?php endif; ?>
                                 
                                 
                                <?php if($current_support['content']): ?>
                        		<textarea rows="10" class="ui-cont"  ><?php  echo esc_html($v['content']); ?></textarea>
                                <p><label ><input type="checkbox" class="ui-autop" <?php echo $v['autop']==1 ? ' checked="checked" ' : ''; ?> value="1" />&nbsp;Automatically add paragraphs</label></p>
                               	<div class="widget-description">Arbitrary text or HTML	</div>
                                 <?php endif; ?>
                                 <?php if($current_support['id']): ?>
                                 <input type="hidden" class="ui-autoid" value="" />
                                <?php endif; ?>
                            	</div>
                                
                                	<div class="widget-control-actions">
                                		<div class="alignleft">
                                    		<a href="#remove" class="remove"><?php _e('Delete','magazon'); ?></a> |
                                    		<a href="#close" class="close">Close</a>
                                		</div>
                                		<br class="clear" />
                                	</div>
              
                            </div>
                    
                        
                    	
                    	</div>
                    	
                    	</div><!-- /.stpb-widget  -->
                    
                </li>
                <?php }// ?>
              </ul>  
                
                
                <div class="ui-temp-code" style="display: none;">
                
                        <div class="stpb-widget widget closed">	
                        <div title="Click to toggle" class="ui-handlediv"><br/></div>
                         <a href="#" class="remove stwrmt button-secondary">Remove</a>
                        <h3 class="stpb-hndle">Title:<span></span></h3>
                        
                    	<div class="inside">
                    
                        	<div class="widget-content">
                                
                                <div class="widget-content">
                        		<p><label >Title:</label>
                        		<input type="text" value="" class="ui-title" ></p>
                                
                                <?php if($current_support['image']): ?>
                                <div class="pb-box-upload ui-img-w"><label >Image:</label>
                            		<input type="text" value=""  class="ui-img pb-input-upload" >
                                     <a href="#"  class="pb-upload-button button-secondary"><span></span><?php echo __('Select Image','magazon'); ?></a>
                                    <a href="#" class="remove_image button-secondary"><span></span><?php echo __('Remove','magazon'); ?></a>
                                    <div class="clear"></div>
                                </div>
                                 <?php endif; ?>
                                 
                                 <?php if($current_support['url']): ?>
                                 <p><label >url:</label>
                        		<input type="text" value="" class="ui-url"  ></p>
                                 <?php endif; ?>
                                 
                                 
                                <?php if($current_support['content']): ?>
                        		<textarea rows="10" class="ui-cont"  ></textarea>
                                <p><label ><input type="checkbox" class="ui-autop" value="1" />&nbsp;Automatically add paragraphs</label></p>
                               	<div class="widget-description">Arbitrary text or HTML	</div>
                                 <?php endif; ?>
                                 <?php if($current_support['id']): ?>
                                 <input type="hidden" class="ui-autoid" value="" />
                                <?php endif; ?>
                            	</div>
                                
                                	<div class="widget-control-actions">
                                		<div class="alignleft">
                                    		<a href="#remove" class="remove"><?php _e('Delete','magazon'); ?></a> |
                                    		<a href="#close" class="close">Close</a>
                                		</div>
                                		<br class="clear" />
                                	</div>
              
                            </div>
                    
                    	</div>
                    	
                    	</div><!-- /.stpb-widget  -->
                      
                
                </div><!-- ui-temp-code -->
            
            <div class="alignright">
    		  <input type="button" value="Add More" class="button-secondary stpb-ui-more" />		
            </div>
    		
          </div><!--box-inner-->
      <?php
    
}


function  stpb_accordion($function_name,$name='',$values= array()){
     $affter_name ='';
    ?>
    <h2 class="stpb_title"><?php _e('Accordion','magazon'); ?></h2>
    <div class="item-gr">
     <label>
        <h4><?php _e('Title','magazon'); ?></h4>
        <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[settings][title]'; ?>" value="<?php echo esc_attr($values['settings']['title']); ?>" />
     </label>
    </div>
    <div class="lb-stdive"></div>
    <?php
    stpb_ui($function_name,$name,$values);
    
} /// stpb_ui

function  stpb_toggle($function_name,$name='',$values= array()){
    ?>
    <h2 class="stpb_title"><?php _e('Toggle','magazon'); ?></h2>
    <div class="item-gr">
     <label>
        <h4><?php _e('Title','magazon'); ?></h4>
        <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[settings][title]'; ?>" value="<?php echo esc_attr($values['settings']['title']); ?>" />
     </label>
    </div>
     <div class="lb-stdive"></div>
    <?php
    stpb_ui($function_name,$name,$values);
    
} /// stpb_ui





function  stpb_tabs($function_name,$name='',$values= array()){
     $affter_name ='';
    ?>
    <h2 class="stpb_title"><?php _e('Tabs','magazon'); ?></h2>
    <div class="item-gr">
     <label>
        <h4><?php _e('Title','magazon'); ?></h4>
        <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[settings][title]'; ?>" value="<?php echo esc_attr($values['settings']['title']); ?>" />
     </label>
    </div>
     <div class="lb-stdive"></div>
    <?php
    stpb_ui($function_name,$name,$values);
    
} /// stpb_ui



function stpb_text($function_name,$name='',$values= array()){
     $affter_name ='';
    ?>
    <h2 class="stpb_title"><?php _e('Text','magazon'); ?></h2>
      <div class="box-inner stpb-text" >
            
            <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
                 <label>
                      <h4><?php _e('Title','magazon'); ?></h4>
                    <input type="text"  class="group-name" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
                 </label>
            </div>
            
            <div class="lb-stdive"></div>
            
             <div class="pb-box-upload ui-img-w item-gr">
                <h4><?php _e('Image','magazon'); ?></h4>
        		<input type="text" value="<?php echo esc_attr($values['data']['img']); ?>" group-name="<?php echo $affter_name.'[data][img]'; ?>" class="group-name pb-input-upload" >
                <a href="#"  class="pb-upload-button button-secondary"><span></span><?php echo __('Select Image','magazon'); ?></a>
                <a href="#" class="remove_image button-secondary"><span></span><?php echo __('Remove','magazon'); ?></a>
                <div class="clear"></div>
            </div>
            
            <div class="lb-stdive"></div>
            
            <div class="item-gr">
                 <label>
                  <h4><?php _e('Content','magazon'); ?></h4>
                  <textarea rows="10" class="group-name" group-name="<?php echo $affter_name.'[data][content]'; ?>" ><?php echo esc_attr($values['data']['content']); ?></textarea>
                 </label>
                 <span class="desc"><?php echo __('Arbitrary text or HTML','magazon'); ?></span>
            </div>
             
             <div class="lb-stdive"></div>
             
             <div class="item-gr">
             <label>
                <h4><?php _e('URL','magazon'); ?></h4>
                <input type="text"  class="group-name" group-name="<?php echo $affter_name.'[data][url]'; ?>" value="<?php echo esc_attr($values['data']['url']); ?>" />
                
             </label>
              <span  class="desc"><?php _e('example','magazon'); ?> : http://google.com </span>
            </div>
            
              <div class="lb-stdive"></div>
              
               <div class="item-gr">
                  <h4><?php _e('Automatically add paragraphs','magazon'); ?></h4>
                  <input type="checkbox" group-name="<?php echo $affter_name.'[data][autop]'; ?>"  class="group-name lb-ibutton"  <?php echo $values['data']['autop']==1 ?' checked="checked"  ' : ''; ?> value="1" />
                 
              </div>
              <div class="lb-stdive"></div>
             <div class="item-gr">
                 <h4><?php _e('Show read more link','magazon'); ?></h4>
                  <input type="checkbox" group-name="<?php echo $affter_name.'[data][show_more]'; ?>"  class="group-name lb-ibutton"  <?php echo $values['data']['show_more']==1 ?' checked="checked"  ' : ''; ?> value="1" /></label>
             </div>
             
              <div class="lb-stdive"></div>
              
              <div class="item-gr">
                <h4><?php _e('More text','magazon'); ?></h4>
                <input type="text"  class="group-name" group-name="<?php echo $affter_name.'[data][more_text]'; ?>" value="<?php echo esc_attr($values['data']['more_text']); ?>" />
                <span  class="desc"><?php _e('Default','magazon'); ?> : <?php echo __('Read more','magazon'); ?></span>
             </div> 
             
    </div>
    <?php
}


function stpb_gallery($function_name,$name='',$values= array()){
     $affter_name ='';
    
     ?>
   
    <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />   
    
    <div class="box-inner stpb-gallery">
          <input class="group-name gallery-name val-only"  type="hidden" group-name="<?php echo $affter_name.'[images][]'; ?>" value="<?php echo '[images]'; ?>" />
          <input class="gallery-meta-name group-name val-only"  group-name="<?php echo $affter_name.'[meta]'; ?>" type="hidden" value="" />
          <div class="stpb-gallery-editct" stpbyle="display: none;">
             <div class="stpb-meta media-item">
                <h2><?php _e('Edit Image','magazon'); ?></h2>
                 <input type="hidden" class="for-img-index" value=""/>
                
                  <table class="slidetoggle ">
                    <tr class="postpb_title">
                    
            			<th valign="midle" class="label" scope="row">
                            <label><span class="alignleft">Image</span></label>
                        </th>
            			<td class="field image_preview">
                            
                        </td>
            		</tr>
                  
                    <tr class="postpb_title form-required">
                    
            			<th valign="top" class="label" scope="row">
                            <label><span class="alignleft">Title</span></label>
                        </th>
            			<td class="field">
                            <input type="text" class="stpbn-title" value="" >
                        </td>
            		</tr>
                    
                    <tr class="postpb_title form-required">
            			<th valign="top" class="label" scope="row">
                            <label><span class="alignleft">Caption</span></label>
                        </th>
            			<td class="field">
                            <textarea class="stpbn-caption"></textarea>
                        </td>
            		</tr>
                    
                     <tr class="postpb_title form-required">
            			<th valign="top" class="label" scope="row">
                            <label><span class="alignleft">URL</span></label>
                        
                        </th>
            			<td class="field">
                            <input type="text" class="stpbn-url" value=""><br />
                            <small>Example: http://goole.com</small>
                        </td>
            		</tr>
                    
                    
                  </table>
                 
                  <button class="button-primary g-save-meta">Save</button>
                  <button class="button-secondary close"  onclick=" return false;">Close</button>
              </div>
          </div><!-- stpb-gallery-editct -->
          
          <div class="stpb-iws">
          <?php
          $ulc= '';
           if(empty($values['images'])){
            $ulc =' no-image';
            $values['images'] = array();
           }
           ?>
          <ul class="stpb-img-items images sortable <?php echo $ulc; ?>">
           <?php 
          
           
           foreach($values['images'] as $k => $img): 
           	$attachment=wp_get_attachment_image_src($img, 'stpb-thumb');
            $meta =  $values['meta'][$k];
           ?>
            <li>
                <div class="imw stpb-hndle"> 
                     <input type="hidden" class="group-name" group-name="[images][]" name="<?php echo $name.'[images][]'; ?>" value="<?php echo $img; ?>" />
                     <img class="imgid"  src="<?php echo $attachment[0]; ?>"  width="<?php echo $attachment[1]; ?>" height="<?php echo $attachment[2]; ?>" />
                     <a href="#" class="stpb_edit stpb_img_tbtn">Edit</a>
                     <a href="#" class="stpb_delete stpb_img_tbtn">Del</a>
                     <input type="hidden" class="gtitle" value="<?php echo esc_html($meta['title']); ?>" />
                     <input type="hidden" class="gcaption" value="<?php echo htmlspecialchars($meta['caption']); ?>" />
                     <input type="hidden" class="gurl" value="<?php echo esc_html($meta['url']); ?>" />
                </div>
            </li>
           <?php endforeach; ?> 
            
          </ul>
          <div class="clear"></div>
          </div>
          
          
         <div class="clear"></div>
         <div class="btn-actions">
            <a href="#" class="add_more_image button-secondary"><span></span><?php _e('Add image','magazon'); ?></a> <a href="#" class="close_ajax_images">Close</a>
            
            <div class="clear"></div>
         </div>
         <div class="ajax-media-cont"></div>
         <div class="clear"></div>
         </div><!--box-inner-->
    
    
    
    
    <?php
   // stpb_gallery($name,$values);
}


function  stpb_image_grid($function_name,$name='',$values= array()){ 
     $affter_name ='';
    ?>
     <h2 class="stpb_title"><?php _e('Images Grid','magazon'); ?></h2>
     
     <div class="item-gr">
     <label>
        <h4><?php _e('Title','magazon'); ?></h4>
        <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[settings][title]'; ?>" value="<?php echo esc_attr($values['settings']['title']); ?>" />
     </label>
    </div>
            
    <?php
    stpb_gallery($function_name,$name,$values);
    
    if(empty($values['settings']['col'])){
        $values['settings']['col']=4;
    }
    
    ?>
    <div class="lb-stdive"></div>
    
    <div class="item-gr">
        <h4><?php _e('How many columns to show ?','magazon'); ?></h4>
         <select class="group-name lb-chzn-select " group-name="[settings][col]" >
          <?php for($i=1; $i<=6; $i++){
            // esc_attr($values['settings']['col']); 
             if($i<=12){
                if(12%$i!=''){
                    continue;
                }
             }else{
                 if($i%12!=''){
                    continue;
                }
             }
            
            $selected="";
            if($values['settings']['col']==$i){
                $selected =' selected="selected" ';
            }
             echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
            
          } ?>
         
         </select>
    </div>

    <?php
    
    
};

function  stpb_slider($function_name,$name='',$values= array()){ 
     $affter_name ='';
    ?>
     <h2 class="stpb_title"><?php _e('Slider','magazon'); ?></h2>
    <?php
    stpb_gallery($function_name,$name,$values);
    
};


function  stpb_posts_slider_prepare_setup($function_name,$name='',$values= array()){
    $affter_name ='';
    ?>
    <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
             <label>
                <h4><?php _e('Title','magazon'); ?></h4>
                <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
             </label>
            </div>
            
             <div class="lb-stdive"></div>
      
             <div class="item-gr">
               <h4><?php echo _e('Show in Categories','magazon'); ?></h4>
                <?php
                
                if(empty($values['data']['cats']) or !is_array($values['data']['cats'])){
                    $values['data']['cats'] = array();
                }
               // $select = wp_dropdown_categories('show_count=1&orderby=name&echo=0&class=group-name&hierarchical=1&show_option_all='.rawurlencode()));
             //  $select = preg_replace("#<select([^>]*)>#", "<select$1 multiple=\"multiple\" selected-ids=\"".join(',',$values['data']['cats'])."\" group-name=\"{$affter_name}[data][cats][]\">", $select);
               //selected='.join(',',$values['data']['cats']).'&
                $select = wp_dropdown_categories('id=&show_count=1&orderby=name&echo=0&class=group-name++lb-chzn-select&hierarchical=1');
                $select = preg_replace("#<select([^>]*)>#", "<select$1   multiple=\"multiple\" selected-ids=\"".join(',',$values['data']['cats'])."\"  group-name=\"{$affter_name}[data][cats][]\">", $select);
                echo $select;
               //  echo $select;
                ?>
             </div>
             
              <div class="lb-stdive"></div>
             
             <?php if(intval($values['data']['numpost'])<=0){
                $values['data']['numpost'] = 4;
             } ?>
             
             <div class="item-gr">
             <label>
                 <h4><?php _e('Num posts to show','magazon'); ?></h4>
                <input type="text"  class="group-name" style="width: 40px;" size="4" max="2" group-name="<?php echo $affter_name.'[data][numpost]'; ?>" value="<?php echo esc_attr($values['data']['numpost']); ?>" />
             </label>
            </div>

            <div class="lb-stdive"></div>
            <div class="item-gr">
                <label>
                    <h4><?php _e('Include','magazon'); ?></h4>
                    <input type="text"  class="group-name"  group-name="<?php echo $affter_name.'[data][include]'; ?>" value="<?php echo esc_attr($values['data']['include']); ?>" />
                </label>
                <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
            </div>
            
             <div class="lb-stdive"></div>
            <div class="item-gr">
             <label>
                 <h4><?php _e('Exclude','magazon'); ?></h4>
                <input type="text"  class="group-name"  group-name="<?php echo $affter_name.'[data][exclude]'; ?>" value="<?php echo esc_attr($values['data']['exclude']); ?>" />
             </label>
             <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
            </div>
            
             <div class="lb-stdive"></div>
             <?php 
             $orderby = array(''=>'Default','title'=>'Title','comment_count'=>'Comment count', 'date'=>'Date' ,'rand'=>'Random', 'post__in' => 'Id include post');
             ?>
             <div class="item-gr">
                 <h4><?php _e('Order by','magazon'); ?></h4>
                <select group-name="<?php echo $affter_name.'[data][orderby]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($orderby as $k => $a):
                     
                     $selected="";
                     if($values['data']['orderby']==$k){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                    
                </select>
             </div>
              <div class="lb-stdive"></div>
             <?php 
             $order = array('DESC'=>'Descending ','ASC'=>'Ascending');
             ?>
             <div class="item-gr">
                 <h4><?php _e('Order','magazon'); ?></h4>
                <select group-name="<?php echo $affter_name.'[data][order]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($order as $k => $a):
                     
                     $selected="";
                     if($values['data']['order']==$k){
                        $selected = ' selected ="selected" ';
                     }
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                </select>
             </div>   
    
    <?php
}




function  stpb_post_slider($function_name,$name='',$values= array()){ 
     $affter_name ='';
    if(empty($values['data']['show_title'])){
    }
    ?>
    <h2 class="stpb_title"><?php _e('Blog Posts Slider','magazon'); ?></h2>
      <div class="box-inner stpb-text" >
        <?php stpb_posts_slider_prepare_setup($function_name,$name,$values); ?>
    </div>
    <?php
};


function  stpb_post_carousel($function_name,$name='',$values= array()){ 
     $affter_name ='';
    if(empty($values['data']['show_title'])){
    }
    ?>
    <h2 class="stpb_title"><?php _e('Blog Posts Carousel','magazon'); ?></h2>
      <div class="box-inner stpb-text" >
        <?php stpb_posts_slider_prepare_setup($function_name,$name,$values); ?>
    </div>
    <?php
};




function  stpb_carousel($function_name,$name='',$values= array()){ 
     $affter_name ='';
    ?>
     <h2 class="stpb_title"><?php _e('Carousel','magazon'); ?></h2>
    <?php
    stpb_gallery($function_name,$name,$values);
    
};


function stpb_widget($function_name,$name='',$values= array()){
     $affter_name ='';
    global $wp_registered_sidebars;
    ?>
    <h2 class="stpb_title"><?php _e('Widget','magazon'); ?></h2>
      <div class="box-inner stpb-text" >
            
            <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
             <label>
                <h4><?php _e('Title','magazon'); ?></h4>
                <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
             </label>
            </div>
            <div class="lb-stdive"></div>
            
            <div class="item-gr">
        
                <h4><?php _e('Choose widget area','magazon'); ?></h4>
               <select name=""class="group-name lb-chzn-select" group-name="<?php echo $affter_name.'[data][widget]'; ?>">
                     <?php foreach($wp_registered_sidebars as $sb):
                     
                     $selected="";
                     if($values['data']['widget']==$sb['id']){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($sb['id']); ?>" <?php echo $selected; ?> ><?php echo esc_html($sb['name']); ?></option>
                     <?php endforeach; ?>
                 </select>
             
            </div>
   
    </div>
    <?php
}


function stpb_service($function_name,$name='',$values= array()){
     $affter_name ='';
     $affter_name ='';
    ?>
    <h2 class="stpb_title"><?php _e('Service Column','magazon'); ?></h2>
       <div class="box-inner stpb-service" >
            
            <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
                 <label>
                      <h4><?php _e('Title','magazon'); ?></h4>
                    <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
                 </label>
            </div>
            
            <div class="lb-stdive"></div>
            
             <div class="pb-box-upload ui-img-w item-gr">
                <h4><?php _e('Image','magazon'); ?></h4>
        		<input type="text" value="<?php echo esc_attr($values['data']['img']); ?>" group-name="<?php echo $affter_name.'[data][img]'; ?>" class="group-name pb-input-upload" >
                <a href="#"  class="pb-upload-button button-secondary"><span></span><?php echo __('Select Image','magazon'); ?></a>
                <a href="#" class="remove_image button-secondary"><span></span><?php echo __('Remove','magazon'); ?></a>
                <div class="clear"></div>
            </div>
            
            <div class="lb-stdive"></div>
            
            <div class="item-gr">
                 <label>
                  <h4><?php _e('Content','magazon'); ?></h4>
                  <textarea rows="10" class="group-name" group-name="<?php echo $affter_name.'[data][content]'; ?>" ><?php echo esc_attr($values['data']['content']); ?></textarea>
                 </label>
                 <span class="desc"><?php echo __('Arbitrary text or HTML','magazon'); ?></span>
            </div>
             
             <div class="lb-stdive"></div>
             
             <div class="item-gr">
             <label>
                <h4><?php _e('URL','magazon'); ?></h4>
                <input type="text"  class="group-name" group-name="<?php echo $affter_name.'[data][url]'; ?>" value="<?php echo esc_attr($values['data']['url']); ?>" />
                
             </label>
              <span  class="desc"><?php _e('example','magazon'); ?> : http://google.com </span>
            </div>
            
              <div class="lb-stdive"></div>
              
               <div class="item-gr">
                  <h4><?php _e('Automatically add paragraphs','magazon'); ?></h4>
                  <input type="checkbox" group-name="<?php echo $affter_name.'[data][autop]'; ?>"  class="group-name lb-ibutton"  <?php echo $values['data']['autop']==1 ?' checked="checked"  ' : ''; ?> value="1" />
                 
              </div>
              
              <div class="lb-stdive"></div>
              
             <div class="item-gr">
                 <h4><?php _e('Show read more link','magazon'); ?></h4>
                  <input type="checkbox" group-name="<?php echo $affter_name.'[data][show_more]'; ?>"  class="group-name lb-ibutton"  <?php echo $values['data']['show_more']==1 ?' checked="checked"  ' : ''; ?> value="1" /></label>
             </div>
             
              <div class="lb-stdive"></div>
              
              <div class="item-gr">
                <h4><?php _e('More text','magazon'); ?></h4>
                <input type="text"  class="group-name" group-name="<?php echo $affter_name.'[data][more_text]'; ?>" value="<?php echo esc_attr($values['data']['more_text']); ?>" />
                <span  class="desc"><?php _e('Default','magazon'); ?> : <?php echo __('Read more','magazon'); ?></span>
             </div> 
             
    </div>

    <?php
}


function stpb_alert($function_name,$name='',$values= array()){
     $affter_name ='';
    ?>
    <h2 class="stpb_title"><?php _e('Alert','magazon'); ?></h2>
      <div class="box-inner stpb-text" >
            
            <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
             <label>
                <h4><?php _e('Title','magazon'); ?></h4>
                <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
             </label>
            </div>
            
            <div class="lb-stdive"></div>
            <?php /*
             <div class="pb-box-upload ui-img-w"><label ><strong>Image:</strong></label>
        		<input type="text" value="<?php echo esc_attr($values['data']['img']); ?>" group-name="<?php echo $affter_name.'[data][img]'; ?>" class="group-name pb-input-upload" >
                 <a href="#"  class="pb-upload-button button-secondary"><span></span><?php echo __('Select Image','magazon'); ?></a>
                <a href="#" class="remove_image button-secondary"><span></span><?php echo __('Remove','magazon'); ?></a>
                <div class="clear"></div>
            </div>
            */ ?>
             
            <div class="item-gr">
                 
                  <h4><?php _e('Content','magazon'); ?></h4>
                  <textarea rows="10" class="group-name" group-name="<?php echo $affter_name.'[data][content]'; ?>" ><?php echo esc_attr($values['data']['content']); ?></textarea>
                 <span><?php echo __('Arbitrary text or HTML','magazon'); ?></span>
                 
            </div>
            
             <div class="lb-stdive"></div>
             
              <div class="item-gr">
                 <h4><?php _e('Automatically add paragraphs','magazon'); ?></h4>
                <input type="checkbox" group-name="<?php echo $affter_name.'[data][autop]'; ?>"  class="group-name lb-ibutton"  <?php echo $values['data']['autop']==1 ?' checked="checked"  ' : ''; ?> value="1" />
                <div class="clear"></div>
              </div>
           	    
             <div class="lb-stdive"></div>
             
             <?php 
             $types = array(
                     ''=>__('Notification','magazon'),
                     'info'=>__('Info','magazon'),
                     'success'=>__('Success','magazon'),
                     'error'=>__('Error','magazon'),
                   );
             ?>
             <div class="item-gr">
                <h4><?php _e('Alert type','magazon') ?></h4>
                <select group-name="<?php echo $affter_name.'[data][alert_type]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($types as $k => $a):
                     
                     $selected="";
                     if($values['data']['alert_type']==$k){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                    
                </select>
                
             </div>
  
    </div>
    <?php
}



function stpb_blog($function_name,$name='',$values= array()){
     $affter_name ='';
    
    if(empty($values['data']['show_title'])){
      //  $values['data']['show_title'] ='y';
    }
    ?>
    <h2 class="stpb_title"><?php _e('Blog Posts','magazon'); ?></h2>
      <div class="box-inner stpb-text" >

            <input type="hidden" class="group-name func_name" group-name="<?php echo $affter_name.'[function]'; ?>"  value="<?php echo $function_name; ?>" />
            
            <div class="item-gr">
             <label>
                <h4><?php _e('Title','magazon'); ?></h4>
                <input type="text"  class="group-name bigtitle" group-name="<?php echo $affter_name.'[data][title]'; ?>" value="<?php echo esc_attr($values['data']['title']); ?>" />
             </label>
            </div>
            
             <div class="lb-stdive"></div>
            

             <div class="item-gr">
               <h4><?php echo _e('Show in Categories','magazon'); ?></h4>
                <?php
                
                if(empty($values['data']['cats']) or !is_array($values['data']['cats'])){
                    $values['data']['cats'] = array();
                }
                
               // $select = wp_dropdown_categories('show_count=1&orderby=name&echo=0&class=group-name&hierarchical=1&show_option_all='.rawurlencode()));
             //  $select = preg_replace("#<select([^>]*)>#", "<select$1 multiple=\"multiple\" selected-ids=\"".join(',',$values['data']['cats'])."\" group-name=\"{$affter_name}[data][cats][]\">", $select);
                $select = wp_dropdown_categories('selected='.join(',',$values['data']['cats']).'&id=&show_count=1&orderby=name&echo=0&class=group-name++lb-chzn-select&hierarchical=1&show_option_all='.rawurlencode(__('All','magazon')));
                $select = preg_replace("#<select([^>]*)>#", "<select$1 multiple=\"multiple\" selected-ids=\"".join(',',$values['data']['cats'])."\"  group-name=\"{$affter_name}[data][cats][]\">", $select);
                echo $select;
               //  echo $select;
                ?>
                
                
             </div>
             
              <div class="lb-stdive"></div>
             
             <?php if(intval($values['data']['numpost'])<=0){
                $values['data']['numpost'] = 4;
             } ?>
             
             <div class="item-gr">
             <label>
                 <h4><?php _e('Num posts to show','magazon'); ?></h4>
                <input type="text"  class="group-name" style="width: 40px;" size="4" max="2" group-name="<?php echo $affter_name.'[data][numpost]'; ?>" value="<?php echo esc_attr($values['data']['numpost']); ?>" />
             </label>
            </div>
            
             <div class="lb-stdive"></div>
             <?php 
             $types = array('1'=>'Type  1 ','2'=>'Type  2', '3'=>'Type 3');
            
             ?>
             <div class="item-gr">
                 <h4><?php _e('Display Type','magazon'); ?></h4>
                <select group-name="<?php echo $affter_name.'[data][display_type]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($types as $k => $a):
                     
                     $selected="";
                     if($values['data']['display_type']==$k){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                </select>
             </div>
              <div class="lb-stdive"></div>
             <div class="item-gr">
                
                <h4><?php _e('Show custom title','magazon'); ?></h4>
            
                <input type="checkbox"  class="group-name lb-ibutton"  group-name="<?php echo $affter_name.'[data][show_title]'; ?>" <?php echo ($values['data']['show_title']=='y') ? ' checked="checked" ': ''; ?> value="y" />

            </div>

            <div class="lb-stdive"></div>
             <div class="item-gr">
                <h4><?php _e('Show paging','magazon'); ?></h4>
                <input type="checkbox"  class="group-name lb-ibutton"  group-name="<?php echo $affter_name.'[data][show_paging]'; ?>" <?php echo ($values['data']['show_paging']=='y') ? ' checked="checked" ': ''; ?> value="y" />
            </div>

          <div class="lb-stdive"></div>
          <div class="item-gr">
              <label>
                  <h4><?php _e('Include','magazon'); ?></h4>
                  <input type="text"  class="group-name"  group-name="<?php echo $affter_name.'[data][include]'; ?>" value="<?php echo esc_attr($values['data']['include']); ?>" />
              </label>
              <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
          </div>
            
            <div class="lb-stdive"></div>
            <div class="item-gr">
             <label>
                 <h4><?php _e('Exclude','magazon'); ?></h4>
                <input type="text"  class="group-name"  group-name="<?php echo $affter_name.'[data][exclude]'; ?>" value="<?php echo esc_attr($values['data']['exclude']); ?>" />
             </label>
             <span class="desc"><?php _e('Enter post IDs, separated by commas','magazon'); ?></span>
            </div>
            
             <div class="lb-stdive"></div>
             <?php 
             $orderby = array(''=>'Default','title'=>'Title','comment_count'=>'Comment count', 'date' => 'Date' ,'rand'=>'Random', 'post__in' => 'Id include post');
             ?>
             <div class="item-gr">
                 <h4><?php _e('Order by','magazon'); ?></h4>
                <select group-name="<?php echo $affter_name.'[data][orderby]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($orderby as $k => $a):
                     
                     $selected="";
                     if($values['data']['orderby']==$k){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                    
                </select>
                
             </div>
              <div class="lb-stdive"></div>
             <?php 
             $order = array('DESC'=>'Descending ','ASC'=>'Ascending');
             ?>
             <div class="item-gr">
                 <h4><?php _e('Order','magazon'); ?></h4>
                <select group-name="<?php echo $affter_name.'[data][order]'; ?>"  class="group-name lb-chzn-select" >
                
                <?php foreach($order as $k => $a):
                     
                     $selected="";
                     if($values['data']['order']==$k){
                        $selected = ' selected ="selected" ';
                     }
                     
                      ?>
                     <option value="<?php echo esc_attr($k); ?>" <?php echo $selected; ?> ><?php echo esc_html($a); ?></option>
                     <?php endforeach; ?>
                    
                </select>
             </div>
              
    </div>
    <?php
}



