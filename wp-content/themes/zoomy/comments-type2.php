<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

$trackbacks = $comments_by_type['pings'];

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments-type2' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'Please do not load this page directly. Thanks!' );
}

if ( post_password_required() ) {
	echo '<div class="c-comment">' . "\n";
	echo '<div class="c-comment__password-protected">' . "\n";
	echo '<p>' . __( 'This post is password protected. Enter the password to view comments.', 'tcd-w' ) . '</p>' . "\n";
	echo '</div>' . "\n";
	echo '</div>' . "\n";
	return;
}
?>
<div id="comments" class="c-comment p-comment--type2">
<?php
if ( is_singular( $dp_options['photo_slug'] ) ) :
?>
	<h2 class="p-headline-photo"><span class="p-headline-photo__comment"><?php echo esc_html( $dp_options['photo_comment_headline'] ); ?></span></h2>
<?php
else :
?>
	<h2 class="p-headline"><?php _e( 'Comment', 'tcd-w' ); ?></h2>
<?php
endif;
?>
	<ol class="c-comment__list">
<?php
if ( $comments && count( $comments_by_type['comment'] ) > 0 ) :
	wp_list_comments( 'type=comment&callback=custom_comments_type2' );
else :
?>
			<li class="c-comment__list-item c-comment__list-item__nocomments">
				<div class="c-comment__item-body"><p><?php _e( 'No comments yet.', 'tcd-w' ); ?></p></div>
			</li>
<?php
endif;
?>
	</ol>
<?php
if ( get_option( 'page_comments' ) ) :
	$paginate_links = paginate_comments_links( array(
		'echo' => false,
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager p-pager-comments">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item<?php if ( strpos( $paginate_link, 'current' ) ) echo ' p-pager__item--current'; ?>"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
endif;

// if comment are closed and don't have any comments
if ( ! comments_open() ) :

// required logged in.
elseif ( ! current_user_can( 'read' ) ) :
	$login_link = wp_login_url();
?>
	<div class="c-comment__form-wrapper" id="respond"><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'tcd-w' ), $login_link ); ?></div>
<?php
// if comment is open
else :
?>
	<form id="respond" action="<?php echo esc_url( site_url( '/' ) ); ?>wp-comments-post.php" class="c-comment__form" method="post">
		<div class="c-comment__input">
			<textarea id="js-comment__textarea" name="comment" placeholder="<?php esc_attr_e( 'Comment', 'tcd-w' ); ?>"></textarea>
		</div>
<?php do_action( 'comment_form', $post->ID ); ?>
		<input type="submit" class="c-comment__form-submit p-button" value="<?php _e( 'Submit Comment', 'tcd-w' ); ?>">
		<div class="c-comment__form-hidden">
			<?php comment_id_fields(); ?>
		</div>
	</form>
<?php
endif;
?>
</div>
