<?php

/**
 * Translation
 */
load_theme_textdomain( 'tcd-w', get_template_directory() . '/languages' );

/**
 * Theme setup
 */
function zoomy_setup() {
	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, false );

	// Title tag
	add_theme_support( 'title-tag' );

	// Image sizes メディア登録しないアップロードと連動してますのでサムネイル名変更時は注意
	add_image_size( 'size1', 300, 300, true );
	add_image_size( 'size2', 600, 600, true );
	add_image_size( 'size3', 850, 0, false );
	add_image_size( 'size-photo1', 1200, 675, false );	// 写真 横長
	add_image_size( 'size-photo2', 675, 1000, false );	// 写真 縦長
	add_image_size( 'size-photo3', 675, 675, false );	// 写真 正方形
	add_image_size( 'size-card', 300, 300, true ); // カードリンクパーツ用

	// imgタグのsrcsetを未使用に
	add_filter( 'wp_calculate_image_srcset', '__return_empty_array' );

	// Menu
	register_nav_menus( array(
		'global' => __( 'Global menu (Displayed in side menu)', 'tcd-w' )
	) );
}
add_action( 'after_setup_theme', 'zoomy_setup' );

/**
 * Theme init
 */
function zoomy_init() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// Emoji
	if ( 0 == $dp_options['use_emoji'] ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	// カスタム投稿 photo
	register_post_type( $dp_options['photo_slug'], array(
		'label' => $dp_options['photo_label'],
		'labels' => array(
			'name' => $dp_options['photo_label'],
			'singular_name' => $dp_options['photo_label'],
			'add_new' => __( 'Add New', 'tcd-w' ),
			'add_new_item' => __( 'Add New Item', 'tcd-w' ),
			'edit_item' => __( 'Edit', 'tcd-w' ),
			'new_item' => __( 'New item', 'tcd-w' ),
			'view_item' => __( 'View Item', 'tcd-w' ),
			'search_items' => __( 'Search Items', 'tcd-w' ),
			'not_found' => __( 'Not Found', 'tcd-w' ),
			'not_found_in_trash' => __( 'Not found in trash', 'tcd-w' ),
			'parent_item_colon' => ''
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_position' => 5,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'comments', 'trackbacks' )
	) );

	if ( 'category' !== $dp_options['photo_category_slug'] ) {
		register_taxonomy(
			$dp_options['photo_category_slug'],
			$dp_options['photo_slug'],
			array(
				'label' => $dp_options['photo_category_label'],
				'labels' => array(
					'name' => $dp_options['photo_category_label'],
					'singular_name' => $dp_options['photo_category_label']
				),
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
			)
		);
	}

	// カスタム投稿 お知らせ
	register_post_type( $dp_options['information_slug'], array(
		'label' => $dp_options['information_label'],
		'labels' => array(
			'name' => $dp_options['information_label'],
			'singular_name' => $dp_options['information_label'],
			'add_new' => __( 'Add New', 'tcd-w' ),
			'add_new_item' => __( 'Add New Item', 'tcd-w' ),
			'edit_item' => __( 'Edit', 'tcd-w' ),
			'new_item' => __( 'New item', 'tcd-w' ),
			'view_item' => __( 'View Item', 'tcd-w' ),
			'search_items' => __( 'Search Items', 'tcd-w' ),
			'not_found' => __( 'Not Found', 'tcd-w' ),
			'not_found_in_trash' => __( 'Not found in trash', 'tcd-w' ),
			'parent_item_colon' => ''
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_position' => 5,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'supports' => array( 'editor' )
	) );
}
add_action( 'init', 'zoomy_init' );

/**
 * Theme scripts and style
 */
function zoomy_scripts() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// 共通
	wp_enqueue_style( 'zoomy-style', get_stylesheet_uri(), array(), version_num() );
	wp_enqueue_script( 'zoomy-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), version_num(), true );
	wp_localize_script( 'zoomy-script', 'TCD_FUNCTIONS', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'ajax_error_message' => __( 'Error was occurred. Please retry again.', 'tcd-w' ),
	) );

	// slick読み込みフラグ
	$slick_load = false;

	if ( is_front_page() ) {
		if ( ! in_array( $dp_options['header_content_type'], array( 'type2', 'type3' ) ) || $dp_options['show_footer_blog_top'] ) {
			$slick_load = true;
		}
	} elseif ( $dp_options['show_footer_blog'] ) {
		$slick_load = true;
	}

	// slick
	if ( $slick_load ) {
		wp_enqueue_script( 'zoomy-slick', get_template_directory_uri() . '/js/slick.mod.min.js', array( 'jquery' ), version_num(), true );
		wp_enqueue_style( 'zoomy-slick', get_template_directory_uri() . '/css/slick.min.css' );

		// ページビルダーのslick.js,slick.cssを読み込まないように
		add_filter( 'page_builder_slick_enqueue_script', '__return_false' );
		add_filter( 'page_builder_slick_enqueue_style', '__return_false' );
	}

	// トップページ
	if ( is_front_page() ) {
		wp_enqueue_script( 'zoomy-front-page', get_template_directory_uri() . '/js/front-page.js', array( 'jquery' ), version_num(), true );
	}

	// フッターバー
	if ( is_mobile() && ( in_array( $dp_options['footer_bar_display'], array( 'type1', 'type2' ) ) || in_array( $dp_options['membership']['loggedin_footer_bar_display'], array( 'type1', 'type2' ) ) ) ) {
		wp_enqueue_style( 'zoomy-footer-bar', get_template_directory_uri() . '/css/footer-bar.css', false, version_num() );
		wp_enqueue_script( 'zoomy-footer-bar', get_template_directory_uri() . '/js/footer-bar.js', array( 'jquery' ), version_num(), true );
	}

	// ヘッダースクロール
	if ( is_singular( $dp_options['photo_slug'] ) ) {
		if ( in_array( $dp_options['header_bar_photo'], array( 'type2', 'type3' ) ) || in_array( $dp_options['header_bar_photo_mobile'], array( 'type2', 'type3' ) ) ) {
			wp_enqueue_script( 'zoomy-header-fix', get_template_directory_uri() . '/js/header-fix.js', array( 'jquery' ), version_num(), true );
		}
	} else {
		if ( in_array( $dp_options['header_bar'], array( 'type2', 'type3' ) ) || in_array( $dp_options['header_bar_mobile'], array( 'type2', 'type3' ) ) ) {
			wp_enqueue_script( 'zoomy-header-fix', get_template_directory_uri() . '/js/header-fix.js', array( 'jquery' ), version_num(), true );
		}
	}

	// author
	if ( is_author() ) {
		wp_enqueue_script( 'zoomy-author', get_template_directory_uri() . '/js/author.js', array( 'zoomy-script' ), version_num(), true );
	}

	// comment-reply
	if ( is_singular( $dp_options['photo_slug'] ) && comments_open() && 'type2' !== $dp_options['comment_type_photo'] ) {
		wp_enqueue_script( 'comment-reply' );
	} elseif ( is_single() && comments_open() && 'type2' !== $dp_options['comment_type'] ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// アドミンバーのインラインスタイルを出力しない
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'wp_enqueue_scripts', 'zoomy_scripts' );

function zoomy_admin_scripts() {
	// 管理画面共通
	wp_enqueue_style( 'tcd_admin_css', get_template_directory_uri() . '/admin/css/tcd_admin.css', array(), version_num() );
	wp_enqueue_script( 'tcd_script', get_template_directory_uri() . '/admin/js/tcd_script.js', array( 'jquery', 'jquery-ui-resizable' ), version_num() );
	wp_localize_script( 'tcd_script', 'TCD_MESSAGES', array(
		'ajaxSubmitSuccess' => __( 'Settings Saved Successfully', 'tcd-w' ),
		'ajaxSubmitError' => __( 'Can not save data. Please try again.', 'tcd-w' )
	) );

	// 画像アップロードで使用
	wp_enqueue_script( 'cf-media-field', get_template_directory_uri() . '/admin/js/cf-media-field.js', array( 'media-upload' ), version_num() );
	wp_localize_script( 'cf-media-field', 'cfmf_text', array(
		'image_title' => __( 'Please Select Image', 'tcd-w' ),
		'image_button' => __( 'Use this Image', 'tcd-w' ),
		'video_title' => __( 'Please Select Video', 'tcd-w' ),
		'video_button' => __( 'Use this Video', 'tcd-w' )
	) );

	// メディアアップローダーAPIを利用するための処理
	wp_enqueue_media();

	// ウィジェットで使用
	wp_enqueue_script( 'zoomy-widget-script', get_template_directory_uri() . '/admin/js/widget.js', array( 'jquery' ), version_num() );

	// テーマオプションのタブで使用
	wp_enqueue_script( 'jquery.cookieTab', get_template_directory_uri() . '/admin/js/jquery.cookieTab.js', array(), version_num() );

	// テーマオプションのAJAX保存で使用
	wp_enqueue_script( 'jquery-form' );

	// フッターバー
	wp_enqueue_style( 'zoomy-admin-footer-bar', get_template_directory_uri() . '/admin/css/footer-bar.css', array(), version_num() );
	wp_enqueue_script( 'zoomy-admin-footer-bar', get_template_directory_uri() . '/admin/js/footer-bar.js', array(), version_num() );

	// WPカラーピッカー
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'zoomy_admin_scripts' );

// Editor style
function zoomy_add_editor_styles() {
	add_editor_style( 'admin/css/editor-style-02.css' );
}
add_action( 'admin_init', 'zoomy_add_editor_styles' );

// 各サムネイル画像生成時の品質を82→92に
function zoomy_wp_editor_set_quality( $quality ) {
	return 92;
}
add_filter( 'wp_editor_set_quality', 'zoomy_wp_editor_set_quality', 10 );
add_filter( 'jpeg_quality', 'zoomy_wp_editor_set_quality', 10 );

// Widget area
function zoomy_widgets_init() {
	// Common side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Common side widget', 'tcd-w' ),
		'description' => __( 'Widgets set in this widget area are displayed as "basic widget" in the sidebar of all pages. If there are individual settings, the widget will be displayed.', 'tcd-w' ),
		'id' => 'common_side_widget'
	) );

	// Post side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Post side widget', 'tcd-w' ),
		'id' => 'post_side_widget'
	) );

	// Page side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Page side widget', 'tcd-w' ),
		'id' => 'page_side_widget'
	) );

	// Above footer widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-above-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Above footer widget', 'tcd-w' ),
		'id' => 'above_footer_widget'
	) );

	// Footer widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Footer widget', 'tcd-w' ),
		'id' => 'footer_widget'
	) );

	// Side menu widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidemenu %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Side menu widget', 'tcd-w' ),
		'id' => 'sidemenu_widget'
	) );

	// Post side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Post side widget (mobile)', 'tcd-w' ),
		'id' => 'post_side_widget_mobile'
	) );

	// Page side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidebar %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Page side widget (mobile)', 'tcd-w' ),
		'id' => 'page_side_widget_mobile'
	) );

	// Above footer widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-above-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Above footer widget (mobile)', 'tcd-w' ),
		'id' => 'above_footer_widget_mobile'
	) );

	// Footer widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-footer %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Footer widget (mobile)', 'tcd-w' ),
		'id' => 'footer_widget_mobile'
	) );

	// Side menu widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget p-widget-sidemenu %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>' . "\n",
		'name' => __( 'Side menu widget (mobile)', 'tcd-w' ),
		'id' => 'sidemenu_widget_mobile'
	) );
}
add_action( 'widgets_init', 'zoomy_widgets_init' );

/**
 * get active sidebar
 */
function get_active_sidebar() {
	global $post, $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$sidebars = array();

	if ( is_front_page() || is_home() || is_archive() || is_singular( $dp_options['photo_slug'] ) ) {
		// no sidebar

	} elseif ( is_page() ) {
		if ( 'show' == $post->display_side_content ) {
			if ( is_mobile() ) {
				$sidebars[] = 'page_side_widget_mobile';
			} else {
				$sidebars[] = 'page_side_widget';
			}
		}

	} elseif ( is_singular() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'post_side_widget_mobile';
		} else {
			$sidebars[] = 'post_side_widget';
		}
	}

	if ( ! empty( $sidebars ) ) {
		$sidebars[] = 'common_side_widget';
	}

	$sidebars = apply_filters( 'get_active_sidebar-sidebars', $sidebars );

	if ( ! empty( $sidebars ) ) {
		foreach( $sidebars as $sidebar ) {
			if ( is_active_sidebar( $sidebar ) ) {
				return $sidebar;
			}
		}
	}

	return false;
}

/**
 * body class
 */
function zoomy_body_classes( $classes ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( get_active_sidebar() ) {
		$classes[] = 'l-sidebar--' . $dp_options['sidebar'];
	}

	if ( is_singular( $dp_options['photo_slug'] ) || is_tcd_membership_preview_photo() ) {
		$classes[] = 'l-header--' . $dp_options['header_bar_photo'];
		$classes[] = 'l-header--' . $dp_options['header_bar_photo_mobile'] . '--mobile';

		if ( in_array( $dp_options['header_bar_photo'], array( 'type2', 'type3' ) ) ) {
			$classes[] = 'l-header__fix';
		}

		if ( in_array( $dp_options['header_bar_photo_mobile'], array( 'type2', 'type3' ) ) ) {
			$classes[] = 'l-header__fix--mobile';
		}
	} else {
		$classes[] = 'l-header--' . $dp_options['header_bar'];
		$classes[] = 'l-header--' . $dp_options['header_bar_mobile'] . '--mobile';

		if ( in_array( $dp_options['header_bar'], array( 'type2', 'type3' ) ) ) {
			$classes[] = 'l-header__fix';
		}

		if ( in_array( $dp_options['header_bar_mobile'], array( 'type2', 'type3' ) ) ) {
			$classes[] = 'l-header__fix--mobile';
		}
	}

	if ( wp_is_mobile() ) {
		$classes[] = 'is-wp-mobile-device';
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'zoomy_body_classes' );

/**
 * Excerpt
 */
function custom_excerpt_length( $length = null ) {
	return is_mobile() ? 50 : 154;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more( $more = null ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Remove wpautop from the excerpt
 */
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Customize archive title
 */
function zoomy_archive_title( $title ) {
	global $dp_options, $author, $post;
	if ( is_post_type_archive( 'post' ) ) {
		$title = $dp_options['blog_label'];
	} elseif ( is_post_type_archive( $dp_options['photo_slug'] ) ) {
		$title = $dp_options['photo_label'];
	} elseif ( is_post_type_archive( $dp_options['information_slug'] ) ) {
		$title = $dp_options['information_label'];
	} elseif ( is_author() ) {
		$title = get_the_author_meta( 'display_name', $author );
	} elseif ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_day() ) {
		$title = get_the_time( __( 'F jS, Y', 'tcd-w' ), $post );
	} elseif ( is_month() ) {
		$title = get_the_time( __( 'F, Y', 'tcd-w' ), $post );
	} elseif ( is_year() ) {
		$title = get_the_time( __( 'Y', 'tcd-w' ), $post );
	} elseif ( is_search() ) {
		$title = __( 'Search result', 'tcd-w' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'zoomy_archive_title', 10 );

/**
 * ビジュアルエディタに表(テーブル)の機能を追加
 */
function mce_external_plugins_table( $plugins ) {
	$plugins['table'] = '//cdn.tinymce.com/4/plugins/table/plugin.min.js';
	return $plugins;
}
add_filter( 'mce_external_plugins', 'mce_external_plugins_table' );

/**
 * tinymceのtableボタンにclass属性プルダウンメニューを追加
 */
function mce_buttons_table( $buttons ) {
	$buttons[] = 'table';
	return $buttons;
}
add_filter( 'mce_buttons', 'mce_buttons_table' );

function table_classes_tinymce( $settings ) {
	$styles = array(
		array( 'title' => __( 'Default style', 'tcd-w' ), 'value' => '' ),
		array( 'title' => __( 'No border', 'tcd-w' ), 'value' => 'table_no_border' ),
		array( 'title' => __( 'Display only horizontal border', 'tcd-w' ), 'value' => 'table_border_horizontal' )
	);
	$settings['table_class_list'] = json_encode( $styles );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'table_classes_tinymce' );

/**
 * ビジュアルエディタにページ分割ボタンを追加
 */
function add_nextpage_buttons( $buttons ) {
	$buttons[] = 'wp_page';
	return $buttons;
}
add_filter( 'mce_buttons', 'add_nextpage_buttons' );

/**
 * Translate Hex to RGB
 */
function hex2rgb( $hex ) {
	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}

	return array( $r, $g, $b );
}

/**
 * ユーザーエージェントを判定するための関数
 */
function is_mobile() {
	static $is_mobile = null;

	if ( $is_mobile !== null ) {
		return $is_mobile;
	}

	// タブレットも含める場合は wp_is_mobile()
	$ua = array(
		'iPhone', // iPhone
		'iPod', // iPod touch
		'Android.*Mobile', // 1.5+ Android *** Only mobile
		'Windows.*Phone', // *** Windows Phone
		'dream', // Pre 1.5 Android
		'CUPCAKE', // 1.5+ Android
		'BlackBerry', // BlackBerry
		'BB10', // BlackBerry10
		'webOS', // Palm Pre Experimental
		'incognito', // Other iPhone browser
		'webmate' // Other iPhone browser
	);

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = false;
	} elseif ( preg_match( '/' . implode( '|', $ua ) . '/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

/**
 * スクリプトのバージョン管理
 */
function version_num() {
	static $theme_version = null;

	if ( $theme_version !== null ) {
		return $theme_version;
	}

	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme();
	} else {
		$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	}

	if ( isset( $theme_data['Version'] ) ) {
		$theme_version = $theme_data['Version'];
	} else {
		$theme_version = '';
	}

	return $theme_version;
}

/**
 * カードリンクパーツ
 */
function get_the_custom_excerpt( $content, $length ) {
	$length = $length ? $length : 70; // デフォルトの長さを指定する
	$content = preg_replace( '/<!--more-->.+/is', '', $content ); // moreタグ以降削除
	$content = strip_shortcodes( $content ); // ショートコード削除
	$content = strip_tags( $content ); // タグの除去
	$content = str_replace( '&nbsp;', '', $content ); // 特殊文字の削除（今回はスペースのみ）
	$content = mb_substr( $content, 0, $length ); // 文字列を指定した長さで切り取る
	return $content.'...';
}

/**
 * カードリンクショートコード
 */
function clink_scode( $atts ) {
	extract( shortcode_atts( array( 'url' => '', 'title' => '', 'excerpt' => '' ), $atts ) );
	$id = url_to_postid( $url ); // URLから投稿IDを取得
	if ( ! $url || ! $id ) return false;

	$post = get_post( $id ); // IDから投稿情報の取得
	$date = mysql2date( 'Y.m.d', $post->post_date ); // 投稿日の取得
	$img_width = 120; // 画像サイズの幅指定
	$img_height = 120; // 画像サイズの高さ指定
	$no_image = get_template_directory_uri() . '/img/common/no-image-300x300.gif';

	// 抜粋を取得
	if ( empty( $excerpt ) ) {
		if ( $post->post_excerpt ) {
			$excerpt = get_the_custom_excerpt( $post->post_excerpt, 115 );
		} else {
			$excerpt = get_the_custom_excerpt( $post->post_content, 115 );
		}
	}

	// タイトルを取得
	if ( empty( $title ) ) {
		$title = strip_tags( get_the_title( $id ) );
	}

	// アイキャッチ画像を取得
	if ( has_post_thumbnail( $id ) ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'size-card' );
		$img_tag = '<img src="' . $img[0] . '" alt="' . $title . '" width="' . $img[1] . '" height="' . $img[2] . '">';
	} else {
		$img_tag ='<img src="' . $no_image . '" alt="" width="' . $img_width . '" height="' . $img_height . '">';
	}

	$clink = '<div class="cardlink"><a href="' . esc_url( $url ) . '"><div class="cardlink_thumbnail">' . $img_tag . '</div></a><div class="cardlink_content"><span class="cardlink_timestamp">' . esc_html( $date ) . '</span><div class="cardlink_title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></div><div class="cardlink_excerpt">' . esc_html( $excerpt ) . '</div></div><div class="cardlink_footer"></div></div>';

	return $clink;
}
add_shortcode( 'clink', 'clink_scode' );

// URL自動リンク
function zoomy_url_auto_link( $text ) {
	$pattern = '/(= ?[\'\"])?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
	$text = preg_replace_callback( $pattern, function( $matches ) {
		// 既にリンクの場合等はそのまま
		if ( isset( $matches[1] ) ) return $matches[0];
		return "<a href=\"{$matches[0]}\" target=\"_blank\">{$matches[0]}</a>";
	}, $text );
	return $text;
}

// 日付が異なれば何分前等の表示にする
function zoomy_the_human_time_diff( $post = null ) {
	echo zoomy_get_human_time_diff( $post );
}
function zoomy_get_human_time_diff( $post = null ) {
	if ( ! $post ) $post = $GLOBALS['post'];

	$post_ts = get_the_time( 'U', $post );
	$current_ts = current_time( 'timestamp' );

	if ( date( 'Ymd', $post_ts ) === date( 'Ymd', $current_ts ) ) {
		return human_time_diff( $post_ts, $current_ts ) . __( ' ago', 'tcd-w' );
	} else {
		return get_the_time( 'Y.m.d', $post );
	}
}

// Information 表示件数、ソート、検索対象投稿タイプ
function zoomy_pre_get_posts( $wp_query ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( ! is_admin() && $wp_query->is_main_query() ) {
		// ソート
		if ( isset( $_REQUEST['sort'] ) && in_array( $_REQUEST['sort'], array( 'likes', 'views' ) ) ) {
			// いいね数降順
			if ( 'likes' === $_REQUEST['sort'] ) {
				$wp_query->set( 'order', 'DESC' );
				$wp_query->set( 'orderby', 'meta_value_num' );
				$wp_query->set( 'meta_key', '_likes' );
			// 総アクセス数降順
			} elseif ( 'views' === $_REQUEST['sort'] ) {
				$wp_query->set( 'order', 'DESC' );
				$wp_query->set( 'orderby', 'meta_value_num' );
				$wp_query->set( 'meta_key', '_views' );
			}
		}

		// Information 表示件数
		if ( $wp_query->is_post_type_archive( $dp_options['information_slug'] ) && 0 < $dp_options['archive_information_num'] ) {
			$wp_query->set( 'posts_per_page', $dp_options['archive_information_num'] );
		}

		// 検索対象投稿タイプ
		if ( $wp_query->is_search() && $dp_options['search_target_post_types'] && is_array( $dp_options['search_target_post_types'] ) ) {
			$wp_query->set( 'post_type', $dp_options['search_target_post_types'] );
		}
	}
}
add_filter( 'pre_get_posts', 'zoomy_pre_get_posts' );

// Information 詳細ページリダイレクト
function information_single_redirect() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( is_singular( $dp_options['information_slug'] ) ) {
		wp_safe_redirect( get_post_type_archive_link( $dp_options['information_slug'] ) );
		exit;
	}
}
add_filter( 'wp', 'information_single_redirect' );

// Information 保存前にタイトル生成
function information_wp_insert_post_data( $data, $postarr ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( $dp_options['information_slug'] === $data['post_type'] ) {
		if ( isset( $postarr['ID'] ) ) {
			$data['post_name'] = $dp_options['information_slug'] . '-' . $postarr['ID'];
		}
		if ( ! empty( $data['post_content'] ) ) {
			$content = $data['post_content'];
			$content = preg_replace( '!<style.*?>.*?</style.*?>!is', '', $content );
			$content = preg_replace( '!<script.*?>.*?</script.*?>!is', '', $content );
			$content = strip_shortcodes( $content );
			$content = strip_tags( $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			$content = str_replace( array( "\r\n", "\r", "\n", "&nbsp;" ), " ", $content );
			$content = htmlspecialchars( $content, ENT_QUOTES );
			$content = wp_trim_words( $content, 100, '...' );
			$data['post_title'] = $content;
		} else {
			$data['post_title'] = '';
		}
	}

	return $data;
}
add_filter( 'wp_insert_post_data', 'information_wp_insert_post_data', 10, 2 );

// ページビルダー投稿タイプフィルター
function zoomy_page_builder_post_types( $post_types ) {
	return array( 'post', 'page' );
}
add_filter( 'get_page_builder_post_types', 'zoomy_page_builder_post_types' );


// Content width
function zoomy_content_width() {
	global $dp_options, $content_width, $post;

	if ( is_front_page() || is_home() || is_archive() || is_singular( $dp_options['photo_slug'] ) ) {
		$content_width = 1200;

	} elseif ( is_singular( 'post' ) || ( is_page() && 'show' == $post->display_side_content ) ) {
		$content_width = 850;
	} else {
		$content_width = 1200;
	}
}
add_action( 'wp', 'zoomy_content_width' );

// レスポンシブ用にoEmbedのコンテナ追加
function zoomy_embed_oembed_html( $html, $url, $attr ) {

	if ( $html ) {
		$embed_container_classes = array( 'p-embed-container' );

		$providers = array(
		
		);

		if ( $url ) {
			static $WP_oEmbed;

			if ( ! $WP_oEmbed ) {
				$WP_oEmbed = new WP_oEmbed();
			}

			$provider = $WP_oEmbed->get_provider( $url );

			if ( $provider && is_string( $provider ) && preg_match( '#https?://([^/]*?\.)?([^\./]+)\.([^\./]+)/#', $provider, $matches ) ) {
				// www.youtube.comのyoutube部分
				$embed_container_classes[] = 'p-embed-container--' . $matches[2];
			}
		}

		$html = '<div class="' . implode( ' ', $embed_container_classes ) . '">' . $html . '</div>';
	}
	return $html;
}
add_filter( 'embed_oembed_html', 'zoomy_embed_oembed_html', 10, 3 );

// Theme options
get_template_part( 'admin/theme-options' );
get_template_part( 'admin/theme-options-tools' );

// Membership (required next to the theme option)
get_template_part( 'functions/membership/membership' );

// Contents Builder
get_template_part( 'admin/contents-builder' );

// Add custom columns
get_template_part( 'functions/admin_column' );

// Comments
get_template_part( 'functions/comments' );

// Custom CSS
get_template_part( 'functions/custom_css' );

// Add quicktags to the visual editor
get_template_part( 'functions/custom_editor' );

// hook wp_head
get_template_part( 'functions/head' );

// OGP
get_template_part( 'functions/ogp' );

// Recommend post
get_template_part( 'functions/recommend' );

// Page builder
get_template_part( 'pagebuilder/pagebuilder' );

// Post custom fields
get_template_part( 'functions/post_cf' );

// Page custom fields
get_template_part( 'functions/page_cf' );
get_template_part( 'functions/page_cf2' );
get_template_part( 'functions/page_ranking_cf' );
get_template_part( 'functions/page_authors_cf' );

// Password protected pages
get_template_part( 'functions/password_form' );

// Show custom fields in quick edit
get_template_part( 'functions/quick_edit' );

// Meta title and description
get_template_part( 'functions/seo' );

// Shortcode
get_template_part( 'functions/short_code' );

// Update notifier
get_template_part( 'functions/update_notifier' );

// Views
get_template_part( 'functions/views' );

// Widgets
get_template_part( 'widget/ad' );
get_template_part( 'widget/archive_list' );
get_template_part( 'widget/category_list' );
get_template_part( 'widget/google_search' );
get_template_part( 'widget/liked_user_list' );
get_template_part( 'widget/site_info' );
get_template_part( 'widget/styled_post_list' );
