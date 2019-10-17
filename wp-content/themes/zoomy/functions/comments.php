<?php

/**
 * カスタムコメント
 */
function custom_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if ( ! $commentcount ) {
		$commentcount = 0;
	}

	$author = $comment->user_id ? get_user_by( 'id', $comment->user_id ) : null;
?>
<li id="comment-<?php comment_ID(); ?>" class="c-comment__list-item comment">
	<div class="c-comment__item-header u-clearfix">
		<div class="c-comment__item-meta u-clearfix">
<?php
	if ( ! empty( $author->ID ) ) {
?>
			<a id="commentauthor-<?php get_comment_ID(); ?>" class="p-comment__item-author<?php the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
				<span class="p-comment__item-author_thumbnail js-object-fit-cover"><?php echo get_avatar( $author->ID, 96, '' ); ?></span>
				<span class="p-comment__item-author_name"><?php echo esc_html( $author->display_name ); ?></span>
			</a>
<?php
	} else {
?>
			<div class="p-comment__item-author">
				<span class="p-comment__item-author_thumbnail js-object-fit-cover"><?php echo get_avatar( $comment, 96 ); ?></span>
				<span class="p-comment__item-author_name"><?php comment_author(); ?></span>
			</div>
<?php
	}
?>
			<time class="c-comment__item-date" datetime="<?php comment_time( 'c' ); ?>"><?php comment_time( 'Y.m.d H:i' ); ?></time>
		</div>
		<ul class="c-comment__item-act">
<?php
	if ( 1 == get_option( 'thread_comments' ) ) :
?>
			<li><?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __( 'REPLY', 'tcd-w' ) . '' ) ) ); ?></li>
<?php
	endif;
?>
		</ul>
	</div>
	<div id="comment-content-<?php comment_ID(); ?>" class="c-comment__item-body">
<?php
	if ( 0 == $comment->comment_approved ) {
		echo '<span class="c-comment__item-note">' . __( 'Your comment is awaiting moderation.', 'tcd-w' ) . '</span>' . "\n";
	} else {
		comment_text();
	}
?>
	</div>
<?php
}

/**
 * カスタムコメント コメントタイプ2
 */
function custom_comments_type2( $comment, $args, $depth ) {
	global $dp_options, $commentcount, $comments_type2_vars;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$GLOBALS['comment'] = $comment;
	if ( ! $commentcount ) {
		$commentcount = 0;
	}

	$author = $comment->user_id ? get_user_by( 'id', $comment->user_id ) : null;

	if ( ! $comments_type2_vars ) {
		$comments_type2_vars = array(
			'posistion' => '',
			'last_comment_user_id' => null
		);
	}

	if ( ! $comments_type2_vars['posistion'] ) {
		$comments_type2_vars['posistion'] = 'left';
	} elseif ( ! $comment->user_id || $comment->user_id != $comments_type2_vars['last_comment_user_id'] ) {
		if ( $comments_type2_vars['posistion'] != 'left' ) {
			$comments_type2_vars['posistion'] = 'left';
		} else {
			$comments_type2_vars['posistion'] = 'right';
		}
	}
	$comments_type2_vars['last_comment_user_id'] = $comment->user_id;
?>
<li id="comment-<?php comment_ID(); ?>" class="c-comment__list-item comment p-comment__list-item--<?php echo esc_attr( $comments_type2_vars['posistion'] ); ?>">
	<div class="c-comment__item-header">

<?php
	if ( ! empty( $author->ID ) ) {
?>
		<a id="commentauthor-<?php get_comment_ID(); ?>" class="p-comment__item-author p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
			<span class="p-comment__item-author_thumbnail"><span class="p-hover-effect__image"><?php echo get_avatar( $author->ID, 96, null, $author->display_name ); ?></span></span>
			<span class="p-comment__item-author_name"><?php echo esc_html( $author->display_name ); ?></span>
		</a>
<?php
	} else {
?>
		<div id="commentauthor-<?php get_comment_ID(); ?>" class="p-comment__item-author">
			<span class="p-comment__item-author_thumbnail"><?php echo get_avatar( $comment, 96 ); ?></span>
			<span class="p-comment__item-author_name"><?php comment_author(); ?></span>
		</div>
<?php
	}
?>
		<time class="c-comment__item-date" datetime="<?php comment_time( 'c' ); ?>"><?php comment_time( 'Y.m.d H:i' ); ?></time>
	</div>
	<div id="comment-content-<?php comment_ID(); ?>" class="c-comment__item-body">
<?php
	if ( 0 == $comment->comment_approved ) {
		echo '<span class="c-comment__item-note">' . __( 'Your comment is awaiting moderation.', 'tcd-w' ) . '</span>' . "\n";
	} else {
		comment_text();
	}
?>
	</div>
<?php
}

/**
 * コメントタイプ2の場合に「コメントをN階層までのスレッド (入れ子) 形式にする」オプション(thread_comments)を強制的にオフにする
 */
function filter_get_option_thread_comments( $option_value, $option_key ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( is_singular( $dp_options['photo_slug'] ) && 'type2' === $dp_options['comment_type_photo'] ) {
		return 0;
	} elseif ( is_single() && 'type2' === $dp_options['comment_type'] ) {
		return 0;
	}

	return $option_value;
}
add_filter( 'option_thread_comments', 'filter_get_option_thread_comments', 10, 2 );
