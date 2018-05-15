<?php

function gallery_settings_action($name,$values='',$object = false){
    global $post;
   // echo var_dump($values);
    $nivo_settings = $values['nivo'];
    $flexslider_settings = $values['flexSlider'];
    $normal = $values['normal'];
    // echo var_dump($flexslider_settings);
    
    $nivo_settings = wp_parse_args($nivo_settings,array(
                                                'width'=>500,
                                                'height'=>400,
                                                'thumb_width'=>50,
                                                'thumb_height'=>50,
                                                'effect'=>array('random'),
                                                'slices'=>15,
                                                'boxCols'=>8,
                                                'boxRows'=>4,
                                                'animSpeed'=>500,
                                                'pauseTime'=>3000,
                                                'startSlide'=>0,
                                                'directionNav'=>1,
                                                'controlNav'=>1,
                                                'controlNavThumbs'=>0,
                                                'pauseOnHover'=>1,
                                                'manualAdvance'=>1,
                                                'randomStart'=>0
                                        ));
     
                                    
    $flexslider_settings = wp_parse_args($flexslider_settings,array(
                                                'display_type'=>'basic',
                                                'height'=>400,
                                                'width'=>500,
                                                'thumb_width'=>50,
                                                'thumb_height'=>50,
                                                'animation'=>array('slide'),
                                                'itemMargin'=>5,
                                                'slideshowSpeed'=>7000,
                                                'animationSpeed'=>600,
                                                'pauseOnHover'=>1
                                        ));
                                        
    $normal = wp_parse_args($normal,array(
                                                'width'=>250,
                                                'height'=>150
                                        ));
                                        
     ?>
     <div class="gallery_settings">
        <a href="#" class="st-adv-btn">Show/Hide advanced Settings</a>
        <table class="st-g-adv-set" style="display: none;">
            <tr>
                 <td><?php _e('Slider type','magazon'); ?></td>
                 <td>
                 <?php 
                  $slider_types = array(
                     'normal'=>"Normal",
                     'nivo'=>"Nivo Slider",
                     'flexSlider'=>'FlexSlider'
                  );
                 ?>
                    <select class="gallery_display_type" name="<?php echo $name.'[slider_type]'; ?>">
                         <?php foreach($slider_types as $k => $st){
                            if($k==$values['slider_type']){
                                echo '<option selected="selected" value="'.$k.'">'.htmlspecialchars($st).'</option>';
                            }else{
                                 echo '<option value="'.$k.'">'.htmlspecialchars($st).'</option>';
                            }
                         } ?>
                    </select>
                 </td>
            </tr>
            <?php 
             // ------------ for nivo slider -----------------
             ?>
             
             <tr  class="st-glmset nivo">
                 <td><?php _e('Slider size (Width x Height)','magazon'); ?> </td>
                 <td>
                    <input type="text" name="<?php echo $name.'[nivo][width]'; ?>" value="<?php echo intval($nivo_settings['width']) ?>" />
                    x
                    <input type="text" name="<?php echo $name.'[nivo][height]'; ?>" value="<?php echo intval($nivo_settings['height']) ?>" />
                 </td>
            </tr>
            

             <tr  class="st-glmset nivo">
                 <td><?php _e('Thumbnai (Width x Height)','magazon'); ?></td>
                 <td>
                 <input type="text" name="<?php echo $name.'[nivo][thumb_width]'; ?>" value="<?php echo intval($nivo_settings['thumb_width']) ?>" />
                 x
                 <input type="text" name="<?php echo $name.'[nivo][thumb_height]'; ?>" value="<?php echo intval($nivo_settings['thumb_height']) ?>" />
                 </td>
            </tr>
            
            <tr class="st-glmset nivo">
                 <td><?php _e('Effect','magazon'); ?></td>
                 <td>
                 
                   <?php
                     $nivo_effect = array(
                                    'sliceDown',
                                    'sliceDownLeft',
                                    'sliceUp',
                                    'sliceUpLeft',
                                    'sliceUpDown',
                                    'sliceUpDownLeft',
                                    'fold',
                                    'fade',
                                    'random',
                                    'slideInRight',
                                    'slideInLeft',
                                    'boxRandom',
                                    'boxRain',
                                    'boxRainReverse',
                                    'boxRainGrow',
                                    'boxRainGrowReverse'
                                );
                       if(!is_array($nivo_settings['effect'])){
                            $nivo_settings['effect'] = array();
                       }   
                             
                    foreach($nivo_effect as $ef){
                        $checked='';
                        if(in_array($ef,$nivo_settings['effect'])){
                            $checked = ' checked="checked" ';
                        }
                        ?>
                        <label><input type="checkbox" name="<?php echo $name.'[nivo][effect][]'; ?>" <?php echo $checked; ?> value="<?php echo $ef; ?>"/><?php echo htmlspecialchars($ef); ?></label><br />
                        
                    <?php
                    }
                    ?>
                 
                 </td>
            </tr>
            <tr  class="st-glmset nivo">
                 <td><?php _e('Slices','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[nivo][slices]'; ?>" value="<?php echo intval($nivo_settings['slices']) ?>" /></td>
            </tr>
            <tr  class="st-glmset nivo">
                 <td><?php  _e('Boxs (Cols x Rows)','magazon'); ?></td>
                 <td>
                    <input type="text" name="<?php echo $name.'[nivo][boxCols]'; ?>" value="<?php echo intval($nivo_settings['boxCols']) ?>" />  x 
                    <input type="text" name="<?php echo $name.'[nivo][boxRows]'; ?>" value="<?php echo intval($nivo_settings['boxRows']) ?>" />
                 </td>
            </tr>
            
            
            <tr  class="st-glmset nivo">
                 <td><?php _e('Anim Speed','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[nivo][animSpeed]'; ?>" value="<?php echo intval($nivo_settings['animSpeed']) ?>" />
                  <br /><em>Slide transition speed</em>
                 </td>
            </tr>
            
             <tr  class="st-glmset nivo">
                 <td><?php _e('Pause Time','magazon'); ?></td>
                  <td><input type="text" name="<?php echo $name.'[nivo][pauseTime]'; ?>" value="<?php echo intval($nivo_settings['pauseTime']) ?>" />
                   <br /><em>How long each slide will show</em>
                  </td>
            </tr>
             <tr  class="st-glmset nivo">
                 <td><?php _e('Start Slide','magazon'); ?></td>
                  <td><input type="text" name="<?php echo $name.'[nivo][startSlide]'; ?>" value="<?php echo intval($nivo_settings['startSlide']) ?>" /></td>
            </tr>
            <tr  class="st-glmset nivo">
                 <td><?php _e('Control Nav','magazon'); ?></td>
                 <td>
                  
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][controlNav]'; ?>" <?php  echo (intval($nivo_settings['controlNav'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][controlNav]'; ?>" <?php  echo (intval($nivo_settings['controlNav'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                    <br /><em>Show  1,2,3... navigation</em>
                 </td>
            </tr>
             <tr  class="st-glmset nivo">
                 <td><?php _e('Direction Nav','magazon'); ?></td>
                 <td>
                
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][directionNav]'; ?>" <?php  echo (intval($nivo_settings['directionNav'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][directionNav]'; ?>" <?php  echo (intval($nivo_settings['directionNav'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                    <br /><em>Show  Next &mp; Prev navigation</em>
                 </td>
            </tr>
            <tr  class="st-glmset nivo">
                 <td><?php _e('Control Nav Thumbs','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][controlNavThumbs]'; ?>" <?php  echo (intval($nivo_settings['controlNavThumbs'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][controlNavThumbs]'; ?>" <?php  echo (intval($nivo_settings['controlNavThumbs'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                  <br /><em>Use thumbnails for Control Nav</em>
                 </td>
            </tr>
            
            <tr  class="st-glmset nivo">
                 <td><?php _e('Pause On Hover','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][pauseOnHover]'; ?>" <?php  echo (intval($nivo_settings['pauseOnHover'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][pauseOnHover]'; ?>" <?php  echo (intval($nivo_settings['pauseOnHover'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                 </td>
            </tr>
            
             <tr  class="st-glmset nivo">
                 <td><?php _e('Manual Advance','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][manualAdvance]'; ?>" <?php  echo (intval($nivo_settings['manualAdvance'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][manualAdvance]'; ?>" <?php  echo (intval($nivo_settings['manualAdvance'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                  <br /><em>Force manual transitions</em>
                 </td>
            </tr>
            
            <tr  class="st-glmset nivo">
                 <td><?php _e('Random Start','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[nivo][randomStart]'; ?>" <?php  echo (intval($nivo_settings['manualAdvance'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[nivo][randomStart]'; ?>" <?php  echo (intval($nivo_settings['manualAdvance'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                    <br /><em>Start on a random slide</em>
                 </td>
            </tr>
            
            <?php 
             // ------------ end for nivo slider -----------------
             
             // ------------ end for flexSlider slider -----------------
             ?>
             
             
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Display type','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="basic" name="<?php echo $name.'[flexSlider][display_type]'; ?>" <?php  echo ($flexslider_settings['display_type']=='basic') ? ' checked="checked" ' : ''; ?> />Basic Slider</label> <br />
                  <label><input type="radio" value="thumbnail" name="<?php echo $name.'[flexSlider][display_type]'; ?>" <?php  echo ($flexslider_settings['display_type']=='thumbnail') ? ' checked="checked" ' : ''; ?>/>Slider with thumbnail slider</label> <br />
                  <label><input type="radio" value="carousel" name="<?php echo $name.'[flexSlider][display_type]'; ?>" <?php  echo ($flexslider_settings['display_type']=='carousel') ? ' checked="checked" ' : ''; ?> />Carousel</label>
                 </td>
            </tr>
            
            <tr  class="st-glmset flexSlider">
                 <td><?php _e('Width','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[flexSlider][width]'; ?>" value="<?php echo intval($flexslider_settings['width']) ?>" /></td>
            </tr>
            
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Animation Loop','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[flexSlider][animationLoop]'; ?>" <?php  echo (intval($flexslider_settings['animationLoop'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[flexSlider][animationLoop]'; ?>" <?php  echo (intval($flexslider_settings['animationLoop'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                 </td>
            </tr>
            
            <tr  class="st-glmset flexSlider">
                 <td><?php _e('Height','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[flexSlider][height]'; ?>" value="<?php echo intval($flexslider_settings['height']) ?>" /></td>
            </tr>
            
            <tr  class="st-glmset flexSlider">
                 <td><?php _e('Thumbnai size (Width x Height)','magazon'); ?></td>
                 <td>
                 <input type="text" name="<?php echo $name.'[flexSlider][thumb_width]'; ?>" value="<?php echo intval($flexslider_settings['thumb_width']) ?>" />
                 x
                 <input type="text" name="<?php echo $name.'[flexSlider][thumb_height]'; ?>" value="<?php echo intval($flexslider_settings['thumb_height']) ?>" />
                 </td>
            </tr>
            

            <tr  class="st-glmset flexSlider">
                 <td><?php _e('Item Margin','magazon'); ?> </td>
                 <td><input type="text" name="<?php echo $name.'[flexSlider][itemMargin]'; ?>" value="<?php echo intval($flexslider_settings['itemMargin']) ?>" /></td>
            </tr>
            
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Item Width', 'magazon'); ?></td>
                 <td>
                 <input type="text" name="<?php echo $name.'[flexSlider][itemWidth]'; ?>" value="<?php echo intval($flexslider_settings['itemWidth']) ?>" />
                 
                 </td>
            </tr>
            
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Animation','magazon'); ?> </td>
                 <td>
                    <?php
                             $animations = array(
                                            'slide',
                                            'fade'
                                        );
                               if(!is_array($flexslider_settings['animation'])){
                                    $flexslider_settings['animation'] = array();
                               }   
                                     
                            foreach($animations as $ef){
                                $checked='';
                                if(in_array($ef,$flexslider_settings['animation'])){
                                    $checked = ' checked="checked" ';
                                }
                                ?>
                                <label><input type="radio" name="<?php echo $name.'[flexSlider][animation]'; ?>" <?php echo $checked; ?> value="<?php echo $ef; ?>"/><?php echo htmlspecialchars($ef); ?></label><br />
                                
                            <?php
                            }
                            ?>
                    </td>
            </tr>
            
            <tr  class="st-glmset flexSlider">
                 <td><?php _e('Slideshow Speed','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[flexSlider][slideshowSpeed]'; ?>" value="<?php echo intval($flexslider_settings['slideshowSpeed']) ?>" /></td>
            </tr>
            
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Animation Speed','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[flexSlider][animationSpeed]'; ?>" value="<?php echo intval($flexslider_settings['animationSpeed']) ?>" /></td>
            </tr>
            
             <tr  class="st-glmset flexSlider">
                 <td><?php _e('Pause On Hover','magazon'); ?></td>
                 <td>
                  <label><input type="radio" value="1" name="<?php echo $name.'[flexSlider][pauseOnHover]'; ?>" <?php  echo (intval($flexslider_settings['pauseOnHover'])==1) ? ' checked="checked" ' : ''; ?> />Yes</label>
                  <label><input type="radio" value="0" name="<?php echo $name.'[flexSlider][pauseOnHover]'; ?>" <?php  echo (intval($flexslider_settings['pauseOnHover'])==0) ? ' checked="checked" ' : ''; ?>/>No</label>
                 </td>
            </tr>
             
           <?php //  ----------- end for flexSlider slider ----------------- ?>  
           <?php //  ----------- for normal  ----------------- ?>  
           
           <tr  class="st-glmset normal">
                 <td><?php _e('Width','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[normal][width]'; ?>" value="<?php echo intval($normal['width']) ?>" /></td>
            </tr>
            
            
            <tr  class="st-glmset normal">
                 <td><?php _e('Height','magazon'); ?></td>
                 <td><input type="text" name="<?php echo $name.'[normal][height]'; ?>" value="<?php echo intval($normal['height']) ?>" /></td>
            </tr>
            
           
            <?php //  ----------- end for normal  ----------------- ?>  
            
        </table>
        
        <div class="st-more-code">
        <?php 
        
        if(intval($post->ID)>0){
                 $key = $object->meta_name.'|'.$object->field['name'];
                 $short_code = "[st-gallery key=\"$key\" id=\"$post->ID\"]";
               
            }else{
                 $short_code = "[st-gallery key=\"{$object->field['name']}\"]";
            }
            ?>
            <?php _e('Shortcode','magazon') ?> : <code><?php echo htmlspecialchars($short_code); ?></code>
        </div>
     </div>
     <?php
}


add_action('st_option_gallery_settings','gallery_settings_action',10,3);
