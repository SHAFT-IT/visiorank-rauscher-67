<?php 

class STTabsContent extends WP_Widget {

	public function __construct() {
		// widget actual processes
        parent::__construct(
	 		'sttabscontent', // Base ID
			'ST Tabs content', // Name
			array( 'description' => __( 'Display Popular Posts, Recent Posts, lastest comments,...', 'magazon' ), ) // Args
		);
	}
    
    function  popular_settings($instance){
        ?>
        <legend><?php _e('Popular posts Tab','magazon'); ?></legend>
        <p>
            <label>
             <input type="checkbox" id="<?php echo $this->get_field_id( 'popular_show' ); ?>" name="<?php echo $this->get_field_name( 'popular_show' ); ?>" value="1" <?php echo ($instance['popular_show'] ==1) ? ' checked="checked" ' : "";  ?> name="" /><?php _e('Show this tab','magazon'); ?>
            </label> 
        </p>
        <p>
    		<label for="<?php echo $this->get_field_id( 'popular_title' ); ?>"><?php _e( 'Tab Title:','magazon'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'popular_title' ); ?>" name="<?php echo $this->get_field_name( 'popular_title' ); ?>" type="text" value="<?php echo esc_attr( $instance['popular_title'] ); ?>" />
		</p>
    	<p>
    		<label for="<?php echo $this->get_field_id( 'popular_number' ); ?>"><?php echo __('How many post to show ? ' ,'magazon') ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'popular_number' ); ?>" name="<?php echo $this->get_field_name( 'popular_number' ); ?>" type="text" value="<?php echo esc_attr( $instance['popular_number'] ); ?>" />
		</p>
        <?php
    }
    
    function recent_settings($instance){
        ?>
    
        <legend><?php _e('Recent posts Tab','magazon'); ?></legend>
        <p>
            <label>
             <input type="checkbox" id="<?php echo $this->get_field_id( 'recent_show' ); ?>" name="<?php echo $this->get_field_name( 'recent_show' ); ?>" <?php echo ($instance['recent_show'] ==1) ? ' checked="checked" ' : "";  ?>  value="1" /><?php _e('Show this tab','magazon'); ?>
            </label> 
        </p>
        <p>
    		<label for="<?php echo $this->get_field_id( 'recent_title' ); ?>"><?php _e( 'Tab Title:','magazon'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'recent_title' ); ?>" name="<?php echo $this->get_field_name( 'recent_title' ); ?>" type="text" value="<?php echo esc_attr($instance['recent_title'] ); ?>" />
		</p>
    	<p>
    		<label for="<?php echo $this->get_field_id( 'recent_number' ); ?>"><?php echo __('How many post to show ? ' ,'magazon') ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'recent_number' ); ?>" name="<?php echo $this->get_field_name( 'recent_number' ); ?>" type="text" value="<?php echo esc_attr( $instance['recent_number'] ); ?>" />
		</p>

        
        <?php
    }
    
    function comments_settings($instance){
        ?>
         <legend><?php _e('Recent comments Tab','magazon'); ?></legend>
        <p>
            <label>
             <input type="checkbox" id="<?php echo $this->get_field_id( 'comments_show' ); ?>" name="<?php echo $this->get_field_name( 'comments_show' ); ?>" <?php echo ($instance['comments_show'] ==1) ? ' checked="checked" ' : "";  ?> value="1" /><?php _e('Show this tab','magazon'); ?>
            </label> 
        </p>
        <p>
    		<label for="<?php echo $this->get_field_id( 'comments_title' ); ?>"><?php _e( 'Tab Title:','magazon'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'comments_title' ); ?>" name="<?php echo $this->get_field_name( 'comments_title' ); ?>" type="text" value="<?php echo esc_attr( $instance['comments_title'] ); ?>" />
		</p>
    	<p>
    		<label for="<?php echo $this->get_field_id( 'comments_number' ); ?>"><?php echo __('How many comments to show ? ' ,'magazon') ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'comments_number' ); ?>" name="<?php echo $this->get_field_name( 'comments_number' ); ?>" type="text" value="<?php echo esc_attr( $instance['comments_number'] ); ?>" />
		</p>
        <?php
    }
     


 	public function form( $instance ) {
		// outputs the options form on admin
         $id = 'widget-'.uniqid();
         if(empty($instance) or count($instance)==0){
                 $is_empty = true;
             }else{
                $is_empty = false;
          
             }
                          
        if(empty($instance['tabs_order']) or !is_array($instance['tabs_order'])){
            $instance['tabs_order'] = array('popular','recent','comments');
        }
        
       // $instance['tabs_order'] = array('popular','recent','comments');
        
		?>
     <script type="text/javascript">
          jQuery(document).ready(function(){
                     //for area  sortable
            jQuery('#<?php echo $id; ?>').sortable({
                        stop: function(event,ui){
                        }
                });
          });
     </script>   
    <div id="<?php echo $id; ?>"> 
    <?php foreach($instance['tabs_order'] as $tab): 
    ?>
	<fieldset style="border: 1px solid #ccc ; padding: 5px; background: #F8F8F8; margin: 5px 0px;">
            <?php
             if($is_empty){
                $instance[$tab.'_show'] = 1;
             }
             
 
             switch(strtolower($tab)){
                case 'popular';
                 $this->popular_settings($instance);
                break;
                case 'recent';
                 $this->recent_settings($instance);
                break;
                case 'comments';
                 $this->comments_settings($instance);
                break;
             }
            
             ?>
            <input  type="hidden" name="<?php echo $this->get_field_name( 'tabs_order' ); ?>[]" value="<?php echo esc_attr($tab); ?>"/>
    </fieldset>
    <?php endforeach; ?>        
    
    </div>   
    
    <p class="description"><?php _e('Drag tabs to sort','magazon'); ?></p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance = array();
		 $instance = $new_instance;
		return $instance;
	}

	public function widget( $args, $instance ) {
		?>
        <div class="widget-content widget-container">
                    <div class="content-tabbed">
                        <div class="list-tabbed-container">
                            <ul class="list-tabbed clearfix">
                             <?php 
                             $i=1;
                             foreach($instance['tabs_order'] as $tab) : 
                             if($instance[$tab.'_show']!=1){
                                continue;
                             }
                              $class = ($i==1) ? 'list-tabbed-active' : '';
                              $title = '';
                               switch(strtolower($tab)){
                                case 'popular';
                                 $title = trim($instance['popular_title'])!='' ? $instance['popular_title'] : __('Popular','magazon');
                                break;
                                case 'recent';
                                  $title = trim($instance['recent_title'])!='' ?  $instance['recent_title'] : __('Recent','magazon');
                                break;
                                case 'comments';
                                  $title = trim($instance['comments_title'])!='' ? $instance['comments_title'] : __('Comments','magazon');
                                break;
                             }
                             ?>
                                <li class="<?php echo $class; ?>"><a for-tab="<?php echo esc_attr($tab); ?>" href="#"><?php echo esc_attr($title); ?></a></li>
                              <?php
                              $i++;
                               endforeach; ?>
                            </ul>
                        </div>
                        <div class="tabbed_content_container">
                        
                             <?php 
                             $i=1;
                             foreach($instance['tabs_order'] as $tab) : 
                             
                             if($instance[$tab.'_show']!=1){
                                continue;
                             }
                             $style = ($i==1) ?  ' style="display: block;"  ' : '';
                             ?>
                             <div <?php echo $style; ?> class="tabbed_content <?php echo esc_attr($tab); ?>" <?php /* id="<?php echo esc_attr($tab); ?>" */ ?> >
                                <?php 
                                    
                                     switch(strtolower($tab)){
                                        case 'popular';
                                            $popular =  new STPopularPosts();
                                            $popular->widget(array(
                                                'before_widget' => '<div id="" class="widget-container  ">',
                                                'after_widget'  => '</div>',
                                                'before_title'  => '<h3 class="single-related-heading">',
                                                'after_title'   => '</h3>'
                                            ),array('title'=>'','number'=>$instance['popular_number']));
                                        break;
                                        case 'recent';
                                            $recent = new STRecentPosts();
                                              $recent->widget(array(
                                                            'before_widget' => '<div id="" class="single-recent-content ">',
                                                            'after_widget'  => '</div>',
                                                            'before_title'  => '<h3 class="single-recent-heading">',
                                                            'after_title'   => '</h3>'
                                            ),array('title'=>'','number'=>$instance['recent_number']));
                                        break;
                                        case 'comments';
                                            $com = new STRecentComments();
                                            $com->widget(array(
                                                        'before_widget' => '<div id="" class="single-recent-comments ">',
                                                        'after_widget'  => '</div>',
                                                        'before_title'  => '<h3 class="single-recent-heading">',
                                                        'after_title'   => '</h3>'
                                                    ),array('title'=>'','number'=>$instance['comments_number']));
                                        break;
                                     }
                                
                                ?>
                             </div>
                             <?php
                              $i++;
                              endforeach;
                              ?>
                    
                        </div>
                    </div>
                </div>
        
        <?php
	}

}

register_widget( 'STTabsContent' );