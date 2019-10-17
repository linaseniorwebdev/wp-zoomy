<?php
global $dp_options, $tcd_membership_post, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( is_singular( $dp_options['photo_slug'] ) ) :
	get_template_part( 'single-photo' );
	return;
endif;

get_header();
?>
<main class="l-main">
<?php
if ( have_posts() || is_tcd_membership_preview_blog() ) :
	the_post();

	// プレビュー時は$post差し替え
	if ( is_tcd_membership_preview_blog() ) :
		$is_tcd_membership_preview = true;
		$post = $tcd_membership_post;
		setup_postdata( $post );

		$author = get_user_by( 'id', $tcd_membership_post->post_author );

		// カテゴリー別途取得
		$category = get_term_by( 'id', $tcd_membership_post->category, 'category' );
	else :
		$is_tcd_membership_preview = false;
		$author = get_user_by( 'id', $post->post_author );
	endif;

	if ( $post->page_link && in_array( $post->page_link, array( 'type1', 'type2' ) ) ) :
		$page_link = $post->page_link;
	else :
		$page_link = $dp_options['page_link'];
	endif;
?>
	<div class="l-inner">
<?php
	// プレビュー時にはthe_title(),the_time(),the_category()が使えない
	if ( $is_tcd_membership_preview ) :
?>
		<h1 class="p-entry__title"><?php
			if ( 'draft' === $post->post_status ) :
				echo __( 'Draft', 'tcd-w' ) . ': ';
			elseif ( 'pending' === $post->post_status ) :
				echo esc_html( $dp_options['membership']['pending_label'] ) . ': ';
			elseif ( 'private' === $post->post_status ) :
				echo __( 'Private', 'tcd-w' ) . ': ';
			endif;
			echo esc_html( $post->post_title );
		?></h1>
<?php
		if ( $dp_options['show_date'] || $dp_options['show_category'] ) :
?>
		<ul class="p-entry__meta_top">
			<?php if ( $dp_options['show_date'] ) : ?><li><time class="p-entry__date p-article__date"><?php echo date( 'Y.m.d', strtotime( $post->post_date ) ); ?></time></li><?php endif; ?>
			<?php if ( $dp_options['show_category'] && $category && ! is_wp_error( $category ) ) : ?><li><a href="<?php echo esc_attr( get_term_link( $category ) ); ?>"><?php echo $category->name; ?></a></li><?php endif; ?>
		</ul>
<?php
		endif;
	else :
?>
		<h1 class="p-entry__title"><?php
			if ( 'draft' === $post->post_status ) :
				echo __( 'Draft', 'tcd-w' ) . ': ';
			elseif ( 'pending' === $post->post_status ) :
				echo esc_html( $dp_options['membership']['pending_label'] ) . ': ';
			elseif ( 'private' === $post->post_status ) :
				echo __( 'Private', 'tcd-w' ) . ': ';
			endif;
			the_title();
		?></h1>
<?php
		if ( $dp_options['show_date'] || $dp_options['show_category'] ) :
?>
		<ul class="p-entry__meta_top">
			<?php if ( $dp_options['show_date'] ) : ?><li><time class="p-entry__date p-article__date" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></li><?php endif; ?>
			<?php if ( $dp_options['show_category'] ) : ?><li><?php the_category( ', ' ); ?></li><?php endif; ?>
		</ul>
<?php
		endif;
	endif;

	if ( $dp_options['show_comment'] || $dp_options['show_views_number'] || ( $dp_options['membership']['use_like_blog'] && $dp_options['show_likes_number'] ) ) :
?>
		<ul class="p-entry__counts">
			<?php if ( $dp_options['show_comment'] ) : ?><li><a class="p-has-icon p-icon-comment" href="#comments"><?php echo get_comments_number(); ?></a></li><?php endif; ?>
			<?php if ( $dp_options['show_views_number'] ) : ?><li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li><?php endif; ?>
			<?php if ( $dp_options['membership']['use_like_blog'] && $dp_options['show_likes_number'] ) : ?><li><a class="p-has-icon p-icon-like<?php if ( is_liked() ) echo 'd'; ?> js-toggle-like" href="#" data-post-id="<?php echo get_the_ID(); ?>"><?php echo get_likes_number(); ?></a></li><?php endif; ?>
		</ul>
<?php
	endif;

	if ( $dp_options['show_breadcrumb_single'] ) :
		get_template_part( 'template-parts/breadcrumb' );
	endif;
?>
		<div class="l-2columns">
			<article class="p-entry l-primary">
<?php
	if ( ! $is_tcd_membership_preview && $dp_options['membership']['use_front_edit_blog'] && get_current_user_id() == $post->post_author ) :
		$edit_buttons = '<div class="p-entry__edit-buttons">';
		$edit_buttons .= '<a class="p-article__edit-button" href="' . esc_attr( get_tcd_membership_memberpage_url( 'edit_blog', $post->ID ) ) . '">' . __( 'Edit', 'tcd-w' ) . '</span>';
		$edit_buttons .= '<a class="p-article__delete-button" href="' . esc_attr( get_tcd_membership_memberpage_url( 'delete_blog', $post->ID ) ) . '">' . __( 'Delete', 'tcd-w' ) . '</a>';
		$edit_buttons .= '</div>';
	else:
		$edit_buttons = null;
	endif;

	if ( $dp_options['show_thumbnail'] ) :
		if ( $is_tcd_membership_preview && $tcd_membership_post->main_image ) :
			echo "\t\t\t\t";
			echo '<div class="p-entry__thumbnail">';
			echo '<img src="' . esc_attr( $tcd_membership_post->main_image ) . '" alt="">';
			echo $edit_buttons;
			echo '</div>';
			echo "\n";
		elseif ( has_main_image() ) :
			echo "\t\t\t\t";
			echo '<div class="p-entry__thumbnail">';
			the_main_image( 'full', get_the_title() );
			echo $edit_buttons;
			echo '</div>';
			echo "\n";
		elseif ( has_post_thumbnail() ) :
			echo "\t\t\t\t";
			echo '<div class="p-entry__thumbnail">';
			the_post_thumbnail();
			echo $edit_buttons;
			echo '</div>';
			echo "\n";
		elseif ( $edit_buttons ) :
			echo "\t\t\t\t" . $edit_buttons ."\n";
		endif;
	elseif ( $edit_buttons ) :
		echo "\t\t\t\t" . $edit_buttons ."\n";
	endif;

	if ( $dp_options['show_sns_top'] ) :
		get_template_part( 'template-parts/sns-btn-top' );
	endif;
?>
				<div class="p-entry__body p-body">
<?php
	// URL自動リンクフィルター追加
	add_filter( 'the_content', 'zoomy_url_auto_link', 20 );

	// プレビュー時にはthe_content()が使えない
	if ( $is_tcd_membership_preview ) :
		echo apply_filters( 'the_content', $post->post_content );
	else :
		the_content();
	endif;

	// URL自動リンクフィルター削除
	remove_filter( 'the_content', 'zoomy_url_auto_link', 20 );

	if ( ! post_password_required() ) :
		if ( 'type2' === $page_link ):
			if ( $page < $numpages && preg_match( '/href="(.*?)"/', _wp_link_page( $page + 1 ), $matches ) ) :
?>
					<div class="p-entry__next-page">
						<a class="p-entry__next-page__link p-button" href="<?php echo esc_url( $matches[1] ); ?>"><?php _e( 'Read more', 'tcd-w' ); ?></a>
						<div class="p-entry__next-page__numbers"><?php echo $page . ' / ' . $numpages; ?></div>
					</div>
<?php
			endif;
		else:
			wp_link_pages( array(
				'before' => '<div class="p-page-links">',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>'
			) );
		endif;
	endif;
?>
				</div>
<?php
	$sns_html = '';
	if ( $dp_options['show_author_sns'] ) :
		if ( $dp_options['membership']['show_profile_website'] && $author->user_url ) :
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--url"><a href="' . esc_attr( $author->user_url ) . '" target="_blank"></a></li>';
		endif;
		if ( $dp_options['membership']['show_profile_facebook'] && $author->facebook_url ) :
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--facebook"><a href="' . esc_attr( $author->facebook_url ) . '" target="_blank"></a></li>';
		endif;
		if ( $dp_options['membership']['show_profile_twitter'] && $author->twitter_url ) :
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--twitter"><a href="' . esc_attr( $author->twitter_url ) . '" target="_blank"></a></li>';
		endif;
		if ( $dp_options['membership']['show_profile_instagram'] && $author->instagram_url ) :
			$sns_html .= '<li class="p-social-nav__item p-social-nav__item--instagram"><a href="' . esc_attr( $author->instagram_url ) . '" target="_blank"></a></li>';
		endif;
	endif;

	if ( $sns_html && $dp_options['show_report'] ) :
?>
				<div class="p-entry__sns_button-report u-clearfix">
					<div class="p-entry__report"><a class="p-entry__report-button js-report-button" href="#"><?php echo esc_html( $dp_options['membership']['report_label'] ? $dp_options['membership']['report_label'] : __( 'Report to administrator', 'tcd-w' ) ); ?></a></div>
					<ul class="p-social-nav p-social-nav--author"><?php echo $sns_html; ?></ul>
				</div>
<?php
	elseif ( $sns_html ) :
?>
				<ul class="p-social-nav p-social-nav--author"><?php echo $sns_html; ?></ul>
<?php
	elseif ( $dp_options['show_report'] ) :
?>
					<div class="p-entry__report"><a class="p-entry__report-button js-report-button" href="#"><?php echo esc_html( $dp_options['membership']['report_label'] ? $dp_options['membership']['report_label'] : __( 'Report to administrator', 'tcd-w' ) ); ?></a></div>
<?php
	endif;

	if ( $dp_options['show_tag'] && get_the_tags() ) :
?>
				<ul class="p-entry__meta c-meta-box u-clearfix">
					<li class="c-meta-box__item c-meta-box__item--tag"><?php echo get_the_tag_list( '', ', ', '' ); ?></li>
				</ul>
<?php
	endif;

	if ( $dp_options['show_sns_btm'] ) :
		get_template_part( 'template-parts/sns-btn-btm' );
	endif;

	$previous_post = get_previous_post();
	$next_post = get_next_post();
	if ( $dp_options['show_next_post'] && ( $previous_post || $next_post ) ) :
?>
				<ul class="p-entry__nav c-entry-nav">
<?php
		if ( $previous_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--prev"><a href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>" data-prev="<?php _e( 'Previous post', 'tcd-w' ); ?>"><span class="u-hidden-sm js-multiline-ellipsis"><?php echo esc_html( mb_strimwidth( strip_tags( $previous_post->post_title ), 0, 100, '...' ) ); ?></span></a></li>
<?php
		else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
		endif;
		if ( $next_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--next"><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" data-next="<?php _e( 'Next post', 'tcd-w' ); ?>"><span class="u-hidden-sm js-multiline-ellipsis"><?php echo esc_html( mb_strimwidth( strip_tags( $next_post->post_title ), 0, 100, '...' ) ); ?></span></a></li>
<?php
		else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
		endif;
?>
				</ul>
<?php
	endif;

	get_template_part( 'template-parts/advertisement' );

	if ( $dp_options['show_related_post'] ) :
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__not_in' => array( $post->ID ),
			'posts_per_page' => $dp_options['related_post_num'],
			'orderby' => 'rand'
		);
		$categories = get_the_category();
		if ( $categories ) :
			$category_ids = array();
			foreach ( $categories as $category ) :
				if ( !empty( $category->term_id ) ) :
					$category_ids[] = $category->term_id;
				endif;
			endforeach;
			if ( $category_ids ) :
				$args['tax_query'][] = array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $category_ids,
					'operator' => 'IN'
				);
			endif;
		endif;
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
?>
				<section class="p-entry__related">
<?php
				if ( $dp_options['related_post_headline'] ) :
?>
					<h2 class="p-headline"><?php echo esc_html( $dp_options['related_post_headline'] ); ?></h2>
<?php
			endif;
?>
					<div class="p-entry__related-items">
<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
?>
						<article class="p-entry__related-item">
							<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
								<div class="p-entry__related-item__thumbnail p-hover-effect__image js-object-fit-cover">
<?php
				echo "\t\t\t\t\t\t\t\t\t";
				if ( has_main_image() ) :
					the_main_image( 'size2' );
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'size2' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
				endif;
				echo "\n";
?>
								</div>
								<h3 class="p-entry__related-item__title js-multiline-ellipsis"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' ); ?></h3>
							</a>
						</article>
<?php
			endwhile;

			wp_reset_postdata();
?>
					</div>
				</section>
<?php
		endif;
	endif;

	// プレビューの場合はフォーム出力
	if ( $is_tcd_membership_preview ) :
		the_tcd_membership_preview_form();

	elseif ( $dp_options['show_comment'] ) :
		if ( 'type2' === $dp_options['comment_type'] ) :
			comments_template( '/comments-type2.php', true );
		else :
			comments_template( '', true );
		endif;
	endif;
?>
			</article>
<?php
	if ( $is_tcd_membership_preview ) :
		wp_reset_postdata();
	endif;
endif;

get_sidebar();
?>
		</div>
	</div>
</main>
<?php
get_footer();
