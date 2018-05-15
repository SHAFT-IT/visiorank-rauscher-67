
<h1 class="page-title">
<?php if ( is_day() ) : ?>
  <?php printf( __( 'Daily Archives: %s', 'magazon' ), '<span>' . get_the_date() . '</span>' ); ?>
	<?php elseif ( is_month() ) : ?>
		<?php printf( __( 'Monthly Archives: %s', 'magazon' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'magazon' ) ) . '</span>' ); ?>
	<?php elseif ( is_year() ) : ?>
		<?php printf( __( 'Yearly Archives: %s', 'magazon' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'magazon' ) ) . '</span>' ); ?>
	<?php else : ?>
		<?php _e( 'Blog Archives', 'magazon'); ?>
	<?php endif; ?>
</h1>

<div class="content clearfix">
 <?php 
if(have_posts()):
  $settings['display_type'] = 3;
  $settings['i'] = 0;
  $c = 0;
   while(have_posts()) : the_post();
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
  <?php else : // if not have posts  ?>
    <?php // not found ?>
 <?php endif  ?>
</div>