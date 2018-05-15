<?php 
/*
* Plugin Name: Instagram Theatre
*
* Plugin URI: http://chrisriversdesign.com
* Description: This is a plugin designed to allow you to easily pull photos from your instagram account and render them on your website. You can do all kinds of fun things like load a location photo feed, load a friend's feed, or load your own. Simply pass in your username and the rest is take care of for you!
* Author: Chris Rivers
*
* Version: 1.5
* Author URI: http://chrisriversdesign.com
*/

// -------------- Global Vars --------------
// Get Mode.
$istheatreaccesstoken = get_option('istheatre_accesstoken');
$istheatremode = get_option('istheatre_mode');
$istheatreuserid = get_option('istheatre_userid');
$istheatretag = get_option('istheatre_tag');
$istheatrelocationID = get_option('istheatre_locationID');
$istheatregallerymode = get_option('istheatre_gallery_mode');
$istheatregalleryphotos = get_option('istheatre_gallery_photos');

$istheatrespeed = get_option('istheatre_speed');
$istheatredelay = get_option('istheatre_delay');

// -------------- Admin function --------------
function instagram_theatre_admin(){
	include('instagram_theatre_admin.php');
}

function instagram_theatre_actions(){
	add_menu_page( __( 'Instagram Theatre', 'wpmt' ), __( 'Instagram Theatre', 'wpmt' ),
		'edit_posts', 'wpmt', 'instagram_theatre_admin',
		'../wp-content/plugins/instagram-theatre/code/css/images/icon.png' );
}

add_action('admin_menu', 'instagram_theatre_actions');

function instagram_theatre_short_code_posts_function() {
	
	global $istheatreaccesstoken;
	global $istheatremode;
	global $istheatreuserid;
	global $istheatretag;
	global $istheatrelocationID;
	global $istheatregallerymode;
	global $istheatregalleryphotos;
	
	global $istheatrespeed;
	global $istheatredelay;
	
	if( $istheatreaccesstoken != "" && $istheatremode != "" && $istheatregallerymode != "" ){
		if( $istheatreuserid != "" || $istheatretag != "" ){
			
			if( $istheatregalleryphotos != "" ){
				$photoContainer = ".fsg-photos";
			} else {
				$photoContainer = "";
			}
			
			if( $istheatrespeed == '' ){
				$istheatrespeed = 700;
			}

			if( $istheatredelay == '' ){
				$istheatredelay = 80;
			}
			
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					// Calling the Plugin
					jQuery('.instagram-theatre').instagramTheatre({
						captionOn : true,
						mode : '<?php echo $istheatremode; ?>',
						accessToken : '<?php echo $istheatreaccesstoken; ?>',
						userID : '<?php echo $istheatreuserid; ?>',
						tag : "<?php echo $istheatretag; ?>",
						galleryMode: '<?php echo $istheatregallerymode; ?>',
						galleryFullscreenPhotos: '<?php echo $photoContainer; ?>',
						speed: <?php echo $istheatrespeed; ?>,
						delayInterval : <?php echo $istheatredelay; ?>,
						locationID : '<?php echo $istheatrelocationID; ?>'
					});
				});
			</script>
			
			<div class="main-content theatre">
				<?php if( $istheatregallerymode == 'fullscreen' ){ ?>
				<div class="photo-nav">
					<a class="prev"></a>
					<a class="next"></a>
				</div>
				<?php } ?>
			</div>

			<div class="caption-container">
				<div class="content"></div>
				<a class="caption-close"></a>
			</div>

			<div class="instagram-theatre"></div>
			<div class="fsg-photos" style="display:none;">
				<?php echo $istheatregalleryphotos; ?>
			</div>
			
			<?php
		}
	}
}

/*--------------------------------
	       Shortcode
----------------------------------*/
add_shortcode("instagram-theatre", "instagram_theatre_short_code_handler");

function instagram_theatre_short_code_handler() {
	global $content;
	
	// New Buffer Functionality
	ob_start();
	instagram_theatre_short_code_posts_function();
	$demolph_output = ob_get_clean();
	
	// run function that actually does the work of the plugin.
	// $demolph_output = instagram_theatre_short_code_posts_function();

	// send back text to replace shortcode in post.
	return $demolph_output;
}


function instagram_theatre_jquery_init() {
    if(!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'instagram_theatre_jquery_init');


/*--------------------------------
	 Adding Need Scripts & CSS
----------------------------------*/
function instagram_theatre_add_to_header()
{
	$pathToTheme = get_bloginfo('wpurl') . "/wp-content/plugins/instagram-theatre";
	
	wp_enqueue_script('custom-script-1', $pathToTheme . '/jquery-instagram-theatre/jquery.fancybox-1.3.4.pack.js');
	wp_enqueue_script('custom-script-2', $pathToTheme . '/jquery-instagram-theatre/dateFormat.js');
	wp_enqueue_script('custom-script-3', $pathToTheme . '/jquery-instagram-theatre/srobbin-jquery-backstretch/jquery.backstretch.min.js');
	wp_enqueue_script('custom-script-4', $pathToTheme . '/jquery-instagram-theatre/easing.js');
	wp_enqueue_script('custom-script-5', $pathToTheme . '/jquery-instagram-theatre/instagramTheatre.js');
	
	wp_enqueue_style('custom-style-1', $pathToTheme . '/jquery-instagram-theatre/jquery.fancybox-1.3.4.css');
	wp_enqueue_style('custom-style-2', $pathToTheme . '/code/style.css');
}
add_action('wp_head', 'instagram_theatre_add_to_header');

/*--------------------------------
	 Needed ADMIN Scripts & CSS
----------------------------------*/
function instagram_theatre_admin_add_to_header()
{
	$pathToTheme = get_bloginfo('wpurl') . "/wp-content/plugins/instagram-theatre";
	
	wp_enqueue_style('admin-custom-style-1', $pathToTheme . '/code/functions/functions.css?ver=1.0');
	wp_enqueue_script('admin-custom-script-1', $pathToTheme . '/code/functions/rm_script.js?ver=1.0');
}

add_action('admin_head', 'instagram_theatre_admin_add_to_header');

?>