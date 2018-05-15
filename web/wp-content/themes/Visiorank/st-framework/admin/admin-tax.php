<?php
// save
//add_action( 'edited_taxonomyname', 'save_extra_fields_callback', 10, 2);
//$taxonomies=get_taxonomies('','names'); 
$taxonomies = array('category');
foreach ($taxonomies as $taxonomy ) {
    add_action("created_{$taxonomy}", 'st_save_tax_extra', 10, 1);
    add_action("edited_{$taxonomy}", 'st_save_tax_extra', 10, 1);
    add_action("{$taxonomy}_edit_form_fields", 'extra_tax_fields', 1, 2);
    add_action("{$taxonomy}_add_form_fields", 'extra_tax_fields', 10, 2);
    add_action("delete_{$taxonomy}", 'st_del_extra_tax', 10, 3);
}



function st_del_extra_tax($term='', $tt_id='', $deleted_term=''){
    delete_option('st_tax_meta_'.$term);
}


function st_save_tax_extra($term_id){

    $data = array();
    if(is_array($_REQUEST)){
        foreach($_REQUEST as $k => $v){
            if(strpos($k, 'st_tax_meta')!==false){
                $data[str_replace('st_tax_meta_','', $k)] = $v;
            }
        }
    }
    update_option('st_tax_meta_'.$term_id, $data );
}

 //   add_options_page();
add_action("admin_print_styles-edit-tags.php","st_options_admin_css"); 
add_action("admin_print_scripts-edit-tags.php","st_options_admin_js");


//add extra fields to custom taxonomy edit form callback function
function extra_tax_fields($tag) {
   //check for existing taxonomy meta for term ID
    $t_id = $tag->term_id;
    $term_meta = get_option( "st_tax_meta_{$t_id}");
    
    global $wp_registered_sidebars;
        $st_sidebars = $wp_registered_sidebars;
        $tpl_sidebars = array();
        foreach($st_sidebars as $k=> $s){
            $tpl_sidebars[$s['id']] = $s['name'];
        }
    
    $bg_tab = array(
    
    array(
            'name'=>'tax_sidebar',
            'title'=>__('Custom Sidebar','magazon'),
            'type' =>'select',
            'multiple'=> false,
            'options'=>$tpl_sidebars,
            'default'=>'',
            'desc'=>'',
            'desc_bottom'=>''
         ),
    
     array(
        'name'        =>'enable_slider',
        'title'       =>__('Enable Top slider','magazon'),
        'type'        =>'select',
        'options' => array(
                'n'=>__('No','magazon'),
                'y'=>__('Yes','magazon')
        ),
        'default'     =>'',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'slider_type',
        'title'       =>__('Slider type','magazon'),
        'type'        =>'select',
        'options' => array(
                'c'=>__('Carousel','magazon'),
                's'=>__('Slider','magazon')
        ),
        'default'     =>'c',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'numpost',
        'title'       =>__('How many numpost to show ?','magazon'),
        'type'        =>'text',
        'default'     =>'6',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'exclude',
        'title'       =>__('exclude','magazon'),
        'type'        =>'text',
        'default'     =>'',
        'desc'        =>'',
        'desc_bottom' =>__('Enter post IDs, separated by commas','magazon')
    ),
    
    
       array(
        'name'        =>'orderby',
        'title'       =>__('Order By','magazon'),
        'type'        =>'select',
        'options' => array(
                'title'=>__('title','magazon'),
                'comment_count'=>__('comment count','magazon'),
                'rand'=>__('Random','magazon')
        ),
        'default'     =>'',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
     array(
        'name'        =>'order',
        'title'       =>__('Order','magazon'),
        'type'        =>'select',
        'options' => array(
                'DESC'=>__('Descending','magazon'),
                'ASC'=>__('Ascending','magazon')
        ),
        'default'     =>'DESC',
        'desc'        =>'',
        'desc_bottom' =>''
    ),
    
    
    
    
    
    
    array(
        'name'        =>'bg_color',
        'title'       =>__('Background color'),
        'type'        =>'color',
        'default'     =>'',
        'desc'        =>'NOTE: background style only apply when selected Boxed layout.',
        'desc_bottom' =>''
    ),
    
    array(
        'name'        =>'bg_img',
        'title'       =>__('Background image'),
        'type'        =>'upload',
        'default'     =>'',
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
    
    
?>
<script type="text/javascript">
 jQuery(document).ready(function(){
    function st_tax_added(){
         jQuery('.STpanel-image-preview').html('');
    }
     var container = document.getElementById ("the-list");
     if(container && container.addEventListener){
         container.addEventListener ('DOMNodeInserted', st_tax_added, false);
     }

 });
</script>

<style type="text/css">
.st_tax_extra_fields .STpanel-input-box input[type="text"]{
    padding: 3px 5px;
}
.st_tax_extra_fields .STpanel-box-title {
     font-size: 16px;
     text-transform: none;
}
</style>
 <?php if($t_id>0): // is _edit  ?>
 <tr>
 <td colspan="2">
    <div class="st_tax_extra_fields">
    <div class="ST">
    <?php 
    $tab_display = new admin_tabs_display($term_meta,'st_tax_meta');
    $tab_display->display_tab_contents($bg_tab); 
    ?>
    </div>
    </div>
 </td>
 </tr>
<?php  else: // add new  ?>

<div class="st_tax_extra_fields">
<div class="ST">
<?php 

$tab_display = new admin_tabs_display($values,'st_tax_meta');
$tab_display->display_tab_contents($bg_tab); 

?>

</div>
</div>

<?php endif; ?>

<?php
}