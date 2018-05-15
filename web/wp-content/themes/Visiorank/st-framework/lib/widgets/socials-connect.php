<?php

/*******************************************/
class STSocialsConnect extends WP_Widget {


    /** constructor -- name this the same as the class above */
   
    
    public function __construct() {
		// widget actual processes
         $this->cacheFileName = dirname(__FILE__)."/STSocialsConnect_cache.txt";
        parent::__construct('STSocialsConnect',__('ST Socials Connect'),  array('description' => __('Social Counter Widget','magazon')));
       
	}

    function get_tweets_bearer_token( $consumer_key, $consumer_secret ){
        $consumer_key = rawurlencode( $consumer_key );
        $consumer_secret = rawurlencode( $consumer_secret );

        $token = maybe_unserialize( get_option( 'st_twitter_connect_widget' ) );

        if( ! is_array($token) || empty($token) || $token['consumer_key'] != $consumer_key || empty($token['access_token']) ) {
            $authorization = base64_encode( $consumer_key . ':' . $consumer_secret );

           $options = array(
                'headers' => array(
                    'Authorization' => 'Basic '.$authorization,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ),
                'body' => array( 'grant_type' => 'client_credentials')
            );
            $result = wp_remote_post('https://api.twitter.com/oauth2/token', $options);
            $result  = json_decode(wp_remote_retrieve_body($result));

            $token = serialize( array(
                'consumer_key'      => $consumer_key,
                'access_token'      => $result->access_token
            ) );
            update_option( 'st_twitter_connect_widget', $token );
        }
    }

    function get_followers( $instance ){
        extract($instance);
        $token = maybe_unserialize( get_option( 'st_twitter_connect_widget' ) );
        if(!$token){
            return  0;
        }

        $number = 1;

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.rawurlencode($twitter_id).'&count='.$number;
        $url .= '&exclude_replies=true';


        $options = array(
            'headers' => array(
                'Authorization' => 'Bearer '.$token['access_token']
            )
        );

        $result = wp_remote_get($url, $options);
        $result  = json_decode(wp_remote_retrieve_body($result));


        if(is_array($result)  && isset($result[0]->user)){
            return  intval($result[0]->user->followers_count);
        }

        // followers_count count
        return  ($result->statuses) ?  $result->statuses[0]->user->followers_count : 0;
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $facebook_id	= $instance['facebook_id'];
        $twitter_id	= ($instance['twitter_id']!='') ? $instance['twitter_id'] : 'SmoothThemes';
        $feedburner_id = $instance['feedburner_id'];
       // $cacheFileName = $this->cacheFileName;
        $rss = esc_attr($instance['rss']);
		
		$mailchimp =  esc_attr($instance['mailchimp']);
		
		$formtype = $instance['formtype'];
       
        if(trim($title)==''){
            $title = sprintf(__('Keep Update With %s',get_bloginfo('name')),'magazon');
        }
		
		
		 $email_txt = __('Your Email Address...','magazon');


        // twitter
        $this->get_tweets_bearer_token($instance['consumer_key'], $instance['consumer_secret']);
        $t_followers =  $this->get_followers($instance);

        
        echo $before_widget;
         ?>
        <div class="connect-widget-wrapper">
                <h3 class="connect-widget-title"><?php echo  esc_html($title); ?></h3>
                <div class="connect-widget-form">
                    <p><?php  echo esc_html($instance['text']); ?></p>
                    
                    
                   <?php if($formtype!='m'){ ?> 
                    
                    <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="_blank" >
                     
                    <input type="text" class="subs_input" name="email" value="<?php echo $email_txt; ?>" onfocus="if (this.value == '<?php echo $email_txt; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $email_txt; ?>';}">
                    <input type="hidden" value="<?php echo esc_attr($feedburner_id); ?>" name="uri"/>
                    <input type="hidden" name="loc" value="en_US"/>
                    <input type="submit" value="<?php _e('Subscribe','magazon'); ?>" class="subs_submit">
                  
                   </form>
                   <?php } else { ?>
                   
                   <form id="subscribe_form" action="<?php echo esc_url($mailchimp); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="" target="_blank" novalidate>
					 <?php
                      $email_txt = __('Your Email Address...','magazon');
                      $email_holder = json_encode($email_txt); 
                      ?>
					 
					  
					 <input type="text" value="" name="EMAIL" class="subs_input" id="mce-EMAIL" placeholder="<?php  echo $email_txt; ?>" required="true">
					  <input type="submit" name="subscribe" value="<?php _e('Subscribe','smooththemes'); ?>" class=" subs_submit">
				 </form>
				 <?php }  ?>
					                   
                   
                    
                </div>
                <div class="connect-widget-social">
                    <a class="connect-rss" href="<?php  echo $rss; ?>"><strong><?php _e('RSS','magazon'); ?></strong><?php _e('Subscribe','magazon'); ?></a>
                     <?php if($twitter_id) { ?>
                    <a class="connect-twitter" twitter-id="<?php echo $twitter_id; ?>" one-text="<?php _e('Follower','magazon'); ?>" plural-text="<?php _e('Followers','magazon'); ?>" href="<?php echo "https://twitter.com/".$twitter_id; ?>">
                        <strong class="num"><?php echo $t_followers; ?></strong>
                        <span class="txt"><?php echo _n('Follower','Followers',$t_followers,'magazon'); ?></span>
                    </a>
                    <?php } ?>
                    <?php if($facebook_id) { ?>
                    <a class="connect-facebook last" facebook-id="<?php echo $facebook_id; ?>" one-text="<?php _e('Like','magazon'); ?>" plural-text="<?php _e('Likes','magazon'); ?>" href="https://www.facebook.com/<?php echo $facebook_id; ?>">
                        <strong class="num"></strong>
                        <span class="txt"></span>
                    </a>
                    <?php } ?>
                    
                </div>
            </div>
        <?php
        
        echo $after_widget; 
        
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        @unlink($this->cacheFileName);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = strip_tags($new_instance['twitter_id']);
        $instance['consumer_secret'] =  $new_instance['consumer_secret'];
        $instance['consumer_key']  = $new_instance['consumer_key'];


        $instance['facebook_id'] = strip_tags($new_instance['facebook_id']);
        $instance['feedburner_id'] = strip_tags($new_instance['feedburner_id']);
        $instance['text'] = $new_instance['text'];
        $instance['rss'] = $new_instance['rss'];
		$instance['mailchimp'] =  $new_instance['mailchimp'];
		$instance['formtype']  = $new_instance['formtype'];
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        $title 		 = esc_attr($instance['title']);
        $twitter_id  = esc_attr($instance['twitter_id']);
        $facebook_id = esc_attr($instance['facebook_id']);
        $feedburner_id = esc_attr($instance['feedburner_id']);
        $custom_txt = esc_attr($instance['text']);
        $rss = esc_attr($instance['rss']);
		$mailchimp =  esc_attr($instance['mailchimp']);
		
		$formtype = $instance['formtype'];
		
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <hr/>

        <p>
          <label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Twitter ID:','magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" type="text" value="<?php echo $twitter_id; ?>" />
          <br /><span class="description"><?php _e('Example: <strong>smooththemes</strong>','magazon'); ?></span>
        </p>

        <p><label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e('Consumer Key','smooththemes') ?></label><br />
            <input type="text" name="<?php echo $this->get_field_name('consumer_key') ?>" id="<?php echo $this->get_field_id('consumer_key') ?>" class="widefat" value="<?php echo $instance['consumer_key'] ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('consumer_secret') ?>"><?php _e('Consumer Secret', 'smooththemes') ?></label><br />
            <input type="text" name="<?php echo $this->get_field_name('consumer_secret') ?>"  class="widefat" id="<?php echo $this->get_field_id('consumer_secret') ?>" value="<?php echo $instance['consumer_secret'] ?>">
        </p>
        <small>Get Consumer Key and Consumer Secret from <a href="https://dev.twitter.com/apps/new">https://dev.twitter.com/apps/new</a> </small>

        <hr/>


        <p>
          <label for="<?php echo $this->get_field_id('facebook_id'); ?>"><?php _e('Facebook page URL:','magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('facebook_id'); ?>" name="<?php echo $this->get_field_name('facebook_id'); ?>" type="text" value="<?php echo $facebook_id; ?>" />
          <br /><span class="description"><?php _e('Example: <strong>smooththemes</strong>','magazon'); ?></span>
        </p>

        <hr/>
        
        <p>
          <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS URL:' ,'magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo $rss; ?>" />
           
        </p>

        <hr/>
        
         <p>
          <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:' ,'magazon'); ?></label><br />
          <textarea rows="7" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" ><?php echo $custom_txt; ?></textarea>
            <br /><span class="description"><?php _e('Example: <strong>smooththemes</strong>','magazon'); ?></span>
        </p>

        <hr/>
        
        <p>
          <label for="<?php echo $this->get_field_id('formtype'); ?>"><?php _e('Form type:' ,'magazon'); ?></label><br />
          
          <label>
          	<input type="radio"  id="<?php echo $this->get_field_id('formtype'); ?>" name="<?php echo $this->get_field_name('formtype'); ?>" <?php  echo ($formtype=='' ||  $formtype!='m') ? ' checked="checked" ' : ''; ?> value="f" />
          	<?php  _e('Feedburner','magazon'); ?>
          </label>
          <br/>
          <label>
          	<input type="radio"  id="<?php echo $this->get_field_id('formtype'); ?>" name="<?php echo $this->get_field_name('formtype'); ?>" <?php  echo ($formtype=='m') ? ' checked="checked" ' : ''; ?>  value="m" />
          	<?php  _e('Mailchimp','magazon'); ?>
          </label>
          
        </p>
        

        <p>
          <label for="<?php echo $this->get_field_id('feedburner_id'); ?>"><?php _e('Feedburner URLI:' ,'magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('feedburner_id'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" type="text" value="<?php echo $feedburner_id; ?>" />
            <br /><span class="description"><?php _e('Example: <strong>smooththemes</strong>','magazon'); ?></span>
        </p>
        
        
        <p>
          <label for="<?php echo $this->get_field_id('mailchimp'); ?>"><?php _e('Mailchimp Action:' ,'magazon'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('mailchimp'); ?>" name="<?php echo $this->get_field_name('mailchimp'); ?>" type="text" value="<?php echo $mailchimp; ?>" />
            <br /><span class="description"><?php _e('Example: <strong>smooththemes</strong>','magazon'); ?></span>
        </p>
        
        <p>
        	
        	
        </p>
        
        Example: <strong>http://smooththemes.us7.list-manage.com/subscribe/post?u=dc130fe66084d082c54779086&amp;id=736887358d</strong> 
        <br/> You can get Mailchimp form action follow steps  <a href="<?php echo ST_ADMIN_URL; ?>/images/mailchimp-form.png" target="_blank">Here</a>
        
       </p>
        <?php
    }




} // end class example_widget


register_widget( 'STSocialsConnect' );
