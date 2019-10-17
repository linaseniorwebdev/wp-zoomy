<?php

/**
 * メンバーページ設定初期化
 */
function tcd_membership_memberpage_init() {
	global $dp_options, $tcd_membership_vars;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$tcd_membership_vars = array(
		'memberpage_page' => null,
		'memberpage_url' => null,
		'memberpage_type' => null,
		'memberpage_all_types' => array(
			'login',
			'logout',
			'reset_password',
			'news',
			'edit_profile',
			'change_password',
			'edit_account',
			'delete_account'
		),
		'memberpage_guest_types' => array(
			'login',
			'registration',
			'registration_account',
			'reset_password'
		),
		'memberpage_static_member_menu_types' => array(
			'news',
			'add_photo',
			'edit_photo',
			'delete_photo',
			'add_blog',
			'edit_blog',
			'delete_blog',
			'edit_profile',
			'edit_account',
			'change_password',
			'delete_account',
			'reset_password'
		),
		'memberpage_image_upload_types' => array(
			'add_photo',
			'edit_photo',
			'add_blog',
			'edit_blog',
			'edit_profile',
		)
	);

	if ( tcd_membership_users_can_register() ) {
		$tcd_membership_vars['memberpage_all_types'][] = 'registration';
		$tcd_membership_vars['memberpage_all_types'][] = 'registration_account';
	}

	if ( $dp_options['membership']['use_front_edit_photo'] ) {
		$tcd_membership_vars['memberpage_all_types'][] = 'add_photo';
		$tcd_membership_vars['memberpage_all_types'][] = 'edit_photo';
		$tcd_membership_vars['memberpage_all_types'][] = 'delete_photo';
	}

	if ( $dp_options['membership']['use_front_edit_blog'] ) {
		$tcd_membership_vars['memberpage_all_types'][] = 'add_blog';
		$tcd_membership_vars['memberpage_all_types'][] = 'edit_blog';
		$tcd_membership_vars['memberpage_all_types'][] = 'delete_blog';
	}

	// メンバーページの固定ページ情報を取得
	if ( $dp_options['membership']['memberpage_page_id'] ) {
		if ( 'page' === get_option( 'show_on_front' ) && in_array( $dp_options['membership']['memberpage_page_id'], array( get_option( 'page_on_front' ), get_option( 'page_for_posts' ) ) ) ) {
			$dp_options['membership']['memberpage_page_id'] = null;
		}
	}
	if ( $dp_options['membership']['memberpage_page_id'] ) {
		$tcd_membership_vars['memberpage_page'] = get_post( $dp_options['membership']['memberpage_page_id'] );
		if ( empty( $tcd_membership_vars['memberpage_page']->post_status ) || 'publish' !== $tcd_membership_vars['memberpage_page']->post_status || 'page' !== $tcd_membership_vars['memberpage_page']->post_type ) {
			$tcd_membership_vars['memberpage_page'] = false;
		} else {
			$tcd_membership_vars['memberpage_url'] = get_permalink( $tcd_membership_vars['memberpage_page'] );
		}
	}
}
add_action( 'init', 'tcd_membership_memberpage_init', 8 );

/**
 * メンバーページの{page_slug}/{memberpage_type}形式リクエスト処理
 */
function tcd_membership_memberpage_parse_request( $wp ) {
	global $tcd_membership_vars;

	if ( is_admin() ) return;

	if ( ! empty( $wp->query_vars['pagename'] ) && $tcd_membership_vars['memberpage_page'] && get_option( 'permalink_structure' ) ) {
		// {page_slug}
		if ( $tcd_membership_vars['memberpage_page']->post_name === $wp->query_vars['pagename'] ) {
			$tcd_membership_vars['memberpage_type'] = 'news';

		// {page_slug}/{memberpage_type}/{ページ番号}
		} elseif ( preg_match( '!' . $tcd_membership_vars['memberpage_page']->post_name .'/([^/]+)/?!u', $wp->query_vars['pagename'], $matches ) ) {
			if ( in_array( $matches[1], $tcd_membership_vars['memberpage_all_types'] ) ) {

				$wp->query_vars['pagename'] = $tcd_membership_vars['memberpage_page']->post_name;
				$tcd_membership_vars['memberpage_type'] = $matches[1];
			}
		}
	}
}
add_action( 'parse_request', 'tcd_membership_memberpage_parse_request', 1 );

/**
 * メンバーページinit(wp)
 */
function tcd_membership_memberpage_wp() {
	global $tcd_membership_vars;

	if ( is_admin() ) return;

	// {page_slug}/{memberpage_type}以外のメンバーページリクエスト処理
	if ( ! $tcd_membership_vars['memberpage_type'] ) {
		// $_REQUEST['memberpage'] を受け取るフラグ
		$is_query_string_memberpage = false;

		if ( $tcd_membership_vars['memberpage_page'] && is_page( $tcd_membership_vars['memberpage_page']->ID ) ) {
			if ( ! empty( $_REQUEST['memberpage'] ) ) {
				$is_query_string_memberpage = true;
			} else {
				$tcd_membership_vars['memberpage_type'] = 'news';
			}
		} elseif ( ! $tcd_membership_vars['memberpage_page'] && is_front_page() ) {
			$is_query_string_memberpage = true;
		}

		if ( $is_query_string_memberpage ) {
			if ( ! empty( $_REQUEST['memberpage'] ) && in_array( $_REQUEST['memberpage'], $tcd_membership_vars['memberpage_all_types'] ) ) {
				$tcd_membership_vars['memberpage_type'] = $_REQUEST['memberpage'];
			}
		}
	}

	if ( $tcd_membership_vars['memberpage_type'] ) {
		// 未ログインの場合にアクセスできるmemberpage_typeでなければログインページへリダイレクト
		if ( ! current_user_can( 'read' ) && ! in_array( $tcd_membership_vars['memberpage_type'], $tcd_membership_vars['memberpage_guest_types'] ) ) {
			$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$redirect = add_query_arg( 'redirect_to', rawurlencode( rawurldecode( $current_url ) ), get_tcd_membership_memberpage_url( 'login' ) );
			wp_safe_redirect( $redirect );
			exit;
		}

		// action
		do_action( 'tcd_membership_action-' . $tcd_membership_vars['memberpage_type'] );
	}
}
add_action( 'wp', 'tcd_membership_memberpage_wp' );

/**
 * メンバーページのテンプレートファイルフィルター
 */
function tcd_membership_memberpage_template_include( $template ) {
	global $tcd_membership_vars;

	if ( !empty( $tcd_membership_vars['template'] ) ) {
		$template_name = $tcd_membership_vars['template'];
	} else {
		$template_name = $tcd_membership_vars['memberpage_type'];
	}

	if ( $template_name ) {
		$memberpage_template = locate_template( 'membership-template/' . $template_name . '.php' );
		if ( $memberpage_template ) {
			return $memberpage_template;
		} else {
			global $wp_query;
			$wp_query->is_404 = true;
			return get_404_template();
		}
	}

	return $template;
}
add_filter( 'template_include', 'tcd_membership_memberpage_template_include', 20 );

/**
 * メンバーページのwp_title用タイトルフィルター
 */
function tcd_membership_memberpage_single_post_title( $title, $_post ) {
	global $tcd_membership_vars;

	if ( ! is_admin() && $tcd_membership_vars['memberpage_type'] ) {
		if ( $_title = get_tcd_membership_memberpage_title( $tcd_membership_vars['memberpage_type'] ) ) {
			return $_title;
		}
	}

	return $title;
}
add_filter( 'single_post_title', 'tcd_membership_memberpage_single_post_title', 10, 2 );

/**
 * メンバーページのタイトルを返す
 */
function get_tcd_membership_memberpage_title( $type ) {
	global $dp_options;

	switch ( $type ) {
		case 'login' :
			$title = __( 'Login', 'tcd-w' );
			break;
		case 'logout' :
			$title = __( 'Logout', 'tcd-w' );
			break;
		case 'registration' :
			$title = $dp_options['membership']['registration_headline'] ? $dp_options['membership']['registration_headline'] : __( 'Registration', 'tcd-w' );
			break;
		case 'registration_account' :
			$title = $dp_options['membership']['registration_account_headline'] ? $dp_options['membership']['registration_account_headline'] : __( 'Registration Account', 'tcd-w' );
			break;
		case 'reset_password' :
			$title = __( 'Reset Password', 'tcd-w' );
			break;
		case 'mypage' :
			$title = __( 'Mypage', 'tcd-w' );
			break;
		case 'news' :
			$title = $dp_options['membership']['mypage_headline_news'] ? $dp_options['membership']['mypage_headline_news'] : __( 'News', 'tcd-w' );
			break;
		case 'add_photo' :
			$title = $dp_options['membership']['mypage_headline_add_photo'] ? $dp_options['membership']['mypage_headline_add_photo'] : __( 'Add photo', 'tcd-w' );
			break;
		case 'edit_photo' :
			$title = sprintf( __( 'Edit %s', 'tcd-w' ), $dp_options['photo_label'] );
			break;
		case 'delete_photo' :
			$title = sprintf( __( 'Delete %s', 'tcd-w' ), $dp_options['photo_label'] );
			break;
		case 'add_blog' :
			$title = $dp_options['membership']['mypage_headline_add_blog'] ? $dp_options['membership']['mypage_headline_add_blog'] : __( 'Add blog', 'tcd-w' );
			break;
		case 'edit_blog' :
			$title = sprintf( __( 'Edit %s', 'tcd-w' ), $dp_options['blog_label'] );
			break;
		case 'delete_blog' :
			$title = sprintf( __( 'Delete %s', 'tcd-w' ), $dp_options['blog_label'] );
			break;
		case 'profile' :
			$title = $dp_options['membership']['mypage_headline_profile'] ? $dp_options['membership']['mypage_headline_profile'] : __( 'Profile', 'tcd-w' );
			break;
		case 'edit_profile' :
			$title = __( 'Edit Profile', 'tcd-w' );
			break;
		case 'account' :
			$title = $dp_options['membership']['mypage_headline_account'] ? $dp_options['membership']['mypage_headline_account'] : __( 'Account', 'tcd-w' );
			break;
		case 'edit_account' :
			$title = __( 'Edit Account', 'tcd-w' );
			break;
		case 'change_password' :
			$title = __( 'Change Password', 'tcd-w' );
			break;
		case 'delete_account' :
			$title = __( 'Delete Account', 'tcd-w' );
			break;
		default :
			$title = null;
			break;
	}

	return apply_filters( 'get_tcd_membership_memberpage_title', $title, $type );
}

/**
 * メンバーページのURLを返す
 */
function get_tcd_membership_memberpage_url( $type, $add_query_key = null, $add_query_value = null ) {
	global $tcd_membership_vars;

	if ( $tcd_membership_vars['memberpage_url'] ) {
		$baseurl = $tcd_membership_vars['memberpage_url'];
		if ( ! $type || 'mypage' === $type || 'news' === $type ) {
			return user_trailingslashit( $baseurl );
		}

		if ( get_option( 'permalink_structure' ) ) {
			$url = user_trailingslashit( untrailingslashit( $baseurl ) . '/' . $type );
		} else {
			$url = add_query_arg( 'memberpage', $type, $baseurl );
		}
	} else {
		$baseurl = home_url( '/' );
		if ( ! $type ) {
			return $baseurl;
		}

		$url = add_query_arg( 'memberpage', $type, $baseurl );
	}

	if ( $add_query_key ) {
		if ( null === $add_query_value && is_numeric( $add_query_key ) ) {
			$add_query_value = intval( $add_query_key );
			$add_query_key = 'post_id';
		}
		$url = add_query_arg( $add_query_key, $add_query_value, $url );
	}

	return $url;
}

/**
 * 現ページのメンバーページ種別を返す
 */
function get_tcd_membership_memberpage_type() {
	global $tcd_membership_vars;
	return $tcd_membership_vars['memberpage_type'];
}

/**
 * 現ページで静的メンバーメニューを表示するか
 */
function is_tcd_membership_static_member_menu() {
	global $tcd_membership_vars;
	return ( $tcd_membership_vars['memberpage_type'] && in_array( $tcd_membership_vars['memberpage_type'], $tcd_membership_vars['memberpage_static_member_menu_types'] ) );
}

/**
 * 現ページで画像アップロードがあるか
 */
function is_tcd_membership_image_upload_type() {
	global $tcd_membership_vars;
	return ( $tcd_membership_vars['memberpage_type'] && in_array( $tcd_membership_vars['memberpage_type'], $tcd_membership_vars['memberpage_image_upload_types'] ) );
}

/**
 * body class
 */
function tcd_membership_body_classes( $classes ) {
	global $tcd_membership_vars;

	// メンバーページ表示の場合
	if ( $tcd_membership_vars['memberpage_type'] ) {
		$classes[] = 'membership-' . $tcd_membership_vars['memberpage_type'];

		// フロントページならhome削除
		if ( is_front_page() && false !== ( $key = array_search( 'home', $classes ) ) ) {
			unset( $classes[$key] );
		}
	}

	// ゲスト 未ログイン
	if ( ! current_user_can( 'read' ) ) {
		$classes[] = 'guest';
	}

	// マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はlogged-in削除
	if ( is_multisite() && is_user_logged_in() && ! current_user_can( 'read' ) && false !== ( $key = array_search( 'logged-in', $classes ) ) ) {
		unset( $classes[$key] );
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'tcd_membership_body_classes', 11 );

/**
 * ヘッダーメンバーメニューを出力
 */
function the_tcd_membership_header_member_menu( $user = null ) {
	global $dp_options;

	if ( null == $user && current_user_can( 'read' ) ) {
		$user = wp_get_current_user();
	}
?>
		<ul class="p-header-member-menu">
<?php
	if ( $user ) :
?>
			<li class="p-header-member-menu__item p-header-member-menu__item--author">
				<a class="p-header-member-menu__item-author p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
					<span class="p-header-member-menu__item-author_thumbnail p-hover-effect__image"><?php echo get_avatar( $user->ID, 96 ); ?></span>
					<span class="p-header-member-menu__item-author_name"><?php echo esc_html( $user->display_name ); ?></span>
				</a>
			</li>
			<li class="p-header-member-menu__item p-header-member-menu__item--mypage"><a id="js-header-member-menu-mypage" href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'news' ) ); ?>"><?php _e( 'Mypage', 'tcd-w' ); ?></a></li>
<?php
	else :
?>
			<li class="p-header-member-menu__item p-header-member-menu__item--login"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'login' ) ); ?>"><?php _e( 'Login', 'tcd-w' ); ?></a></li>
<?php
		if ( tcd_membership_users_can_register() ) :
?>
			<li class="p-header-member-menu__item p-header-member-menu__item--registration has-bg"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'registration' ) ); ?>"><?php _e( 'Join', 'tcd-w' ); ?></a></li>
<?php
		endif;
	endif;
?>
		</ul>
<?php
}

/**
 * ヘッダーメンバーメニューliを出力
 */
function the_tcd_membership_member_menu( $user = null ) {
	global $dp_options, $tcd_membership_vars;

	$active = null;

	if ( ! $user && current_user_can( 'read' ) ) {
		$user = wp_get_current_user();

		switch( $tcd_membership_vars['memberpage_type'] ) {
			case 'news' :
				$active = 'news';
				break;
			case 'add_photo' :
			case 'edit_photo' :
				$active = 'photo';
				break;
			case 'add_blog' :
			case 'edit_blog' :
				$active = 'blog';
				break;
			case 'edit_profile' :
				$active = 'profile';
				break;
			case 'edit_account' :
			case 'reset_password' :
			case 'change_password' :
			case 'delete_account' :
				$active = 'account';
				break;
		}
	}

	if ( $user ) :
		$member_news_unread = get_tcd_membership_news_unread_number( $user );
?>
	<div class="p-member-menu<?php if ( is_tcd_membership_static_member_menu() ) echo ' p-member-menu--static'; ?>">
		<ul class="p-member-menu__inner">
			<li class="p-member-menu__item<?php if ( 'news' === $active ) echo ' is-active'; ?>"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'news' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'news' ) ); ?><?php if ( $member_news_unread ) echo '<span class="p-member-menu__item-badge">' . esc_html( $member_news_unread ) . '</span>'; ?></a></li>
<?php
		if ( $dp_options['membership']['use_front_edit_photo'] && current_user_can( 'edit_posts' ) ) :
?>
			<li class="p-member-menu__item<?php if ( 'photo' === $active ) echo ' is-active'; ?>"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'add_photo' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'add_photo' ) ); ?></a></li>
<?php
		endif;
		if ( $dp_options['membership']['use_front_edit_blog'] && current_user_can( 'edit_posts' ) ) :
?>
			<li class="p-member-menu__item<?php if ( 'blog' === $active ) echo ' is-active'; ?>"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'add_blog' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'add_blog' ) ); ?></a></li>
<?php
		endif;
?>
			<li class="p-member-menu__item<?php if ( 'profile' === $active ) echo ' is-active'; ?>"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'edit_profile' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'profile' ) ); ?></a></li>
			<li class="p-member-menu__item<?php if ( 'account' === $active ) echo ' is-active'; ?>"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'edit_account' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'account' ) ); ?></a></li>
			<li class="p-member-menu__item"><a href="<?php echo esc_url( get_tcd_membership_memberpage_url( 'logout' ) ); ?>"><?php echo esc_html( get_tcd_membership_memberpage_title( 'logout' ) ); ?></a></li>
		</ul>
	</div>
<?php
	endif;
}
