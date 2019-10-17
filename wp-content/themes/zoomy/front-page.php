<?php
$dp_options = get_design_plus_option();

get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/index-slider' );

// コンテンツビルダー
if ( ! empty( $dp_options['contents_builder'] ) ) :
	// 重複記事除外用配列
	$cb_queries = array( 'has_duplicature_flag' => false );

	// 重複表示なしのチェックありがあるかチェック
	foreach ( $dp_options['contents_builder'] as $key => $cb_content ) :
		if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

		// ブログ・写真で重複表示なしチェックあり
		if ( in_array( $cb_content['cb_content_select'], array( 'blog', 'photo' ) ) && ! empty( $cb_content['cb_hide_posts_duplicature_other_content'] ) ) :
			$cb_queries['has_duplicature_flag'] = true;
			break;
		endif;
	endforeach;

	// 重複記事除外対策で先にブログ・写真の記事取得
	foreach ( $dp_options['contents_builder'] as $key => $cb_content ) :
		if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

		// ブログ・写真
		if ( in_array( $cb_content['cb_content_select'], array( 'blog', 'photo' ) ) ) :
			if ( 'photo' == $cb_content['cb_content_select'] ) :
				$cb_queries[$key]['post_type'] = $dp_options['photo_slug'];
				$cb_queries[$key]['taxonomy'] = $dp_options['photo_category_slug'];
			else :
				$cb_queries[$key]['post_type'] = 'post';
				$cb_queries[$key]['taxonomy'] = 'category';
			endif;
			$cb_queries[$key]['cb_category'] = null;
			$cb_queries[$key]['cb_hide_posts_duplicature_other_content'] = ! empty( $cb_content['cb_hide_posts_duplicature_other_content'] );

			$args = array(
				'post_type' => $cb_queries[$key]['post_type'],
				'posts_per_page' => $cb_content['cb_post_num'],
				'ignore_sticky_posts' => true
			);

			if ( 'recommend_post' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'recommend_post';
				$args['meta_value'] = 'on';
			elseif ( 'recommend_post2' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'recommend_post2';
				$args['meta_value'] = 'on';
			elseif ( 'pickup_post' == $cb_content['cb_list_type'] ) :
				$args['meta_key'] = 'pickup_post';
				$args['meta_value'] = 'on';
			elseif ( 'category' == $cb_content['cb_list_type'] && $cb_content['cb_category'] ) :
				$cb_queries[$key]['cb_category'] = get_term_by( 'id', $cb_content['cb_category'], $cb_queries[$key]['taxonomy'] );
			endif;
			if ( ! empty( $cb_queries[$key]['cb_category'] ) && ! is_wp_error( $cb_queries[$key]['cb_category'] ) ) :
				if ( 'category' === $cb_queries[$key]['taxonomy'] ) :
					$args['cat'] = $cb_queries[$key]['cb_category']->term_id;
				else :
					$args['tax_query'] = array(
						array(
							'taxonomy' => $cb_queries[$key]['taxonomy'],
							'field' => 'term_id',
							'terms' => $cb_queries[$key]['cb_category']->term_id
						)
					);
				endif;
			else :
				$cb_queries[$key]['cb_category'] = null;
			endif;

			if ( $cb_content['cb_show_within_hours'] && 0 < $cb_content['cb_within_hours'] ) :
				$ts = current_time( 'timestamp' ) - 3600 * $cb_content['cb_within_hours'];
				$args['date_query'] = array(
					array(
						'after' => array(
							'year'		=> date( 'Y', $ts ),
							'month'		=> (int) date( 'm', $ts ),
							'day'		=> (int) date( 'd', $ts ),
							'hour'		=> (int) date( 'H', $ts ),
							'minute'	=> (int) date( 'i', $ts ),
							'second'	=> (int) date( 's', $ts )
						),
						'inclusive' => true
					),
				);
			endif;

			if ( 'random' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'rand';
			elseif ( 'date2' == $cb_content['cb_order'] ) :
				$args['orderby'] = 'date';
				$args['order'] = 'ASC';
			else :
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
			endif;

			$cb_queries[$key]['args'] = $args;

			// 重複表示なしコンテンツあり
			if ( $cb_queries['has_duplicature_flag'] ) :
				// 現コンテンツが重複表示なしのチェックなしの場合クエリー実行
				if ( empty( $cb_content['cb_hide_posts_duplicature_other_content'] ) ) :
					$cb_queries[$key]['WP_Query'] = new WP_Query( $args );

					// 重複表示なし用に記事ID取得
					if ( $cb_queries[$key]['WP_Query']->have_posts() ) :
						foreach ( $cb_queries[$key]['WP_Query']->posts as $_row ) :
							$cb_queries[$key]['post_ids'][] = $_row->ID;
						endforeach;
					endif;
				endif;

			// 重複表示なしコンテンツなしの場合はクエリー実行
			else :
				$cb_queries[$key]['WP_Query'] = new WP_Query( $args );
			endif;
		endif;
	endforeach;

	// 重複表示なしのチェックありのクエリー実行
	if ( $cb_queries['has_duplicature_flag'] ) :
		foreach ( $cb_queries as $key => $_row ) :
			if ( ! $cb_queries[$key]['cb_hide_posts_duplicature_other_content'] ) continue;
			// 除外する記事ID取得・セット
			$cb_queries[$key]['args']['post__not_in'] = array();
			foreach ( $cb_queries as $key2 => $_row2 ) :
				if ( $key2 === $key || $_row2['post_type'] !== $_row['post_type'] || empty( $_row2['post_ids'] ) ) continue;
				$cb_queries[$key]['args']['post__not_in'] = array_merge( $cb_queries[$key]['args']['post__not_in'], $_row2['post_ids'] );
			endforeach;

			// クエリー実行
			$cb_queries[$key]['WP_Query'] = new WP_Query( $cb_queries[$key]['args'] );

			// 別の重複表示なし用に記事ID取得
			if ( $cb_queries[$key]['WP_Query']->have_posts() ) :
				foreach ( $cb_queries[$key]['WP_Query']->posts as $_row2 ) :
					$cb_queries[$key]['post_ids'][] = $_row2->ID;
				endforeach;
			endif;
		endforeach;
		unset( $_row, $_row2, $key2 );
	endif;

	foreach ( $dp_options['contents_builder'] as $key => $cb_content ) :
		$cb_index = 'cb_' . ( $key + 1 );
		if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

		$cb_item_class = 'p-cb__item p-cb__item--' . esc_attr( $cb_content['cb_content_select'] );
		$cb_item_attr = null;

		if ( ! empty( $cb_content['cb_background_color'] ) && '#ffffff' != strtolower( $cb_content['cb_background_color'] ) ) :
			$cb_item_class .= ' has-bg';
			$cb_item_attr .= ' style="background-color: ' . esc_attr( $cb_content['cb_background_color'] ) . ';"';
		endif;

		$cb_item_start = "\t" . '<div id="' . $cb_index . '" class="' . esc_attr( $cb_item_class ) . '"' . $cb_item_attr . '>' . "\n";
		$cb_item_start .= "\t\t" . '<div class="p-cb__item-inner l-inner">' . "\n";

		if ( ! empty( $cb_content['cb_headline'] ) ) :
			$cb_item_start .= "\t\t\t" . '<h2 class="p-cb__item-headline">' . str_replace( array( "\r\n" , "\r" , "\n" ), '<br>', esc_html( $cb_content['cb_headline'] ) ) . '</h2>' . "\n";
		endif;

		if ( ! empty( $cb_content['cb_desc'] ) ) :
			$cb_item_start .= "\t\t\t" . '<div class="p-cb__item-desc">' . str_replace( array( "\r\n", "\r", "\n" ), '', wpautop( $cb_content['cb_desc'] ) ) . '</div>' . "\n";
		endif;

		$cb_item_end = "\t\t</div>\n";
		$cb_item_end .= "\t</div>\n";

		// ブログ・写真
		if ( in_array( $cb_content['cb_content_select'], array( 'blog', 'photo' ) ) ) :
			$cb_archive_url = null;

			if ( 'photo' == $cb_content['cb_content_select'] ) :
				$use_like = $dp_options['membership']['use_like_photo'];
			else :
				$use_like = $dp_options['membership']['use_like_blog'];
			endif;

			if ( $cb_content['cb_show_archive_link'] && $cb_content['cb_archive_link_text'] ) :
				if ( ! empty( $cb_queries[$key]['cb_category'] ) ) :
					$cb_archive_url = get_term_link( $cb_queries[$key]['cb_category'], $cb_queries[$key]['taxonomy'] );
				elseif ( 'all' == $cb_content['cb_list_type'] ) :
					$cb_archive_url = get_post_type_archive_link( $cb_queries[$key]['post_type'] );
				endif;
			endif;

			if ( ( $cb_content['cb_show_comments_number'] && get_comments_number() ) || $cb_content['cb_show_views_number'] || ( $use_like && $cb_content['cb_show_likes_number'] ) ) :
				$show_counts = true;
			else :
				$show_counts = false;
			endif;

			if ( ! empty( $cb_queries[$key]['WP_Query'] ) && $cb_queries[$key]['WP_Query']->have_posts() ) :
				echo $cb_item_start;
?>
			<div class="p-index-archive p-blog-archive">
<?php
				while ( $cb_queries[$key]['WP_Query']->have_posts() ) :
					$cb_queries[$key]['WP_Query']->the_post();

					$author = get_user_by( 'id', $post->post_author );

					$catlist_float = array();
					if ( $cb_content['cb_show_category'] ) :
						if ( 'photo' == $cb_content['cb_content_select'] ) :
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
				<article class="p-blog-archive__item<?php if ( $show_counts ) echo ' has-counts'; ?>">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>">
						<div class="p-blog-archive__item-thumbnail">
							<div class="p-blog-archive__item-thumbnail__inner p-hover-effect__image js-object-fit-cover">
<?php
					echo "\t\t\t\t\t\t\t";
					if ( has_main_image() ) :
						the_main_image( 'size2' );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size2' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
					endif;
					echo "\n";

					if ( $catlist_float ) :
						echo "\t\t\t\t\t\t\t";
						echo '<div class="p-float-category">' . implode( '', $catlist_float ) . '</div>' . "\n";
					endif;

					if ( $cb_content['cb_show_date'] ) :
						echo "\t\t\t\t\t\t\t";
						echo '<div class="p-blog-archive__item-thumbnail_meta p-article__meta">';
						echo '<time class="p-article__date" datetime="' . get_the_time( 'c' ) . '">' . zoomy_get_human_time_diff() . '</time>';
						echo '</div>' . "\n";
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
						if ( $cb_content['cb_show_comments_number'] && get_comments_number() ) :
?>
						<li class="p-has-icon p-icon-comment"><?php echo get_comments_number(); ?></li>
<?php
						endif;
						if ( $cb_content['cb_show_views_number'] ) :
?>
						<li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li>
<?php
						endif;
						if ( $use_like && $cb_content['cb_show_likes_number'] ) :
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
				if ( $cb_archive_url && $cb_content['cb_archive_link_text'] ) :
?>
			<div class="p-cb__item-button__wrapper">
				<a class="p-cb__item-button p-button<?php the_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ); ?>" href="<?php echo esc_url( $cb_archive_url ); ?>"<?php if ( $cb_content['cb_archive_link_target_blank'] ) echo ' target="_blank"'; ?>><?php echo esc_html( $cb_content['cb_archive_link_text'] ); ?></a>
			</div>
<?php
				endif;

				echo $cb_item_end;
			endif;

		// 広告
		elseif ( 'ad' == $cb_content['cb_content_select'] ) :
			$cb_ad_image1 = null;
			$cb_ad_image2 = null;

			if ( $cb_content['cb_ad_image1'] ) :
				$cb_ad_image1 = wp_get_attachment_image_src( $cb_content['cb_ad_image1'], 'full' );
			endif;
			if ( $cb_content['cb_ad_image2'] ) :
				$cb_ad_image2 = wp_get_attachment_image_src( $cb_content['cb_ad_image2'], 'full' );
			endif;

			if ( $cb_content['cb_ad_code1'] || $cb_ad_image1 || $cb_content['cb_ad_code2'] || $cb_ad_image2 ) :
				if ( ( $cb_content['cb_ad_code1'] || $cb_ad_image1 ) && ( $cb_content['cb_ad_code2'] || $cb_ad_image2 ) ) :
					$ad_class = 'p-index-ad p-index-ad--2ads';
				else :
					$ad_class = 'p-index-ad';
				endif;

				echo $cb_item_start;
				echo "\t\t\t" . '<div class="' . $ad_class . '">' . "\n";

				if ( $cb_content['cb_ad_code1'] ) :
					echo "\t\t\t\t";
					echo '<div class="p-index-ad__item p-index-ad__item-code">' . $cb_content['cb_ad_code1'] . '</div>';
				elseif ( $cb_ad_image1 ) :
					echo "\t\t\t\t";
					echo '<div class="p-index-ad__item p-index-ad__item-image"><a href="' . esc_url( $cb_content['cb_ad_url1'] ) . '" target="_blank"><img src="' . esc_attr( $cb_ad_image1[0] ) . '" alt=""></a></div>';
				endif;

				if ( $cb_content['cb_ad_code2'] ) :
					echo "\t\t\t\t";
					echo '<div class="p-index-ad__item p-index-ad__item-code">' . $cb_content['cb_ad_code2'] . '</div>';
				elseif ( $cb_ad_image2 ) :
					echo "\t\t\t\t";
					echo '<div class="p-index-ad__item p-index-ad__item-image"><a href="' . esc_url( $cb_content['cb_ad_url2'] ) . '" target="_blank"><img src="' . esc_attr( $cb_ad_image2[0] ) . '" alt=""></a></div>';
				endif;

				echo "\t\t\t" . '</div>' . "\n";
				echo $cb_item_end;
			endif;

		// フリースペース
		elseif ( 'wysiwyg' == $cb_content['cb_content_select'] ) :
			$cb_wysiwyg_editor = apply_filters( 'the_content', $cb_content['cb_wysiwyg_editor'] );
			if ( $cb_wysiwyg_editor ) :
				echo $cb_item_start;
?>
			<div class="p-body">
				<?php echo $cb_wysiwyg_editor; ?>
			</div>
<?php
				echo $cb_item_end;
			endif;

		endif;
	endforeach;

	wp_reset_postdata();
	unset( $cb_queries[$key]['args'] );
endif;
?>
</main>
<?php
get_footer();
