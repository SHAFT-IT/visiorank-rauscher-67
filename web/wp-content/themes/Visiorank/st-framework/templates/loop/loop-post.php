<?php
global $post;

if($post->ID):

if($settings['display_type']==3){
    $settings['display_type'] = 2;
    $settings['i'] = 0;
}


 if($settings['display_type']==2){
    $content_class= 'post-content';
    $thumb_class = 'post-thumbnail hover-thumb';
 }else{
    $thumb_class ='post-thumbnail six columns hover-thumb';
    $content_class ='post-content six columns';
 }
  
  $is_small = false;
  $pos_class ='row st-category-wrapper';
 if($settings['display_type']==2 and intval($settings['i'])>0){
    $pos_class ='small-post-wrapper small-'.intval($settings['i']);
    $content_class = 'small-post-content';
    $thumb_class ='small-post-thumb hover-thumb';
    $is_small = true ;
 }elseif($settings['display_type']==2){
     $pos_class ='st-category-wrapper';
 }

?>

<div <?php post_class($pos_class); ?>  id="post-<?php the_ID(); ?>">
        <div class="<?php echo $thumb_class; ?>">
            <?php
            if(!$is_small){
                echo st_post_thumbnail($post->ID,'st_medium_thumb');
            }else{
                  echo st_post_thumbnail($post->ID,'st_small_thumb',true);
            }
            ?>  
            <div class="clear"></div>
        </div>
        
        <div class="<?php echo $content_class; ?>">
            <h2 class="<?php echo $is_small ? 'small-post-title' : 'post-title'; ?>"><a  title="<?php printf( esc_attr__( 'Permalink to %s', 'magazon' ), the_title_attribute( 'echo=0' ) ); ?>"  rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="<?php echo $is_small ? 'small-post-meta' : 'post-meta'; ?>">
                  <span class="date"><?php echo get_the_date(); ?></span>
                  <?php if(!$is_small) : ?>
                 - <span class="author">
                  <?php the_author_posts_link(); ?>
                 </span>
                 <?php endif; ?>
                 - <span><?php comments_number(__('0 Comment','magazon'),__('1 Comment','magazon'),__('% Comments','magazon') )?></span>
            </div>
            <?php if(!$is_small): ?>
            <div class="post-excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="read-more">
                <a class="read-more-button"  title="<?php printf( esc_attr__( 'Permalink to %s', 'magazon' ), the_title_attribute( 'echo=0' ) ); ?>"   href="<?php the_permalink(); ?>"><?php _e('Read More','magazon'); ?></a>
            </div>
            <?php endif; ?>
        </div>
    <div class="clear"></div>   
</div>
<?php endif; ?>