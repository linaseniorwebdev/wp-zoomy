<?php
global $dp_options, $tcd_membership_post, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

get_header();
?>
<main class="l-main">
<?php
if ( have_posts() || is_tcd_membership_preview_photo() ) :
	the_post();

	// プレビュー時は$post差し替え
	if ( is_tcd_membership_preview_photo() ) :
		$is_tcd_membership_preview = true;
		$post = $tcd_membership_post;
		setup_postdata( $post );

		$author = get_user_by( 'id', $tcd_membership_post->post_author );

		// カテゴリー別途取得
		$category = get_term_by( 'id', $tcd_membership_post->category, $dp_options['photo_category_slug'] );
	else :
		$is_tcd_membership_preview = false;
		$author = get_user_by( 'id', $post->post_author );
	endif;
?>
<article class="p-entry-photo l-inner">
<?php
	if ( $dp_options['show_breadcrumb_single_photo'] ) :
		get_template_part( 'template-parts/breadcrumb' );
	endif;

	if ( ! $is_tcd_membership_preview && $dp_options['membership']['use_front_edit_photo'] && get_current_user_id() == $post->post_author ) :
		$edit_buttons = '<div class="p-entry__edit-buttons">';
		$edit_buttons .= '<a class="p-article__edit-button" href="' . esc_attr( get_tcd_membership_memberpage_url( 'edit_photo', $post->ID ) ) . '">' . __( 'Edit', 'tcd-w' ) . '</span>';
		$edit_buttons .= '<a class="p-article__delete-button" href="' . esc_attr( get_tcd_membership_memberpage_url( 'delete_photo', $post->ID ) ) . '">' . __( 'Delete', 'tcd-w' ) . '</a>';
		$edit_buttons .= '</div>';
	else:
		$edit_buttons = null;
	endif;

	if ( $is_tcd_membership_preview && $tcd_membership_post->main_image ) :
		echo "\t\t";
		echo '<div class="p-entry-photo__thumbnail">';
		echo '<div class="p-entry-photo__thumbnail__inner">';
		echo '<img src="' . esc_attr( $tcd_membership_post->main_image ) . '" alt="">';
		echo $edit_buttons;
		echo '</div>';
		echo '</div>';
		echo "\n";
	elseif ( has_main_image() ) :
		echo "\t\t";
		echo '<div class="p-entry-photo__thumbnail">';
		echo '<div class="p-entry-photo__thumbnail__inner">';
		the_main_image( 'full', get_the_title() );
		echo $edit_buttons;
		echo '</div>';
		echo '</div>';
		echo "\n";
	else :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if ( $image ) :
			// 正方形
			if ( $image[1] == $image[2] ) :
				$size = 'size-photo3';
			// 縦長
			elseif ( $image[1] < $image[2] ) :
				$size = 'size-photo2';
			// 横長
			else :
				$size = 'size-photo1';
			endif;

			echo "\t\t";
			echo '<div class="p-entry-photo__thumbnail">';
			echo '<div class="p-entry-photo__thumbnail__inner">';
			the_post_thumbnail( $size );
			echo $edit_buttons;
			echo '</div>';
			echo '</div>';
			echo "\n";
		elseif ( $edit_buttons ) :
			echo "\t\t" . $edit_buttons . "\n";
		endif;
	endif;
?>
		<div class="p-entry-photo__inner">
<?php
	if ( $dp_options['show_category_photo'] ) :
		// プレビュー時にはget_the_terms()が使えない
		if ( $is_tcd_membership_preview ) :
			if ( $category && ! is_wp_error( $category ) ) :
				echo "\t\t";
				echo '<div class="p-entry-photo__category">';
				echo '<a class="p-category-item" href="' . esc_attr( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
				echo '</div>';
				echo "\n";
			endif;
		else :
			$categories = get_the_terms( $post->ID, $dp_options['photo_category_slug'] );
			if ( $categories && ! is_wp_error( $categories ) ) :
				echo "\t\t";
				echo '<div class="p-entry-photo__category">';
				foreach ( $categories as $key => $category ) :
					if ( 0 !== $key ) :
						echo ' ';
					endif;
					echo '<a class="p-category-item" href="' . esc_attr( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
				endforeach;
				echo '</div>';
				echo "\n";
			endif;
		endif;
	endif;

	// プレビュー時にはthe_title(),the_time()が使えない
	if ( $is_tcd_membership_preview ) :
?>
			<h1 class="p-entry-photo__title"><?php
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
		if ( $dp_options['show_date_photo'] ) :
?>
			<time class="p-entry-photo__date p-article__date"><?php echo date( 'Y.m.d', strtotime( $post->post_date ) ); ?></time>
<?php
		endif;
	else :
?>
			<h1 class="p-entry-photo__title"><?php
				if ( 'draft' === $post->post_status ) :
					echo __( 'Draft', 'tcd-w' ) . ': ';
				elseif ( 'pending' === $post->post_status ) :
					echo esc_html( $dp_options['membership']['pending_label'] ) . ': ';
				endif;
				the_title();
			?></h1>
<?php
		if ( $dp_options['show_date_photo'] ) :
?>
			<time class="p-entry-photo__date p-article__date" datetime="<?php echo date( 'c', strtotime( $post->post_date ) ); ?>"><?php echo date( 'Y.m.d', strtotime( $post->post_date ) ); ?></time>
<?php
		endif;
	endif;

	if ( $dp_options['show_comment_photo'] || $dp_options['show_views_number_photo'] || ( $dp_options['membership']['use_like_photo'] && $dp_options['show_likes_number'] ) ) :
?>
			<ul class="p-entry__counts p-entry-photo__counts">
				<?php if ( $dp_options['show_comment_photo'] ) : ?><li><a class="p-has-icon p-icon-comment" href="#comments"><?php echo get_comments_number(); ?></a></li><?php endif; ?>
				<?php if ( $dp_options['show_views_number_photo'] ) : ?><li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li><?php endif; ?>
				<?php if ( $dp_options['membership']['use_like_photo'] && $dp_options['show_likes_number_photo'] ) : ?><li><a class="p-has-icon p-icon-like<?php if ( is_liked() ) echo 'd'; ?> js-toggle-like" href="#" data-post-id="<?php echo get_the_ID(); ?>"><?php echo get_likes_number(); ?></a></li><?php endif; ?>
			</ul>
<?php
	endif;
?>
			<div class="p-entry__body p-entry-photo__body p-body<?php if ( 'center' == $post->textalign ) echo ' align1'; ?>">
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
?>
			</div>
<?php
	$sns_html = '';
	if ( $dp_options['show_author_sns_photo'] ) :
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

	if ( $sns_html ) :
?>
			<ul class="p-social-nav p-social-nav--author"><?php echo $sns_html; ?></ul>
<?php
	endif;

	if ( $dp_options['show_report_photo'] ) :
?>
			<div class="p-entry__report p-entry-photo__report"><a class="p-entry__report-button js-report-button" href="#"><?php echo esc_html( $dp_options['membership']['report_label'] ? $dp_options['membership']['report_label'] : __( 'Report to administrator', 'tcd-w' ) ); ?></a></div>
<?php
	endif;

	if ( $dp_options['show_sns_btm_photo'] ) :
		get_template_part( 'template-parts/sns-btn-btm' );
	endif;
?>
		</div>
		<div class="p-entry-photo__author">
			<h2 class="p-headline-photo"><span class="p-headline-photo__author"><?php echo esc_html( $dp_options['photo_author_headline'] ); ?></span></h2>
			<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
				<div class="p-author__thumbnail js-object-fit-cover">
					<div class="p-hover-effect__image"><?php echo get_avatar( $author->ID, 300 ); ?></div>
				</div>
				<div class="p-author__name"><?php echo esc_html( $author->display_name ); ?></div>
			</a>
<?php
	if ( $author->area ) :
?>
			<p class="p-author__area"><?php echo esc_html( $author->area ); ?></p>
<?php
	endif;

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
	get_template_part( 'template-parts/advertisement' );

	// プレビューの場合はフォーム出力
	if ( $is_tcd_membership_preview ) :
		the_tcd_membership_preview_form();

	elseif ( $dp_options['show_comment_photo'] ) :
		if ( 'type2' === $dp_options['comment_type_photo'] ) :
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
?>
</main>
<?php
get_footer();
