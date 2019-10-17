<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<footer class="l-footer">
<?php
// フッター上ウィジェット
if ( is_mobile() ) :
	$above_footer_widget = 'above_footer_widget_mobile';
else :
	$above_footer_widget = 'above_footer_widget';
endif;
if ( is_active_sidebar( $above_footer_widget ) ) :
	$memberpage = get_tcd_membership_memberpage_type();
	if ( $memberpage ) :
		switch ( $memberpage ) :
			case 'login' :
				$above_footer_widget = $dp_options['show_above_footer_widget_login'] ? $above_footer_widget : false;
				break;
			case 'registration' :
				$above_footer_widget = $dp_options['show_above_footer_widget_registration'] ? $above_footer_widget : false;
				break;
			case 'registration_account' :
				$above_footer_widget = $dp_options['show_above_footer_widget_registration_account'] ? $above_footer_widget : false;
				break;
			case 'reset_password' :
				$above_footer_widget = $dp_options['show_above_footer_widget_reset_password'] ? $above_footer_widget : false;
				break;
			case 'news' :
				$above_footer_widget = $dp_options['show_above_footer_widget_mypage_news'] ? $above_footer_widget : false;
				break;
			case 'add_photo' :
			case 'edit_photo' :
				$above_footer_widget = $dp_options['show_above_footer_widget_mypage_add_photo'] ? $above_footer_widget : false;
				break;
			case 'add_blog' :
			case 'edit_blog' :
				$above_footer_widget = $dp_options['show_above_footer_widget_mypage_add_blog'] ? $above_footer_widget : false;
				break;
			case 'profile' :
			case 'edit_profile' :
				$above_footer_widget = $dp_options['show_above_footer_widget_mypage_profile'] ? $above_footer_widget : false;
				break;
			case 'account' :
			case 'edit_account' :
			case 'change_password' :
			case 'delete_account' :
				$above_footer_widget = $dp_options['show_above_footer_widget_mypage_account'] ? $above_footer_widget : false;
				break;
			default :
				$above_footer_widget = false;
				break;
		endswitch;
	elseif ( is_front_page() ) :
		if ( ! $dp_options['show_above_footer_widget_front'] ) :
			$above_footer_widget = false;
		endif;
	elseif ( is_singular() ) :
		if (
			( is_singular( 'post' ) && ! $dp_options['show_above_footer_widget_single_post'] ) ||
			( is_singular( $dp_options['photo_slug'] ) && ! $dp_options['show_above_footer_widget_single_photo'] ) ||
			( is_page() && ! $dp_options['show_above_footer_widget_single_page'] ) ||
			( is_singular( $dp_options['information_slug'] ) && ! $dp_options['show_above_footer_widget_single_information'] )
		) :
			$above_footer_widget = false;
		endif;
	elseif (
		( is_home() && ! $dp_options['show_above_footer_widget_archive_post'] ) ||
		( is_category() && ! $dp_options['show_above_footer_widget_archive_category'] ) ||
		( is_tax( $dp_options['photo_category_slug'] ) && ! $dp_options['show_above_footer_widget_archive_photo'] ) ||
		( is_tag() && ! $dp_options['show_above_footer_widget_archive_tag'] ) ||
		( is_date() && ! $dp_options['show_above_footer_widget_archive_date'] ) ||
		( is_search() && ! $dp_options['show_above_footer_widget_archive_search'] ) ||
		( is_post_type_archive( $dp_options['information_slug'] ) && ! $dp_options['show_above_footer_widget_archive_information'] ) ||
		( is_post_type_archive( $dp_options['photo_slug'] ) && ! $dp_options['show_above_footer_widget_archive_photo'] ) ||
		( is_404() && ! $dp_options['show_above_footer_widget_404'] )
	) :
		$above_footer_widget = false;
	endif;

	if ( $above_footer_widget ) :
?>
	<div class="p-above-footer-widget-area">
		<div class="l-inner">
<?php
		dynamic_sidebar( $above_footer_widget );
?>
		</div>
	</div>
<?php
	endif;
endif;
?>
	<div id="js-pagetop" class="p-pagetop"><a href="#"></a></div>
<?php
// フッターブログスライダー
if ( ( is_front_page() && $dp_options['show_footer_blog_top'] ) || ( ! is_front_page() && $dp_options['show_footer_blog'] ) ) :
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'post',
		'posts_per_page' => $dp_options['footer_blog_num']
	);
	$footer_blog_category = null;
	if ( 'type2' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post';
		$args['meta_value'] = 'on';
	elseif ( 'type3' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post2';
		$args['meta_value'] = 'on';
	elseif ( 'type4' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'pickup_post';
		$args['meta_value'] = 'on';
	elseif ( 'type5' == $dp_options['footer_blog_list_type'] ) :
	elseif ( $dp_options['footer_blog_category'] ) :
		$footer_blog_category = get_category( $dp_options['footer_blog_category'] );
		if ( ! empty( $footer_blog_category ) && ! is_wp_error( $footer_blog_category ) ) :
			$args['cat'] = $footer_blog_category->term_id;
		else :
			$footer_blog_category = null;
		endif;
	endif;
	if ( 'rand' == $dp_options['footer_blog_post_order'] ) :
		$args['orderby'] = 'rand';
	elseif ( 'date2' == $dp_options['footer_blog_post_order'] ) :
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
	else :
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	endif;
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>
	<div class="p-footer-blog">
		<div class="l-inner">
			<div id="js-footer-slider" data-interval="<?php echo esc_attr( $dp_options['footer_blog_slide_time_seconds'] ); ?>">
<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();

			$catlist_float = array();
			if ( $dp_options['show_footer_blog_category'] ) :
				// 選択カテゴリーあり
				if ( $footer_blog_category ) :
					$catlist_float[] = '<span class="p-category-item' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ) . '" data-url="' . get_category_link( $footer_blog_category ) . '">' . esc_html( $footer_blog_category->name ) . '</span>';
				else :
					$categories = get_the_category();
					if ( $categories && ! is_wp_error( $categories ) ) :
						foreach ( $categories as $category ) :
							$catlist_float[] = '<span class="p-category-item' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
							break;
						endforeach;
					endif;
				endif;
			endif;
?>
				<article class="p-footer-blog__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post->post_type, 'single', ' ' ); ?>" href="<?php the_permalink(); ?>">
<?php
			echo "\t\t\t\t\t\t";
			echo '<div class="p-footer-blog__item-thumbnail p-hover-effect__image js-object-fit-cover">';
			if ( has_main_image() ) :
				the_main_image( 'size2' );
			elseif ( has_post_thumbnail() ) :
				the_post_thumbnail( 'size2' );
			else :
				echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
			endif;
			echo "</div>\n";

			if ( $catlist_float ) :
				echo "\t\t\t\t\t\t";
				echo '<div class="p-float-category">' . implode( ', ', $catlist_float ) . '</div>';
				echo "\n";
			endif;
?>
						<h3 class="p-footer-blog__item-title p-article__title js-multiline-ellipsis"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' ); ?></h3>
					</a>
				</article>
<?php
		endwhile;
		wp_reset_postdata();
?>
			</div>
		</div>
	</div>
<?php
	endif;
endif;

// フッターウィジェット
$footer_widget_area_class = 'p-footer-widget-area';
if ( is_mobile() ) :
	$footer_widget = 'footer_widget_mobile';
else :
	$footer_widget = 'footer_widget';
endif;
if ( is_active_sidebar( $footer_widget ) ) :
	ob_start();
	dynamic_sidebar( $footer_widget );
	$footer_widget_html = ob_get_clean();
else :
	$footer_widget_area_class .= ' p-footer-widget-area__default';
	ob_start();
	the_widget(
		'Site_Info_Widget',
		array(
			'title' => get_bloginfo( 'name' ),
			'image' => is_mobile() && 'yes' === $dp_options['use_footer_logo_image_mobile'] ? $dp_options['footer_logo_image_mobile'] : ( 'yes' === $dp_options['use_footer_logo_image'] ? $dp_options['footer_logo_image'] : false ),
			'image_retina' => is_mobile() ? $dp_options['footer_logo_image_mobile_retina'] : $dp_options['footer_logo_image_retina'],
			'image_url' => home_url( '/' ),
			'image_target_blank' => 0,
			'description' => get_bloginfo( 'description' ),
			'use_sns_theme_options' => 1
		),
		array(
			'id' => $footer_widget,
			'before_widget' => '<div class="p-widget p-widget-footer site_info_widget">' . "\n",
			'after_widget' => "</div>\n",
			'before_title' => '<h2 class="p-widget__title">',
			'after_title' => '</h2>' . "\n"
		)
	);
	$footer_widget_html = ob_get_clean();
endif;

// justify-content: space-betweenの最終行調整
if ( preg_match_all( '/<div class="(p-widget .*?)"/', $footer_widget_html, $matches ) ) :
	// 半分に表示するウィジェットcssクラス
	$footer_widget_half_classes = array( 'widget_nav_menu', 'widget_categories', 'widget_recent_entries', 'widget_pages', 'widget_meta' );
	$footer_widget_rows = 1;
	$footer_widget_cols = 0;
	foreach( $matches[1] as $match ) :
		$footer_widget_is_half = false;
		foreach( $footer_widget_half_classes as $footer_widget_half_class ) :
			if ( strpos( $match, $footer_widget_half_class ) !== false ) :
				$footer_widget_is_half = true;
				break;
			endif;
		endforeach;
		if ( $footer_widget_is_half ) :
			$footer_widget_col = 1;
			if ( $footer_widget_cols <= 5 ) :
				$footer_widget_cols += 1;
			else :
				$footer_widget_cols = 1;
				$footer_widget_rows++;
			endif;
		else :
			if ( $footer_widget_cols <= 4 ) :
				$footer_widget_cols += 2;
			else :
				$footer_widget_cols = 2;
				$footer_widget_rows++;
			endif;
		endif;
	endforeach;

	// 不足分を挿入
	if ( $footer_widget_cols < 6 ) :
		$footer_widget_html .= str_repeat( '<div class="p-widget p-widget-footer u-hidden-sm"></div>', floor( ( 6 - $footer_widget_cols ) / 2 ) );
		$footer_widget_html .= str_repeat( '<div class="p-widget p-widget-footer u-hidden-sm widget_nav_menu"></div>', ( 6 - $footer_widget_cols ) % 2 );
		$footer_widget_html .= "\n";
	endif;
endif;
?>
	<div id="js-footer-widget" class="<?php echo esc_attr( $footer_widget_area_class ); ?>" style="background: <?php echo esc_attr($dp_options['footer_widget_bg_color']); ?>">

		<div class="p-footer-widget-area__inner l-inner">
<?php
	echo $footer_widget_html;
?>
		</div>
	</div>
	<div class="p-copyright">
		<div class="p-copyright__inner l-inner">
			<p>Copyright &copy;<span class="u-hidden-xs"><?php echo date( 'Y',current_time( 'timestamp', 0 ) ); ?></span> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
		</div>
	</div>
<?php
if ( is_mobile() && ( in_array( $dp_options['footer_bar_display'], array( 'type1', 'type2' ) ) || in_array( $dp_options['membership']['loggedin_footer_bar_display'], array( 'type1', 'type2' ) ) ) ) :
	get_template_part( 'template-parts/footer-bar' );
endif;
?>
</footer>
<?php wp_footer(); ?>
<script>
jQuery(function($){
	var initialized = false;
	var initialize = function(){
		if (initialized) return;
		initialized = true;

		$(document).trigger('js-initialized');
		$(window).trigger('resize').trigger('scroll');
	};

<?php
if ( $dp_options['use_load_icon'] ) :
?>
	$(window).load(function() {
		setTimeout(initialize, 800);
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800, function(){
			$(document).trigger('js-initialized-after');
		});
	});
	setTimeout(function(){
		setTimeout(initialize, 800);
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800, function(){
			$(document).trigger('js-initialized-after');
		});
	}, <?php echo esc_html( $dp_options['load_time'] ? $dp_options['load_time'] : 5000 ); ?>);
<?php
else : // ロード画面を表示しない
?>
	initialize();
	$(document).trigger('js-initialized-after');
<?php
endif;
?>

});
</script>
<?php
if ( is_singular() && ! is_page() ) :
	if ( 'type5' == $dp_options['sns_type_top'] || 'type5' == $dp_options['sns_type_btm'] ) :
		if ( $dp_options['show_twitter_top'] || $dp_options['show_twitter_btm'] ) :
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
		endif;
		if ( $dp_options['show_fblike_top'] || $dp_options['show_fbshare_top'] || $dp_options['show_fblike_btm'] || $dp_options['show_fbshare_btm'] ) :
?>
<!-- facebook share button code -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
		endif;
		if ( $dp_options['show_google_top'] || $dp_options['show_google_btm'] ) :
?>
<script type="text/javascript">window.___gcfg = {lang: 'ja'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
</script>
<?php
		endif;
		if ( $dp_options['show_hatena_top'] || $dp_options['show_hatena_btm'] ) :
?>
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<?php
		endif;
		if ( $dp_options['show_pocket_top'] || $dp_options['show_pocket_btm'] ) :
?>
<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
<?php
		endif;
		if ( $dp_options['show_pinterest_top'] || $dp_options['show_pinterest_btm'] ) :
?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
		endif;
	endif;
endif;
?>
</body>
</html>
