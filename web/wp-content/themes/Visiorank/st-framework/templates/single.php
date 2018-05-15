 <?php
 
 global $post;
  the_post(); 
 $st_page_options =  $st_page_builder = get_page_builder_options($post->ID);
 $builder_content =  get_page_builder_content($post->ID);
 
 ?>
    <?php the_title('<h1 class="page-title">','</h1>'); ?>
    
     <div class="page-meta-wrapper">
        
        <?php if(st_get_setting('display_single_author_metadata','y')!='n'){ ?>
        <span><?php _e('By','magazon'); ?>
        <span class="author">
         <?php echo the_author_posts_link(); ?>
        </span>
         <span class="meta-sep">|</span> 
         <?php } ?>

        <?php if(st_get_setting('display_single_date_metadata','y')!='n'){ ?>
         <?php _e('on','magazon'); ?> <?php echo get_the_date(); ?> 
         <span class="meta-sep">|</span> 
         <?php } ?>
        
        <?php if(st_get_setting('display_single_comment_metadata','y')!='n'){ ?>
        <a class="link-comments" href="<?php  comments_link(); ?>"><?php comments_number(__('0 Comment','magazon'),__('1 Comment'),__('% Comments')); ?></a>
        </span>
        <?php } ?>

        <?php if(st_get_setting('disable_single_categories','n')!='y'){ ?>
        <div class="categories">
          <?php the_category(' '); ?>
        </div>
        <?php } ?>

    </div>

    <?php do_action('st_single_after_post_meta'); ?>
    
    <div class="page-content content">

        <?php if(st_get_setting('disable_single_media','n')!='y'){ ?>
        <div class="page-featured-image">
          <?php
          switch(strtolower($st_page_options['thumbnail_type'])){
              case 'video':
                // echo  $st_page_options['video_code'];
                echo  st_get_video($st_page_options['video_code']);
              break;
              case 'slider':
                  st_slider($st_page_options['thumbnails'],array('show_caption'=>'yes'));
              break;
              default;
                 if(st_get_setting('disable_s_thumb','n')!='y'){
                       the_post_thumbnail('st_normal_thumb'); 
                  }
                
          } 

          ?>
        </div>
        <?php } ?>
                

        <?php 
        the_content(); 
 
        if($builder_content!=''){
            echo do_shortcode($builder_content);
        }
       
        
        ?>
        
       <?php $args = array(
                      'before'           => '<p>' . __('Pages:','magazon'),
                      'after'            => '</p>',
                      'link_before'      => '',
                      'link_after'       => '',
                      'next_or_number'   => 'number',
                      'nextpagelink'     => __('Next page','magazon'),
                      'previouspagelink' => __('Previous page','magazon'),
                      'pagelink'         => '%',
                      'echo'             => 1
                    ); 
           ?>
          <?php wp_link_pages( $args ); ?> 
                    
                    
        <div class="clear"></div>
        
        <div class="st-hook-after-single-article">
          <?php do_action('st_single_after_article'); ?>
        </div>

    </div><!-- END page-content-->
    
    <div class="page-single-element">
        

        <?php if(st_get_setting("enable_share_entry") != 'n'): ?>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <script type="text/javascript">
        (function() {
          var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
          po.src = 'https://apis.google.com/js/plusone.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
        </script>

        <div class="share_entry">
          <span class="share_entry_text"><?php _e('Share this story:','magazon') ?></span>
          <ul>
            <li>
              <a data-lang="en" data-via="" data-text="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>" class="twitter-share-button" href="https://twitter.com/share">tweet</a>
            </li>
            <li><iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>%2F&amp;send=false&amp;layout=button_count&amp;width=107&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:107px; height:21px;" allowTransparency="true"></iframe></li>
            <li><div class="g-plusone" data-size="medium"></div></li>
            <li>
              <a data-pin-config="none" data-pin-do="buttonBookmark" href="//pinterest.com/pin/create/button/"><img src="//assets.pinterest.com/images/PinExt.png" /></a>
              <script src="//assets.pinterest.com/js/pinit.js"></script>
            </li>
          </ul>
          <div class="clear"></div>
        </div>
        <?php endif; ?>


        <p class="page-tags">
            <?php the_tags('<b>'.__('Tags:','magazon').'</b> ','',''); ?>
        </p>
        
        <div class="clear"></div>
        
        <?php   do_action('st_after_the_content'); ?>
        
        <?php if(st_get_setting("enable_re_re",'y') == 'y'): ?>
        <div class="row">
            <div class="related-recent-post-wrapper">
                
                <div class="single-recent-wrapper six columns b40">
                    <?php 
                      $recent = new STRecentPosts();
                      $recent->widget(array(
                                    'before_widget' => '<div id="%1$s" class="single-recent-content %2$s">',
                                    'after_widget'  => '</div>',
                                    'before_title'  => '<h3 class="single-recent-heading">',
                                    'after_title'   => '</h3>'
                                ),array('title'=>__('Recent Posts','magazon'),'number'=>3));
                    ?>
                    
                </div>
                
                <div class="single-related-wrapper six columns b40">
                    
                    <?php 
                      $related = new STRelatedPosts();
                      $related->widget(array(
                                    'before_widget' => '<div id="%1$s" class="widget-container  %2$s">',
                                    'after_widget'  => '</div>',
                                    'before_title'  => '<h3 class="single-related-heading">',
                                    'after_title'   => '</h3>'
                                ),array('title'=>__('Related Posts','magazon'),'number'=>3));
                    ?>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
        <?php endif; ?>

        <?php do_action('st_single_before_author_bio'); ?>
        
        <?php if(st_get_setting("enable_author_desc") == 'y'): ?>
        <div class="page-author-wrapper">
            <h4 class="author-box-title"><?php _e('Author Description','magazon'); ?></h4>
            <div class="author-box-content">
                    <?php echo get_avatar( $post->post_author, 80 ); ?>
                <div class="author-desc">
                    <p class="author-text"><?php the_author_meta('description'); ?> </p>
                    
                    <ul class="author-social b0">
                    <?php if( get_user_meta($post->post_author,'twitter',true)) : ?>
                    <li><a title="Twitter" href="<?php echo esc_attr( get_user_meta($post->post_author,'twitter', true)); ?>" class="icon-twitter"></a></li>
                    <?php endif; ?>
                     <?php if( get_user_meta($post->post_author,'facebook', true)) : ?>
                    <li><a title="Facebook" href="<?php echo esc_attr( get_user_meta($post->post_author,'facebook', true)); ?>" class="icon-facebook"></a></li>
                      <?php endif; ?>
                     <?php if( get_user_meta($post->post_author,'google_plus', true)) : ?>
                    <li><a title="Google Plus" href="<?php echo esc_attr( get_user_meta($post->post_author,'google_plus', true)); ?>" class="icon-google-plus"></a></li>
                      <?php endif; ?>
                     <?php if( get_user_meta($post->post_author,'linkedin', true)) : ?>
                    <li><a title="Linkedin" href="<?php echo esc_attr( get_user_meta($post->post_author,'linkedin', true)); ?>" class="icon-linkedin"></a></li>
                      <?php endif; ?>
                     <?php if( get_user_meta($post->post_author,'pinterest', true)) : ?>
                    <li><a title="Pinterest" href="<?php echo esc_attr( get_user_meta($post->post_author,'pinterest', true)); ?>" class="icon-pinterest"></a></li>
                      <?php endif; ?>
                </ul>   
                </div>

            </div>                                                         
        </div>
        <?php endif; ?>
        
        <div class="clear"></div>
        <?php do_action('st_single_before_comments'); ?>
        <?php comments_template('', true ); ?>
      
    </div><!-- Single Page Element -->