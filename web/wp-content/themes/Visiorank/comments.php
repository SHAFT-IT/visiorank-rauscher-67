<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.",'magazon'); ?></p>
	<?php
		return;
	}
?>

<div id="comments">
<!-- You can start editing here. -->
<!--if there is one comment-->
<?php if ( have_comments() ) : ?><!--you need the id comments for the links to the comments-->
    	<h4 class="comments-header-title"><?php comments_number(__('No Responses','magazon'), __('One Response','magazon'), __('% Responses','magazon') );?> to &#8220;<?php the_title(); ?>&#8221;</h4>
    	<ol class="comments-list"><!--one comment-->
    	   <?php wp_list_comments('callback=st_comments'); ?>
    	</ol>
    <!--comments navi-->
    <div class="comment_nav">
    	<?php previous_comments_link("<span class='comment_prev advancedlink'>&laquo; ".__('Older Comments','magazon')."</span>") ?>
    	<?php next_comments_link("<span class='comment_next advancedlink'>".__('Newer Comments','magazon')." &raquo;</span>") ?>
    </div>
	
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
        <p class="meta" id="comments">
            <?php comments_number(__('No Responses','magazon'), __('One Response','magazon'), __('% Responses','magazon') );?> 
            <?php _e('to','magazon'); ?> &#8220;<?php the_title(); ?>&#8221;
        </p>    
        <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<span class="meta"><?php _e('Comments are closed.','magazon'); ?></span>

	<?php endif; ?>
<?php endif; ?><!--end of comments-->

<!--beginn of the comments form-->
<?php if ('open' == $post->comment_status) : ?>

    <div id="respond"><!--you need div  id response for threaded comments-->
    <?php  comment_form_title( '', '<h3>'.__('Leave a Reply to %s','magazon').'</h3>'); ?>
    <!--if registration is required-->
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p>
        <?php _e('You must be','magazon'); ?> 
        <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">
            <?php _e('logged in','magazon'); ?>
        </a> 
        <?php _e('to post a comment.','magazon'); ?>
    </p>

<?php else : ?>
    <!--begin of the comment form read and understand -->
    <?php /*
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <div class='personal_data'>
            <?php if ( $user_ID ) : ?>
        
            <p>
            <?php _e('Logged in as','magazon'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out','magazon'); ?> &raquo;</a></p>
            
            <?php else : 
            
            if ($comment_author == '') $comment_author = __('','magazon');
            if ($comment_author_email == '') $comment_author_email = __('','magazon');
            if ($comment_author_url == '') $comment_author_url = __('','magazon');
            
            ?>
        
             <div class="form-line">
                <label for="author"><?php _e('Name','magazon');  if ($req) echo " (<span>*</span>)"; ?></label><br />
                <input type="text" name="author" class="text_input" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1"   />
                
             </div>
            
             <div class="form-line">
                <label for="email"><?php _e('Mail (will not be published)','magazon');  if ($req) echo " (<span>*</span>)"; ?></label><br />
                <input type="text" name="email" class="text_input" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
             </div>
            
            <div class="form-line">
                <label for="url"><?php _e('Website','magazon'); ?></label><br />
                <input type="text" name="url" class="text_input" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
               
            </div>
        
            <?php endif; ?>
        </div><!-- #personal_data -->
        
        <div class='form-line'>
            <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
                <label for="comment_txt"><?php _e('Comment','magazon'); ?><span>*</span></label> <br />
                <textarea name="comment" id="comment_txt" cols="100%" rows="10" class='text_area' tabindex="4"></textarea>
        </div><!-- /form-line -->
        
        
            <p>
                <input name="submit" class="button_submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /><?php cancel_comment_reply_link(__("Cancel Reply",'magazon')); ?><!--to cancel the comment link or not-->
            </p>
            <p>
                <?php comment_id_fields(); ?><!--this is necessary because wp must know which comment to which article-->
                
                <?php do_action('comment_form', $post->ID); ?><!--some plugins needs this hook-->
            </p>
    </form>
    */ ?>
    <?php 
    $user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
    if ($comment_author == '') $comment_author = __('','magazon');
    if ($comment_author_email == '') $comment_author_email = __('','magazon');
    if ($comment_author_url == '') $comment_author_url = __('','magazon');
    
   	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$required_text = sprintf( ' ' . __('Required fields are marked %s','magazon'), '<span class="required">*</span>' );
    $args = array(
	'id_form' => 'commentform',
	'id_submit' => 'submit',
	'title_reply' => __( 'Leave a Reply' ,'magazon'),
	'title_reply_to' => __( 'Leave a Reply to %s','magazon'),
	'cancel_reply_link' => __( 'Cancel Reply', 'magazon' ),
	'label_submit' => __( 'Post Comment' ,'magazon'),
	'comment_field' => '<div class="form-line"><label for="comment_txt">' . __( 'Comment','magazon' ) . '</label><br /><textarea id="comment_txt" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
	'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','magazon') . ( $req ? $required_text : '' ) . '</p>',
	'comment_notes_after' => '',
	'fields' => apply_filters( 'comment_form_default_fields', array(
    		'author' => '<div class="form-line comment-form-author">' . '<label for="author">' . __( 'Name', 'magazon' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<br /><input id="author" name="author" type="text" value="' . esc_attr( $comment_author) . '" size="30"' . $aria_req . ' /></div>',
    		'email' => '<div class="form-line comment-form-email"><label for="email">' . __( 'Email', 'magazon' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<br /><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
    		'url' => '<div class="form-line comment-form-url"><label for="url">' . __( 'Website', 'magazon' ) . '</label>' . '<br /><input id="url" name="url" type="text" value="' . esc_attr($comment_author_url ) . '" size="30" /></div>' ) ) );
    
    comment_form($args); ?>
    
    
    <?php endif; // If registration required and not logged in ?>
</div><!-- respond -->
<?php endif; // if you delete this the sky will fall on your head ?>

</div><!-- #comments -->