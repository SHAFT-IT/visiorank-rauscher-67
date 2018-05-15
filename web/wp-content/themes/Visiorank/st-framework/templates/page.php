<?php 

global $post;
the_post();
$st_page_options =  $st_page_builder = get_page_builder_options($post->ID);
$builder_content =  get_page_builder_content($post->ID);
$showTitle=   true;


if(empty($st_page_options['page_options']['show_title']) ||  $st_page_options['page_options']['show_title']==''){
        $showTitle =  false;
}

$showContent =  true; 
if(empty($st_page_options['page_options']['show_content']) ||  $st_page_options['page_options']['show_content']==''){
        $showContent =  false;
}

if(empty($st_page_options)){ // if $st_page_options not set that mean this page created by other theme
     $showContent =  true;
     $showTitle =  true;
}

if($showTitle):

?>
<h1 class="page-title"><?php the_title(); ?></h1>
<?php endif; ?>
<div <?php post_class('content clearfix'); ?>>
    <?php 
    do_action('st_before_page_content',$post);
    if($showContent){
        echo '<div class="post-entry">';
         the_content();
         echo '</div>';
    }
   echo '<div class="post-bc">';
        echo do_shortcode($builder_content) ; 
   echo '</div>';
    do_action('st_after_page_content',$post);
    
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
  <?php wp_link_pages( $args );

    if(st_get_setting('enable_page_comments','n')=='y'){
        comments_template('', true );
    }

    ?>
</div>