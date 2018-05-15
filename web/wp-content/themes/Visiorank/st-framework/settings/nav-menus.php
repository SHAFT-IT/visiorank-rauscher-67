<?php
register_nav_menus( array(
        'Primary_Navigation' => __( 'Primary Navigation', 'magazon' ),
    ) );
register_nav_menus( array(
        'Top_Menu' => __( 'Top Menu', 'magazon' ),
    ) );
    
    
register_nav_menus( array(
    'Footer_Menu' => __( 'Footer Menu', 'magazon' ),
) );

function st_home_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'st_home_page_menu_args' );