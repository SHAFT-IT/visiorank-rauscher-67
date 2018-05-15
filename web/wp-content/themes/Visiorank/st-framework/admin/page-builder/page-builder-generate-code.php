<?php

/** ************************************************* ADMIN generate code FUNCTiONS ********************************************************************* */


// for blog post
function stpb_blog_generate($data,$type=''){
    if(empty($data)){
        return '';
    }
    $r = wp_parse_args($data['data'],array(
        'title'=>'',
        'cats' => array(),
        'numpost'=>5,
        'include'=>'',
        'exclude'=>'',
        'orderby'=>'ID',
        'order'=>'DESC',
        'display_type'=>1,
        'show_title'=>'n',
        'show_paging'=>'n'
    ));
    
    extract($r);
    
    if(!empty($cats) and is_array($cats)){
        $cats =  ' cats="'.join(',',$cats).'" ';
    }else{
        $cats ='';
    }
    
     $short_code = ' [blog_post c="'.$data['pbwith'].'" show_title ="'.esc_attr($show_title).'"  show_paging="'.esc_attr($show_paging).'" type="'.esc_attr($display_type).'" order="'.esc_attr($order).'"  orderby="'.esc_attr($orderby).'" include="'.esc_attr(str_replace(' ','',$include)).'" exclude="'.esc_attr(str_replace(' ','',$exclude)).'" title="'.str_replace('"','&quot;',esc_attr($title)).'" '.$cats.' numpost ="'.$numpost.'"] ';
     $short_code = apply_filters('stpb_blog_generate',$short_code,$data);
     return $short_code;
    
}

// for text items
function  stpb_text_generate($data,$type=''){
     if(empty($data)){
        return '';
    }
    
    $function = $data['function'];
    $function = explode('_',$function);
    unset($function[0]);
    $function =join('-',$function);
    if($function==''){
        $function ='text';
    }
    
    $function= strtolower($function);
    
    $r = wp_parse_args($data['data'],array(
        'title'=>'',
        'content'=>'',
        'img'=>'',
        'url'=>'',
        'autop'=>false,
        'show_more'=>'',
        'more_text'=>__('Read more','magazon')
    ));
    
    extract($r);
    
    if($url!='' && ($show_more==1|| $show_more==true)){
        $more = '<div class="read-more"><a class="more" title="'.esc_attr($title).'" href="'.esc_attr($url).'">'.esc_html($more_text).'</a></div>';
    }else{
        $more='';
    }
    
    
    if($content !='' &&($autop ==1 || $autop==true )){
        $content = '<div class="'.$function.'-content" >'.wpautop($content).'</div>';
    }elseif($content!=''){
         $content = '<div class="'.$function.'-content">'.$content.'</div>';
    }else{
        $content ='';
    }
    
    if($img!=''){
        $img = '<div class="img"><img src="'.esc_attr($img).'" alt="'.esc_attr($title).'" /></div>';
    }
    if($title!='' && $url!=''){
        $title ='<h2 class="post-title '.$function.'-title"><a title="'.esc_attr($title).'" href="'.esc_attr($url).'">'.esc_html($title).'</a></h2>';
    }elseif($title!=''){
         $title ='<h2 class="post-title '.$function.'-title">'.esc_html($title).'</h2>';
        
    }else{
        $title= '';
    }
    
    $html  = '<div class="'.$function.'-box">'.$title.$img.$content.$more.'</div>';
    return $html;
    
}



function  stpb_alert_generate($data,$type=''){
     if(empty($data)){
        return '';
    }
    $r = wp_parse_args($data['data'],array(
        'title'=>'',
        'content'=>'',
        'img'=>'',
        'url'=>'',
        'autop'=>false,
        'alert_type'=>'',
    ));
    
    extract($r);
    if($content !='' &&($autop ==1 || $autop==true )){
        $content = '<div class="alert-content" >'.wpautop($content).'</div>';
    }elseif($content!=''){
         $content = '<div class="alert-content">'.$content.'</div>';
    }else{
        $content ='';
    }
    
    if($img!=''){
        $img = '<div class="img"><img src="'.esc_attr($img).'" alt="'.esc_attr($title).'" /></div>';
    }
    if($title!='' && $url!=''){
        $title ='<h3 class="alert-title"><a title="'.esc_attr($title).'" href="'.esc_attr($url).'">'.esc_html($title).'</a></h3>';
    }elseif($title!=''){
         $title ='<h3 class="alert-title">'.esc_html($title).'</h3>';
        
    }else{
        $title= '';
    }
    if($alert_type!=''){
        $alert_type =' alert-'.$alert_type;
    }
    $html  = '<div class="alert'.$alert_type.'"><button type="button" class="close">'.esc_html(__('&#215;','magazon')).'</button>'.$title.$img.$content.'<div class="clear"></div></div>';
    return $html;
    
}

function stpb_image_grid_generate($data){
    
    if(empty($data['images'])){
        return '';
    }
    
    $images = $data['images'];
    $meta = $data['meta'];
    $num_col = intval($data['settings']['col']);
    
    if($num_col<=0){
        $num_col =4;
    }
    
    if($num_col>6){
        $num_col = 6; // max 6 col
    }
    $title ='';
    if($data['settings']['title']!=''){
         $title .='<h1 class="st-category-heading">'.esc_html($data['settings']['title']).'</h1>';
    }
    $shorcode = '<div class="content-wrapper image_grid col-'.$num_col.'">'.$title.'  %1$s  </div>';
    
    $class=  stpb_number_to_text(round(12*(1/$num_col)));
    $string_shortcode = array();
    
    $rows = array();
    
    $c = 0;
    $i =0;
    $str_cols ='';
    $format = "<div class=\"row \"> \n".'%1$s'."\n</div>";
    
    foreach($images as $n=> $img){
        $col = array();
        $col['img'] = $img;
        $col['meta'] =$meta[$n];
      
      $str_cols = ' <div class="'.$class.' columns"> [st_img img_id="'.esc_attr($col['img']).'" title="'.esc_attr($col['meta']['title']).'" url="'.esc_attr($col['meta']['url']).'" ] '.esc_attr($col['meta']['caption']).' [/st_img] </div>';
    
      $rows[$c][] =  $str_cols ;
      if($i>=$num_col-1){
        $c++;
        $i=0;
      }else{
         $i++;
      }        
    }
    
    $item=array();
    foreach($rows  as  $cols){
        // $item[] =  sprintf($format,join("\n",$cols));
         $item[] =   sprintf($format,join("\n",$cols).'<div class="clear"></div>');
    }
    
    $shorcode = sprintf($shorcode,join("\n",$item).'').'<div class="clear"></div>';
    
    return  $shorcode;
   // extract($r);  
}



function stpb_widget_generate($data){
    
    if(empty($data)){
        return '';
    }
    
    $title ='';
    if($data['data']['title']!=''){
         $title .='<h1 class="st-category-heading">'.esc_html($data['data']['title']).'</h1>';
    }
    
    return '<div class="content-wrapper buider-widget sidebar">'.$title.'  [st_widget id="'.esc_attr($data['data']['widget']).'"]  </div>';
   
}



function stpb_slider_generate($data){
    
    if(empty($data['images'])){
        return '';
    }
    $images = $data['images'];
    $meta = $data['meta'];
    $html = st_get_content_from_func('st_slider',$data);
    return  $html;
}


function stpb_carousel_generate($data){
    if(empty($data['images'])){
        return '';
    }
    $images = $data['images'];
    $meta = $data['meta'];
    $html = st_get_content_from_func('st_carousel',$data);
    return  $html;
}

/**
 * return  item html code
 */ 
function  stpb_ui_item_generate($data=array(),$tag ='li',$class='',$chil_class_prefix='item',$icon='', $item_id='',$is_tab = false){
    $data = wp_parse_args($data,array(
            'title'=>'',
            'content'=>'',
            'img'=>'',
            'url'=>'',
            'autop'=>false,
            'show_more'=>'',
            'more_text'=>__('Read more','magazon')
        ));
        
        extract($data);
        $html ='';
        
        if($url!='' && ($show_more==1|| $show_more==true)){
            $more = '<div class="read-more"><a class="more" title="'.esc_attr($title).'" href="'.esc_attr($url).'">'.esc_html($more_text).'</a></div>';
        }else{
            $more='';
        }
        
        
        if($content !='' &&($autop ==1 || $autop==true )){
            $content = '<div class="txt-content" >'.wpautop($content).'</div>';
        }elseif($content!=''){
             $content = '<div class="txt-content">'.$content.'</div>';
        }else{
            $content ='';
        }
        
        if($img!=''){
            $img = '<div class="img"><img src="'.esc_attr($img).'" alt="'.esc_attr($title).'" /></div>';
        }

       if($title!='' and !$is_tab){
          if($icon){
            $icon = '-'.$icon;
          }
             $title =' <h3 class="'.esc_html($chil_class_prefix).'-title">'.esc_html($title).'<i class="ui-icon icon'.$icon.'"></i></h3>';
            
        }else{
            $title= '';
        }
        
        if($class!=''){
            $class = ' class="'.esc_attr($class).'"';
        }
        
        if($item_id!=''){
            $item_id = '  id= "'.esc_attr($item_id).'" ';
        }
        
        if($is_tab){
            $html .= '<'.$tag.$item_id.$class.'>'.$img.$content.$more.'</'.$tag.'>'."\n";
        
        }else{
            $html .= '<'.$tag.$item_id.$class.'>'.$title.'<div class="'.esc_html($chil_class_prefix).'-content">'.$img.$content.$more.'</div></'.$tag.'>'."\n";
        
        }
        
        
        return $html;
}



function  stpb_accordion_generate($data){
    $actitle = '';
    if($data['settings']['title']!=''){
        $actitle = '<h2  class="acc-head-title">'.esc_html($data['settings']['title']).'</h2>';
    }
    $html ='';
    foreach($data['data'] as $k => $d){
        $html .=stpb_ui_item_generate($d,'li','accordion-item','acc','chevron-down');
    }
    
    $html = '<div class="accordion-wrap">
            '.$actitle.'
            <ul class="st-accordion">
                '.$html.'
            </ul>
        </div>';
    return $html;
}


function  stpb_toggle_generate($data){
    $actitle = '';
    if($data['settings']['title']!=''){
        $actitle = '<h2  class="toggle-head-title">'.esc_html($data['settings']['title']).'</h2>';
    }
    $html ='';
    foreach($data['data'] as $k => $d){
        $html .=stpb_ui_item_generate($d,'li','toggle-item','toggle','minus');
    }
    
    $html = '<div class="toggle-wrap">
            '.$actitle.'
            <ul class="st-toggle">
                '.$html.'
            </ul>
        </div>';
    return $html;
}




function  stpb_tabs_generate($data){
    $mtitle = '';
    if($data['settings']['title']!=''){
        $mtitle = '<h2  class="tabs-head-title">'.esc_html($data['settings']['title']).'</h2>';
    }
    $content  ='';
    $tab_titles = '';
    $i = 0;
    $id = 'tab-'.uniqid();
    foreach($data['data'] as $k => $d){

        $tab_titles.='<li'.$class.' tab-id="'.$id.$k.'"><span>'.esc_html($d['title']).'</span></li>'."\n";
        $content .=stpb_ui_item_generate($d,'div','tab-content','','',$id.$k,true);
        $i++;
    }
    
    $html = '<div class="tabs-wrap">
            '.$mtitle.'
            <div class="st-tabs b40">
                    <ul class="tab-title">
                        '.$tab_titles.'
                    </ul>
                    <div class="tab-content-wrapper">
                        '.$content.'
                    </div>
                </div>
        </div>';
    return $html;
}





function  stpb_post_slider_generate($data){
    if(empty($data)){
        return '';
    }
    //st_slider()
    $html ='';
    if(trim($data['data']['title'])!=''){
        $html .= '<h2  class="post-slider-title">'.esc_html($data['data']['title']).'</h2>';
    }
    
   // $html  .=  st_get_content_from_func('st_slider',st_get_setup_post_slider_data($data['data']), array('class'=>'posts-slider'));
     $html .='[st_slider '.st_shortcode_attr($data['data']).']';
   // wp_reset_query();
    return $html;

}

function  stpb_post_carousel_generate($data){
    if(empty($data)){
        return '';
    }
    //st_slider()
    $html ='';
    if(trim($data['data']['title'])!=''){
        $html .= '<h1 class="st-category-heading st_carousel">'.esc_html($data['data']['title']).'</h1>';
    }
    //$html  .=  st_get_content_from_func('st_carousel',st_get_setup_post_slider_data($data['data']), array('class'=>'posts-carousel'));
     $html .='[st_carousel '.st_shortcode_attr($data['data']).']';
    return $html;

}



