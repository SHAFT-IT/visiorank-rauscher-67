<?php
/**
 * Images column for posr type
 */ 
 
 

 
 

 
function st_manage_post_type_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'images':
        // Get number of images in gallery
       // $num_images = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE post_parent = {$id};"));
       // echo $num_images;
       echo get_the_post_thumbnail($id,array(40,40));
        break;
    default:
        break;
    } // end switch
}   



function add_new_st_post_type_columns($columns) {
    
    $new_cols = array();
    $i=1;
    $insert_index = 3;
    foreach($columns as $k => $col){
        if($i==$insert_index){
            // insert new col here
            // $columns['images'] = __('Images','magazon');
            $new_cols['images'] = __('Images','magazon');
        }
        $new_cols[$k] = $col;
        $i++;
    }
    
    return $new_cols;
}
// Add to admin_init function
add_action('manage_post_posts_custom_column', 'st_manage_post_type_columns', 10, 2);
add_filter('manage_edit-post_columns', 'add_new_st_post_type_columns',10);
add_action('manage_page_posts_custom_column', 'st_manage_post_type_columns', 10, 2);
add_filter('manage_edit-page_columns', 'add_new_st_post_type_columns',10);