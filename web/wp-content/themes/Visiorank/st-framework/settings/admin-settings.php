<?php
global $wp_registered_sidebars;
$st_sidebars = $wp_registered_sidebars;
$general_tab = array();
$tpl_sidebars = array();
foreach($st_sidebars as $k=> $s){
    $tpl_sidebars[$s['id']] = $s['name'];
}


$general_tab_page = array(
        array(
            'name'        =>'page_full_boxed',
            'title'       =>__('Boxed of Full-Width Layout'),
            'type'        =>'select',
            'options'     => array(
            'f'           =>__('Full-Width','magazon'),
            'b'           =>__('Boxed','magazon')
            ),
            'default'     =>'f',
            'desc'        =>'',
            'desc_bottom' =>''
        ),
        
        array(
            'name'=>'layout',
            'title'=>__('Default Layout','magazon'),
            'type' =>'layout',
            'multiple'=> false,
            'options'=>array(
              //  '4'=> ST_ADMIN_URL.'/images/layout/3.png',
                '3'=> ST_ADMIN_URL.'/images/layout/2.png',
                '2'=> ST_ADMIN_URL.'/images/layout/1.png',
                '1'=> ST_ADMIN_URL.'/images/layout/0.png',
            ),
            'default'=>'2',
            'desc'=>'',
            'desc_bottom'=>''
         ),

        array(
            'name'=>'page_rtl',
            'title'=>__('Is your site RTL language?','magazon'),
            'type' =>'radio',
            'multiple'=> false,
            'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'=>'n',
            'desc'=>'',
            'desc_bottom'=>'Select Yes if your site is RTL language'
         ),
         
         
          array(
            'name'=>'sidebar_l',
            'title'=>__('Default sidebar left','magazon'),
            'type' =>'select',
            'multiple'=> false,
            'options'=>$tpl_sidebars,
            'default'=>'',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
         array(
            'name'=>'sidebar_r',
            'title'=>__('Default sidebar right','magazon'),
            'type' =>'select',
            'multiple'=> false,
            'options'=>$tpl_sidebars,
            'default'=>'sidebar_default_r',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
          array(
            'name'=>'sidebar_search',
            'title'=>__('Default sidebar Search page','magazon'),
            'type' =>'select',
            'multiple'=> false,
            'options'=>$tpl_sidebars,
            'default'=>'',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
         
        array(
            'name'=>'show_footer_widget',
            'title'=>__('Show Footer Widgets','magazon'),
            'type' =>'radio',
            'multiple'=> false,
            'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'=>'y',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
         array(
            'name'=>'show_footer_nav',
            'title'=>__('Show Footer Navigation','magazon'),
            'type' =>'radio',
            'multiple'=> false,
            'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'=>'y',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
		 
		 array(
            'name'=>'show_top_search',
            'title'=>__('Show Search form in top menu','magazon'),
            'type' =>'radio',
            'multiple'=> false,
            'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'=>'y',
            'desc'=>'',
            'desc_bottom'=>''
         ),
         
		 array(
            'name'=>'show_nav_search',
            'title'=>__('Show Search form in Nav menu','magazon'),
            'type' =>'radio',
            'multiple'=> false,
            'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'=>'y',
            'desc'=>'',
            'desc_bottom'=>''
         ),

        array(
            'name'        =>'enable_page_comments',
            'title'       =>__('Enable comments for page','magazon'),
            'type'        =>'select',
            'multiple'    => false,
            'options'     =>array('n'=>__('No'), 'y'=>__('Yes')),
            'default'     =>'n',
            'desc'        =>'',
            'desc_bottom' =>''
        ),
		 
		 
		 
		 
);
$general_tab_logo = array(
    array(
        'name'        =>'site_logo',
        'title'       =>'Upload logo',
        'type'        =>'upload',
        'default'     =>st_img('logo.png'),
        'desc'        =>'',
        'desc_bottom' =>'Upload your custom logo.'
    ),
    array(
        'name'        =>'logo_padding_top',
        'type'        =>'text',
        'title'       =>__('Logo Padding Top','magazon'),
        'default'     =>'20',
        'desc'        => __('Set padding top of logo, default is 20','magazon'),
        'desc_bottom' =>'',
    ),
    array(
        'name'        =>'logo_padding_bottom',
        'type'        =>'text',
        'title'       =>__('Logo Padding Bottom','magazon'),
        'default'     =>'20',
        'desc'        => __('Set padding bottom of logo, default is 20','magazon'),
        'desc_bottom' =>'',
     )
);
$general_tab_favicon = array(
        array(
            'name'        =>'enable_favicon',
            'title'       =>__('Enable Favicon','magazon'),
            'type'        =>'radio',
            'multiple'    => false,
            'options'     =>array('y'=>__('Yes'), 'n'=>__('No')),
            'default'     =>'n',
            'desc'        =>'Enable favicon for your website',
            'desc_bottom' =>''
         ),
        array(
            'name'        =>'site_favicon',
            'title'       =>'Upload Favicon',
            'type'        =>'upload',
            // 'value_type' =>'id',
            // 'default'     =>st_img('logo.png'),
            'desc'        =>'',
            'desc_bottom' =>'Upload your custom favicon.'
        )
    );

$oe_social = array(
    array(
        'name'        =>'facebook',
        'title'       =>__('Facebook URL','magazon'),
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your Facebook link'
     ),
    array(
        'name'        =>'twitter',
        'title'       =>'Twitter URL',
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your Twitter link'
     ),
     array(
        'name'        =>'google_plus',
        'title'       =>'Google+ URL',
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your Google+ link'
     ),
     
     array(
        'name'        =>'linkedin',
        'title'       =>'LinkedIn URL',
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your LinkedIn link'
     ),
     
     array(
        'name'        =>'pinterest',
        'title'       =>'Pinterest URL',
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your Pinterest link'
     ),

    array(
        'name'        =>'rss',
        'title'       =>'RSS URL',
        'type'        =>'text',
        'default'     =>'#',
        'desc'        =>'',
        'desc_bottom' =>'Enter your RSS link'
    ),
     
     array(
        'name'        =>'social_link_target',
        'title'       =>__('Link target','magazon'),
        'type'        =>'radio',
        'options'     =>array('_blank'=>'New window', '_c'=>__('Current window')),
        'default'     =>'_blank',
     )
     
);

$oe_single_post = array(
    array(
        'name'        =>'enable_share_entry',
        'title'       =>__('Enable Social Sharing on single post','magazon'),
        'type'        =>'radio',
        'multiple'    => false,
        'options'     =>array('y'=>__('Yes'), 'n'=>__('No')),
        'default'     =>'y',
        'desc'        =>'',
        'desc_bottom' =>''
     ),
    array(
        'name'        =>'enable_author_desc',
        'title'       =>__('Enable Author Description','magazon'),
        'type'        =>'radio',
        'multiple'    => false,
        'options'     =>array('y'=>__('Yes'), 'n'=>__('No')),
        'default'     =>'y',
        'desc'        =>'Enable Author bio on single page.',
        'desc_bottom' =>''
     ),
    array(
        'name'        =>'enable_re_re',
        'title'       =>__('Enable Recent and Related Post','magazon'),
        'type'        =>'radio',
        'multiple'    => false,
        'options'     =>array('y'=>__('Yes'), 'n'=>__('No')),
        'default'     =>'y',
        'desc'        =>'Enable Recent and Related Posts on single page.',
        'desc_bottom' =>''
     ),
     array(
        'name'    =>'disable_s_thumb',
        'type'    =>'radio',
        'title'   =>__('Disable Featured Image in single post','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'n'
     ),
     array(
        'name'    =>'disable_single_media',
        'type'    =>'radio',
        'title'   =>__('Disable Featured Image, Slider, Video in single post','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'n',
        'desc_bottom' =>'If you choose Yes this option, you can insert image,video inside the article'
     ),
     array(
        'name'    =>'disable_single_categories',
        'type'    =>'radio',
        'title'   =>__('Disable Categories on Single Post','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'n',
        'desc_bottom' =>'Choose Yes to hide categories at top of singple post.'
     ),
     array(
        'name'    =>'display_single_author_metadata',
        'type'    =>'radio',
        'title'   =>__('Display Author Metadata in Single','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'y',
        'desc_bottom' =>''
     ),
     array(
        'name'    =>'display_single_date_metadata',
        'type'    =>'radio',
        'title'   =>__('Display Date Metadata in Single','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'y',
        'desc_bottom' =>''
     ),

     array(
        'name'    =>'display_single_comment_metadata',
        'type'    =>'radio',
        'title'   =>__('Display Comment Metadata in Single','magazon'),
        'options' =>array('y'=>__('Yes'),'n'=>__('No')),
        'default' =>'y',
        'desc_bottom' =>''
     )


);

$oe_footer_copyright = array(
    array(
        'name'        =>'footer_copyright',
        'title'       =>'Footer CopyRight Infomation',
        'type'        =>'textarea',
        'default'     =>'&copy; 2012. All Rights Reserved. Created with love by <a target="_blank" href="http://www.smooththemes.com">SmoothThemes</a>',
        'desc'        =>'',
        'desc_bottom' =>''
    ), 
);



global $predefined_colors;

$global_skin_tab = array(

     array(
        'name'        =>'predefined_colors',
        'title'       =>'Pre-Defined Skins',
        'type'        =>'select',
        'options'     =>$predefined_colors,
        'default'     =>'16A1E7',
        'desc'        =>__('Select a color scheme for your website.','magazon'),
        'desc_bottom' =>''
    ),
    array(
        'name'=>'enable_custom_global_skin',
        'title'=>__('Enable Custom Skin','magazon'),
        'type' =>'radio',
        'multiple'=> false,
        'options'=>array('y'=>__('Yes'), 'n'=>__('No')),
        'default'=>'n',
        'desc'=>'Select global skin color below, it will overwrite predefined color.',
        'desc_bottom'=>''
    ),
    array(
        'name'        =>'custom_global_skin',
        'title'       =>__('Custom Global Skin'),
        'type'        =>'color',
        'default'     =>'CCCCCC',
        'desc'        =>'NOTE: It will overwrite predefined color.',
        'desc_bottom' =>''
    ),
       
);
/*
$top_bar_tab = array(

     array(
        'name'        =>'top_bar_bg',
        'title'       =>'Top Bar Background.',
        'type'        =>'color',
        'default'     =>'333333',
        'desc'        =>'',
        'desc_bottom' =>__('Select background color for top bar.','magazon')
    ),
);
$primary_nav_tab = array(

     array(
        'name'        =>'primary_nav_bg',
        'title'       =>'Primary Navigation Background',
        'type'        =>'color',
        'default'     =>'333333',
        'desc'        =>'',
        'desc_bottom' =>__('Select background color for primary navigation.','magazon')
    ),
);
*/

$bg_tab = array(
    
    array(
        'name'        =>'bg_color',
        'title'       =>__('Background color','magazon'),
        'type'        =>'color',
        'default'     =>'CCCCCC',
        'desc'        =>'NOTE: background style only apply when selected Boxed layout.',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'bg_img',
        'title'       =>__('Background image','magazon'),
        'type'        =>'upload',
        'default'     =>'CCCCCC',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
     array(
        'name'        =>'bg_positon',
        'title'       =>__('Background positon'),
        'type'        =>'select',
        'options' => array(
                'tl'=>__('Top left','magazon'),
                'tc'=>__('Top center','magazon'),
                'tr'=>__('Top right','magazon'),
                'cc'=>__('Center','magazon'),
                'bl'=>__('Bottom left','magazon'),
                'br'=>__('Bottom right','magazon'),
                'bc'=>__('Bottom center','magazon'),
        ),
        'default'     =>'',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'bg_repreat',
        'title'       =>__('Background repreat'),
        'type'        =>'select',
        'options' => array(
                'n'=>__('No repeat','magazon'),
                'x'=>__('Repeat X','magazon'),
                'y'=>__('Repeat Y','magazon')
        ),
        'default'     =>'',
        'desc'        =>'',
        'desc_bottom' =>''
    )
    ,
    array(
        'name'        =>'bg_fixed',
        'title'       =>__('Background fixed'),
        'type'        =>'select',
        'options' => array(
                'n'=>__('No','magazon'),
                'y'=>__('Yes','magazon')
        ),
        'desc'        =>'',
        'desc_bottom' =>''
    ),

);




$tab_flexslider = array(
//animation
    array(
        'name'=>'flex_animation',
        'type'=>'radio',
        'title'=>__('Animation','magazon'),
        'options'=>array('fade'=>__('fade'),'slide'=>__('slide')),
        'default'=>'fade'
     ),
     
     array(
        'name'=>'flex_smoothHeight',
        'type'=>'radio',
        'title'=>__('Smooth Height','magazon'),
        'options'=>array('true'=>__('Yes','magazon'),'false'=>__('No','magazon')),
        'default'=>'false',
        'desc'=>'Allow height of the slider to animate smoothly in horizontal mode'
     ),
     
     array(
        'name'=>'flex_animationLoop',
        'type'=>'radio',
        'title'=>__('Should the animation loop?','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'true'
     ),
      array(
        'name'=>'flex_slideshow',
        'type'=>'radio',
        'title'=>__('Animate slider automatically','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'y'
     ),
     array(
        'name'=>'flex_slideshowSpeed',
        'type'=>'text',
        'title'=>__('Slideshow Speed','magazon'),
        'default'=>'7000',
        'desc_bottom'=>__('Set the speed of the slideshow cycling, in milliseconds, default: 7000','magazon')
     ),
     array(
        'name'=>'flex_animationSpeed',
        'type'=>'text',
        'title'=>__('Animation Speed','magazon'),
        'default'=>'6000',
        'desc_bottom'=>__('Set the speed of animations, in milliseconds, default: 6000','magazon')
     ),
     array(
        'name'=>'flex_pauseOnAction',
        'type'=>'radio',
        'title'=>__('Pause On Action','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'true'
     ),
     array(
        'name'=>'flex_pauseOnHover',
        'type'=>'radio',
        'title'=>__('Pause On Hover','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'true'
     ),
     array(
        'name'=>'flex_controlNav',
        'type'=>'radio',
        'title'=>__('Create navigation for paging control of each slide','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'false'
     ),
      array(
        'name'=>'flex_randomize',
        'type'=>'radio',
        'title'=>__('Randomize slide order','magazon'),
        'options'=>array('true'=>__('Yes'),'false'=>__('No')),
        'default'=>'false'
     )
);

// Font Style Tabs

$font_body = array(

    array(
        'name'        =>'body_font',
        'title'       =>__('Body Font','magazon'),
        'type'        =>'style',
        'function'  =>'st_settings_fonts',
        'default'     =>'',
        'previetxt'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset 
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
                        including versions of Lorem Ipsum.',
        'options'=>array(
                'font-family'=>'Droid Sans',
                'color'=>'000000',
                'font-weight' =>'normal',
                'font-style'=>'nomal',
                'line-height'=>'22', // unit px
                'line-height-unit'=>'px',
                'font-size'=>'12',
                'font-size-unit'=>'px',
                'letter-spacing'=>'0',
                'letter-spacing-uni'=>'px'
            ),
        'support'=>  array('font_family','font_size', 'line_height'),
        'desc'        =>__('','magazon'),
        'desc_bottom' =>''
    ),
    
);

$font_heading = array(

    array(
        'name'        =>'heading_font',
        'title'       =>__('Heading Font','magazon'),
        'type'        =>'style',
        'function'  =>'st_settings_fonts',
        'default'     =>'',
        'previetxt'=>'<div style="font-size: 36px;  line-height:  40px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>',
        
        
         'options'=>array(
                'font-family'=>'Droid Sans',
                'color'=>'000000',
                'font-weight' =>'normal',
                'font-style'=>'nomal',
                'line-height'=>'24', // unit px
                'line-height-unit'=>'px',
                'font-size'=>'18',
                'font-size-unit'=>'px',
                'letter-spacing'=>'0',
                'letter-spacing-uni'=>'px'
            ),
         
         'support'=>  array('font_family','font_style', 'font_weight'),
        'desc'        =>__('','magazon'),
        'desc_bottom' =>''
    ),
    
);
$font_archive_heading = array(

    array(
        'name'        =>'archive_heading_font',
        'title'       =>__('Archive Heading Font','magazon'),
        'type'        =>'style',
        'function'  =>'st_settings_fonts',
        'default'     =>'',
        'previetxt'=>'<div style="font-size: 36px;  line-height:  40px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>',
        
         'options'=>array(
                'font-family'=>'Oswald',
                'color'=>'000000',
                'font-weight' =>'normal',
                'font-style'=>'nomal',
                'line-height'=>'22', // unit px
                'line-height-unit'=>'px',
                'font-size'=>'18',
                'font-size-unit'=>'px',
                'letter-spacing'=>'0',
                'letter-spacing-uni'=>'px'
            ),
            'support'=>  array('font_family','font_style', 'font_weight'),
            'desc'        =>'',
            'desc_bottom' =>__('Set font style for archive heading like category, tags, search...','magazon')
    ),
    
);

$sidebar_tab = array(
    array(
        'name'        =>'sidebars',
        'title'       =>'Sidebars',
        'type'        =>'ui',
        'default'     =>'',
        'support'    =>array('title','id'),
        'desc'        =>'',
        'desc_bottom' =>'Create custom sidebar.'
     )
);
global $st_hooks;

$ads_tab = array(
    array(
        'name'        =>'ads',
        'title'       =>'Site Ads Management',
        'type'        =>'ui',
        'default'     =>'',
        'support'    =>array('title','content','hook'),
        'hooks'=>$st_hooks,
        'desc'        =>'',
        'desc_bottom' =>''
     )
);


$tracking_code= array(
    array(
        'name'=>'headder_tracking_code',
        'type'=>'textarea',
        'title'=>__('Header tracking code','magazon'),
        'default'=>''
     ),
     array(
        'name'=>'footer_tracking_code',
        'type'=>'textarea',
        'title'=>__('Footer tracking code','magazon'),
        'default'=>''
     ),
);



// ========================== Setup Load Panel ========================== \\

$tabs_settings =  new Smooththemes_tabs_settings();

// General Setting
$tabs_settings->add_tab('general',__('General Setings','magazon'),$general_tab,'icon-cog');
    $tabs_settings->add_tab('general_page',__('Page Settings','magazon'),$general_tab_page,'icon-caret-right','general');
    $tabs_settings->add_tab('general_logo',__('Logo','magazon'),$general_tab_logo,'icon-caret-right','general');
    $tabs_settings->add_tab('general_favicon',__('Favicon','magazon'),$general_tab_favicon,'icon-caret-right','general');
    $tabs_settings->add_tab('general_sidebar',__('Custom Sidebars','magazon'),$sidebar_tab,'icon-caret-right','general');

// Font Style Setting
$tabs_settings->add_tab('fonts',__('Font Style','magazon'),'','icon-font');
    $tabs_settings->add_tab('fonts_body',__('Body Font','magazon'),$font_body,'icon-caret-right','fonts');
    $tabs_settings->add_tab('fonts_heading',__('Heading Font','magazon'),$font_heading,'icon-caret-right','fonts');
    $tabs_settings->add_tab('fonts_archive_heading',__('Archive Heading Font','magazon'),$font_archive_heading,'icon-caret-right','fonts');

// Color Setting
$tabs_settings->add_tab('elements_color',__('Elements Color','magazon'),'','icon-magic');
    $tabs_settings->add_tab('body_predefined_colors',__('Global Skin','magazon'),$global_skin_tab,'icon-caret-right','elements_color');
    $tabs_settings->add_tab('body_bg',__('Body Background','magazon'),$bg_tab,'icon-caret-right','elements_color');
    

// Overall Elements
$tabs_settings->add_tab('overall_elements',__('Overall Elements','magazon'),'','icon-cogs');
    $tabs_settings->add_tab('single_setting',__('Single Post Elements','magazon'),$oe_single_post,'icon-caret-right','overall_elements');
    $tabs_settings->add_tab('social',__('Social','magazon'),$oe_social,'icon-caret-right','overall_elements');
    $tabs_settings->add_tab('footer_copyright',__('Footer Copyright','magazon'),$oe_footer_copyright,'icon-caret-right','overall_elements');
    


// Slider Setting
$tabs_settings->add_tab('slider',__('Slider','magazon'),array(),'icon-exchange');
    $tabs_settings->add_tab('flexslider',__('FlexSlider','magazon'),$tab_flexslider,'icon-caret-right','slider');

// Ads Management
$tabs_settings->add_tab('ads',__('Ads Management','magazon'),array(),'icon-cogs');
    $tabs_settings->add_tab('ads_manage',__('Ads Management','magazon'),$ads_tab,'icon-caret-right','ads');

// for header and footer code
$tabs_settings->add_tab('tracking_code',__('Tracking code','magazon'),$tracking_code,'icon-cogs');



/*
// Load Google Webfonts
function st_google_font_to_options(){
     if(!function_exists('st_get_google_fonts_array')){
        if(is_file(dirname(__FILE__).'/google-fonts.php')){
             include(dirname(__FILE__).'/google-fonts.php');
        } 
    }
    
     if(!function_exists('st_get_google_fonts_array')){ 
       
            return array();
      }
      $google_fonts = st_get_google_fonts_array();
      
     // echo count($google_fonts);
      $font_options = array();
      foreach($google_fonts as $k=> $font){
            if(empty($font['family']) || $font['family']=='' ){
                continue;
            }
            $font_options[$font['family']] = 'http://fonts.googleapis.com/css?family='.rawurlencode($font['family']);
      }
      return $font_options;
    
}

*/


function st_build_google_font_options_url($font){
     if(empty($font['family']) || $font['family']=='' ){
                continue;
     }
     
     $variants = '';
     if(isset($font['variants']) && count($font['variants'])){
          $variants =  join(',',$font['variants']);
     }
     $subsets= '';
     if(isset($font['subsets'])&& count($font['subsets'])){
        $subsets = join(',',$font['subsets']);
     }
     
    $url = 'http://fonts.googleapis.com/css?family='.urlencode($font['family']); 
    if($variants!=''){
        $url.=':'.urlencode($variants);
    }
    if($subsets!=''){
          $url  .= '&subset='.urlencode($subsets);
    }

    return $url;
}



// Load Google Webfonts
function st_google_font_to_options(){
     if(!function_exists('st_get_google_fonts_array')){
        if(is_file(dirname(__FILE__).'/google-fonts.php')){
             include(dirname(__FILE__).'/google-fonts.php');
        } 
    }
    
     if(!function_exists('st_get_google_fonts_array')){ 
       
            return array();
      }
      $google_fonts = st_get_google_fonts_array();
      
     // echo count($google_fonts);
      $font_options = array();
      foreach($google_fonts as $k=> $font){
            if(empty($font['family']) || $font['family']=='' ){
                continue;
            }
            
            $font_options[$font['family']] = st_build_google_font_options_url($font);
      }
      return $font_options;
    
}










