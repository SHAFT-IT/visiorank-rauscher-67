<?php

#-----------------------------------------------------------------
# Default theme variables and information
#-----------------------------------------------------------------

$themeInfo            =  wp_get_theme(); // TEMPLATEPATH . '/style.css'
$themeName            = trim($themeInfo['Title']);
$themeAuthor          = trim($themeInfo['Author']);
$themeAuthor_URI      = trim($themeInfo['AuthorURI']);
$themeVersion         = trim($themeInfo['Version']);
$themeShortname       = sanitize_title($themeName . '_');
$frameworkVersion     = trim($themeInfo['Framework Version']);

#-----------------------------------------------------------------
# Define variables
#-----------------------------------------------------------------

define('ST_NAME','magazone');    
define('ST_THEME_NAME',$themeName);
define('ST_AUTHOR',$themeAuthor);                    // The theme Author
define('ST_AUTHOR_URL',$themeAuthor_URI);            // Author URL
define('ST_VERSION',$themeVersion);                  // Theme version number
define('ST_THEME_URL',trailingslashit(get_bloginfo('template_url') ) );   
define('ST_THEME_DIR',get_template_directory() );
define('ST_URL',ST_THEME_URL.'st-framework/' );   
define('ST_URL',ST_THEME_URL.'st-framework/' );                         
//define('ST_DIR',dirname(__FILE__) ); 			// Theme directory
define('ST_DIR',get_template_directory().'/st-framework');
define('ST_ADMIN_DIR',ST_DIR . '/admin/');
define('ST_LIB_DIR',ST_DIR .'/lib/');
define('ST_SETTINS_DIR',ST_DIR .'/settings/');
define('ST_TEMPLATE_DIR',ST_DIR.'/templates/');

if(is_child_theme() ){
    define('ST_CHILD_TEMPLATE_DIR',get_template_directory().'-child/st-framework'.'/templates/');
}

define('ST_SETTINGS_OPTION','ST_SETTINGS_OPTION');

define('ST_PAGE_TITLE',ST_THEME_NAME.' Settings Page');   // Theme Option Title
define('ST_MENU_TITLE',ST_THEME_NAME);					 // Theme Option Menu Title
define('ST_PAGE_SLUG','smooththemes');				 // Theme Option URL Slug

//for woocommerce templatess
define('ST_WC_TEMPLATE_DIR',ST_THEME_DIR.'/woocommerce/');


/**
 *@todo  DO NOT LOAD DEFAULT WOOCOMMERCE CSS 
 */ 
define('WOOCOMMERCE_USE_CSS', false);

// disable for live, enable for development
error_reporting(0);


#-----------------------------------------------------------------
# WORDPRESS TWEAKS
#-----------------------------------------------------------------

remove_action ('wp_head', 'rsd_link');
remove_action ('wp_head', 'wlwmanifest_link');
remove_action ('wp_head', 'wp_generator');
remove_action ('wp_head', 'feed_links_extra');
remove_action ('wp_head', 'feed_links');
remove_action ('wp_head', 'index_rel_link');
remove_action ('wp_head', 'parent_post_rel_link');
remove_action ('wp_head', 'start_post_rel_link');
remove_action ('wp_head', 'adjacent_posts_rel_link');

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'woocommerce' );
add_editor_style();

if ( ! isset( $content_width ) ) $content_width = 978;

#-----------------------------------------------------------------
# Thumnail Generator
#-----------------------------------------------------------------
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'st_small_thumb', 50, 50, true ); // Small thumb // 306x160
add_image_size( 'st_builder_thumb', 125, 125, true ); //
add_image_size( 'st_medium_thumb', 500, 261, true ); // Medium thumb for post on homepage
add_image_size( 'st_normal_thumb', 642, 336, true ); // Normal thumb for image inside post


#-----------------------------------------------------------------
# Predefined Skin
#-----------------------------------------------------------------

$predefined_colors = array(
        '16A1E7' => __('Blue','magazon'),
        'B3C211' => __('Olive','magazon'),
        'FA5B0F' => __('Orange','magazon'),
        'F9BA00' => __('Yellow','magazon')
    );


$st_hooks =  array(
    'st_before_page_template',
    'st_after_page_template',
    'st_before_page_content',
    'st_after_page_content',
    'st_single_before_author_bio',
    'st_single_before_comments',
    'st_single_after_post_meta',
    'st_single_after_article'
);

#-----------------------------------------------------------------
# Load Translation File
#-----------------------------------------------------------------

//global $locale; $locale = 'es_ES';
$locale = get_locale();
load_theme_textdomain( 'magazon', get_template_directory(). '/languages' );

global $st_options , $smooththemes_sidebar;


if(!function_exists('st_stripslashes')){
    
    function st_stripslashes($array){
        if(!is_array($array)){
            return stripslashes($array);
        }
        
        $tpl=  array();
        foreach($array as $k=> $v){
            $tpl[stripslashes($k)] = st_stripslashes($v);
        }
        
        return  $tpl;
  }    
     
}



/**
 * @return true if Woocommerce installed and atvive
 * 
 */
 function st_is_woocommerce(){
    return class_exists('Woocommerce');
 }



/**
 *  @true  if WPML installed.
 * @Since  ver 1.3
 */ 
function  st_is_wpml(){
    return function_exists('icl_get_languages');
}
/**
* @Since  ver 1.3
*/ 
if(st_is_wpml()){
     $st_same_settings = get_option('st_same_lang_settings','y');
     if($st_same_settings=='y'){
        $st_options = get_option(ST_SETTINGS_OPTION,array()); 
     }else{
        $st_options = get_option(ST_SETTINGS_OPTION.'_'.ICL_LANGUAGE_CODE,array()); 
        
        if(empty($st_options)){
             $st_options = get_option(ST_SETTINGS_OPTION,array());  // default value
        }
     }
}else{
    $st_options = get_option(ST_SETTINGS_OPTION);
}



require_once(ST_LIB_DIR.'lib-functions.php');

include_once(ST_LIB_DIR.'st-active-theme.php');

include_once(ST_LIB_DIR.'st-filters.php');
include_once(ST_LIB_DIR.'Cuztom_Helper.php');


// load other settings
require_once(ST_SETTINS_DIR.'shortcode.php');
require_once(ST_SETTINS_DIR.'sidebars.php');
require_once(ST_SETTINS_DIR.'nav-menus.php');
require_once(ST_SETTINS_DIR.'js-and-css.php');
require_once(ST_SETTINS_DIR.'post-type.php');
require_once(ST_SETTINS_DIR.'taxonomies.php');
require_once(ST_ADMIN_DIR.'admin-int.php');

require_once(ST_DIR.'/translate/translate.php');

// load widget 
require_once(ST_DIR .'/lib/widgets/popular-posts.php');
require_once(ST_DIR .'/lib/widgets/related-posts.php');
require_once(ST_DIR .'/lib/widgets/recent-posts.php');
require_once(ST_DIR .'/lib/widgets/recent-comments.php');
require_once(ST_DIR .'/lib/widgets/tabs-content.php');
require_once(ST_DIR .'/lib/widgets/flickr.php');
require_once(ST_DIR .'/lib/widgets/ads-125.php');
require_once(ST_DIR .'/lib/widgets/socials-connect.php');

require_once(ST_DIR .'/lib/st-nav-walker.php');

if( is_file(ST_TEMPLATE_DIR.'/template-functions.php')){
    require_once(ST_TEMPLATE_DIR.'/template-functions.php');
}



require_once(ST_DIR.'/css/css.php');


if(st_is_woocommerce()){
	if(file_exists(ST_TEMPLATE_DIR.'/st-wc-functions.php')){
		require_once(ST_TEMPLATE_DIR.'/st-wc-functions.php');
	}
     
}

function isValid($code, $ip = null)
{
    if (empty($code)) {
        return false; // Si aucun code n'est entré, on ne cherche pas plus loin
    }
    $params = [
        'secret'    => CLEF_SECRETE,
        'response'  => $code
    ];
    if( $ip ){
        $params['remoteip'] = $ip;
    }
    $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
    if (function_exists('curl_version')) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
        $response = curl_exec($curl);
    } else {
        // Si curl n'est pas dispo, un bon vieux file_get_contents
        $response = file_get_contents($url);
    }

    if (empty($response) || is_null($response)) {
        return false;
    }

    $json = json_decode($response);
    return $json->success;
}