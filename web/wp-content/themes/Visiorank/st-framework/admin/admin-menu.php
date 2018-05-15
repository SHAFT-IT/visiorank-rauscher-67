<?php

add_action('admin_menu','st_add_admin_menu');

function st_add_admin_menu(){
    $icon = ST_ADMIN_URL . '/images/st_icon.png';
    // add_theme_page(ST_PAGE_TITLE,ST_MENU_TITLE,'manage_options',ST_PAGE_SLUG,'st_admin_display','',61);
    add_menu_page(apply_filters('st_admin_menu_page_title',ST_PAGE_TITLE),apply_filters('st_admin_menu_title',ST_MENU_TITLE),'manage_options',ST_PAGE_SLUG,'st_admin_display','',61);
   // add_submenu_page( ST_PAGE_SLUG, apply_filters('st_settings_page_title',__('Theme Options','smooththemes')), apply_filters('st_settings_menu_title',__('Theme Options')), 'manage_options', ST_PAGE_SLUG, 'st_admin_display' );
     
     
}

  // Function callback for add_menu_page
  function st_admin_display(){
   
    include(ST_ADMIN_PATH.'/admin-interface.php');
    
  }
  
  function st_sidebar_display(){
   
  }
  
  function st_install(){
   
  }