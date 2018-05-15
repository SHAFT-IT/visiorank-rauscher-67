<?php

/**
 * @author Kien T. - http://www.smooththemes.com
 * @copyright 2012
 */


/*-----------------------------------------------------------------------------------*/
/*-----: ST_Widget_Ads125x125 :-----*/
/*-----------------------------------------------------------------------------------*/

     class st_widget_125 extends WP_Widget {
         function st_widget_125() {
            
            //Constructor
            $widget_ops = array('classname' => 'widget_ads_125x125', 
                                'description' => 'A widget that allows the display of ads 125x125' );
            $this->WP_Widget('st_widget_125', 'ST Ads 125x125', $widget_ops);
         }
          
         function widget($args, $instance) {
            // prints the widget
            extract($args);
            
            //variables from widget setting
            $title = apply_filters('widget_title', $instance['title']);
            
            // Ads 125x125 Images Link
            $ads_img1 = $instance['ads_img1'];
            $ads_img2 = $instance['ads_img2'];
            $ads_img3 = $instance['ads_img3'];
            $ads_img4 = $instance['ads_img4'];
            $ads_img5 = $instance['ads_img5'];
            $ads_img6 = $instance['ads_img6'];
            $ads_img7 = $instance['ads_img7'];
            $ads_img8 = $instance['ads_img8'];
            
            // Ads link
            $link1 = $instance['link1'];
            $link2 = $instance['link2'];
            $link3 = $instance['link3'];
            $link4 = $instance['link4'];
            $link5 = $instance['link5'];
            $link6 = $instance['link6'];
            $link7 = $instance['link7'];
            $link8 = $instance['link8'];
            
            // Random ads
            $randomize = $instance['random'];
            
            
            
            // Before Widget :
            echo $before_widget;
            
            // Display Widget Title if one was input .
            if($title)
                echo $before_title.$title.$after_title; // Before_title and After_title define by theme .
                
            // Randomize ads
            $random_ads = array();
            
            // Display Ads
                echo '<div class="ads125"><ul>'; // Containing DIV
                
                // Ads slot 1
                if($link1)
                    $random_ads[] = '<li><a href="' . $link1 . '"><img src="' . $ads_img1 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img1)
                    $random_ads[] = '<li><img src="' . $ads_img1 . '" width="125" height="125" alt="" /></li>';
                
                // Ads slot 2
                if($link2)
                    $random_ads[] = '<li><a href="' . $link2 . '"><img src="' . $ads_img2 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img2)
                    $random_ads[] = '<li><img src="' . $ads_img2 . '" width="125" height="125" alt="" /></li>';   
                    
                // Ads slot 3
                if($link3)
                    $random_ads[] = '<li><a href="' . $link3 . '"><img src="' . $ads_img3 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img3)
                    $random_ads[] = '<li><img src="' . $ads_img3 . '" width="125" height="125" alt="" /></li>';
                    
                // Ads slot 4
                if($link4)
                    $random_ads[] = '<li><a href="' . $link4 . '"><img src="' . $ads_img4 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img4)
                    $random_ads[] = '<li><img src="' . $ads_img4 . '" width="125" height="125" alt="" /></li>';
                    
                // Ads slot 5
                if($link5)
                    $random_ads[] = '<li><a href="' . $link5 . '"><img src="' . $ads_img5 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img5)
                    $random_ads[] = '<li><img src="' . $ads_img5 . '" width="125" height="125" alt="" /></li>';
                    
                // Ads slot 6
                if($link6)
                    $random_ads[] = '<li><a href="' . $link6 . '"><img src="' . $ads_img6 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img6)
                    $random_ads[] = '<li><img src="' . $ads_img6 . '" width="125" height="125" alt="" /></li>';
                    
                // Ads slot 7
                if($link7)
                    $random_ads[] = '<li><a href="' . $link7 . '"><img src="' . $ads_img7 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img7)
                    $random_ads[] = '<li><img src="' . $ads_img7 . '" width="125" height="125" alt="" /></li>';
                    
                // Ads slot 8
                if($link8)
                    $random_ads[] = '<li><a href="' . $link8 . '"><img src="' . $ads_img8 . '" width="125" height="125" alt="" /></a></li>';
                elseif($ads_img8)
                    $random_ads[] = '<li><img src="' . $ads_img8 . '" width="125" height="125" alt="" /></li>';
                
                //Randomize order if user want it
                if ($randomize){
                    shuffle($random_ads);
                }
                
                //Display ads
                foreach($random_ads as $random_ad){
                    echo $random_ad;
                }     
                    
                echo '</ul></div><div class="clear"></div>'; // end Containing DIV
            
            // After Widget
            echo $after_widget;
         }
          
         function update($new_instance, $old_instance) {
            //save the widget
            $instance = $old_instance;
            
            // Only text inputs
            $instance['title'] = strip_tags($new_instance['title']);
            
            $instance['ads_img1'] = $new_instance['ads_img1'];
            $instance['ads_img2'] = $new_instance['ads_img2'];
            $instance['ads_img3'] = $new_instance['ads_img3'];
            $instance['ads_img4'] = $new_instance['ads_img4'];
            $instance['ads_img5'] = $new_instance['ads_img5'];
            $instance['ads_img6'] = $new_instance['ads_img6'];
            $instance['ads_img7'] = $new_instance['ads_img7'];
            $instance['ads_img8'] = $new_instance['ads_img8'];
            
            $instance['link1'] = $new_instance['link1'];
            $instance['link2'] = $new_instance['link2'];
            $instance['link3'] = $new_instance['link3'];
            $instance['link4'] = $new_instance['link4'];
            $instance['link5'] = $new_instance['link5'];
            $instance['link6'] = $new_instance['link6'];
            $instance['link7'] = $new_instance['link7'];
            $instance['link8'] = $new_instance['link8'];
            
            $instance['random'] = $new_instance['random'];
            
            return $instance;
         }
          
         function form($instance) {
            //widgetform in backend
            
            //default widget settings.
            $defaults_setting = array(
                'title' => '',
                'ads_img1' => '',
                'link1' => '',
                'ads_img2' => '',
                'link2' => '',
                'ads_img3' => '',
                'link3' => '',
                'ads_img4' => '',
                'link4' => '',
                'ads_img5' => '',
                'link5' => '',
                'ads_img6' => '',
                'link6' => '',
                'ads_img7' => '',
                'link7' => '',
                'ads_img8' => '',
                'link8' => '',
                'random' => false
            );
            $instance = wp_parse_args( (array) $instance, $defaults_setting );
            ?>
            
            <!-- Widget Title -->
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </p>
            
            <!-- Ads 1 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img1' ); ?>"><?php _e('Ads 1 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img1' ); ?>" name="<?php echo $this->get_field_name( 'ads_img1' ); ?>" value="<?php echo $instance['ads_img1']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Ads 1 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" />
            </p>
            
            <!-- Ads 2 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img2' ); ?>"><?php _e('Ads 2 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img2' ); ?>" name="<?php echo $this->get_field_name( 'ads_img2' ); ?>" value="<?php echo $instance['ads_img2']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Ads 2 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" />
            </p>
            
            <!-- Ads 3 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img3' ); ?>"><?php _e('Ads 3 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img3' ); ?>" name="<?php echo $this->get_field_name( 'ads_img3' ); ?>" value="<?php echo $instance['ads_img3']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Ads 3 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" />
            </p>
            
            <!-- Ads 4 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img4' ); ?>"><?php _e('Ads 4 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img2' ); ?>" name="<?php echo $this->get_field_name( 'ads_img4' ); ?>" value="<?php echo $instance['ads_img4']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link4' ); ?>"><?php _e('Ads 4 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link4' ); ?>" name="<?php echo $this->get_field_name( 'link4' ); ?>" value="<?php echo $instance['link4']; ?>" />
            </p>
            
            <!-- Ads 5 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img5' ); ?>"><?php _e('Ads 5 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img2' ); ?>" name="<?php echo $this->get_field_name( 'ads_img5' ); ?>" value="<?php echo $instance['ads_img5']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link5' ); ?>"><?php _e('Ads 5 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link5' ); ?>" name="<?php echo $this->get_field_name( 'link5' ); ?>" value="<?php echo $instance['link5']; ?>" />
            </p>
            
            <!-- Ads 6 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img6' ); ?>"><?php _e('Ads 6 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img6' ); ?>" name="<?php echo $this->get_field_name( 'ads_img6' ); ?>" value="<?php echo $instance['ads_img6']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link6' ); ?>"><?php _e('Ads 6 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link6' ); ?>" name="<?php echo $this->get_field_name( 'link6' ); ?>" value="<?php echo $instance['link6']; ?>" />
            </p>
            
            <!-- Ads 7 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img7' ); ?>"><?php _e('Ads 7 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img7' ); ?>" name="<?php echo $this->get_field_name( 'ads_img7' ); ?>" value="<?php echo $instance['ads_img7']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link7' ); ?>"><?php _e('Ads 7 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link7' ); ?>" name="<?php echo $this->get_field_name( 'link7' ); ?>" value="<?php echo $instance['link7']; ?>" />
            </p>
            
            <!-- Ads 8 : Images link and Ads link-->
            <p>
                <label for="<?php echo $this->get_field_id( 'ads_img8' ); ?>"><?php _e('Ads 8 image url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'ads_img8' ); ?>" name="<?php echo $this->get_field_name( 'ads_img8' ); ?>" value="<?php echo $instance['ads_img8']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'link8' ); ?>"><?php _e('Ads 8 url:', 'magazon') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link8' ); ?>" name="<?php echo $this->get_field_name( 'link8' ); ?>" value="<?php echo $instance['link8']; ?>" />
            </p>
            
            <!-- Randomize -->
        <p>
            
            <?php if ($instance['random']){ ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" checked="checked" />
            <?php } else { ?>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>"  />
            <?php } ?>
            <label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e('Randomize ads ?', 'magazon') ?></label>
        </p>
            
         <?php   
         }
     }
     
     function ST_Widget_Ads125125(){
        register_widget('st_widget_125');
     }
     
     add_action( 'widgets_init', 'ST_Widget_Ads125125' );
?>
