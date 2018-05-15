<?php 
/**
 * Left sidebar  layout
 */ 
 
 if(is_singular()):
        global $post;
        $st_page_builder = get_page_builder_options($post->ID);
    else :
        $st_page_builder = array();  
    endif
 
?>
<div class="page-wrapper twelve columns page-wrapper-left-sidebar b0">
    <div class="row">
    

    
         <div class="content-wrapper eight columns b0">
             <?php
                do_action('st_before_page_template');
                do_action('st_page_template');
                do_action('st_after_page_template');
             ?>
         </div>

        <div class="left-sidebar-wrapper four columns b0">
            <div class="left-sidebar sidebar">
                <?php
                if(empty($st_page_builder['left_sidebar'])){
                    $st_page_builder['left_sidebar'] ='';
                }
                do_action('st_sidebar',$st_page_builder['left_sidebar'],'left');
                ?>
                <div class="clear"></div>
            </div>
        </div>
         
         <div class="clear"></div>
    </div>
</div>

