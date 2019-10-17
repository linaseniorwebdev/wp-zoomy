<?php
global $dp_options, $active_sidebar, $post, $tcd_membership_post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
if ( ! $active_sidebar ) $active_sidebar = get_active_sidebar();

if ( $active_sidebar || is_single() || is_tcd_membership_preview_blog() ) :
?>
		<aside class="p-sidebar l-secondary">
<?php
	if ( is_single() || is_tcd_membership_preview_blog() ) :
		// プレビューの場合は$tcd_membership_postから
		if ( is_tcd_membership_preview_blog() ) :
			$author = get_user_by( 'id', $tcd_membership_post->post_author );
		else :
			$author = get_user_by( 'id', $post->post_author );
		endif;
?>
			<div class="p-entry__author">
				<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
					<div class="p-author__thumbnail js-object-fit-cover">
						<div class="p-hover-effect__image"><?php echo get_avatar( $author->ID, 300 ); ?></div>
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
<?php
		// 投稿者の写真一覧
		$the_query = new WP_Query( array(
			'author' => $author->ID,
			'post_type' => $dp_options['photo_slug'],
			'posts_per_page' => 6,
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand'
		) );

		if ( $the_query->have_posts() ) :
?>
			<div class="p-widget p-widget-sidebar author_photo_list_widget">
				<h2 class="p-widget__title"><?php printf( __( "%s's photo", 'tcd-w' ), $author->display_name ); ?></h2>
				<ul class="p-widget-photo-list u-clearfix">
<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				if ( ! has_main_image() && ! has_post_thumbnail() ) continue;
?>
					<li class="p-widget-photo-list__item"><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'photo', 'single', ' ' );?>" href="<?php the_permalink(); ?>"><span class="p-hover-effect__image js-object-fit-cover"><?php
				if ( has_main_image() ) :
					the_main_image( 'size1' );
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'size1' );
				endif;
					?></span></a></li>
<?php
			endwhile;
			wp_reset_postdata();
?>
				</ul>
			</div>
<?php
		endif;
	endif;

	if ( $active_sidebar ) :
		dynamic_sidebar( $active_sidebar );
	endif;
?>
		</aside>
<?php
endif;
