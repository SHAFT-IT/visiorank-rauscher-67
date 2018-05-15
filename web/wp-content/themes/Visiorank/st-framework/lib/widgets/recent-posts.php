<?php 

class STRecentPosts extends WP_Widget {

	public function __construct() {
		// widget actual processes
        parent::__construct(
	 		'strecentposts', // Base ID
			'ST Recent Posts', // Name
			array( 'description' => __( 'Display Recent Posts', 'magazon' ), ) // Args
		);
	}

 	public function form( $instance ) {
		// outputs the options form on admin
        
        if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
        
        $number = intval($instance[ 'number' ]);
        
        if($number<=0){
            $number = 3; // default  = 3;
        }
        
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','magazon' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
        	<p>
    		<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo __('How many post to show ? ' ,'magazon') ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
    		</p>
        
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance[ 'number' ] = intval($new_instance[ 'number' ]);
		return $instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
            global $wpdb,$post;
            
            extract( $args );
    		$title = apply_filters( 'widget_title', $instance['title'] );
            $number = intval($instance['number'] );
            if($number<=0){
                $number = 3; // default  = 3;
            }
    
    		echo $before_widget;
    		if ( ! empty( $title ) )
    			echo $before_title . $title . $after_title;
                
                
                 /**
             * New in ver 1.3
             */ 
               $args = array( 'posts_per_page' => $number );
                if($cats>0){
                    $args['category__in'] =  array($cats);
                }
                $args['post__not_in'] = array($post->ID);
                $args['orderby'] = 'post_date';
                $args['order'] = 'DESC';
                 $args['post_status'] = 'publish';
                
                 if(st_is_wpml()){
                     $args['sippress_filters'] = true;
                    $args['language'] = get_bloginfo('language');
                 }
                 $new_query = new WP_Query($args);
                 $posts =  $new_query->posts;
                
            /*
             $args = array(
                'numberposts' => $number,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'exclude' => array($post->ID) ,
              //  'post_type' => $post->post_type,
                'post_status' => 'publish'
              );
        
            	$posts = wp_get_recent_posts( $args ,'OBJECT');
                */

        	if($posts){ ?>
            <ul class="po_re_container">
                <?php foreach($posts as $post){ setup_postdata($post); ?>
                        
                        <li class="widget-post-wrapper">
                        		<div class="widget-post-thumb">
                              <?php 
                                  echo st_post_thumbnail($post->ID);
                              ?>
                              </div>
                        	<div class="widget-post-content">
                        		<h3 class="widget-post-title"><a <?php echo $title; ?> href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                        		<span class="widget-post-meta"><?php echo get_the_date(); ?> - <span><?php comments_number(__('0 Comment','magazon'),__('1 Comment','magazon'),__('% Comments','magazon') )?></span></span>
                        	</div>
                        </li>
                <?php } ?>
             </ul>
            <?php }	wp_reset_query() ;
            
        	echo $after_widget;
	}

}

register_widget( 'STRecentPosts' );