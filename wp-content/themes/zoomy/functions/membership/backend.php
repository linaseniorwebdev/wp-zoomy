<?php

/**
 * カスタム投稿タイプ登録
 */
function tcd_membership_init_post_type() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// メンバーニュース
	register_post_type( 'member_news', array(
		'label' => __( 'Member News', 'tcd-w'),
		'labels' => array(
			'name' => __( 'Member News', 'tcd-w'),
			'singular_name' => __( 'Member News', 'tcd-w'),
			'add_new' => sprintf( __( 'Add %s', 'tcd-w' ), __( 'Member News', 'tcd-w' ) ),
			'add_new_item' => __( 'Add New Item', 'tcd-w' ),
			'edit_item' => __( 'Edit', 'tcd-w' ),
			'new_item' => __( 'New item', 'tcd-w' ),
			'view_item' => __( 'View Item', 'tcd-w' ),
			'search_items' => __( 'Search Items', 'tcd-w' ),
			'not_found' => __( 'Not Found', 'tcd-w' ),
			'not_found_in_trash' => __( 'Not found in trash', 'tcd-w' ),
			'parent_item_colon' => ''
		),
		'public' => false,
		'publicly_queryable' => false,
		'menu_position' => 5,
		'show_ui' => true,
		'query_var' => false,
		'rewrite' => false,
		'capabilities' => array(
			'read_post' => 'read',
			'create_posts' => 'edit_theme_options',
			'edit_post' => 'edit_theme_options',
			'edit_posts' => 'edit_theme_options',
			'edit_others_posts' => 'edit_theme_options',
			'delete_post' => 'edit_theme_options',
			'delete_posts' => 'edit_theme_options',
			'publish_posts' => 'edit_theme_options',
			'read_private_posts' => 'edit_theme_options',
		),
		'has_archive' => false,
		'hierarchical' => false,
		'supports' => array( 'editor' )
	) );

	// メールマガジン
	if ( $dp_options['membership']['use_mail_magazine'] ) {
		register_post_type( 'mail_magazine', array(
			'label' => __( 'Mail Magazine', 'tcd-w' ),
			'labels' => array(
				'name' => __( 'Mail Magazine', 'tcd-w' ),
				'singular_name' => __( 'Mail Magazine', 'tcd-w' ),
				'add_new' => sprintf( __( 'Add %s', 'tcd-w' ), __( 'Mail Magazine', 'tcd-w' ) ),
				'add_new_item' => __( 'Add New Item', 'tcd-w' ),
				'edit_item' => __( 'Edit', 'tcd-w' ),
				'new_item' => __( 'New item', 'tcd-w' ),
				'view_item' => __( 'View Item', 'tcd-w' ),
				'search_items' => __( 'Search Items', 'tcd-w' ),
				'not_found' => __( 'Not Found', 'tcd-w' ),
				'not_found_in_trash' => __( 'Not found in trash', 'tcd-w' ),
				'parent_item_colon' => ''
			),
			'public' => false,
			'publicly_queryable' => true,	// need preview
			'menu_position' => 5,
			'show_ui' => true,
			'query_var' => false,
			'rewrite' => false,
			'capabilities' => array(
				'read_post' => 'read',
				'create_posts' => 'edit_theme_options',
				'edit_post' => 'edit_theme_options',
				'edit_posts' => 'edit_theme_options',
				'edit_others_posts' => 'edit_theme_options',
				'delete_post' => 'edit_theme_options',
				'delete_posts' => 'edit_theme_options',
				'publish_posts' => 'edit_theme_options',
				'read_private_posts' => 'edit_theme_options',
			),
			'has_archive' => false,
			'hierarchical' => false,
			'supports' => array( 'title', 'editor' )
		) );
	}
}
add_action( 'init', 'tcd_membership_init_post_type' );

/**
 * 管理画面サブメニューを登録
 */
function tcd_membership_add_menu_page() {
	global $dp_options, $menu, $submenu, $parent_file;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	add_submenu_page(
		'theme_options',
		__( 'TCD Theme Options', 'tcd-w' ),
		__( 'TCD Theme Options', 'tcd-w' ),
		'edit_theme_options',
		'theme_options',
		'theme_options_do_page'
	);

	add_submenu_page(
		'theme_options',
		__( 'Membership Options', 'tcd-w' ),
		__( 'Membership Options', 'tcd-w' ),
		'edit_theme_options',
		'tcd_membership_options',
		'tcd_membership_options_do_page'
	);

	// tcd_membership_init_post_typeで追加したカスタム投稿タイプをTCDテーマ下層に移動
	$post_types = array( 'member_news', 'mail_magazine' );

	foreach ( $post_types as $post_type ) {
		if ( isset( $submenu['edit.php?post_type=' . $post_type] ) ) {
			if ( isset( $submenu['theme_options'] ) ) {
				$submenu['theme_options'] = array_merge( $submenu['theme_options'], $submenu['edit.php?post_type=' . $post_type] );
			} else {
				$submenu['theme_options'] = $submenu['edit.php?post_type=' . $post_type];
			}
			unset( $submenu['edit.php?post_type=' . $post_type] );

			foreach ( $menu as $key => $value ) {
				if ( 'edit.php?post_type=' . $post_type === $value[2] ) {
					unset( $menu[$key] );
					break;
				}
			}
		}
	}

	add_submenu_page(
		'theme_options',
		__( 'Export Members', 'tcd-w' ),
		__( 'Export Members', 'tcd-w' ),
		'edit_theme_options',
		'tcd_membership_export_users',
		'tcd_membership_export_users_do_page'
	);

	// ブログ pending使用ならpending数を表示
	if ( $dp_options['membership']['use_front_edit_blog_pending'] && current_user_can( 'edit_others_posts' ) ) {
		$results = get_posts( array(
			'post_type' => 'post',
			'nopaging' => true,
			'post_status' => 'pending'
		) );

		if ( $results ) {
			$count_html = ' <span class="awaiting-mod count-' . count( $results ) . '"><span class="pending-count">' . count( $results ) . '</span></span>';

			foreach ( $menu as $key => $item ) {
				if ( isset( $item[5] ) && $item[5] === 'menu-posts' ) {
					// 親メニューが非アクティブ
					if ( ! $parent_file || $item[2] != $parent_file ) {
						// メニュー名
						$menu[$key][0] .= $count_html;
					}

					// サブメニュー
					$submenu[$item[2]][14] = array(
						// サブメニュー名
						$dp_options['membership']['pending_label'] . $count_html,
						// capability
						$item[1],
						// url
						'edit.php?post_status=pending&amp;post_type=post'
					);
					ksort( $submenu[$item[2]] );

					break;
				}
			}
		}
	}

	// 写真 pending使用ならpending数を表示
	if ( $dp_options['membership']['use_front_edit_blog_pending'] && current_user_can( 'edit_others_posts' ) ) {
		$results = get_posts( array(
			'post_type' => $dp_options['photo_slug'],
			'nopaging' => true,
			'post_status' => 'pending'
		) );

		if ( $results ) {
			$count_html = ' <span class="awaiting-mod count-' . count( $results ) . '"><span class="pending-count">' . count( $results ) . '</span></span>';

			foreach ( $menu as $key => $item ) {
				if ( isset( $item[5] ) && $item[5] === 'menu-posts-' . $dp_options['photo_slug'] ) {
					// 親メニューが非アクティブ
					if ( ! $parent_file || $item[2] != $parent_file ) {
						// メニュー名
						$menu[$key][0] .= $count_html;
					}

					// サブメニュー
					$submenu[$item[2]][14] = array(
						// サブメニュー名
						$dp_options['membership']['pending_label'] . $count_html,
						// capability
						$item[1],
						// url
						'edit.php?post_status=pending&amp;post_type=' . $dp_options['photo_slug']
					);
					ksort( $submenu[$item[2]] );

					break;
				}
			}
		}
	}
}
add_action( 'admin_menu', 'tcd_membership_add_menu_page', 11 );

/**
 * TCDテーマ下層に移動したカスタム投稿タイプの編集の際に$parent_fileを変更するフィルター
 */
function tcd_membership_parent_file( $parent_file ) {
	global $pagenow, $typenow;
	if ( 'post.php' == $pagenow && in_array( $typenow, array( 'member_news', 'mail_magazine' ) ) ) {
		$parent_file = 'theme_options';
	}
	return $parent_file;
}
add_filter( 'parent_file', 'tcd_membership_parent_file' );

/**
 * 購読者・寄稿者は管理画面にアクセスさせない
 */
function tcd_membership_admin_restrict() {
	// ajaxは除外
	if ( wp_doing_ajax() ) {
		return;
	}

	if ( ! current_user_can( 'publish_posts' ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
}
add_action( 'admin_init', 'tcd_membership_admin_restrict' );

/**
 * wp-login.phpにアクセスさせない
 */
function tcd_membership_disable_wp_login_php() {
	global $dp_options, $pagenow;

	if ( 'wp-login.php' == $pagenow && $dp_options['membership']['disable_wp_login_php'] ) {
		// action指定の場合や管理画面操作中の再ログインの場合は何もしない
		if ( isset( $_REQUEST['action'] ) || isset( $_REQUEST['key'] ) || isset( $_REQUEST['interim-login'] ) ) {
			return;
		}

		// リダイレクト先
		if ( current_user_can( 'read' ) ) {
			$redirect = get_tcd_membership_memberpage_url( 'news' );
		} else {
			$redirect = get_tcd_membership_memberpage_url( 'login' );
		}

		if ( ! empty( $_REQUEST['redirect_to'] ) ) {
			$redirect = add_query_arg( 'redirect_to', rawurlencode( $_REQUEST['redirect_to'] ), $redirect );
		}

		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'init', 'tcd_membership_disable_wp_login_php' );

/**
 * メール送信
 */
function tcd_membership_mail( $mail_type, $mailto = null, $replaces = array() ) {
	global $dp_options;

	if ( ! $mailto ) {
		return false;
	}

	$subject = '';
	$body = '';

	switch ( $mail_type ) {
		case 'registration' :
			$subject = $dp_options['membership']['mail_registration_subject'];
			$body = $dp_options['membership']['mail_registration_body'];
			break;

		case 'registration_account' :
			$subject = $dp_options['membership']['mail_registration_account_subject'];
			$body = $dp_options['membership']['mail_registration_account_body'];
			break;

		case 'registration_account_admin' :
			$subject = $dp_options['membership']['mail_registration_account_admin_subject'];
			$body = $dp_options['membership']['mail_registration_account_admin_body'];
			break;

		case 'reset_password' :
			$subject = $dp_options['membership']['mail_reset_password_subject'];
			$body = $dp_options['membership']['mail_reset_password_body'];
			break;

		case 'withdraw' :
			$subject = $dp_options['membership']['mail_withdraw_subject'];
			$body = $dp_options['membership']['mail_withdraw_body'];
			break;

		case 'withdraw_admin' :
			$subject = $dp_options['membership']['mail_withdraw_admin_subject'];
			$body = $dp_options['membership']['mail_withdraw_admin_body'];
			break;

		case 'report' :
			$subject = $dp_options['membership']['mail_report_subject'];
			$body = $dp_options['membership']['mail_report_body'];
			break;

		case 'member_news_notify' :
			$subject = $dp_options['membership']['mail_member_news_notify_subject'];
			$body = $dp_options['membership']['mail_member_news_notify_body'];

			// 未読通知から新着通知への仕様変更での変数名置換
			if ( false !== strpos( $subject, '[unread_count]' ) ||  false !== strpos( $body, '[unread_count]' ) ) {
				$subject = str_replace( '[unread_count]', '[news_count]', $subject );
				$body = str_replace( '[unread_count]', '[news_count]', $body );
			}

			break;

		case 'social_notify' :
			$subject = $dp_options['membership']['mail_social_notify_subject'];
			$body = $dp_options['membership']['mail_social_notify_body'];

			// 未読通知から新着通知への仕様変更での変数名置換
			if ( false !== strpos( $subject, 'unread_' ) ||  false !== strpos( $body, 'unread_' ) ) {
				foreach ( array(
					'[unread_count]' => '[total_count]',
					'[unread_likes_count]' => '[likes_count]',
					'[unread_comments_count]' => '[comments_count]',
					'[unread_follows_count]' => '[follows_count]',
					'[has_unread_likes]' => '[has_likes_count]',
					'[/has_unread_likes]' => '[/has_likes_count]',
					'[has_unread_comments]' => '[has_comments_count]',
					'[/has_unread_comments]' => '[/has_comments_count]',
					'[has_unread_follows]' => '[has_follows_count]',
					'[/has_unread_follows]' => '[/has_follows_count]'
				) as $search => $replace ) {
					$subject = str_replace( $search, $replace, $subject );
					$body = str_replace( $search, $replace, $body );
				}
			}

			break;

		default :
			return false;
			break;
	}

	if ( ! $subject && ! $body ) {
		return false;
	}

	// 置換デフォルト
	$replaces = (array) $replaces;
	if ( ! isset( $replaces['[blog_name]'] ) ) {
		$replaces['[blog_name]'] = get_bloginfo( 'name' );
	}
	if ( ! isset( $replaces['[blog_url]'] ) ) {
		$replaces['[blog_url]'] = get_bloginfo( 'url' );
	}

	// 置換
	foreach ( $replaces as $search => $replace ) {
		if ( is_int( $search ) || ! is_string( $search ) ) continue;
		$subject = str_replace( $search, $replace, $subject );
		$body = str_replace( $search, $replace, $body );
	}

	// 件名・本文フィルター
	$subject = apply_filters( 'tcd_membership_mail_subject-' . $mail_type, $subject, $replaces, $mailto );
	$body = apply_filters( 'tcd_membership_mail_body-' . $mail_type, $body, $replaces, $mailto );

	if ( ! $subject && ! $body ) {
		return false;
	}

	// 送信元フィルター追加
	add_filter( 'wp_mail_from', 'tcd_membership_wp_mail_from', 20 );
	add_filter( 'wp_mail_from_name', 'tcd_membership_wp_mail_from_name', 20 );

	// メール送信
	$result = wp_mail( $mailto, $subject, $body );

	// 送信元フィルター削除
	remove_filter( 'wp_mail_from', 'tcd_membership_wp_mail_from', 20 );
	remove_filter( 'wp_mail_from_name', 'tcd_membership_wp_mail_from_name', 20 );

	return $result;
}

/**
 * メール送信元メールアドレスフィルター
 */
function tcd_membership_wp_mail_from( $from_email ) {
	global $dp_options;
	if ( $dp_options['membership']['mail_from_email'] && is_email( $dp_options['membership']['mail_from_email'] ) ) {
		return $dp_options['membership']['mail_from_email'];
	}
	return $from_email;
}

/**
 * メール送信元名フィルター
 */
function tcd_membership_wp_mail_from_name( $from_name ) {
	global $dp_options;
	return $dp_options['membership']['mail_from_name'];
}
