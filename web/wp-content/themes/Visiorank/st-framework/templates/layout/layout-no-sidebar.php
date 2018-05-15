<?php 
/**
 * FULL layout no sidebar
 */ 
 
 if(is_singular()):
        global $post;
        $st_page_builder = get_page_builder_options($post->ID);
    else :
        $st_page_builder = array();  
    endif
?>
<div class="page-wrapper twelve columns no-sidebar b0">
    <div class="row">
         <div class="content-wrapper twelve columns b0">
			<?php
			do_action('st_before_page_template');
			do_action('st_page_template');
			do_action('st_after_page_template');
			?>
         </div>
    </div>
</div>

