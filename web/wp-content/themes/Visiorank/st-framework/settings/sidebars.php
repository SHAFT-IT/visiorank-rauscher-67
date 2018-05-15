<?php
/**
 * register Sidebars for theme
 */
    
    register_sidebar( array(
        'name'          => 'Default Sidebar right',
        'id'            => 'sidebar_default_r',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>'

    ));
    
  
    register_sidebar( array(
        'name'          => 'Default Sidebar left',
        'id'            => 'sidebar_default_l',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    
    
    register_sidebar( array(
        'name'          => 'Header Right Widget',
        'id'            => 'header_ads',
        'description'   => 'This widget area will display at header right.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    if(st_is_woocommerce()){
    	register_sidebar( array(
		        'name'          => 'Shop',
		        'id'            => 'st_shop',
		        'description'   => 'This widget area will display at header right.',
		        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		        'after_widget'  => '</div>',
		        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
		        'after_title'   => '</h3>'
		
		    ));
    }
    
    
    $st_sidebars = st_get_setting("sidebars",array());
    
    foreach($st_sidebars as $sidebar){
        register_sidebar( array(
            'name'          => $sidebar['title'],
            'id'            => $sidebar['id'],
            'description'   => 'This sidebar is displayed on the "'.esc_html($sidebar['title']).'".',
            'before_widget' => '<div id="%1$s" class="widget-container sb'.$sidebar['id'].' '.$sidebar['id'].' %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widgettitle">',
            'after_title'   => '</h3>'
        ));
    };
    
    register_sidebar( array(
        'name'          => 'Footer 1',
        'id'            => 'footer_1',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    register_sidebar( array(
        'name'          => 'Footer 2',
        'id'            => 'footer_2',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    register_sidebar( array(
        'name'          => 'Footer 3',
        'id'            => 'footer_3',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    register_sidebar( array(
        'name'          => 'Footer 4',
        'id'            => 'footer_4',
        'description'   => 'This is default sidebar widget that will displayed on all pages.',
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle footer_widgettitle">',
        'after_title'   => '</h3>'

    ));
    
    
    
    
    