<?php 
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
?>
<div class="page-author-wrapper">
    <h4 class="author-box-title"><?php _e('Author Description','magazon'); ?></h4>
    <div class="author-box-content">
         <?php echo get_avatar($curauth->ID); ?>
        <div class="author-desc">
            <div class="author-text b10">
            <?php  if($curauth->user_url):?>
            <b><a href="<?php echo esc_attr($curauth->user_url); ?>" rel="me"><?php echo esc_html($curauth->display_name); ?></a></b>
            <?php else: ?>
            <b><?php echo esc_html($curauth->display_name); ?></b>
            <?php endif; ?>
            <?php echo esc_html($curauth->description); ?>
            </div>
            
            <ul class="author-social b0">
                <?php if( get_user_meta($curauth->ID,'twitter',true)) : ?>
                <li><a title="Twitter" href="<?php echo esc_attr( get_user_meta($curauth->ID,'twitter',true)); ?>" class="icon-twitter"></a></li>
                <?php endif; ?>
                 <?php if( get_user_meta($curauth->ID,'facebook',true)) : ?>
                <li><a title="Facebook" href="<?php echo esc_attr( get_user_meta($curauth->ID,'facebook',true)); ?>" class="icon-facebook"></a></li>
                  <?php endif; ?>
                 <?php if( get_user_meta($curauth->ID,'google_plus',true)) : ?>
                <li><a title="Google Plus" href="<?php echo esc_attr( get_user_meta($curauth->ID,'google_plus',true)); ?>" class="icon-google-plus"></a></li>
                  <?php endif; ?>
                 <?php if( get_user_meta($curauth->ID,'linkedin',true)) : ?>
                <li><a title="Linkedin" href="<?php echo esc_attr( get_user_meta($curauth->ID,'linkedin',true)); ?>" class="icon-linkedin"></a></li>
                  <?php endif; ?>
                 <?php if( get_user_meta($curauth->ID,'pinterest',true)) : ?>
                <li><a title="Pinterest" href="<?php echo esc_attr( get_user_meta($curauth->ID,'pinterest',true)); ?>" class="icon-pinterest"></a></li>
                  <?php endif; ?>
            </ul>
        </div>
    </div>                                                         
</div>

<h1 class="st-category-heading"><?php _e('Author Posts','magazon'); ?></h1>

<div class="content clearfix">
 <?php
  $settings['display_type'] = 3;
  $settings['i'] = 0;
  $c = 0;
  if(have_posts()): while(have_posts()) : the_post();
        
  ?>
        <?php if($c==0): ?>
        <div class="row">
        <?php endif; ?>
        
            <div class="six columns"> 
             <?php

             $file = st_get_theme_template('loop/loop-post.php');
             if($file!==false){
                 include($file);
             }

             ?>
            </div>
            
            
        <?php if($c>=1): ?>
            <div class="clear"></div>
        </div><!-- .row -->
        <?php
            $c=0;
         else :
            $c++;
         endif;
         
         ?>
 
 <?php endwhile; ?>
 
 <?php
  if($c%2!=0): 
    echo '<div class="six columns"> </div>
    <div class="clear"></div>
    </div><!-- .row -->';
  
  endif; ?>
 
 <div class="pagination text-center t40">
  <?php st_post_pagination(); ?>
  </div>
 <?php else : ?>
    <?php // not found ?>
 <?php endif  ?>
 
 
</div>