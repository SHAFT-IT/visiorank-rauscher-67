<?php

if(!defined('ST_TRANSLATE_OPTION')){
    define('ST_TRANSLATE_OPTION','st_translate');
}

function st_get_translate_default(){
     $texts = 'YTo4NTp7czo2OToiVGhpcyBwb3N0IGlzIHBhc3N3b3JkIHByb3RlY3RlZC4gRW50ZXIgdGhlIHBhc3N3b3JkIHRvIHZpZXcgY29tbWVudHMuIjtzOjA6IiI7czoxMjoiTm8gUmVzcG9uc2VzIjtzOjA6IiI7czoxMjoiT25lIFJlc3BvbnNlIjtzOjA6IiI7czoxMToiJSBSZXNwb25zZXMiO3M6MDoiIjtzOjE0OiJPbGRlciBDb21tZW50cyI7czowOiIiO3M6MTQ6Ik5ld2VyIENvbW1lbnRzIjtzOjA6IiI7czoyOiJ0byI7czowOiIiO3M6MjA6IkNvbW1lbnRzIGFyZSBjbG9zZWQuIjtzOjA6IiI7czoxOToiTGVhdmUgYSBSZXBseSB0byAlcyI7czowOiIiO3M6MTE6IllvdSBtdXN0IGJlIjtzOjA6IiI7czo5OiJsb2dnZWQgaW4iO3M6MDoiIjtzOjE4OiJ0byBwb3N0IGEgY29tbWVudC4iO3M6MDoiIjtzOjI5OiJSZXF1aXJlZCBmaWVsZHMgYXJlIG1hcmtlZCAlcyI7czowOiIiO3M6MTM6IkxlYXZlIGEgUmVwbHkiO3M6MDoiIjtzOjEyOiJDYW5jZWwgUmVwbHkiO3M6MDoiIjtzOjEyOiJQb3N0IENvbW1lbnQiO3M6MDoiIjtzOjc6IkNvbW1lbnQiO3M6MDoiIjtzOjU3OiJZb3UgbXVzdCBiZSA8YSBocmVmPSIlcyI+bG9nZ2VkIGluPC9hPiB0byBwb3N0IGEgY29tbWVudC4iO3M6MDoiIjtzOjQxOiJZb3VyIGVtYWlsIGFkZHJlc3Mgd2lsbCBub3QgYmUgcHVibGlzaGVkLiI7czowOiIiO3M6NDoiTmFtZSI7czowOiIiO3M6NToiRW1haWwiO3M6MDoiIjtzOjc6IldlYnNpdGUiO3M6MDoiIjtzOjk6IlNFQVJDSC4uLiI7czowOiIiO3M6NjoiU2VhcmNoIjtzOjA6IiI7czo4OiJGYWNlYm9vayI7czowOiIiO3M6MTE6Ikdvb2dsZSBQbHVzIjtzOjA6IiI7czo3OiJUd2l0dGVyIjtzOjA6IiI7czo4OiJMaW5rZWRpbiI7czowOiIiO3M6OToiUGludGVyZXN0IjtzOjA6IiI7czoxMDoiTmF2aWdhdGlvbiI7czowOiIiO3M6NjoiUGFnZXM6IjtzOjA6IiI7czo5OiJOZXh0IHBhZ2UiO3M6MDoiIjtzOjEzOiJQcmV2aW91cyBwYWdlIjtzOjA6IiI7czo3OiJQYWdlICVzIjtzOjA6IiI7czoxNToiUGVybWFsaW5rIHRvICVzIjtzOjA6IiI7czo5OiIwIENvbW1lbnQiO3M6MDoiIjtzOjk6IjEgQ29tbWVudCI7czowOiIiO3M6MTA6IiUgQ29tbWVudHMiO3M6MDoiIjtzOjE5OiJLZWVwIFVwZGF0ZSBXaXRoICVzIjtzOjA6IiI7czoyMToiWW91ciBFbWFpbCBBZGRyZXNzLi4uIjtzOjA6IiI7czo5OiJTdWJzY3JpYmUiO3M6MDoiIjtzOjM6IlJTUyI7czowOiIiO3M6ODoiRm9sbG93ZXIiO3M6MDoiIjtzOjk6IkZvbGxvd2VycyI7czowOiIiO3M6NDoiTGlrZSI7czowOiIiO3M6NToiTGlrZXMiO3M6MDoiIjtzOjExOiJUd2l0dGVyIElEOiI7czowOiIiO3M6Mzg6IkV4YW1wbGU6IDxzdHJvbmc+c21vb3RodGhlbWVzPC9zdHJvbmc+IjtzOjA6IiI7czoxODoiRmFjZWJvb2sgcGFnZSBVUkw6IjtzOjA6IiI7czoxNjoiRmVlZGJ1cm5lciBVUkxJOiI7czowOiIiO3M6ODoiUlNTIFVSTDoiO3M6MDoiIjtzOjU3OiJEaXNwbGF5IFBvcHVsYXIgUG9zdHMsIFJlY2VudCBQb3N0cywgbGFzdGVzdCBjb21tZW50cywuLi4iO3M6MDoiIjtzOjE3OiJQb3B1bGFyIHBvc3RzIFRhYiI7czowOiIiO3M6MTM6IlNob3cgdGhpcyB0YWIiO3M6MDoiIjtzOjEwOiJUYWIgVGl0bGU6IjtzOjA6IiI7czoxNjoiUmVjZW50IHBvc3RzIFRhYiI7czowOiIiO3M6MTk6IlJlY2VudCBjb21tZW50cyBUYWIiO3M6MDoiIjtzOjE3OiJEcmFnIHRhYnMgdG8gc29ydCI7czowOiIiO3M6NzoiUG9wdWxhciI7czowOiIiO3M6NjoiUmVjZW50IjtzOjA6IiI7czo4OiJDb21tZW50cyI7czowOiIiO3M6MTg6IlByaW1hcnkgTmF2aWdhdGlvbiI7czowOiIiO3M6ODoiVG9wIE1lbnUiO3M6MDoiIjtzOjExOiJGb290ZXIgTWVudSI7czowOiIiO2k6NDA0O3M6MDoiIjtzOjIxOiJPb3BzLCBQYWdlIG5vdCBmb3VuZC4iO3M6MDoiIjtzOjE0OiJHbyB0byBob21lcGFnZSI7czowOiIiO3M6MTg6IkRhaWx5IEFyY2hpdmVzOiAlcyI7czowOiIiO3M6MjA6Ik1vbnRobHkgQXJjaGl2ZXM6ICVzIjtzOjA6IiI7czoxOToiWWVhcmx5IEFyY2hpdmVzOiAlcyI7czowOiIiO3M6MTM6IkJsb2cgQXJjaGl2ZXMiO3M6MDoiIjtzOjE4OiJBdXRob3IgRGVzY3JpcHRpb24iO3M6MDoiIjtzOjEyOiJBdXRob3IgUG9zdHMiO3M6MDoiIjtzOjIyOiJTZWFyY2ggUmVzdWx0cyBmb3I6ICVzIjtzOjA6IiI7czoyOiJCeSI7czowOiIiO3M6Mjoib24iO3M6MDoiIjtzOjE3OiJTaGFyZSB0aGlzIHN0b3J5OiI7czowOiIiO3M6NToiVGFnczoiO3M6MDoiIjtzOjQ6IiUxJHMiO3M6MDoiIjtzOjI5OiI8YiBjbGFzcz0iYXV0aG9yX25hbWUiPiVzPC9iPiI7czowOiIiO3M6NjoiKEVkaXQpIjtzOjA6IiI7czozNjoiWW91ciBjb21tZW50IGlzIGF3YWl0aW5nIG1vZGVyYXRpb24uIjtzOjA6IiI7czo5OiJSZWFkIE1vcmUiO3M6MDoiIjtzOjEyOiJSZWNlbnQgUG9zdHMiO3M6MDoiIjtzOjEzOiJSZWxhdGVkIFBvc3RzIjtzOjA6IiI7fQ==';
     return unserialize(base64_decode($texts));
}


if(!function_exists('__st_get_translate')){
 /**
   *  load options 
   * @return array();  
   */   
 function __st_get_translate(){
        if(st_is_wpml()){
                 $st_translate = get_option(ST_TRANSLATE_OPTION.'_'.ICL_LANGUAGE_CODE,array()); 
                 if(empty($st_translate)){
                    $st_translate = get_option(ST_TRANSLATE_OPTION,array());  // default value
                 }

            }else{
                // get default langguage
                $st_default_lang_code = get_bloginfo('language'); // DO NOT REMOVE
                if(strpos($st_default_lang_code,'-')!==false){
                    $st_default_lang_code = explode('-',$st_default_lang_code);
                    $st_default_lang_code = $st_default_lang_code[0];
                }
                 $st_translate = get_option(ST_TRANSLATE_OPTION.'_'.$st_default_lang_code,array());  // default value
                 if(empty($st_translate)){
                         $st_translate = get_option(ST_TRANSLATE_OPTION,array());  // default value
                 }
            }

        // remove slashes
        $st_translate = st_stripslashes($st_translate);
        return $st_translate;
    }
 
}
       
       
if(!function_exists('st_stripslashes')){
    function st_stripslashes($array){
        if(!is_array($array)){
            return stripcslashes($array);
        }
        
        $tpl=  array();
        foreach($array as $k=> $v){
            $tpl[stripslashes($k)] = stripcslashes($v);
        }
        return  $tpl;
    }    
}
 



global  $st_translate, $_st_where_tran; // for Translate
$st_translate = __st_get_translate();

$_st_where_tran = get_option('_st_where_tran', array());
if(empty($_st_where_tran)){
   $_st_where_tran['f']='f';
   $_st_where_tran['b']='';
}


if(!function_exists('st_is_wpml')){
    /**
     *  @true  if WPML installed.
     */ 
    function  st_is_wpml(){
        return function_exists('icl_get_languages');
    }
}

add_action('admin_menu','st_tran_add_admin_menu',99);

function st_tran_add_admin_menu(){
   $icon = ST_ADMIN_URL . '/images/st_icon.png';
   if(defined('ST_PAGE_SLUG') && ST_PAGE_SLUG!=''){
        add_submenu_page( ST_PAGE_SLUG,'stTranslator', 'stTranslator', 'manage_options', 'st-translator', 'st_admin_translator' );
   }else{
        add_menu_page('stTranslator','stTranslator','manage_options','st-translator','st_admin_translator');
   }   
}

function st_admin_translator(){
      $st_tran_page = 'st-translator';
      $dir_name = dirname(__FILE__) ;
      if($_REQUEST['import']==1){
             include($dir_name.'/admin-translator-import.php');
      }elseif($_REQUEST['export']==1){
             include($dir_name.'/admin-translator-export.php');
      }else{
            include($dir_name.'/admin-translator.php');
      }
}


/**
 * ST Translate function 
 * @return  false if not translated else the text translated
*/
function __st_false($text){
     if($text ==''){
        return false;
    }
    global $st_translate;
    if(isset($st_translate[$text])!='' && $st_translate[$text]!=''){
        return $st_translate[$text];
    }else{
        return false;
    }
}


/**
 * ST Translate function
 * @return string translate
*/
function __st($text=''){
    if($text ==''){
        return $text;
    }
    global $st_translate;
    if(isset($st_translate[$text])!='' && $st_translate[$text]!=''){
        return $st_translate[$text];
    }else{
        return $text;
    }
}


/**
 * ST Translate function
 * Display translate text
 * @return none
*/
function _st($text=''){
     echo __st($text);
}

function  st_translate_text($translated='', $text='', $domain=''){
        global $st_translate;
        if(isset($st_translate[$text])!='' && $st_translate[$text]!=''){
            return $st_translate[$text];
        }else{
            return $translated;
        }
}

function  st_translate_context_text($translated='', $text='', $context='', $domain =''){
    return st_translate_text($translated,$text,$domain);
}

function st_translate_n_text( $translation='', $singular='', $plural='', $number='',$domain =''){
    
    $text = ( 1 == $number) ? __st_false($singular) : __st_false($plural);
    if($text===false){
        return $translation;
    }else{
        return $text;
    }
}

function st_translate_n_context_text($translation='', $single='', $plural='', $number='', $context='', $domain=''){
    return st_translate_n_text( $translation, $single, $plural, $number,$domain);
}


/**
 *  Theme tranlate first
 * Add filter translate() function  
**/
if(!is_admin()){
    add_filter('gettext','st_translate_text',99,3);
    add_filter('gettext_with_context','st_translate_context_text',4);
    add_filter( 'ngettext', 'st_translate_n_text',99, 5);
    add_filter( 'ngettext_with_context', 'st_translate_n_context_text',99, 6);
}
