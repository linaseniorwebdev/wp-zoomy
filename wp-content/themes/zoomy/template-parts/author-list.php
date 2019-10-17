<?php
global $dp_options, $wp_query, $paged, $user_ids, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

// フォロワー・フォロー中リスト
if ( in_array( $_GET['list_type'], array( 'follower', 'following') ) ) :
	if ( $user_ids ) :
		if ( 1 === $paged ) :
?>
<div class="p-user-list p-author__list__inner">
<?php
		endif;

		foreach ( $user_ids as $user_id ) :
			$author = get_user_by( 'id', $user_id );
			if ( ! $author ) continue;
?>
	<div class="p-user-list__item p-author__list-item">
		<div class="p-user-list__item__inner">
			<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
				<div class="p-author__thumbnail js-object-fit-cover">
					<div class="p-author__thumbnail__inner p-hover-effect__image"><?php echo get_avatar( $author->ID, 300 ); ?></div>
				</div>
				<div class="p-author__name"><?php echo esc_html( $author->display_name ); ?></div>
			</a>
<?php
			if ( $dp_options['membership']['use_follow'] ) :
?>
			<div class="p-author__follow">
<?php
				if ( is_following( $author->ID ) ) :
?>
				<a class="p-button-following js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Following', 'tcd-w' ); ?></a>
<?php
				else :
?>
				<a class="p-button-follow js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Follow', 'tcd-w' ); ?></a>
<?php
				endif;
?>
			</div>
<?php
			endif;
?>
		</div>
	</div>
<?php
		endforeach;

		if ( 1 === $paged ) :
?>
</div>
<?php
		endif;
	elseif ( 1 === $paged && 'follower' == $_GET['list_type'] ) :
?>
<p class="no_follow"><?php _e( 'No follower.', 'tcd-w' ); ?></p>
<?php
	elseif ( 1 === $paged && 'following' == $_GET['list_type'] ) :
?>
<p class="no_follow"><?php _e( 'No following.', 'tcd-w' ); ?></p>
<?php
	endif;

// 投稿リスト
elseif ( have_posts() ) :
	$post_statuses = get_post_statuses();

	if ( isset( $_GET['list_type'] ) && 'photo' == $_GET['list_type'] ) :
		$_post_type = '_photo';
		$use_like = $dp_options['membership']['use_like_photo'];
	else :
		$_post_type = '';
		$use_like = $dp_options['membership']['use_like_blog'];
	endif;

	if ( ( $dp_options['show_comments_number_archive' . $_post_type] && get_comments_number() ) || $dp_options['show_views_number_archive' . $_post_type] || ( $use_like && $dp_options['show_likes_number_archive' . $_post_type] ) ) :
		$show_counts = true;
	else :
		$show_counts = false;
	endif;

	if ( 1 === $paged ) :
?>
<div class="p-blog-archive p-author__list__inner">
<?php
	endif;

	while ( have_posts() ) :
		the_post();

		$is_post_author = ( get_current_user_id() == $post->post_author );
		$edit_url = '';
		$delete_url = '';
		if ( $dp_options['membership']['use_front_edit_photo'] && $is_post_author && $post->post_type == $dp_options['photo_slug'] ) :
			$edit_url = get_tcd_membership_memberpage_url( 'edit_photo', $post->ID );
			$delete_url = get_tcd_membership_memberpage_url( 'delete_photo', $post->ID );
		elseif ( $dp_options['membership']['use_front_edit_blog'] && $is_post_author && 'post' == $post->post_type ) :
			$edit_url = get_tcd_membership_memberpage_url( 'edit_blog', $post->ID );
			$delete_url = get_tcd_membership_memberpage_url( 'delete_blog', $post->ID );
		endif;

		$catlist_float = array();
		if ( $dp_options['show_category_archive'] ) :
			if ( $post->post_type == $dp_options['photo_slug'] ) :
				$categories = get_the_terms( $post->ID, $dp_options['photo_category_slug'] );
			else :
				$categories = get_the_category();
			endif;
			if ( $categories && ! is_wp_error( $categories ) ) :
				foreach( $categories as $category ) :
					$catlist_float[] = '<span class="p-category-item' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					break;
				endforeach;
			endif;
		endif;
?>
	<article class="p-blog-archive__item p-author__list-item<?php if ( $show_counts ) echo ' has-counts'; ?>">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>">
			<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
				<div class="p-blog-archive__item-thumbnail__inner">
<?php
		echo "\t\t\t\t\t";
		if ( has_main_image() ) :
			the_main_image( 'size2' );
		elseif ( has_post_thumbnail() ) :
			the_post_thumbnail( 'size2' );
		else :
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
		endif;
		echo "\n";

		if ( $dp_options['show_date_archive'] || $is_post_author ) :
			echo "\t\t\t\t\t";
			echo '<div class="p-blog-archive__item-thumbnail_meta p-article__meta">';
			if ( $dp_options['show_date_archive'] ) :
				echo '<time class="p-article__date" datetime="' . get_the_time( 'c' ) . '">' . zoomy_get_human_time_diff() . '</time>';
			endif;
			if ( $edit_url ) :
				echo '<span class="p-article__edit-button u-hidden-sm" data-url="' . esc_attr( $edit_url ) . '">' . __( 'Edit', 'tcd-w' ) . '</span>';
			endif;
			if ( $delete_url ) :
				echo '<span class="p-article__delete-button u-hidden-sm" data-url="' . esc_attr( $delete_url ) . '">' . __( 'Delete', 'tcd-w' ) . '</span>';
			endif;
			echo '</div>' . "\n";
		endif;

		if ( $catlist_float ) :
			echo "\t\t\t\t\t";
			echo '<div class="p-float-category">' . implode( '', $catlist_float ) . '</div>' . "\n";
		endif;
?>
				</div>
			</div>
			<h3 class="p-blog-archive__item-title p-article-<?php echo esc_attr( $post->post_type ); ?>__title p-article__title js-multiline-ellipsis"><?php
				// admin-ajax経由だと「Private: 」が付かないので注意
				if ( is_admin() && 'private' === $post->post_status ) :
					echo __( 'Private', 'tcd-w' ) . ': ';
				elseif ( 'pending' === $post->post_status ) :
					echo esc_html( $dp_options['membership']['pending_label'] ) . ': ';
				elseif ( 'draft' === $post->post_status ) :
					echo __( 'Draft', 'tcd-w' ) . ': ';
				endif;
				echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' );
			?></h3>
		</a>
<?php
		if ( $edit_url || $delete_url ) :
			echo "\t\t\t\t\t";
			echo '<div class="p-article__edit-buttons u-visible-sm">' . "\n";
			if ( $edit_url ) :
				echo '<a class="p-article__edit-button" href="' . esc_attr( $edit_url ) . '">' . __( 'Edit', 'tcd-w' ) . '</a>';
			endif;
			if ( $delete_url ) :
				echo '<a class="p-article__delete-button" href="' . esc_attr( $delete_url ) . '">' . __( 'Delete', 'tcd-w' ) . '</a>';
			endif;
			echo '</div>' . "\n";
		endif;

		if ( $show_counts ) :
?>
		<ul class="p-blog-archive__item-counts">
<?php
			if ( $dp_options['show_comments_number_archive' . $_post_type] && get_comments_number() ) :
?>
			<li class="p-has-icon p-icon-comment"><?php echo get_comments_number(); ?></li>
<?php
			endif;
			if ( $dp_options['show_views_number_archive' . $_post_type] ) :
?>
			<li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li>
<?php
			endif;
			if ( $use_like && $dp_options['show_likes_number_archive' . $_post_type] ) :
?>
			<li class="p-has-icon p-icon-like<?php if ( is_liked() ) echo 'd'; ?> js-toggle-like" data-post-id="<?php echo get_the_ID(); ?>"><?php echo get_likes_number(); ?></li>
<?php
			endif;
?>
		</ul>
<?php
		endif;
?>
	</article>
<?php
	endwhile;

	if ( 1 === $paged ) :
?>
</div>
<?php
	endif;
elseif ( 1 === $paged ) :
?>
<p class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
<?php
endif;
