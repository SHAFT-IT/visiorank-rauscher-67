
<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'magazon' ), '<span>' . esc_html(get_search_query()) . '</span>' ); ?></h1>

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
             <?php  include(ST_TEMPLATE_DIR.'loop/loop-post.php');?>
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