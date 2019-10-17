<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post, $post;

get_header();
?>
<main class="l-main has-bg--pc">
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( $tcd_membership_vars['memberpage_type'] ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-delete-article">
			<form id="js-membership-delete-article" class="p-membership-form js-delete-confirm" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( $tcd_membership_vars['memberpage_type'] ) ); ?>" method="post">
<?php
if ( $tcd_membership_post ) :
	$post = $tcd_membership_post;
	setup_postdata( $post );

	if ( $post->post_type == $dp_options['photo_slug'] ) :
		$use_like = $dp_options['membership']['use_like_photo'];
		$_post_type = '_photo';
		$post_type_label = $dp_options['photo_label'] ? $dp_options['photo_label'] : __( 'Photo', 'tcd-w');
	else :
		$use_like = $dp_options['membership']['use_like_blog'];
		$_post_type = '';
		$post_type_label = $dp_options['blog_label'] ? $dp_options['blog_label'] : __( 'Blog', 'tcd-w');
	endif;
?>
				<div class="p-membership-form__body p-body">
					<h2 class="p-member-page-headline--color"><?php printf( __( 'Would you like to delete this %s?', 'tcd-w' ), $post_type_label ); ?></h2>
					<p><?php printf( __( 'Deleted %s can not be restored.', 'tcd-w' ), $post_type_label ); ?></p>
				</div>
<?php
	if ( ( $dp_options['show_comments_number_archive' . $_post_type] && get_comments_number() ) || $dp_options['show_views_number_archive' . $_post_type] || ( $use_like && $dp_options['show_likes_number_archive' . $_post_type] ) ) :
		$show_counts = true;
	else :
		$show_counts = false;
	endif;

	$author = get_user_by( 'id', $post->post_author );

	$catlist = array();
	$catlist_float = array();
	if ( $dp_options['show_category_archive'] ) :
		if ( $post->post_type == $dp_options['photo_slug'] ) :
			$categories = get_the_terms( $post->ID, $dp_options['photo_category_slug'] );
		else :
			$categories = get_the_category();
		endif;
		if ( $categories && ! is_wp_error( $categories ) ) :
			foreach( $categories as $category ) :
				$catlist[] = '<span' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' class="', '"' ) . ' data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
				$catlist_float[] = '<span class="p-category-item' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
				break;
			endforeach;
		endif;
	endif;
?>
				<div class="p-blog-archive">
					<article class="p-blog-archive__item<?php if ( $show_counts ) echo ' has-counts'; ?>">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>" target="_blank">
							<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
								<div class="p-blog-archive__item-thumbnail__inner">
<?php
	echo "\t\t\t\t\t\t\t\t";
	if ( has_main_image() ) :
		the_main_image( 'size2' );
	elseif ( has_post_thumbnail() ) :
		the_post_thumbnail( 'size2' );
	else :
		echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
	endif;
	echo "\n";

	if ( $dp_options['show_date_archive'] ) :
		echo "\t\t\t\t\t\t\t\t";
		echo '<div class="p-blog-archive__item-thumbnail_meta p-article__meta">';

		if ( $dp_options['show_date_archive'] ) :
			echo '<time class="p-article__date" datetime="' . get_the_time( 'c' ) . '">' . zoomy_get_human_time_diff() . '</time>';
		endif;

		echo '</div>' . "\n";
	endif;

	if ( $catlist_float ) :
		echo "\t\t\t\t\t\t\t\t";
		echo '<div class="p-float-category">' . implode( '', $catlist_float ) . '</div>' . "\n";
	endif;
?>
								</div>
							</div>
							<h2 class="p-blog-archive__item-title p-article-<?php echo esc_attr( $post->post_type ); ?>__title p-article__title js-multiline-ellipsis"><?php
								if ( 'pending' === $post->post_status ) :
									echo esc_html( $dp_options['membership']['pending_label'] ) . ': ';
								elseif ( 'draft' === $post->post_status ) :
									echo __( 'Draft', 'tcd-w' ) . ': ';
								endif;
								echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' );
							?></h2>
							<div class="p-blog-archive__item-author p-article__author<?php the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" data-url="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
								<span class="p-blog-archive__item-author_thumbnail p-article__author-thumbnail"><?php echo get_avatar( $author->ID, 96 ); ?></span>
								<span class="p-blog-archive__item-author_name p-article__author-name"><?php echo esc_html( $author->display_name ); ?></span>
							</div>
						</a>
<?php
	if ( $show_counts ) :
?>
						<ul class="p-blog-archive__item-counts">
<?php
		if ( $dp_options['show_comments_number_archive'] && get_comments_number() ) :
?>
							<li class="p-has-icon p-icon-comment"><?php echo get_comments_number(); ?></li>
<?php
		endif;
		if ( $dp_options['show_views_number_archive'] ) :
?>
							<li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li>
<?php
		endif;
		if ( $use_like && $dp_options['show_likes_number_archive'] ) :
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
				</div>
<?php
	wp_reset_postdata();
endif;
?>
				<div class="p-membership-form__button">
					<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Delete', 'tcd-w' ); ?></button>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $_REQUEST['post_id'] ); ?>">
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-' . $tcd_membership_vars['memberpage_type'] . '-' . $_REQUEST['post_id'] ) ); ?>">
<?php
	if ( ! empty( $_REQUEST['redirect_to'] ) ) :
?>
					<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $_REQUEST['redirect_to'] ); ?>">
<?php
	endif;
?>
				</div>
			</form>
		</div>
	</div>
</main>
<?php
get_footer();
