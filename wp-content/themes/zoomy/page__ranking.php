<?php

/**
 * Template Name: Ranking
 */

global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main has-bg--pc">
<?php
get_template_part( 'template-parts/page-header' );
if ( 'show' === $post->display_breadcrumb ) :
	get_template_part( 'template-parts/breadcrumb' );
endif;

if ( have_posts() ) :
	the_post();

	if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
		<div class="l-primary">
<?php
	else :
?>
	<div class="l-inner">
<?php
	endif;

	if ( has_post_thumbnail() || get_the_content() || post_password_required() ) :
?>
			<article class="p-entry p-entry-page">
				<div class="p-entry-page__inner">
<?php
		if ( has_post_thumbnail() ) :
			echo "\t\t\t\t\t<div class=\"p-entry__thumbnail\">";
			the_post_thumbnail();
			echo "</div>\n";
		endif;
?>
					<div class="p-entry__body p-entry-page__body p-body">
<?php
		the_content();

		if ( ! post_password_required() ) :
			wp_link_pages( array(
				'before' => '<div class="p-page-links">',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>'
			) );
		endif;
?>
					</div>
				</div>
			</article>
<?php
	endif;

	if ( ! post_password_required() ) :
		$_post = $post;

		$rank_type = 'likes' === $_post->rank_type ? 'likes' : 'views';
		$rank_post_num = is_numeric( $_post->rank_post_num ) ? absint( $_post->rank_post_num ) : 10;

		$rank_post_type = array();
		foreach ( (array) get_post_meta( $_post->ID, 'rank_post_type', true ) as $value ) :
			if ( 'post' === $value ) :
				$rank_post_type[] = 'post';
			elseif ( 'photo' === $value ) :
				$rank_post_type[] = $dp_options['photo_slug'];
			endif;
		endforeach;
		if ( ! $rank_post_type ) :
			$rank_post_type[] = 'post';
		endif;

		$ranking_terms = array(
			'daily' => __( 'Daily', 'tcd-w'),
			'weekly' => __( 'Weekly', 'tcd-w'),
			'monthly' => __( 'Monthly', 'tcd-w')
		);

		// tab for mobile
		$tab_radios = '';
		foreach( $ranking_terms as $ranking_term => $ranking_label ) :
			$tab_radios .= "\t\t\t" . '<input id="p-ranking-tab__radio--' . esc_attr( $ranking_term ) . '" class="p-ranking-tab__radio p-ranking-tab__radio--' . esc_attr( $ranking_term ) . '" name="rankingtab" type="radio"' . ( ! $tab_radios ? ' checked="checked"' : '' ) . '>' . "\n";
		endforeach;
		echo $tab_radios
?>
			<ul class="p-ranking-tabs">
<?php
		foreach( $ranking_terms as $ranking_term => $ranking_label ) :
?>
				<li class="p-ranking-tab p-ranking-tab--<?php echo esc_attr( $ranking_term ); ?>"><label for="p-ranking-tab__radio--<?php echo esc_attr( $ranking_term ); ?>"><?php echo esc_html( $ranking_label ); ?></label></li>

<?php
		endforeach;
?>
			</ul>
			<div class="p-ranking-archives">
<?php

		foreach( $ranking_terms as $ranking_term => $ranking_label ) :
			$rank = 0;

			// いいね数ランキング
			if ( 'likes' === $rank_type ) :
				$query_args = array(
					'post_type' => $rank_post_type,
					'posts_per_page' => $rank_post_num,
					'ignore_sticky_posts' => 1
				);
				$the_query = get_posts_likes_ranking( $ranking_term, $query_args, 'WP_Query' );

			// アクセス数ランキング
			else :
				$query_args = array(
					'post_type' => $rank_post_type,
					'posts_per_page' => $rank_post_num,
					'ignore_sticky_posts' => 1
				);
				$the_query = get_posts_views_ranking( $ranking_term, $query_args, 'WP_Query' );
			endif;
?>
				<div class="p-ranking-archive p-ranking-archive--<?php echo esc_attr( $ranking_term ); ?>">
					<div class="p-ranking-archive__label"><?php echo esc_html( $ranking_label ); ?></div>
<?php
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$rank++;

					$author = get_user_by( 'id', $post->post_author );
?>
					<article class="p-ranking-archive__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>">
							<div class="p-ranking-archive__item-rank rank--<?php echo $rank; ?>">BEST <?php echo $rank; ?></div>
							<div class="p-ranking-archive__item-thumbnail p-hover-effect__image js-object-fit-cover">
								<div class="p-ranking-archive__item-thumbnail__inner">
<?php
					echo "\t\t\t\t\t\t\t\t";
					if ( has_main_image() ) :
						the_main_image( 'size1' );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
					endif;
					echo "\n";
?>
								</div>
							</div>
							<h3 class="p-ranking-archive__item-title p-article-<?php echo esc_attr( $post->post_type ); ?>__title p-article__title js-multiline-ellipsis"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' ); ?></h3>
							<div class="p-ranking-archive__item-author p-article__author<?php the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" data-url="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
								<span class="p-ranking-archive__item-author_thumbnail p-article__author-thumbnail"><?php echo get_avatar( $author->ID, 96 ); ?></span>
								<span class="p-ranking-archive__item-author_name p-article__author-name"><?php echo esc_html( $author->display_name ); ?></span>
							</div>
						</a>
					</article>
<?php
				endwhile;
			else :
?>
					<div class="p-ranking-archive__item p-ranking-archive__item-empty"><?php _e( 'No ranking', 'tcd-w' ); ?></div>
<?php
			endif;
?>
				</div>
<?php
		endforeach;
		wp_reset_postdata();
?>
			</div>
			<style scoped>
				.p-ranking-archive__label, .p-ranking-tab label:hover, .p-ranking-tab__radio--daily:checked ~.p-ranking-tabs .p-ranking-tab--daily label, .p-ranking-tab__radio--weekly:checked ~ .p-ranking-tabs .p-ranking-tab--weekly label, .p-ranking-tab__radio--monthly:checked ~ .p-ranking-tabs .p-ranking-tab--monthly label { background-color: <?php echo esc_html( $_post->rank_term_bg_color ); ?>; color: <?php echo esc_html( $_post->rank_term_font_color ); ?>; }
				.p-ranking-archive__item-rank { background-color: <?php echo esc_html( $_post->rank_bg_color0 ); ?>; color: <?php echo esc_html( $_post->rank_font_color0 ); ?>; }
				.p-ranking-archive__item-rank.rank--1 { background-color: <?php echo esc_html( $_post->rank_bg_color1 ); ?>; color: <?php echo esc_html( $_post->rank_font_color1 ); ?>; }
				.p-ranking-archive__item-rank.rank--2 { background-color: <?php echo esc_html( $_post->rank_bg_color2 ); ?>; color: <?php echo esc_html( $_post->rank_font_color2 ); ?>; }
				.p-ranking-archive__item-rank.rank--3 { background-color: <?php echo esc_html( $_post->rank_bg_color3 ); ?>; color: <?php echo esc_html( $_post->rank_font_color3 ); ?>; }
			</style>
<?php
	endif;

	if ( $active_sidebar ) :
?>
		</div>
<?php
		get_sidebar();
?>
	</div>
<?php
	else :
?>
		</div>
<?php
	endif;
endif;
?>
</main>
<?php
get_footer();
