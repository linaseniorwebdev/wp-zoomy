<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( is_post_type_archive( $dp_options['information_slug'] ) ) :
	get_template_part( 'archive-information' );
	return;
endif;

get_header();
?>
<main class="l-main has-bg--pc">
<?php
get_template_part( 'template-parts/page-header' );
if ( is_post_type_archive( $dp_options['photo_slug'] ) || is_tax( $dp_options['photo_category_slug'] ) ) :
	if ( $dp_options['show_breadcrumb_archive_photo'] ) :
		get_template_part( 'template-parts/breadcrumb' );
	endif;
elseif ( $dp_options['show_breadcrumb_archive'] ) :
	get_template_part( 'template-parts/breadcrumb' );
endif;
?>
	<div class="l-inner">
<?php
if ( have_posts() ) :
	if ( isset( $_GET['sort'] ) && in_array( $_GET['sort'], array( 'likes', 'views' ) ) ) :
		$sort = $_GET['sort'];
	else :
		$sort = null;
	endif;
	$baseurl = remove_query_arg( 'sort', get_pagenum_link( 1, false ) );

	if ( is_post_type_archive( $dp_options['photo_slug'] ) || is_tax( $dp_options['photo_category_slug'] ) ) :
		$use_like = $dp_options['membership']['use_like_photo'];
		$_post_type = '_photo';
	else :
		$use_like = $dp_options['membership']['use_like_blog'];
		$_post_type = '';
	endif;
?>
		<div class="p-blog-archive__sort">
			<a class="p-blog-archive__sort-item<?php if ( ! $sort ) echo ' is-active'; ?>" href="<?php echo esc_attr( $baseurl ); ?>"><span><?php _e( 'Newest', 'tcd-w' ); ?></span></a>
<?php
	if ( $use_like ) :
?>
			<a class="p-blog-archive__sort-item<?php if ( 'likes' === $sort ) echo ' is-active'; ?>" href="<?php echo esc_attr( add_query_arg( 'sort', 'likes', $baseurl ) ); ?>"><span><?php _e( 'Sort by likes', 'tcd-w' ); ?></span></a>
<?php
	endif;
?>
			<a class="p-blog-archive__sort-item<?php if ( 'views' === $sort ) echo ' is-active'; ?>" href="<?php echo esc_attr( add_query_arg( 'sort', 'views', $baseurl ) ); ?>"><span><?php _e( 'Sort by views', 'tcd-w' ); ?></span></a>
		</div>
		<div class="p-blog-archive">
<?php
	if ( ( $dp_options['show_comments_number_archive' . $_post_type] && get_comments_number() ) || $dp_options['show_views_number_archive' . $_post_type] || ( $use_like && $dp_options['show_likes_number_archive' . $_post_type] ) ) :
		$show_counts = true;
	else :
		$show_counts = false;
	endif;

	while ( have_posts() ) :
		the_post();

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
			<article class="p-blog-archive__item<?php if ( $show_counts ) echo ' has-counts'; ?>">
				<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>">
					<div class="p-blog-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
						<div class="p-blog-archive__item-thumbnail__inner">
<?php
		echo "\t\t\t\t\t\t";
		if ( has_main_image() ) :
			the_main_image( 'size2' );
		elseif ( has_post_thumbnail() ) :
			the_post_thumbnail( 'size2' );
		else :
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
		endif;
		echo "\n";

		if ( $dp_options['show_date_archive' . $_post_type] || $catlist ) :
			echo "\t\t\t\t\t\t";
			echo '<div class="p-blog-archive__item-thumbnail_meta p-article__meta' . ( ! $catlist ? ' u-hidden-sm' : '' ) . '">';

			if ( $dp_options['show_date_archive'] ) :
				echo '<time class="p-article__date" datetime="' . get_the_time( 'c' ) . '">' . zoomy_get_human_time_diff() . '</time>';
			endif;

			if ( $catlist ) :
				echo '<span class="p-article__category u-hidden-sm">' . implode( '', $catlist ) . '</span>';
			endif;

			echo '</div>' . "\n";
		endif;

		if ( $catlist_float ) :
			echo "\t\t\t\t\t\t";
			echo '<div class="p-float-category u-visible-sm">' . implode( '', $catlist_float ) . '</div>' . "\n";
		endif;
?>
						</div>
					</div>
					<h2 class="p-blog-archive__item-title p-article-<?php echo esc_attr( $post->post_type ); ?>__title p-article__title js-multiline-ellipsis"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' ); ?></h2>
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
<?php
	endwhile;
?>
		</div>
<?php
	$paginate_links = paginate_links( array(
		'current' => max( 1, get_query_var( 'paged' ) ),
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager">
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
else :
?>
			<p class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></p>
<?php
endif;
?>
	</div>
</main>
<?php
get_footer();
