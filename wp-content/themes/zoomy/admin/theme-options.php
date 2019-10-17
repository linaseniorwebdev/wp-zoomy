<?php

// 設定項目と無害化用コールバックを登録
function theme_options_init() {
	register_setting(
		'design_plus_options',
		'dp_options',
		'theme_options_validate'
	);
}
add_action( 'admin_init', 'theme_options_init' );

// 親メニュー・サブメニューを登録
function theme_options_add_page() {
	add_menu_page(
		__( 'TCD Theme', 'tcd-w' ),
		__( 'TCD Theme', 'tcd-w' ),
		'edit_theme_options',
		'theme_options',
		'theme_options_do_page',
		'',
		'2.0000012'	// ダッシュボードの下
	);
}
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * オプション初期値
 * @var array
 */
global $dp_default_options;
$dp_default_options = array(
	/**
	 * 基本設定
	 */
	// 色の設定
	'primary_color' => '#0093c5',
	'secondary_color' => '#027197',
	'content_link_color' => '#0093c5',

	// ファビコンの設定
	'favicon' => '',

	// フォントタイプ
	'font_type' => 'type2',

	// 大見出しのフォントタイプ
	'headline_font_type' => 'type2',

	// 絵文字の設定
	'use_emoji' => 0,

	// クイックタグの設定
	'use_quicktags' => 1,

	// サイドバーの設定
	'sidebar' => 'type2',

	// ロード画面の設定
	'use_load_icon' => 0,
	'load_icon' => 'type1',
	'load_time' => 3,
	'load_color1' => '#000000',
	'load_color2' => '#999999',

	// ホバーエフェクトの設定
	'hover_type' => 'type1',
	'hover1_zoom' => 1.2,
	'hover1_rotate' => 1,
	'hover1_opacity' => 1,
	'hover1_bgcolor' => '#000000',
	'hover2_direct' => 'type1',
	'hover2_opacity' => 0.5,
	'hover2_bgcolor' => '#000000',
	'hover3_opacity' => 0.5,
	'hover3_bgcolor' => '#000000',

	// Facebook OGPの設定
	'use_ogp' => 0,
	'fb_app_id' => '',
	'ogp_image' => '',

	// Twitter Cardsの設定
	'use_twitter_card' => 0,
	'twitter_account_name' => '',

	// ソーシャルボタンの表示設定
	'sns_type_top' => 'type6',
	'show_twitter_top' => 1,
	'show_fblike_top' => 1,
	'show_fbshare_top' => 1,
	'show_google_top' => 1,
	'show_hatena_top' => 1,
	'show_pocket_top' => 1,
	'show_feedly_top' => 1,
	'show_rss_top' => 1,
	'show_pinterest_top' => 1,
	'sns_type_btm' => 'type6',
	'show_twitter_btm' => 1,
	'show_fblike_btm' => 1,
	'show_fbshare_btm' => 1,
	'show_google_btm' => 1,
	'show_hatena_btm' => 1,
	'show_pocket_btm' => 1,
	'show_feedly_btm' => 1,
	'show_rss_btm' => 1,
	'show_pinterest_btm' => 1,
	'twitter_info' => '',

	// Google Map
	'gmap_api_key' => '',
	'gmap_marker_type' => 'type1',
	'gmap_custom_marker_type' => 'type1',
	'gmap_marker_text' => '',
	'gmap_marker_color' => '#ffffff',
	'gmap_marker_img' => '',
	'gmap_marker_bg' => '#000000',

	// カスタムCSS
	'css_code' => '',

	// Custom head/script
	'custom_head' => '',

	// 検索設定
	'search_target_post_types' => array( 'post', 'photo' ),

	/**
	 * ロゴ
	 */
	// ヘッダーのロゴ
	'use_header_logo_image' => 'no',
	'header_logo_font_size' => 30,
	'header_logo_image' => '',
	'header_logo_image_retina' => 0,

	// ヘッダーのロゴ（スマホ用）
	'use_header_logo_image_mobile' => 'no',
	'header_logo_font_size_mobile' => 24,
	'header_logo_image_mobile' => '',
	'header_logo_image_mobile_retina' => 0,

	// フッターのロゴ
	'use_footer_logo_image' => 'no',
	'footer_logo_font_size' => 30,
	'footer_logo_image' => '',
	'footer_logo_image_retina' => 0,

	// フッターのロゴ（スマホ用）
	'use_footer_logo_image_mobile' => 'no',
	'footer_logo_font_size_mobile' => 24,
	'footer_logo_image_mobile' => '',
	'footer_logo_image_mobile_retina' => 0,

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	'header_content_type' => 'type1',
	'slide_time_seconds' => 7,

	// 画像スライダー スライド共通モバイル設定
	'slider_content_type_mobile' => 'default',
	'slider_logo_mobile_type1' => '',
	'slider_logo_width_mobile_type1' => '',
	'slider_catch_mobile_type2' => '',
	'slider_catch_vertical_mobile_type2' => 0,
	'slider_catch_font_size_mobile_type2' => 24,
	'slider_catch_color_mobile_type2' => '#ffffff',
	'slider_catch_font_type_mobile_type2' => 'type3',
	'slider_catch_align_mobile_type2' => 'type2',
	'slider_catch_shadow1_mobile_type2' => '',
	'slider_catch_shadow2_mobile_type2' => '',
	'slider_catch_shadow3_mobile_type2' => '',
	'slider_catch_shadow_color_mobile_type2' => '#999999',
	'display_slider_overlay_mobile' => 0,
	'slider_overlay_color_mobile' => '#000000',
	'slider_overlay_opacity_mobile' => 0.5,

	// Video
	'header_video' => '',
	'header_video_mute' => 0,
	'header_video_image' => '',

	// Youtube
	'header_youtube_url' => '',
	'header_youtube_image' => '',

	// Video/Youtubeコンテンツ
	'header_video_link_url' => '',
	'header_video_target' => 0,
	'header_video_content_type' => 'type2',
	'header_video_logo' => '',
	'header_video_logo_width' => '',
	'header_video_catch' => '',
	'header_video_catch_vertical' => 0,
	'header_video_catch_font_size' => 46,
	'header_video_catch_color' => '#ffffff',
	'header_video_catch_font_type' => 'type3',
	'header_video_catch_align' => 'type2',
	'header_video_catch_shadow1' => '',
	'header_video_catch_shadow2' => '',
	'header_video_catch_shadow3' => '',
	'header_video_catch_shadow_color' => '#999999',
	'display_header_video_desc' => 0,
	'header_video_desc' => '',
	'header_video_desc_font_size' => 18,
	'header_video_desc_color' => '#ffffff',
	'header_video_desc_align' => 'type2',
	'header_video_desc_shadow1' => 0,
	'header_video_desc_shadow2' => 0,
	'header_video_desc_shadow3' => 0,
	'header_video_desc_shadow_color' => '#999999',
	'display_header_video_button' => 0,
	'header_video_button_label' => '',
	'header_video_button_font_color' => '#ffffff',
	'header_video_button_bg_color' => '#0093c5',
	'header_video_button_font_color_hover' => '#ffffff',
	'header_video_button_bg_color_hover' => '#000000',
	'display_header_video_overlay' => 0,
	'header_video_overlay_color' => '#000000',
	'header_video_overlay_opacity' => 0.5,
	'header_video_content_type_mobile' => 'default',
	'header_video_logo_width_mobile' => '',
	'header_video_catch_font_size_mobile' => 26,
	'header_video_desc_font_size_mobile' => 14,
	'header_video_logo_mobile_type1' => '',
	'header_video_logo_width_mobile_type1' => '',
	'header_video_catch_mobile_type2' => '',
	'header_video_catch_vertical_mobile_type2' => 0,
	'header_video_catch_font_size_mobile_type2' => 26,
	'header_video_catch_color_mobile_type2' => '#ffffff',
	'header_video_catch_font_type_mobile_type2' => 'type3',
	'header_video_catch_align_mobile_type2' => 'type2',
	'header_video_catch_shadow1_mobile_type2' => 0,
	'header_video_catch_shadow2_mobile_type2' => 0,
	'header_video_catch_shadow3_mobile_type2' => 0,
	'header_video_catch_shadow_color_mobile_type2' => '#999999',
	'display_header_video_overlay_mobile' => 0,
	'header_video_overlay_color_mobile' => '#000000',
	'header_video_overlay_opacity_mobile' => 0.5,

	// ニュースティッカーの設定
	'show_index_newsticker' => 1,
	'index_newsticker_num' => 5,
	'show_index_newsticker_date' => 1,
	'index_newsticker_archive_link_text' => __( 'Information archive', 'tcd-w' ),
	'index_newsticker_archive_link_font_color' => '#ffffff',
	'index_newsticker_archive_link_bg_color' => '#0093c5',
	'index_newsticker_archive_link_font_color_hover' => '#ffffff',
	'index_newsticker_archive_link_bg_color_hover' => '#027197',
	'index_newsticker_slide_time_seconds' => 7,

	// コンテンツビルダー
	'contents_builder' => array(),

	/**
	 * ブログ
	 */
	// ブログの設定
	'blog_label' => __( 'Blog', 'tcd-w' ),
	'blog_header_headline' => __( 'Blog', 'tcd-w' ),
	'blog_header_desc' => '',

	// 記事詳細ページの設定
	'title_font_size' => 36,
	'title_font_size_mobile' => 22,
	'title_color' => '#000000',
	'content_font_size' => 16,
	'content_font_size_mobile' => 14,
	'content_color' => '#000000',
	'page_link' => 'type1',

	// 表示設定
	'show_breadcrumb_archive' => 0,
	'show_breadcrumb_single' => 0,
	'show_date_archive' => 1,
	'show_category_archive' => 1,
	'show_comments_number_archive' => 1,
	'show_views_number_archive' => 1,
	'show_likes_number_archive' => 1,
	'show_date' => 1,
	'show_category' => 1,
	'show_likes_number' => 1,
	'show_views_number' => 1,
	'show_thumbnail' => 1,
	'show_author_sns' => 1,
	'show_report' => 1,
	'show_sns_top' => 1,
	'show_sns_btm' => 1,
	'show_next_post' => 1,
	'show_tag' => 1,
	'show_comment' => 1,
	'show_trackback' => 1,
	'comment_type' => 'type2',

	// 関連記事の設定
	'show_related_post' => 1,
	'related_post_headline' => __( 'Related posts', 'tcd-w' ),
	'related_post_num' => 8,

	// 記事詳細の広告設定1
	'single_ad_code1' => '',
	'single_ad_image1' => false,
	'single_ad_url1' => '',
	'single_ad_code2' => '',
	'single_ad_image2' => false,
	'single_ad_url2' => '',

	// 記事詳細の広告設定2
	'single_ad_code3' => '',
	'single_ad_image3' => false,
	'single_ad_url3' => '',
	'single_ad_code4' => '',
	'single_ad_image4' => false,
	'single_ad_url4' => '',

	// スマートフォン専用の広告
	'single_mobile_ad_code1' => '',
	'single_mobile_ad_image1' => false,
	'single_mobile_ad_url1' => '',

	/**
	 * 写真
	 */
	 // Photoの設定
	'photo_label' => __( 'Photo', 'tcd-w' ),
	'photo_slug' => 'photo',
	'photo_category_label' => __( 'Photo category', 'tcd-w' ),
	'photo_category_slug' => 'photo-category',
	'photo_header_headline' => __( 'Photo', 'tcd-w' ),
	'photo_header_desc' => '',

	// Photoページの設定
	'photo_title_font_size' => 36,
	'photo_title_font_size_mobile' => 22,
	'photo_title_color' => '#000000',
	'photo_content_font_size' => 16,
	'photo_content_font_size_mobile' => 14,
	'photo_content_color' => '#000000',

	// 表示設定
	'show_breadcrumb_archive_photo' => 0,
	'show_breadcrumb_single_photo' => 0,
	'show_date_archive_photo' => 1,
	'show_category_archive_photo' => 1,
	'show_comments_number_archive_photo' => 1,
	'show_views_number_archive_photo' => 1,
	'show_likes_number_archive_photo' => 1,
	'show_date_photo' => 1,
	'show_category_photo' => 1,
	'show_views_number_photo' => 1,
	'show_likes_number_photo' => 1,
	'show_author_sns_photo' => 1,
	'show_sns_btm_photo' => 1,
	'show_report_photo' => 1,
	'show_comment_photo' => 1,
	'show_trackback_photo' => 1,
	'photo_author_headline' => __( 'Author', 'tcd-w'),
	'photo_author_headline_font_color' => '#ffffff',
	'photo_author_headline_bg_color' => '#000000',
	'photo_comment_headline' => __( 'Comment', 'tcd-w'),
	'photo_comment_headline_font_color' => '#ffffff',
	'photo_comment_headline_bg_color' => '#000000',
	'comment_type_photo' => 'type2',

	// 記事詳細の広告設定1
	'photo_single_ad_code1' => '',
	'photo_single_ad_image1' => false,
	'photo_single_ad_url1' => '',
	'photo_single_ad_code2' => '',
	'photo_single_ad_image2' => false,
	'photo_single_ad_url2' => '',

	// スマートフォン専用の広告
	'photo_single_mobile_ad_code1' => '',
	'photo_single_mobile_ad_image1' => false,
	'photo_single_mobile_ad_url1' => '',

	/**
	 * Information
	 */
	 // お知らせの設定
	'information_label' => __( 'Information', 'tcd-w' ),
	'information_slug' => 'information',
	'information_header_headline' => __( 'Information', 'tcd-w' ),
	'information_header_desc' => '',

	// お知らせページの設定
	'information_title_font_size' => 36,
	'information_title_font_size_mobile' => 22,
	'information_title_color' => '#000000',
	'information_content_font_size' => 16,
	'information_content_font_size_mobile' => 14,
	'information_content_color' => '#000000',

	// 表示設定
	'archive_information_num' => 10,
	'show_breadcrumb_archive_information' => 0,
	'show_date_information' => 1,

	/**
	 * ヘッダー
	 */
	// ヘッダーバーの表示設定
	'header_bar' => 'type2',
	'header_bar_mobile' => 'type2',
	'header_bar_photo' => 'type3',
	'header_bar_photo_mobile' => 'type3',

	// ヘッダーバーの色の設定
	'header_bg' => '#ffffff',
	'header_opacity' => 1,
	'header_opacity_fixed' => 0.8,
	'header_font_color' => '#000000',
	'header_font_color_hover' => '#0093c5',

	// ドロップダウンメンバーメニュー設定
	'membermenu_font_color' => '#ffffff',
	'membermenu_font_color_hover' => '#0093c5',
	'membermenu_badge_font_color' => '#ffffff',
	'membermenu_badge_bg_color' => '#0093c5',
	'membermenu_bg_color' => '#222222',

	// サイドメニュー設定
	'sidemenu_font_color' => '#ffffff',
	'sidemenu_font_color_hover' => '#0093c5',
	'sidemenu_title_font_color' => '#ffffff',
	'sidemenu_title_bg_color' => '#0093c5',
	'sidemenu_bg_color' => '#222222',
	'show_sidemenu_category' => 1,
	'sidemenu_category_label' => __( 'Category', 'tcd-w' ),
	'sidemenu_category_exclude' => '',
	'show_sidemenu_photo_category' => 1,
	'sidemenu_photo_category_label' => __( 'Photo category', 'tcd-w' ),
	'sidemenu_photo_category_exclude' => '',
	'sidemenu_photo_category_show_first' => 0,
	'show_sidemenu_globalmenu' => 1,
	'show_sidemenu_search' => 1,
	'show_sidemenu_widget' => 1,

	/**
	 * フッター
	 */
	// フッター上ウィジェット
	'show_above_footer_widget_front' => 0,
	'show_above_footer_widget_archive_post' => 0,
	'show_above_footer_widget_archive_photo' => 0,
	'show_above_footer_widget_archive_information' => 0,
	'show_above_footer_widget_archive_category' => 0,
	'show_above_footer_widget_archive_photo_category' => 0,
	'show_above_footer_widget_archive_tag' => 0,
	'show_above_footer_widget_archive_date' => 0,
	'show_above_footer_widget_archive_search' => 0,
	'show_above_footer_widget_single_post' => 0,
	'show_above_footer_widget_single_page' => 0,
	'show_above_footer_widget_single_photo' => 0,
	'show_above_footer_widget_author' => 0,
	'show_above_footer_widget_404' => 0,
	'show_above_footer_widget_login' => 0,
	'show_above_footer_widget_registration' => 0,
	'show_above_footer_widget_registration_account' => 0,
	'show_above_footer_widget_reset_password' => 0,
	'show_above_footer_widget_mypage_news' => 0,
	'show_above_footer_widget_mypage_add_photo' => 0,
	'show_above_footer_widget_mypage_add_blog' => 0,
	'show_above_footer_widget_mypage_profile' => 0,
	'show_above_footer_widget_mypage_account' => 0,

	// ブログコンテンツの設定
	'show_footer_blog_top' => 1,
	'show_footer_blog' => 1,
	'footer_blog_list_type' => 'type5',
	'footer_blog_category' => 0,
	'footer_blog_num' => 10,
	'footer_blog_post_order' => 'date1',
	'show_footer_blog_category' => 1,
	'footer_blog_slide_time_seconds' => 7,
	'footer_blog_bg_color' => '#000000',

	// フッターウィジェット
	'footer_widget_title_color' => '#0093c5',
	'footer_widget_font_color' => '#000000',
	'footer_widget_font_color_hover' => '#027197',
	'footer_widget_bg_color' => '#ffffff',

	// SNSボタンの設定
	'instagram_url' => '',
	'twitter_url' => '',
	'pinterest_url' => '',
	'facebook_url' => '',
	'googleplus_url' => '',
	'youtube_url' => '',
	'contact_url' => '',
	'show_rss' => 0,

	// コピーライトの設定
	'copyright_font_color' => '#000000',
	'copyright_bg_color' => '#ffffff',

	// スマホ用固定フッターバーの設定
	'footer_bar_display' => 'type3',
	'footer_bar_tp' => 0.8,
	'footer_bar_bg' => '#ffffff',
	'footer_bar_border' => '#dddddd',
	'footer_bar_color' => '#000000',
	'footer_bar_btns' => array(
		array(
			'type' => 'type1',
			'label' => '',
			'url' => '',
			'number' => '',
			'target' => 0,
			'icon' => 'file-text'
		)
	),

	/**
	 * 404 ページ
	 */
	'image_404' => '',
	'overlay_404' => '#000000',
	'overlay_opacity_404' => 0.2,
	'catchphrase_404' => __( '404 Not Found', 'tcd-w' ),
	'desc_404' => __( 'The page you were looking for could not be found', 'tcd-w' ),
	'catchphrase_font_size_404' => 32,
	'catchphrase_font_size_404_mobile' => 26,
	'catchphrase_font_type_404' => 'type2',
	'desc_font_size_404' => 16,
	'desc_font_size_404_mobile' => 14,
	'color_404' => '#ffffff',
	'shadow1_404' => 0,
	'shadow2_404' => 0,
	'shadow3_404' => 0,
	'shadow_color_404' => '#999999',

	/**
	 * 保護ページ
	 */
	'pw_label' => '',
	'pw_align' => 'type1',
	'pw_name1' => '',
	'pw_name2' => '',
	'pw_name3' => '',
	'pw_name4' => '',
	'pw_name5' => '',
	'pw_btn_display1' => '',
	'pw_btn_display2' => '',
	'pw_btn_display3' => '',
	'pw_btn_display4' => '',
	'pw_btn_display5' => '',
	'pw_btn_label1' => '',
	'pw_btn_label2' => '',
	'pw_btn_label3' => '',
	'pw_btn_label4' => '',
	'pw_btn_label5' => '',
	'pw_btn_url1' => '',
	'pw_btn_url2' => '',
	'pw_btn_url3' => '',
	'pw_btn_url4' => '',
	'pw_btn_url5' => '',
	'pw_btn_target1' => 0,
	'pw_btn_target2' => 0,
	'pw_btn_target3' => 0,
	'pw_btn_target4' => 0,
	'pw_btn_target5' => 0,
	'pw_editor1' => '',
	'pw_editor2' => '',
	'pw_editor3' => '',
	'pw_editor4' => '',
	'pw_editor5' => ''
);

// オプション初期値ループ項目
for ( $i = 1; $i <= 5; $i++ ) {
	$dp_default_options['slider_image' . $i] = '';
	$dp_default_options['slider_image_sp' . $i] = '';
	$dp_default_options['slider_url' . $i] = '#';
	$dp_default_options['slider_target' . $i] = 0;
	$dp_default_options['slider_content_type' . $i] = 'type2';
	$dp_default_options['slider_logo' . $i] = '';
	$dp_default_options['slider_logo_width' . $i] = '';
	$dp_default_options['slider_logo_width_mobile' . $i] = '';
	$dp_default_options['slider_catch' . $i] = sprintf( __( 'Catchphrase for slide %d', 'tcd-w' ), $i );
	$dp_default_options['slider_catch_vertical' . $i] = 0;
	$dp_default_options['slider_catch_font_size' . $i] = 46;
	$dp_default_options['slider_catch_font_size_mobile' . $i] = 26;
	$dp_default_options['slider_catch_color' . $i] = '#ffffff';
	$dp_default_options['slider_catch_font_type' . $i] = 'type3';
	$dp_default_options['slider_catch_align' . $i] = 'type2';
	$dp_default_options['slider_catch' . $i . '_shadow1'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow2'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow3'] = 0;
	$dp_default_options['slider_catch' . $i . '_shadow_color'] = '#999999';
	$dp_default_options['display_slider_desc' . $i] = 0;
	$dp_default_options['slider_desc' . $i] = sprintf( __( 'Description for slide %d', 'tcd-w' ), $i ) . "\n" . sprintf( __( 'Description for slide %d', 'tcd-w' ), $i );
	$dp_default_options['slider_desc_font_size' . $i] = 18;
	$dp_default_options['slider_desc_font_size_mobile' . $i] = 14;
	$dp_default_options['slider_desc_color' . $i] = '#ffffff';
	$dp_default_options['slider_desc_align' . $i] = 'type2';
	$dp_default_options['slider_desc' . $i . '_shadow1'] = 0;
	$dp_default_options['slider_desc' . $i . '_shadow2'] = 0;
	$dp_default_options['slider_desc' . $i . '_shadow3'] = 0;
	$dp_default_options['slider_desc' . $i . '_shadow_color'] = '#999999';
	$dp_default_options['display_slider_button' . $i] = 0;
	$dp_default_options['slider_button_label' . $i] = '';
	$dp_default_options['slider_button_font_color' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color' . $i] = '#0093c5';
	$dp_default_options['slider_button_font_color_hover' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color_hover' . $i] = '#027197';
	$dp_default_options['display_slider_overlay' . $i] = 0;
	$dp_default_options['slider_overlay_color' . $i] = '#000000';
	$dp_default_options['slider_overlay_opacity' . $i] = 0.5;
	$dp_default_options['display_slider_overlay_mobile' . $i] = 0;
	$dp_default_options['slider_overlay_color_mobile' . $i] = '#000000';
	$dp_default_options['slider_overlay_opacity_mobile' . $i] = 0.5;
}
$i = 1;
$dp_default_options['display_slider_desc' . $i] = 1;
$dp_default_options['slider_desc' . $i] = __( 'Enter description here.', 'tcd-w' ) . "\n" . __( 'Enter description here. Enter description here.', 'tcd-w' );
$dp_default_options['display_slider_button' . $i] = 1;
$dp_default_options['slider_button_label' . $i] = __( 'Sample button', 'tcd-w' );

/**
 * Design Plus のオプションを返す
 *
 * @global array $dp_default_options
 * @return array
 */
function get_design_plus_option() {
	global $dp_default_options;
	$dp_options = (array) get_option( 'dp_options', array() );
	$dp_options = array_merge( $dp_default_options, $dp_options );
	$dp_options['membership'] = array_merge( $dp_default_options['membership'], $dp_options['membership'] );
	return $dp_options;
}

// フォントタイプ
global $font_type_options;
$font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// 大見出しのフォントタイプ
global $headline_font_type_options;
$headline_font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// サイドバーの設定
global $sidebar_options;
$sidebar_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Display on left side', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/sidebar_type1.png'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Display on right side', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/sidebar_type2.png'
	)
);

// ローディングアイコンの種類の設定
global $load_icon_options;
$load_icon_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Circle', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Square', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Dot', 'tcd-w' )
	)
);

// ロード画面の設定
global $load_time_options;
for ( $i = 3; $i <= 10; $i++ ) {
	$load_time_options[$i * 1000] = array( 'value' => $i * 1000, 'label' => $i );
}

// ホバーエフェクトの設定
global $hover_type_options;
$hover_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Zoom', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Slide', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Fade', 'tcd-w' )
	)
);
global $hover2_direct_options;
$hover2_direct_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Left to Right', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Right to Left', 'tcd-w' )
	)
);

// ロゴに画像を使うか否か
global $logo_type_options;
$logo_type_options = array(
	'no' => array(
		'value' => 'no',
		'label' => __( 'Use text for logo', 'tcd-w' )
	),
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Use image for logo', 'tcd-w' )
	)
);

// Google Maps
global $gmap_marker_type_options;
$gmap_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Use default marker', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/gmap_marker_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Use custom marker', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/gmap_marker_type2.jpg'
	)
);
global $gmap_custom_marker_type_options;
$gmap_custom_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Text', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Image', 'tcd-w' )
	)
);

// ヘッダーコンテンツの設定
global $header_content_type_options;
$header_content_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Image slider', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Video', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Youtube', 'tcd-w' )
	)
);

// PC用スライドコンテンツの設定
global $slider_content_type_options;
$slider_content_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Logo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Catchphrase', 'tcd-w' )
	)
);

// モバイル用スライドコンテンツの設定
global $slider_content_type_mobile_options;
$slider_content_type_mobile_options = array(
	'default' => array(
		'value' => 'default',
		'label' => __( 'Default : Same as PC setting', 'tcd-w' )
	),
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Type1 : Logo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Type2 : Catchphrase', 'tcd-w' )
	)
);

// モバイル用スライドコンテンツの設定
global $slide_effect_type_options;
$slide_effect_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Type1', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Type2', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Type3', 'tcd-w' )
	)
);

// 記事タイプ
global $list_type_options;
$list_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Category', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Recommend post', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Recommend post2', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Pickup post', 'tcd-w' )
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'All posts', 'tcd-w' )
	)
);

// ページナビ
global $page_link_options;
$page_link_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Page numbers', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/page_link_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Read more button', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/page_link_type2.jpg'
	)
);

// コメントタイプ
global $comment_type_options;
$comment_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Comments and trackbacks', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/comments_type1.jpg',
		'image_photo' => get_template_directory_uri() . '/admin/img/comments_type1_photo.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Speech bubble style comments (Require login to comment, Do not show trackbacks)', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/comments_type2.jpg',
		'image_photo' => get_template_directory_uri() . '/admin/img/comments_type2_photo.jpg'
	)
);

// ブログ表示順
global $post_order_options;
$post_order_options = array(
	'date1' => array(
		'value' => 'date1',
		'label' => __( 'Date (DESC)', 'tcd-w' )
	),
	'date2' => array(
		'value' => 'date2',
		'label' => __( 'Date (ASC)', 'tcd-w' )
	),
	'rand' => array(
		'value' => 'rand',
		'label' => __( 'Random', 'tcd-w' )
	)
);

// text align
global $text_align_options;
$text_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Align right', 'tcd-w' )
	)
);

// 記事上ボタンタイプ
global $sns_type_top_options;
$sns_type_top_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'style1', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'style2', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type2.jpg'
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'style3', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type3.jpg'
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'style4', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type4.jpg'
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'style5', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type5.jpg'
	),
	'type6' => array(
		'value' => 'type6',
		'label' => __( 'style6', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/share_type6.jpg'
	)
);

// 記事下ボタンタイプ
global $sns_type_btm_options;
$sns_type_btm_options = $sns_type_top_options;

// ヘッダーバー 表示タイプ
global $header_bar_options;
$header_bar_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Display header bar', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Display sticky header bar', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Display sticky header bar after scroll', 'tcd-w' ) ),
	'type4' => array( 'value' => 'type4', 'label' => __( 'Hide', 'tcd-w' ) )
);

// フッターの固定メニュー 表示タイプ
global $footer_bar_display_options;
$footer_bar_display_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Hide', 'tcd-w' ) )
);

// フッターバーボタンのタイプ
global $footer_bar_button_options;
$footer_bar_button_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Default', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Share', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Telephone', 'tcd-w' ) )
);

// フッターバーボタンのアイコン
global $footer_bar_icon_options;
$footer_bar_icon_options = array(
	'file-text' => array(
		'value' => 'file-text',
		'label' => __( 'Document', 'tcd-w' )
	),
	'share-alt' => array(
		'value' => 'share-alt',
		'label' => __( 'Share', 'tcd-w' )
	),
	'phone' => array(
		'value' => 'phone',
		'label' => __( 'Telephone', 'tcd-w' )
	),
	'envelope' => array(
		'value' => 'envelope',
		'label' => __( 'Envelope', 'tcd-w' )
	),
	'tag' => array(
		'value' => 'tag',
		'label' => __( 'Tag', 'tcd-w' )
	),
	'pencil' => array(
		'value' => 'pencil',
		'label' => __( 'Pencil', 'tcd-w' )
	)
);

// 保護ページalign
global $pw_align_options;
$pw_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	)
);

// テーマオプション画面の作成
function theme_options_do_page() {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$tabs = array(
		// 基本設定
		array(
			'label' => __( 'Basic', 'tcd-w' ),
			'template_part' => 'admin/inc/basic',
		),
		// ロゴの設定
		array(
			'label' => __( 'Logo', 'tcd-w' ),
			'template_part' => 'admin/inc/logo',
		),
		// トップページ
		array(
			'label' => __( 'Index', 'tcd-w' ),
			'template_part' => 'admin/inc/top',
		),
		// ブログ
		array(
			'label' => $dp_options['blog_label'],
			'template_part' => 'admin/inc/blog',
		),
		// Photo
		array(
			'label' => $dp_options['photo_label'],
			'template_part' => 'admin/inc/photo',
		),
		// Information
		array(
			'label' => __( 'Information', 'tcd-w' ),
			'template_part' => 'admin/inc/information',
		),
		// ヘッダー
		array(
			'label' => __( 'Header', 'tcd-w' ),
			'template_part' => 'admin/inc/header',
		),
		// フッター
		array(
			'label' => __( 'Footer', 'tcd-w' ),
			'template_part' => 'admin/inc/footer',
		),
		// 404 ページ
		array(
			'label' => __( '404 page', 'tcd-w' ),
			'template_part' => 'admin/inc/404',
		),
		// ページ保護
		array(
			'label' => __( 'Password protected pages', 'tcd-w' ),
			'template_part' => 'admin/inc/password',
		),
		// Tools
		array(
			'label' => __( 'Tools', 'tcd-w' ),
			'template_part' => 'admin/inc/tools',
		)
	);
?>
<div class="wrap">
	<h2><?php _e( 'TCD Theme Options', 'tcd-w' ); ?></h2>
<?php
	// 更新時のメッセージ
	if ( ! empty( $_REQUEST['settings-updated'] ) ) :
?>
	<div class="updated fade">
		<p><strong><?php _e( 'Updated', 'tcd-w' ); ?></strong></p>
	</div>
<?php
	endif;

	// Toolsメッセージ
	theme_options_tools_notices();
?>
	<div id="tcd_theme_option" class="cf">
		<div id="tcd_theme_left">
			<ul id="theme_tab" class="cf">
<?php
	foreach ( $tabs as $key => $tab ):
?>
				<li><a href="#tab-content<?php echo esc_attr( $key + 1 ); ?>"><?php echo esc_html( $tab['label'] ); ?></a></li>
<?php
	endforeach;
?>
			</ul>
		</div>
		<div id="tcd_theme_right">
			<form method="post" action="options.php" enctype="multipart/form-data">
<?php
	settings_fields( 'design_plus_options' );
?>
				<div id="tab-panel">
<?php
	foreach ( $tabs as $key => $tab ):
?>
					<div id="#tab-content<?php echo esc_attr( $key + 1 ); ?>">
<?php
		if ( !empty( $tab['template_part'] ) ) :
			get_template_part( $tab['template_part'] );
		endif;
?>
					</div>
<?php
	endforeach;
?>
				</div><!-- END #tab-panel -->
			</form>
			<div id="saved_data"></div>
			<div id="saving_data" style="display:none;"><p><?php _e( 'Now saving...', 'tcd-w' ); ?></p></div>
		</div><!-- END #tcd_theme_right -->
	</div><!-- END #tcd_theme_option -->
</div><!-- END #wrap -->
<?php
}

/**
 * チェック
 */
function theme_options_validate( $input ) {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// TCD Membership optionsのフォーム送信時
	if ( ! empty( $_POST['tcd_membership_options'] ) ) {
		// TCDテーマ・TCD Membership設定で共通保存処理のため現設定に入力値をマージ
		$input = array_merge( $dp_options, (array) $input );
		$input = tcd_membership_options_validate( $input );
	}

	// TCDテーマ
	global $dp_default_options, $font_type_options, $headline_font_type_options, $sidebar_options, $load_icon_options, $load_time_options, $logo_type_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options, $gmap_marker_type_options, $gmap_custom_marker_type_options, $header_content_type_options, $slider_content_type_options, $slider_content_type_mobile_options, $slide_effect_type_options, $list_type_options, $post_order_options, $page_link_options, $comment_type_options, $text_align_options, $header_bar_options, $footer_bar_display_options, $footer_bar_icon_options, $footer_bar_button_options, $pw_align_options;

	// 色の設定
	$input['primary_color'] = wp_unslash( wp_filter_nohtml_kses( $input['primary_color'] ) );
	$input['secondary_color'] = wp_unslash( wp_filter_nohtml_kses( $input['secondary_color'] ) );
	$input['content_link_color'] = wp_unslash( wp_filter_nohtml_kses( $input['content_link_color'] ) );

	// ファビコン
	$input['favicon'] = wp_unslash( wp_filter_nohtml_kses( $input['favicon'] ) );

	// フォントの種類
	if ( ! isset( $input['font_type'] ) || ! array_key_exists( $input['font_type'], $font_type_options ) )
		$input['font_type'] = $dp_default_options['font_type'];

	// 大見出しのフォントタイプ
	if ( ! isset( $input['headline_font_type'] ) || ! array_key_exists( $input['headline_font_type'], $headline_font_type_options ) )
		$input['headline_font_type'] = $dp_default_options['headline_font_type'];

	// 絵文字の設定
	$input['use_emoji'] = ! empty( $input['use_emoji'] ) ? 1 : 0;

	// クイックタグの設定
	$input['use_quicktags'] = ! empty( $input['use_quicktags'] ) ? 1 : 0;

	// サイドバーの設定
	if ( ! isset( $input['sidebar'] ) || ! array_key_exists( $input['sidebar'], $sidebar_options ) )
		$input['sidebar'] = $dp_default_options['sidebar'];

	// ロード画面の設定
	$input['use_load_icon'] = ! empty( $input['use_load_icon'] ) ? 1 : 0;
	if ( ! isset( $input['load_icon'] ) || ! array_key_exists( $input['load_icon'], $load_icon_options ) )
		$input['load_icon'] = $dp_default_options['load_icon'];
	if ( ! isset( $input['load_time'] ) || ! array_key_exists( $input['load_time'], $load_time_options ) )
		$input['load_time'] = $dp_default_options['load_time'];
	$input['load_color1'] = wp_unslash( wp_filter_nohtml_kses( $input['load_color1'] ) );
	$input['load_color2'] = wp_unslash( wp_filter_nohtml_kses( $input['load_color2'] ) );

	// ホバーエフェクトの設定
	if ( ! isset( $input['hover_type'] ) || ! array_key_exists( $input['hover_type'], $hover_type_options ) )
		$input['hover_type'] = $dp_default_options['hover_type'];
	$input['hover1_zoom'] = wp_unslash( wp_filter_nohtml_kses( $input['hover1_zoom'] ) );
	$input['hover1_rotate'] = ! empty( $input['hover1_rotate'] ) ? 1 : 0;
	$input['hover1_opacity'] = wp_unslash( wp_filter_nohtml_kses( $input['hover1_opacity'] ) );
	$input['hover1_bgcolor'] = wp_unslash( wp_filter_nohtml_kses( $input['hover1_bgcolor'] ) );
	if ( ! isset( $input['hover2_direct'] ) || ! array_key_exists( $input['hover2_direct'], $hover2_direct_options ) )
		$input['hover2_direct'] = $dp_default_options['hover2_direct'];
	$input['hover2_opacity'] = wp_unslash( wp_filter_nohtml_kses( $input['hover2_opacity'] ) );
	$input['hover2_bgcolor'] = wp_unslash( wp_filter_nohtml_kses( $input['hover2_bgcolor'] ) );
	$input['hover3_opacity'] = wp_unslash( wp_filter_nohtml_kses( $input['hover3_opacity'] ) );
	$input['hover3_bgcolor'] = wp_unslash( wp_filter_nohtml_kses( $input['hover3_bgcolor'] ) );

	// Facebook OGPの設定
	$input['use_ogp'] = ! empty( $input['use_ogp'] ) ? 1 : 0;
	$input['fb_app_id'] = wp_unslash( wp_filter_nohtml_kses( $input['fb_app_id'] ) );
	$input['ogp_image'] = wp_unslash( wp_filter_nohtml_kses( $input['ogp_image'] ) );

	// Twitter Cardsの設定
	$input['use_twitter_card'] = ! empty( $input['use_twitter_card'] ) ? 1 : 0;
	$input['twitter_account_name'] = wp_unslash( wp_filter_nohtml_kses( $input['twitter_account_name'] ) );

	// ソーシャルボタンの表示設定
	if ( ! isset( $input['sns_type_top'] ) || ! array_key_exists( $input['sns_type_top'], $sns_type_top_options ) )
		$input['sns_type_top'] = $dp_default_options['sns_type_top'];
	$input['show_sns_top'] = ! empty( $input['show_sns_top'] ) ? 1 : 0;
	$input['show_twitter_top'] = ! empty( $input['show_twitter_top'] ) ? 1 : 0;
	$input['show_fblike_top'] = ! empty( $input['show_fblike_top'] ) ? 1 : 0;
	$input['show_fbshare_top'] = ! empty( $input['show_fbshare_top'] ) ? 1 : 0;
	$input['show_google_top'] = ! empty( $input['show_google_top'] ) ? 1 : 0;
	$input['show_hatena_top'] = ! empty( $input['show_hatena_top'] ) ? 1 : 0;
	$input['show_pocket_top'] = ! empty( $input['show_pocket_top'] ) ? 1 : 0;
	$input['show_feedly_top'] = ! empty( $input['show_feedly_top'] ) ? 1 : 0;
	$input['show_rss_top'] = ! empty( $input['show_rss_top'] ) ? 1 : 0;
	$input['show_pinterest_top'] = ! empty( $input['show_pinterest_top'] ) ? 1 : 0;

	if ( ! isset( $input['sns_type_btm'] ) || ! array_key_exists( $input['sns_type_btm'], $sns_type_btm_options ) )
		$input['sns_type_btm'] = $dp_default_options['sns_type_btm'];
	$input['show_sns_btm'] = ! empty( $input['show_sns_btm'] ) ? 1 : 0;
	$input['show_twitter_btm'] = ! empty( $input['show_twitter_btm'] ) ? 1 : 0;
	$input['show_fblike_btm'] = ! empty( $input['show_fblike_btm'] ) ? 1 : 0;
	$input['show_fbshare_btm'] = ! empty( $input['show_fbshare_btm'] ) ? 1 : 0;
	$input['show_google_btm'] = ! empty( $input['show_google_btm'] ) ? 1 : 0;
	$input['show_hatena_btm'] = ! empty( $input['show_hatena_btm'] ) ? 1 : 0;
	$input['show_pocket_btm'] = ! empty( $input['show_pocket_btm'] ) ? 1 : 0;
	$input['show_feedly_btm'] = ! empty( $input['show_feedly_btm'] ) ? 1 : 0;
	$input['show_rss_btm'] = ! empty( $input['show_rss_btm'] ) ? 1 : 0;
	$input['show_pinterest_btm'] = ! empty( $input['show_pinterest_btm'] ) ? 1 : 0;

	// Google Maps
	$input['gmap_api_key'] = wp_unslash( wp_filter_nohtml_kses( $input['gmap_api_key'] ) );
	if ( ! isset( $input['gmap_marker_type'] ) || ! array_key_exists( $input['gmap_marker_type'], $gmap_marker_type_options ) )
		$input['gmap_marker_type'] = $dp_default_options['gmap_marker_type'];
	if ( ! isset( $input['gmap_custom_marker_type'] ) || ! array_key_exists( $input['gmap_custom_marker_type'], $gmap_custom_marker_type_options ) )
		$input['gmap_custom_marker_type'] = $dp_default_options['gmap_custom_marker_type'];
	$input['gmap_marker_text'] = wp_unslash( wp_filter_nohtml_kses( $input['gmap_marker_text'] ) );
	$input['gmap_marker_color'] = wp_unslash( wp_filter_nohtml_kses( $input['gmap_marker_color'] ) );
	$input['gmap_marker_img'] = wp_unslash( wp_filter_nohtml_kses( $input['gmap_marker_img'] ) );
	$input['gmap_marker_bg'] = wp_unslash( wp_filter_nohtml_kses( $input['gmap_marker_bg'] ) );

	// オリジナルスタイルの設定
	$input['css_code'] = $input['css_code'];

	// Custom head/script
	$input['custom_head'] = $input['custom_head'];

	// 検索設定
	$input['search_target_post_types'] = $input['search_target_post_types'];

	// ヘッダーのロゴ
	if ( ! isset( $input['use_header_logo_image'] ) || ! array_key_exists( $input['use_header_logo_image'], $logo_type_options ) )
		$input['use_header_logo_image'] = $dp_default_options['use_header_logo_image'];
	$input['header_logo_font_size'] = wp_unslash( wp_filter_nohtml_kses( $input['header_logo_font_size'] ) );
	$input['header_logo_image'] = wp_unslash( wp_filter_nohtml_kses( $input['header_logo_image'] ) );
	$input['header_logo_image_retina'] = ! empty( $input['header_logo_image_retina'] ) ? 1 : 0;

	// ヘッダーのロゴ（スマホ用）
	if ( ! isset( $input['use_header_logo_image_mobile'] ) || ! array_key_exists( $input['use_header_logo_image_mobile'], $logo_type_options ) )
		$input['use_header_logo_image_mobile'] = $dp_default_options['use_header_logo_image_mobile'];
	$input['header_logo_font_size_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['header_logo_font_size_mobile'] ) );
	$input['header_logo_image_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['header_logo_image_mobile'] ) );
	$input['header_logo_image_mobile_retina'] = ! empty( $input['header_logo_image_mobile_retina'] ) ? 1 : 0;

	// フッターのロゴ
	if ( ! isset( $input['use_footer_logo_image'] ) || ! array_key_exists( $input['use_footer_logo_image'], $logo_type_options ) )
		$input['use_footer_logo_image'] = $dp_default_options['use_footer_logo_image'];
	$input['footer_logo_font_size'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_logo_font_size'] ) );
	$input['footer_logo_image'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_logo_image'] ) );
	$input['footer_logo_image_retina'] = ! empty( $input['footer_logo_image_retina'] ) ? 1 : 0;

	// フッターのロゴ（スマホ用）
	if ( ! isset( $input['use_footer_logo_image_mobile'] ) || ! array_key_exists( $input['use_footer_logo_image_mobile'], $logo_type_options ) )
		$input['use_footer_logo_image_mobile'] = $dp_default_options['use_footer_logo_image_mobile'];
	$input['footer_logo_font_size_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_logo_font_size_mobile'] ) );
	$input['footer_logo_image_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_logo_image_mobile'] ) );
	$input['footer_logo_image_mobile_retina'] = ! empty( $input['footer_logo_image_mobile_retina'] ) ? 1 : 0;

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	for ( $i = 1; $i <= 5; $i++ ) {
		$input['slider_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_image' . $i] ) );
		$input['slider_image_sp' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_image_sp' . $i] ) );
		$input['slider_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_url' . $i] ) );
		$input['slider_target' . $i] = ! empty( $input['slider_target' . $i] ) ? 1 : 0;
		if ( ! isset( $input['slider_content_type' . $i] ) || ! array_key_exists( $input['slider_content_type' . $i], $slider_content_type_options ) )
			$input['slider_content_type' . $i] = $dp_default_options['slider_content_type' . $i];
		$input['slider_logo' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_logo' . $i] ) );
		$input['slider_logo_width' . $i] = absint( $input['slider_logo_width' . $i] );
		$input['slider_logo_width_mobile' . $i] = absint( $input['slider_logo_width_mobile' . $i] );
		$input['slider_catch' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch' . $i] ) );
		$input['slider_catch_vertical' . $i] = ! empty( $input['slider_catch_vertical' . $i] ) ? 1 : 0;
		$input['slider_catch_font_size' . $i] = absint( $input['slider_catch_font_size' . $i] );
		$input['slider_catch_font_size_mobile' . $i] = absint( $input['slider_catch_font_size_mobile' . $i] );
		$input['slider_catch_color' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch_color' . $i] ) );
		if ( ! isset( $input['slider_catch_font_type' . $i] ) || ! array_key_exists( $input['slider_catch_font_type' . $i], $font_type_options ) )
			$input['slider_catch_font_type' . $i] = $dp_default_options['slider_catch_font_type' . $i];
		if ( ! isset( $input['slider_catch_align' . $i] ) || ! array_key_exists( $input['slider_catch_align' . $i], $text_align_options ) )
			$input['slider_catch_align' . $i] = $dp_default_options['slider_catch_align' . $i];
		$input['slider_catch' . $i . '_shadow1'] = intval( $input['slider_catch' . $i . '_shadow1'] );
		$input['slider_catch' . $i . '_shadow2'] = intval( $input['slider_catch' . $i . '_shadow2'] );
		$input['slider_catch' . $i . '_shadow3'] = absint( $input['slider_catch' . $i . '_shadow3'] );
		$input['slider_catch' . $i . '_shadow_color'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch' . $i . '_shadow_color'] ) );
		$input['display_slider_desc' . $i] = ! empty( $input['display_slider_desc' . $i] ) ? 1 : 0;
		$input['slider_desc_font_size' . $i] = absint( $input['slider_desc_font_size' . $i] );
		$input['slider_desc_font_size_mobile' . $i] = absint( $input['slider_desc_font_size_mobile' . $i] );
		$input['slider_desc_color' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_desc_color' . $i] ) );
		if ( ! isset( $input['slider_desc_align' . $i] ) || ! array_key_exists( $input['slider_desc_align' . $i], $text_align_options ) )
			$input['slider_desc_align' . $i] = $dp_default_options['slider_desc_align' . $i];
		$input['slider_desc' . $i . '_shadow1'] = intval( $input['slider_desc' . $i . '_shadow1'] );
		$input['slider_desc' . $i . '_shadow2'] = intval( $input['slider_desc' . $i . '_shadow2'] );
		$input['slider_desc' . $i . '_shadow3'] = absint( $input['slider_desc' . $i . '_shadow3'] );
		$input['slider_desc' . $i . '_shadow_color'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_desc' . $i . '_shadow_color'] ) );
		$input['display_slider_button' . $i] = ! empty( $input['display_slider_button' . $i] ) ? 1 : 0;
		$input['slider_button_label' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_button_label' . $i] ) );
		$input['slider_button_font_color' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_button_font_color' . $i] ) );
		$input['slider_button_bg_color' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_button_bg_color' . $i] ) );
		$input['slider_button_font_color_hover' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_button_font_color_hover' . $i] ) );
		$input['slider_button_bg_color_hover' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_button_bg_color_hover' . $i] ) );
		$input['display_slider_overlay' . $i] = ! empty( $input['display_slider_overlay' . $i] ) ? 1 : 0;
		$input['slider_overlay_color' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_overlay_color' . $i] ) );
		$input['slider_overlay_opacity' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_overlay_opacity' . $i] ) );
		$input['display_slider_overlay_mobile' . $i] = ! empty( $input['display_slider_overlay_mobile' . $i] ) ? 1 : 0;
		$input['slider_overlay_color_mobile' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_overlay_color_mobile' . $i] ) );
		$input['slider_overlay_opacity_mobile' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['slider_overlay_opacity_mobile' . $i] ) );
	}

	if ( ! isset( $input['header_content_type'] ) || ! array_key_exists( $input['header_content_type'], $header_content_type_options ) )
		$input['header_content_type'] = $dp_default_options['header_content_type'];
	$input['slide_time_seconds'] = absint( $input['slide_time_seconds'] );

	// 画像スライダー スライド共通モバイル設定
	if ( ! isset( $input['slider_content_type_mobile'] ) || ! array_key_exists( $input['slider_content_type_mobile'], $slider_content_type_mobile_options ) )
		$input['slider_content_type_mobile'] = $dp_default_options['slider_content_type_mobile'];
	$input['slider_logo_mobile_type1'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_logo_mobile_type1'] ) );
	$input['slider_logo_width_mobile_type1'] = absint( $input['slider_logo_width_mobile_type1'] );
	$input['slider_catch_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch_mobile_type2'] ) );
	$input['slider_catch_vertical_mobile_type2'] = ! empty( $input['slider_catch_vertical_mobile_type2'] ) ? 1 : 0;
	$input['slider_catch_font_size_mobile_type2'] = absint( $input['slider_catch_font_size_mobile_type2'] );
	$input['slider_catch_color_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch_color_mobile_type2'] ) );
	if ( ! isset( $input['slider_catch_font_type_mobile_type2'] ) || ! array_key_exists( $input['slider_catch_font_type_mobile_type2'], $font_type_options ) )
		$input['slider_catch_font_type_mobile_type2'] = $dp_default_options['slider_catch_font_type_mobile_type2'];
	if ( ! isset( $input['slider_catch_align_mobile_type2'] ) || ! array_key_exists( $input['slider_catch_align_mobile_type2'], $text_align_options ) )
		$input['slider_catch_align_mobile_type2'] = $dp_default_options['slider_catch_align_mobile_type2'];
	$input['slider_catch_shadow1_mobile_type2'] = intval( $input['slider_catch_shadow1_mobile_type2'] );
	$input['slider_catch_shadow2_mobile_type2'] = intval( $input['slider_catch_shadow2_mobile_type2'] );
	$input['slider_catch_shadow3_mobile_type2'] = absint( $input['slider_catch_shadow3_mobile_type2'] );
	$input['slider_catch_shadow_color_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['slider_catch_shadow_color_mobile_type2'] ) );

	// Video
	$input['header_video'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video'] ) );
	$input['header_video_image'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_image'] ) );

	// Youtube
	$input['header_youtube_url'] = wp_unslash( wp_filter_nohtml_kses( $input['header_youtube_url'] ) );
	$input['header_youtube_image'] = wp_unslash( wp_filter_nohtml_kses( $input['header_youtube_image'] ) );

	// Video/Youtubeコンテンツ
	$input['header_video_link_url'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_link_url'] ) );
	$input['header_video_target'] = ! empty( $input['header_video_target'] ) ? 1 : 0;
	if ( ! isset( $input['header_video_content_type'] ) || ! array_key_exists( $input['header_video_content_type'], $slider_content_type_options ) )
		$input['header_video_content_type'] = $dp_default_options['header_video_content_type' . $i];
	$input['header_video_logo'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_logo'] ) );
	$input['header_video_logo_width'] = absint( $input['header_video_logo_width'] );
	$input['header_video_catch'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch'] ) );
	$input['header_video_catch_vertical'] = ! empty( $input['header_video_catch_vertical'] ) ? 1 : 0;
	$input['header_video_catch_font_size'] = absint( $input['header_video_catch_font_size'] );
	$input['header_video_catch_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch_color'] ) );
	if ( ! isset( $input['header_video_catch_font_type'] ) || ! array_key_exists( $input['header_video_catch_font_type'], $font_type_options ) )
		$input['header_video_catch_font_type'] = $dp_default_options['header_video_catch_font_type'];
	if ( ! isset( $input['header_video_catch_align'] ) || ! array_key_exists( $input['header_video_catch_align'], $text_align_options ) )
		$input['header_video_catch_align'] = $dp_default_options['header_video_catch_align'];
	$input['header_video_catch_shadow1'] = intval( $input['header_video_catch_shadow1'] );
	$input['header_video_catch_shadow2'] = intval( $input['header_video_catch_shadow2'] );
	$input['header_video_catch_shadow3'] = absint( $input['header_video_catch_shadow3'] );
	$input['header_video_catch_shadow_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch_shadow_color'] ) );
	$input['display_header_video_desc'] = ! empty( $input['display_header_video_desc'] ) ? 1 : 0;
	$input['header_video_desc_font_size'] = absint( $input['header_video_desc_font_size'] );
	$input['header_video_desc_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_desc_color'] ) );
	if ( ! isset( $input['header_video_desc_align'] ) || ! array_key_exists( $input['header_video_desc_align'], $text_align_options ) )
		$input['header_video_desc_align'] = $dp_default_options['header_video_desc_align'];
	$input['header_video_desc_shadow1'] = intval( $input['header_video_desc_shadow1'] );
	$input['header_video_desc_shadow2'] = intval( $input['header_video_desc_shadow2'] );
	$input['header_video_desc_shadow3'] = absint( $input['header_video_desc_shadow3'] );
	$input['header_video_desc_shadow_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_desc_shadow_color'] ) );
	$input['display_header_video_button'] = ! empty( $input['display_header_video_button'] ) ? 1 : 0;
	$input['header_video_button_label'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_button_label'] ) );
	$input['header_video_button_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_button_font_color'] ) );
	$input['header_video_button_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_button_bg_color'] ) );
	$input['header_video_button_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_button_font_color_hover'] ) );
	$input['header_video_button_bg_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_button_bg_color_hover'] ) );
	$input['display_header_video_overlay'] = ! empty( $input['display_header_video_overlay'] ) ? 1 : 0;
	$input['header_video_overlay_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_overlay_color'] ) );
	$input['header_video_overlay_opacity'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_overlay_opacity'] ) );
	if ( ! isset( $input['header_video_content_type_mobile'] ) || ! array_key_exists( $input['header_video_content_type_mobile'], $slider_content_type_mobile_options ) )
		$input['header_video_content_type_mobile'] = $dp_default_options['header_video_content_type_mobile'];
	$input['header_video_logo_width_mobile'] = absint( $input['header_video_logo_width_mobile'] );
	$input['header_video_catch_font_size_mobile'] = absint( $input['header_video_catch_font_size_mobile'] );
	$input['header_video_desc_font_size_mobile'] = absint( $input['header_video_desc_font_size_mobile'] );
	$input['header_video_logo_mobile_type1'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_logo_mobile_type1'] ) );
	$input['header_video_logo_width_mobile_type1'] = absint( $input['header_video_logo_width_mobile_type1'] );
	$input['header_video_catch_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch_mobile_type2'] ) );
	$input['header_video_catch_vertical_mobile_type2'] = ! empty( $input['header_video_catch_vertical_mobile_type2'] ) ? 1 : 0;
	$input['header_video_catch_font_size_mobile_type2'] = absint( $input['header_video_catch_font_size_mobile_type2'] );
	$input['header_video_catch_color_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch_color_mobile_type2'] ) );
	if ( ! isset( $input['header_video_catch_font_type_mobile_type2'] ) || ! array_key_exists( $input['header_video_catch_font_type_mobile_type2'], $font_type_options ) )
		$input['header_video_catch_font_type_mobile_type2'] = $dp_default_options['header_video_catch_font_type_mobile_type2'];
	if ( ! isset( $input['header_video_catch_align_mobile_type2'] ) || ! array_key_exists( $input['header_video_catch_align_mobile_type2'], $text_align_options ) )
		$input['header_video_catch_align_mobile_type2'] = $dp_default_options['header_video_catch_align_mobile_type2'];
	$input['header_video_catch_shadow1_mobile_type2'] = intval( $input['header_video_catch_shadow1_mobile_type2'] );
	$input['header_video_catch_shadow2_mobile_type2'] = intval( $input['header_video_catch_shadow2_mobile_type2'] );
	$input['header_video_catch_shadow3_mobile_type2'] = absint( $input['header_video_catch_shadow3_mobile_type2'] );
	$input['header_video_catch_shadow_color_mobile_type2'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_catch_shadow_color_mobile_type2'] ) );
	$input['display_header_video_overlay_mobile'] = ! empty( $input['display_header_video_overlay_mobile'] ) ? 1 : 0;
	$input['header_video_overlay_color_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_overlay_color_mobile'] ) );
	$input['header_video_overlay_opacity_mobile'] = wp_unslash( wp_filter_nohtml_kses( $input['header_video_overlay_opacity_mobile'] ) );

	// ニュースティッカーの設定
	$input['show_index_newsticker'] = ! empty( $input['show_index_newsticker'] ) ? 1 : 0;
	$input['index_newsticker_num'] = absint( $input['index_newsticker_num'] );
	$input['show_index_newsticker_date'] = ! empty( $input['show_index_newsticker_date'] ) ? 1 : 0;
	$input['index_newsticker_archive_link_text'] = wp_unslash( wp_filter_nohtml_kses( $input['index_newsticker_archive_link_text'] ) );
	$input['index_newsticker_archive_link_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['index_newsticker_archive_link_font_color'] ) );
	$input['index_newsticker_archive_link_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['index_newsticker_archive_link_bg_color'] ) );
	$input['index_newsticker_archive_link_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['index_newsticker_archive_link_font_color_hover'] ) );
	$input['index_newsticker_archive_link_bg_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['index_newsticker_archive_link_bg_color_hover'] ) );
	$input['index_newsticker_slide_time_seconds'] = absint( $input['index_newsticker_slide_time_seconds'] );

	/**
	 * ブログ
	 */
	 // ブログの設定
	$input['blog_label'] = wp_unslash( wp_filter_nohtml_kses( $input['blog_label'] ) );
	$input['blog_header_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['blog_header_headline'] ) );
	$input['blog_header_desc'] = wp_unslash( wp_filter_nohtml_kses( $input['blog_header_desc'] ) );

	// 記事詳細ページの設定
	$input['title_font_size'] = absint( $input['title_font_size'] );
	$input['title_font_size_mobile'] = absint( $input['title_font_size_mobile'] );
	$input['title_color'] = wp_unslash( wp_filter_nohtml_kses( $input['title_color'] ) );
	$input['content_font_size'] = absint( $input['content_font_size'] );
	$input['content_font_size_mobile'] = absint( $input['content_font_size_mobile'] );
	$input['content_color'] = wp_unslash( wp_filter_nohtml_kses( $input['content_color'] ) );
	if ( ! isset( $input['page_link'] ) || ! array_key_exists( $input['page_link'], $page_link_options ) )
		$input['page_link'] = $dp_default_options['page_link'];

	// 表示設定
	$input['show_breadcrumb_archive'] = ! empty( $input['show_breadcrumb_archive'] ) ? 1 : 0;
	$input['show_breadcrumb_single'] = ! empty( $input['show_breadcrumb_single'] ) ? 1 : 0;
	$input['show_date_archive'] = ! empty( $input['show_date_archive'] ) ? 1 : 0;
	$input['show_category_archive'] = ! empty( $input['show_category_archive'] ) ? 1 : 0;
	$input['show_comments_number_archive'] = ! empty( $input['show_comments_number_archive'] ) ? 1 : 0;
	$input['show_views_number_archive'] = ! empty( $input['show_views_number_archive'] ) ? 1 : 0;
	$input['show_likes_number_archive'] = ! empty( $input['show_likes_number_archive'] ) ? 1 : 0;
	$input['show_views_number'] = ! empty( $input['show_views_number'] ) ? 1 : 0;
	$input['show_likes_number'] = ! empty( $input['show_likes_number'] ) ? 1 : 0;
	$input['show_thumbnail'] = ! empty( $input['show_thumbnail'] ) ? 1 : 0;
	$input['show_date'] = ! empty( $input['show_date'] ) ? 1 : 0;
	$input['show_category'] = ! empty( $input['show_category'] ) ? 1 : 0;
	$input['show_tag'] = ! empty( $input['show_tag'] ) ? 1 : 0;
	$input['show_author_sns'] = ! empty( $input['show_author_sns'] ) ? 1 : 0;
	$input['show_report'] = ! empty( $input['show_report'] ) ? 1 : 0;
	$input['show_next_post'] = ! empty( $input['show_next_post'] ) ? 1 : 0;
	$input['show_comment'] = ! empty( $input['show_comment'] ) ? 1 : 0;
	$input['show_trackback'] = ! empty( $input['show_trackback'] ) ? 1 : 0;
	if ( ! isset( $input['comment_type'] ) || ! array_key_exists( $input['comment_type'], $comment_type_options ) )
		$input['comment_type'] = $dp_default_options['comment_type'];

	// 関連記事の設定
	$input['show_related_post'] = ! empty( $input['show_related_post'] ) ? 1 : 0;
	$input['related_post_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['related_post_headline'] ) );
	$input['related_post_num'] = absint( $input['related_post_num'] );

	// 記事ページの広告設定1, 2
	for ( $i = 1; $i <= 4; $i++ ) {
		$input['single_ad_code' . $i] = $input['single_ad_code' . $i];
		$input['single_ad_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['single_ad_image' . $i] ) );
		$input['single_ad_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['single_ad_url' . $i] ) );
	}

	// スマートフォン専用の広告
	$input['single_mobile_ad_code1'] = $input['single_mobile_ad_code1'];
	$input['single_mobile_ad_image1'] = wp_unslash( wp_filter_nohtml_kses( $input['single_mobile_ad_image1'] ) );
	$input['single_mobile_ad_url1'] = wp_unslash( wp_filter_nohtml_kses( $input['single_mobile_ad_url1'] ) );

	/**
	 * 写真
	 */
	 // Photoの設定
	$input['photo_label'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_label'] ) );
	if ( ! $input['photo_label'] )
		$input['photo_label'] = $dp_default_options['photo_label'];
	if ( $input['photo_slug'] )
		$input['photo_slug'] = trim( $input['photo_slug'] );
	if ( ! $input['photo_slug'] )
		$input['photo_slug'] = $dp_default_options['photo_slug'];
	$input['photo_slug'] = sanitize_title( $input['photo_slug'] );
	$input['photo_category_label'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_category_label'] ) );
	if ( ! $input['photo_category_label'] )
		$input['photo_category_label'] = $dp_default_options['photo_category_label'];
	if ( $input['photo_category_slug'] )
		$input['photo_category_slug'] = trim( $input['photo_category_slug'] );
	if ( ! $input['photo_category_slug'] )
		$input['photo_category_slug'] = $dp_default_options['photo_category_slug'];
	$input['photo_category_slug'] = sanitize_title( $input['photo_category_slug'] );

	$input['photo_header_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_header_headline'] ) );
	$input['photo_header_desc'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_header_desc'] ) );
	// Photoページの設定
	$input['photo_title_font_size'] = absint( $input['photo_title_font_size'] );
	$input['photo_title_font_size_mobile'] = absint( $input['photo_title_font_size_mobile'] );
	$input['photo_title_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_title_color'] ) );
	$input['photo_content_font_size'] = absint( $input['photo_content_font_size'] );
	$input['photo_content_font_size_mobile'] = absint( $input['photo_content_font_size_mobile'] );
	$input['photo_content_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_content_color'] ) );

	// 表示設定
	$input['show_breadcrumb_archive_photo'] = ! empty( $input['show_breadcrumb_archive_photo'] ) ? 1 : 0;
	$input['show_breadcrumb_single_photo'] = ! empty( $input['show_breadcrumb_single_photo'] ) ? 1 : 0;
	$input['show_date_archive_photo'] = ! empty( $input['show_date_archive_photo'] ) ? 1 : 0;
	$input['show_category_archive_photo'] = ! empty( $input['show_category_archive_photo'] ) ? 1 : 0;
	$input['show_comments_number_archive_photo'] = ! empty( $input['show_comments_number_archive_photo'] ) ? 1 : 0;
	$input['show_views_number_archive_photo'] = ! empty( $input['show_views_number_archive_photo'] ) ? 1 : 0;
	$input['show_likes_number_archive_photo'] = ! empty( $input['show_likes_number_archive_photo'] ) ? 1 : 0;
	$input['show_date_photo'] = ! empty( $input['show_date_photo'] ) ? 1 : 0;
	$input['show_category_photo'] = ! empty( $input['show_category_photo'] ) ? 1 : 0;
	$input['show_views_number_photo'] = ! empty( $input['show_views_number_photo'] ) ? 1 : 0;
	$input['show_likes_number_photo'] = ! empty( $input['show_likes_number_photo'] ) ? 1 : 0;
	$input['show_author_sns_photo'] = ! empty( $input['show_author_sns_photo'] ) ? 1 : 0;
	$input['show_sns_btm_photo'] = ! empty( $input['show_sns_btm_photo'] ) ? 1 : 0;
	$input['show_report_photo'] = ! empty( $input['show_report_photo'] ) ? 1 : 0;
	$input['show_comment_photo'] = ! empty( $input['show_comment_photo'] ) ? 1 : 0;
	$input['show_trackback_photo'] = ! empty( $input['show_trackback_photo'] ) ? 1 : 0;
	$input['photo_author_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_author_headline'] ) );
	$input['photo_author_headline_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_author_headline_font_color'] ) );
	$input['photo_author_headline_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_author_headline_bg_color'] ) );
	$input['photo_comment_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_comment_headline'] ) );
	$input['photo_comment_headline_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_comment_headline_font_color'] ) );
	$input['photo_comment_headline_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_comment_headline_bg_color'] ) );
	if ( ! isset( $input['comment_type_photo'] ) || ! array_key_exists( $input['comment_type'], $comment_type_options ) )
		$input['comment_type_photo'] = $dp_default_options['comment_type_photo'];

	// 記事ページの広告設定1
	for ( $i = 1; $i <= 2; $i++ ) {
		$input['photo_single_ad_code' . $i] = $input['photo_single_ad_code' . $i];
		$input['photo_single_ad_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['photo_single_ad_image' . $i] ) );
		$input['photo_single_ad_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['photo_single_ad_url' . $i] ) );
	}

	// スマートフォン専用の広告
	$input['photo_single_mobile_ad_code1'] = $input['photo_single_mobile_ad_code1'];
	$input['photo_single_mobile_ad_image1'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_single_mobile_ad_image1'] ) );
	$input['photo_single_mobile_ad_url1'] = wp_unslash( wp_filter_nohtml_kses( $input['photo_single_mobile_ad_url1'] ) );

	/**
	 * Information
	 */
	 // お知らせの設定
	$input['information_label'] = wp_unslash( wp_filter_nohtml_kses( $input['information_label'] ) );
	if ( ! $input['information_label'] )
		$input['information_label'] = $dp_default_options['information_label'];
	if ( $input['information_slug'] )
		$input['information_slug'] = trim( $input['information_slug'] );
	if ( ! $input['information_slug'] )
		$input['information_slug'] = $dp_default_options['information_slug'];
	$input['information_slug'] = sanitize_title( $input['information_slug'] );
	$input['information_header_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['information_header_headline'] ) );
	$input['information_header_desc'] = wp_unslash( wp_filter_nohtml_kses( $input['information_header_desc'] ) );

	// お知らせページの設定
	$input['information_content_font_size'] = absint( $input['information_content_font_size'] );
	$input['information_content_font_size_mobile'] = absint( $input['information_content_font_size_mobile'] );
	$input['information_content_color'] = wp_unslash( wp_filter_nohtml_kses( $input['information_content_color'] ) );

	// お知らせ表示設定
	$input['archive_information_num'] = absint( $input['archive_information_num'] );
	$input['show_breadcrumb_archive_information'] = ! empty( $input['show_breadcrumb_archive_information'] ) ? 1 : 0;
	$input['show_date_information'] = ! empty( $input['show_date_information'] ) ? 1 : 0;

	/**
	 * Header
	 */
	// ヘッダーバーの表示設定
	if ( ! isset( $input['header_bar'] ) || ! array_key_exists( $input['header_bar'], $header_bar_options ) )
		$input['header_bar'] = $dp_default_options['header_bar'];
	if ( ! isset( $input['header_bar_mobile'] ) || ! array_key_exists( $input['header_bar_mobile'], $header_bar_options ) )
		$input['header_bar_mobile'] = $dp_default_options['header_bar_mobile'];
	if ( ! isset( $input['header_bar_photo'] ) || ! array_key_exists( $input['header_bar_photo'], $header_bar_options ) )
		$input['header_bar_photo'] = $dp_default_options['header_bar_photo'];
	if ( ! isset( $input['header_bar_photo_mobile'] ) || ! array_key_exists( $input['header_bar_photo_mobile'], $header_bar_options ) )
		$input['header_bar_photo_mobile'] = $dp_default_options['header_bar_photo_mobile'];
	// ヘッダーバーの色の設定
	$input['header_bg'] = wp_unslash( wp_filter_nohtml_kses( $input['header_bg'] ) );
	$input['header_opacity'] = wp_unslash( wp_filter_nohtml_kses( $input['header_opacity'] ) );
	$input['header_opacity_fixed'] = wp_unslash( wp_filter_nohtml_kses( $input['header_opacity_fixed'] ) );
	$input['header_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['header_font_color'] ) );
	$input['header_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['header_font_color_hover'] ) );

	// ドロップダウンメンバーメニュー設定
	$input['membermenu_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['membermenu_font_color'] ) );
	$input['membermenu_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['membermenu_font_color_hover'] ) );
	$input['membermenu_badge_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['membermenu_badge_font_color'] ) );
	$input['membermenu_badge_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['membermenu_badge_bg_color'] ) );
	$input['membermenu_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['membermenu_bg_color'] ) );

	// サイドメニュー設定
	$input['sidemenu_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_font_color'] ) );
	$input['sidemenu_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_font_color_hover'] ) );
	$input['sidemenu_title_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_title_font_color'] ) );
	$input['sidemenu_title_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_title_bg_color'] ) );
	$input['sidemenu_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_bg_color'] ) );
	$input['show_sidemenu_category'] = ! empty( $input['show_sidemenu_category'] ) ? 1 : 0;
	$input['sidemenu_category_label'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_category_label'] ) );
	$input['sidemenu_category_exclude'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_category_exclude'] ) );
	$input['show_sidemenu_photo_category'] = ! empty( $input['show_sidemenu_photo_category'] ) ? 1 : 0;
	$input['sidemenu_photo_category_label'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_photo_category_label'] ) );
	$input['sidemenu_photo_category_exclude'] = wp_unslash( wp_filter_nohtml_kses( $input['sidemenu_photo_category_exclude'] ) );
	$input['sidemenu_photo_category_show_first'] = ! empty( $input['sidemenu_photo_category_show_first'] ) ? 1 : 0;
	$input['show_sidemenu_globalmenu'] = ! empty( $input['show_sidemenu_globalmenu'] ) ? 1 : 0;
	$input['show_sidemenu_search'] = ! empty( $input['show_sidemenu_search'] ) ? 1 : 0;
	$input['show_sidemenu_widget'] = ! empty( $input['show_sidemenu_widget'] ) ? 1 : 0;

	/**
	 * Footer
	 */
	// フッター上ウィジェット
	$input['show_above_footer_widget_front'] = ! empty( $input['show_above_footer_widget_front'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_post'] = ! empty( $input['show_above_footer_widget_archive_post'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_photo'] = ! empty( $input['show_above_footer_widget_archive_photo'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_information'] = ! empty( $input['show_above_footer_widget_archive_information'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_category'] = ! empty( $input['show_above_footer_widget_archive_category'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_photo_category'] = ! empty( $input['show_above_footer_widget_archive_photo_category'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_tag'] = ! empty( $input['show_above_footer_widget_archive_tag'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_date'] = ! empty( $input['show_above_footer_widget_archive_date'] ) ? 1 : 0;
	$input['show_above_footer_widget_archive_search'] = ! empty( $input['show_above_footer_widget_archive_search'] ) ? 1 : 0;
	$input['show_above_footer_widget_single_post'] = ! empty( $input['show_above_footer_widget_single_post'] ) ? 1 : 0;
	$input['show_above_footer_widget_single_page'] = ! empty( $input['show_above_footer_widget_single_page'] ) ? 1 : 0;
	$input['show_above_footer_widget_single_photo'] = ! empty( $input['show_above_footer_widget_single_photo'] ) ? 1 : 0;
	$input['show_above_footer_widget_author'] = ! empty( $input['show_above_footer_widget_author'] ) ? 1 : 0;
	$input['show_above_footer_widget_404'] = ! empty( $input['show_above_footer_widget_404'] ) ? 1 : 0;
	$input['show_above_footer_widget_login'] = ! empty( $input['show_above_footer_widget_login'] ) ? 1 : 0;
	$input['show_above_footer_widget_registration'] = ! empty( $input['show_above_footer_widget_registration'] ) ? 1 : 0;
	$input['show_above_footer_widget_registration_account'] = ! empty( $input['show_above_footer_widget_registration_account'] ) ? 1 : 0;
	$input['show_above_footer_widget_reset_password'] = ! empty( $input['show_above_footer_widget_reset_password'] ) ? 1 : 0;
	$input['show_above_footer_widget_mypage_news'] = ! empty( $input['show_above_footer_widget_mypage_news'] ) ? 1 : 0;
	$input['show_above_footer_widget_mypage_add_photo'] = ! empty( $input['show_above_footer_widget_mypage_add_photo'] ) ? 1 : 0;
	$input['show_above_footer_widget_mypage_add_blog'] = ! empty( $input['show_above_footer_widget_mypage_add_blog'] ) ? 1 : 0;
	$input['show_above_footer_widget_mypage_profile'] = ! empty( $input['show_above_footer_widget_mypage_profile'] ) ? 1 : 0;
	$input['show_above_footer_widget_mypage_account'] = ! empty( $input['show_above_footer_widget_mypage_account'] ) ? 1 : 0;

	// フッターブログコンテンツの設定
	$input['show_footer_blog_top'] = ! empty( $input['show_footer_blog_top'] ) ? 1 : 0;
	$input['show_footer_blog'] = ! empty( $input['show_footer_blog'] ) ? 1 : 0;
	if ( ! isset( $input['footer_blog_list_type'] ) || ! array_key_exists( $input['footer_blog_list_type'], $list_type_options ) )
		$input['footer_blog_list_type'] = $dp_default_options['footer_blog_list_type'];
	$input['footer_blog_category'] = intval( $input['footer_blog_category'] );
	$input['footer_blog_num'] = absint( $input['footer_blog_num'] );
	if ( ! isset( $input['footer_blog_post_order'] ) || ! array_key_exists( $input['footer_blog_post_order'], $post_order_options ) )
		$input['footer_blog_post_order'] = $dp_default_options['footer_blog_post_order'];
	$input['show_footer_blog_category'] = ! empty( $input['show_footer_blog_category'] ) ? 1 : 0;
	$input['footer_blog_slide_time_seconds'] = absint( $input['footer_blog_slide_time_seconds'] );
	$input['footer_blog_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_blog_bg_color'] ) );

	// フッターウィジェット
	$input['footer_widget_title_color'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_widget_title_color'] ) );
	$input['footer_widget_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_widget_font_color'] ) );
	$input['footer_widget_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_widget_font_color_hover'] ) );
	$input['footer_widget_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_widget_bg_color'] ) );

	// SNSボタンの設定
	$input['instagram_url'] = wp_unslash( wp_filter_nohtml_kses( $input['instagram_url'] ) );
	$input['twitter_url'] = wp_unslash( wp_filter_nohtml_kses( $input['twitter_url'] ) );
	$input['pinterest_url'] = wp_unslash( wp_filter_nohtml_kses( $input['pinterest_url'] ) );
	$input['facebook_url'] = wp_unslash( wp_filter_nohtml_kses( $input['facebook_url'] ) );
	$input['googleplus_url'] = wp_unslash( wp_filter_nohtml_kses( $input['googleplus_url'] ) );
	$input['youtube_url'] = wp_unslash( wp_filter_nohtml_kses( $input['youtube_url'] ) );
	$input['contact_url'] = wp_unslash( wp_filter_nohtml_kses( $input['contact_url'] ) );
	$input['show_rss'] = ! empty( $input['show_rss'] ) ? 1 : 0;

	// コピーライトの設定
	$input['copyright_font_color'] = wp_unslash( wp_filter_nohtml_kses( $input['copyright_font_color'] ) );
	$input['copyright_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $input['copyright_bg_color'] ) );

	// スマホ用固定フッターバーの設定
	if ( ! isset( $input['footer_bar_display'] ) || ! array_key_exists( $input['footer_bar_display'], $footer_bar_display_options ) )
		$input['footer_bar_display'] = 'type3';
	$input['footer_bar_bg'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_bar_bg'] ) );
	$input['footer_bar_border'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_bar_border'] ) );
	$input['footer_bar_color'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_bar_color'] ) );
	$input['footer_bar_tp'] = wp_unslash( wp_filter_nohtml_kses( $input['footer_bar_tp'] ) );
	$footer_bar_btns = array();
	if ( empty( $input['repeater_footer_bar_btns'] ) && ! empty( $input['footer_bar_btns'] ) && is_array( $input['footer_bar_btns'] ) ) {
		$input['repeater_footer_bar_btns'] = $input['footer_bar_btns'];
	}
	if ( isset( $input['repeater_footer_bar_btns'] ) ) {
		foreach ( $input['repeater_footer_bar_btns'] as $key => $value ) {
			$footer_bar_btns[] = array(
				'type' => ( isset( $input['repeater_footer_bar_btns'][$key]['type'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['type'], $footer_bar_button_options ) ) ? $input['repeater_footer_bar_btns'][$key]['type'] : 'type1',
				'label' => isset( $input['repeater_footer_bar_btns'][$key]['label'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['label'] ) : '',
				'url' => isset( $input['repeater_footer_bar_btns'][$key]['url'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['url'] ) : '',
				'number' => isset( $input['repeater_footer_bar_btns'][$key]['number'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['number'] ) : '',
				'target' => ! empty( $input['repeater_footer_bar_btns'][$key]['target'] ) ? 1 : 0,
				'icon' => ( isset( $input['repeater_footer_bar_btns'][$key]['icon'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['icon'], $footer_bar_icon_options ) ) ? $input['repeater_footer_bar_btns'][$key]['icon'] : 'file-text'
			);
		}
		unset( $input['repeater_footer_bar_btns'] );
	}
	$input['footer_bar_btns'] = $footer_bar_btns;

	/**
	 * 404 ページ
	 */
	$input['image_404'] = wp_unslash( wp_filter_nohtml_kses( $input['image_404'] ) );
	$input['overlay_404'] = wp_unslash( wp_filter_nohtml_kses( $input['overlay_404'] ) );
	$input['overlay_opacity_404'] = floatval( $input['overlay_opacity_404'] );
	$input['catchphrase_404'] = wp_unslash( wp_filter_nohtml_kses( $input['catchphrase_404'] ) );
	$input['catchphrase_font_size_404'] = absint( $input['catchphrase_font_size_404'] );
	$input['catchphrase_font_size_404_mobile'] = absint( $input['catchphrase_font_size_404_mobile'] );
	if ( ! isset( $input['catchphrase_font_type_404'] ) || ! array_key_exists( $input['catchphrase_font_type_404'], $headline_font_type_options ) )
		$input['catchphrase_font_type_404'] = $dp_default_options['catchphrase_font_type_404'];
	$input['desc_404'] = wp_unslash( wp_filter_nohtml_kses( $input['desc_404'] ) );
	$input['desc_font_size_404'] = absint( $input['desc_font_size_404'] );
	$input['desc_font_size_404_mobile'] = absint( $input['desc_font_size_404_mobile'] );
	$input['color_404'] = wp_unslash( wp_filter_nohtml_kses( $input['color_404'] ) );
	$input['shadow1_404'] = intval( $input['shadow1_404'] );
	$input['shadow2_404'] = intval( $input['shadow2_404'] );
	$input['shadow3_404'] = absint( $input['shadow3_404'] );
	$input['shadow_color_404'] = wp_unslash( wp_filter_nohtml_kses( $input['shadow_color_404'] ) );

	/**
	 * 保護ページ
	 */
	$input['pw_label'] = wp_unslash( wp_filter_nohtml_kses( $input['pw_label'] ) );
	if ( ! isset( $input['pw_align'] ) || ! array_key_exists( $input['pw_align'], $pw_align_options ) )
		$input['pw_align'] = $dp_default_options['pw_align'];
	for ( $i = 1; $i <= 5; $i++ ) {
		$input['pw_name' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['pw_name' . $i] ) );
		$input['pw_btn_display' . $i] = ! empty( $input['pw_btn_display' . $i] ) ? 1 : 0;
		$input['pw_btn_label' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['pw_btn_label' . $i] ) );
		$input['pw_btn_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['pw_btn_url' . $i] ) );
		$input['pw_btn_target' . $i] = ! empty( $input['pw_btn_target' . $i] ) ? 1 : 0;
		$input['pw_editor' . $i] = $input['pw_editor' . $i];
	}

	// コンテンツビルダー
	$input = cb_validate( $input );

	// スラッグ変更チェック
	$is_slug_change = false;

	foreach( array( 'information_slug', 'photo_slug' ) as $post_type_slug ) {
		if ( $dp_options[$post_type_slug] !== $input[$post_type_slug] ) {
			register_post_type( $input[$post_type_slug], array(
				'label' => $input[$post_type_slug],
				'public' => true,
				'has_archive' => true,
				'hierarchical' => false
			) );
			$is_slug_change = true;
		}
	}

	foreach( array( 'photo_category_slug' => 'photo_slug' ) as $tax_slug => $post_type_slug ) {
		if ( $dp_options[$tax_slug] !== $input[$tax_slug] && 'category' !== $input[$tax_slug] ) {
			register_taxonomy(
				$input[$tax_slug],
				$input[$post_type_slug],
				array(
					'label' => $input[$tax_slug],
					'public' => true,
					'hierarchical' => true,
				)
			);
		}
	}

	if ( $is_slug_change ) {
		flush_rewrite_rules( false );
	}

	// TCD Membership optionsのフォーム送信時以外での更新
	if ( empty( $_POST['tcd_membership_options'] ) ) {
		// membershipがあればvalidate実行
		if ( isset( $input['membership'] ) ) {
			$input = tcd_membership_options_validate( $input );
		// membershipがなければ現設定に入力値をマージ
		} else {
			$input = array_merge( $dp_options, (array) $input );
		}
	}

	return $input;
}
