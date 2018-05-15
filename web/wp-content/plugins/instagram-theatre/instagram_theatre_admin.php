<?php
/*
*
* Instagram Theatre Admin
*
*/
?>

<?php 
	if($_POST){
		if($_POST['istheatre_hidden'] == 'Y') {
			// Post View
			$istheatreaccesstoken = $_POST['istheatre_accesstoken'];
			update_option('istheatre_accesstoken', $istheatreaccesstoken);
			
			$istheatremode = $_POST['istheatre_mode'];
			update_option('istheatre_mode', $istheatremode);
			
			$istheatreuserid = $_POST['istheatre_userid'];
			update_option('istheatre_userid', $istheatreuserid);
			
			$istheatretag = $_POST['istheatre_tag'];
			update_option('istheatre_tag', $istheatretag);
			
			$istheatrelocationID = $_POST['istheatre_locationID'];
			update_option('istheatre_locationID', $istheatrelocationID);
			
			$istheatregallerymode = $_POST['istheatre_gallery_mode'];
			update_option('istheatre_gallery_mode', $istheatregallerymode);
			
			$istheatregalleryphotos = stripslashes($_POST['istheatre_gallery_photos']);			
			update_option('istheatre_gallery_photos', $istheatregalleryphotos);
						
			$istheatrespeed = stripslashes($_POST['istheatre_speed']);			
			update_option('istheatre_speed', $istheatrespeed);
			
			$istheatredelay = stripslashes($_POST['istheatre_delay']);			
			update_option('istheatre_delay', $istheatredelay);
		
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php
		
		}
	} else {
		// Normal View
		$istheatreaccesstoken = get_option('istheatre_accesstoken');
		$istheatremode = get_option('istheatre_mode');
		$istheatreuserid = get_option('istheatre_userid');
		$istheatretag = get_option('istheatre_tag');
		$istheatrelocationID = get_option('istheatre_locationID');
		$istheatregallerymode = get_option('istheatre_gallery_mode');
		$istheatregalleryphotos = get_option('istheatre_gallery_photos');
		$istheatrespeed = get_option('istheatre_speed');
		$istheatredelay = get_option('istheatre_delay');
	}
?>

<div class="wrap rm_wrap">
	<h2>Instagram Theatre Settings</h2>
	<img src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/instagram-theatre/code/css/images/admin-view.png">
 
	<div class="rm_opts">
		<form method="post">
			<input type="hidden" name="istheatre_hidden" value="Y">
			<p>To easily use the Instagram Theatre plugin, you can use the menu below.</p>
			
			<div class="rm_section">
				<div class="rm_title">
					<h3 class="inactive">
						<img alt="" class="inactive" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/instagram-theatre/code/functions/images/trans.png">
						Basic Settings
					</h3>
					<span class="submit">
						<input type="submit" value="Save changes" name="save1">
					</span>
					<div class="clearfix"></div>
				</div>
				
				<div class="rm_options" style="display: block;">
					<div class="rm_input rm_textarea">
                        <label>Access Token:</label>
                        <input class="username" type="text" name="istheatre_accesstoken" value="<?php echo $istheatreaccesstoken; ?>" />
                        <small>Enter your Instagram access token. This is used by the plugin to pull in your photos.</small>
						<div class="clearfix"></div>
                    </div>

					<div class="rm_input rm_textarea rm_instagram_mode" rel="<?php echo $istheatremode; ?>">
												
						<label>Instagram Mode:</label>
						<div class="radio-container">
							<input type="radio" name="istheatre_mode" value="user" <?php if( $istheatremode == 'user' || $istheatremode == '' ){ echo "checked='checked'"; }?> />
							User<br />
							<input type="radio" name="istheatre_mode" value="tag" <?php if( $istheatremode == 'tag' ){ echo "checked='checked'"; }?> />
							Tag<br />
							<input type="radio" name="istheatre_mode" value="multiuser" <?php if( $istheatremode == 'multiuser' ){ echo "checked='checked'"; }?> />
							Multiuser<br />
							
							<input type="radio" name="istheatre_mode" value="location" <?php if( $istheatremode == 'location' ){ echo "checked='checked'"; }?> />
							Location
						</div>
						<small>
							This feature allows you to choose between two different plugin modes.
						</small>
						<div class="clearfix"></div>	
					</div>
					
					<div class="rm_input rm_textarea rm_instagram_userid">
                        <label>Userid(s):</label>
                        <input class="username" type="text" name="istheatre_userid" value="<?php echo $istheatreuserid; ?>" />
                        <small>
							Enter the user id of the person you would like to use. If your using the multiuser mode, 
							you can put multiple userids separated with commas.
						</small>
						<div class="clearfix"></div>
                    </div>

					<div class="rm_input rm_textarea rm_instagram_tag">
                        <label>Tag:</label>
                        <input class="username" type="text" name="istheatre_tag" value="<?php echo $istheatretag; ?>" />
                        <small>
							Enter the tag that you would like to pull from the Instagram API.
						</small>
						<div class="clearfix"></div>
                    </div>

					<div class="rm_input rm_textarea rm_instagram_location">
                        <label>Location ID:</label>
                        <input class="username" type="text" name="istheatre_locationID" value="<?php echo $istheatrelocationID; ?>" />
                        <small>
							Enter the location ID that you would like to pull from the Instagram API.
						</small>
						<div class="clearfix"></div>
                    </div>

					<div class="rm_input rm_textarea rm_instagram_gallery_mode">
						<label>Gallery Mode:</label>
						<div class="radio-container">
							<input type="radio" name="istheatre_gallery_mode"  value="fullscreen" <?php if( $istheatregallerymode == 'fullscreen' ){ echo "checked='checked'"; }?> />
							Fullscreen<br />
							<input type="radio" name="istheatre_gallery_mode" value="thumbnail" <?php if( $istheatregallerymode == 'thumbnail' || $istheatregallerymode == '' ){ echo "checked='checked'"; }?> />
							Thumbnails<br />
							<input type="radio" name="istheatre_gallery_mode" value="list" <?php if( $istheatregallerymode == 'list' ){ echo "checked='checked'"; }?> />
							List
						</div>
						<small>
							This feature allows you to choose between different layout modes.
						</small>
						<div class="clearfix"></div>	
					</div>

					<div class="rm_input rm_textarea rm_instagram_gallery_photos">
                        <label>Gallery Fullscreen Photos HTML:</label>
                        <textarea class="username" name="istheatre_gallery_photos"><?php echo $istheatregalleryphotos; ?></textarea>
                        <small>
							Enter your images here in html format. For example:<br />
							
							&lt;img title="Title here" rel="Caption Here" date-created="Date Here" src="imagepathhere" &gt;&lt;/div&gt;

						</small>
						<div class="clearfix"></div>
                    </div>
				</div>
				
			</div>
			
			<br />
			
			<div class="rm_section">
				
				<div class="rm_title">
					<h3 class="inactive">
						<img alt="" class="inactive" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/instagram-theatre/code/functions/images/trans.png">
						Advanced Settings
					</h3>
					<span class="submit">
						<input type="submit" value="Save changes" name="save1">
					</span>
					<div class="clearfix"></div>
				</div>
				
				<div class="rm_options" style="display: block;">
					<div class="rm_input rm_textarea">
                        <label>Transition Speed:</label>
                        <input class="username" type="text" name="istheatre_speed" value="<?php echo $istheatrespeed; ?>" />
                        <small>Enter your transition speed(in milliseconds). This controls the speed in which your photos appear. The default is 700.</small>
						<div class="clearfix"></div>
                    </div>
					<div class="rm_input rm_textarea">
                        <label>Transition Delay Interval:</label>
                        <input class="username" type="text" name="istheatre_delay" value="<?php echo $istheatredelay; ?>" />
                        <small>Enter your delay interval. Sets the interval of the delay between photos appearing. The default is 80.</small>
						<div class="clearfix"></div>
                    </div>
				</div>
				
			</div>
			
			<br>
			<input type="hidden" value="save" name="action">
		</form>
		
		<form method="post">
			<p class="submit">
				<input type="submit" value="Reset" name="reset">
				<input type="hidden" value="reset" name="action">
			</p>
		</form>
	</div> 
	<div class="clear"></div>
</div>
