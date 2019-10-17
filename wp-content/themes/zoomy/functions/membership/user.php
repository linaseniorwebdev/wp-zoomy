<?php

/**
 * 購読者・寄稿者はアドミンバー非表示
 */
if ( ! current_user_can( 'publish_posts' ) ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

/**
 * 管理画面 ユーザー一覧カスタムカラム
 */
function tcd_membership_manage_users_columns( $posts_columns ) {
	global $dp_options;

	if ( isset( $posts_columns['display_name'] ) ) {
		return $posts_columns;
	}

	$new_columns = array();

	foreach ( $posts_columns as $key => $value ) {
		if ( $key == 'name' ) {
			// 氏名欄の代わりにdisplay_nameを表示
			$new_columns['display_name'] = __( 'Display name', 'tcd-w' );
		} elseif ( $key == 'posts' ) {
			// 氏名欄の代わりにdisplay_nameを表示
			$new_columns['posts'] = $dp_options['blog_label'];
			$new_columns['photos'] = $dp_options['photo_label'];
		} else {
			$new_columns[$key] = $value;
		}
	}

	return $new_columns;
}
add_filter( 'manage_users_columns', 'tcd_membership_manage_users_columns', 10 );

function tcd_membership_manage_users_custom_column( $output, $column_name, $user_id ) {
	global $dp_options, $wpdb;

	switch( $column_name ) {
		case 'display_name':
			$user = get_user_by( 'id', $user_id );
			if ( $user ) {
				return $user->display_name;
			}
			break;

		case 'photos':
			$sql = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = %s AND post_status IN ( 'publish', 'private', 'pending', 'draft' ) AND post_author = %d";
			$count = $wpdb->get_var( $wpdb->prepare( $sql, $dp_options['photo_slug'], $user_id ) );
			if ( $count ) {
				return '<a href="edit.php?post_type=' . $dp_options['photo_slug'] . '&amp;author=' . $user_id . '">' . $count . '</a>';
			} else {
				return 0;
			}
			break;
	}
	return $output;
}
add_filter( 'manage_users_custom_column', 'tcd_membership_manage_users_custom_column', 10, 3 );

/**
 * 管理画面 ユーザー一覧の検索対象カラムフィルター
 */
function tcd_membership_user_search_columns( $search_columns, $search, $WP_User_Query ) {
	global $pagenow;
	$search_columns_default = array( 'user_login', 'user_nicename' );
	if ( $pagenow == 'users.php' && $search && $search_columns === $search_columns_default ) {
		$search_columns = array( 'user_login', 'display_name' );
	}
	return $search_columns;
}
add_filter( 'user_search_columns', 'tcd_membership_user_search_columns', 10, 3 );

/**
 * 会員登録可能か
 */
function tcd_membership_users_can_register() {
	global $dp_options;

	// マルチサイトの場合、マルチサイト側でユーザー登録可でも会員制オプションで不可の場合も考慮
	if ( is_multisite() ) {
		return get_option( 'users_can_register' ) && $dp_options['membership']['users_can_register'];

	// シングルサイト
	} else {
		return get_option( 'users_can_register' );
	}
}

/**
 * 投稿者詳細ページのリンクで/author/user_nicenameのuser_nicenameをdisplay_nameに変更しURLエンコードする
 */
function tcd_membership_author_link( $author_link, $author_id, $author_nicename ) {
	if ( ! get_option( 'permalink_structure' ) ) {
		return $author_link;
	}

	$user = get_user_by( 'id', $author_id );
	if ( ! $user ) {
		return $author_link;
	}

	global $wp_rewrite;
	$link = $wp_rewrite->get_author_permastruct();

	if ( ! empty( $link ) ) {
		$link = str_replace( '%author%', rawurlencode( $user->display_name ), $link );
		$author_link = home_url( user_trailingslashit( $link ) );
	}

	return $author_link;
}
add_filter( 'author_link', 'tcd_membership_author_link', 10, 3 );

/**
 * URLエンコードされた/author/display_nameのリクエスト対応
 */
function tcd_membership_author_link_request( $query_vars ) {
	if ( ! empty( $query_vars['author_name'] ) ) {
		global $wpdb;
		$sql = "SELECT ID FROM {$wpdb->users} WHERE display_name = %s LIMIT 1";
		$user_id = $wpdb->get_var( $wpdb->prepare( $sql, rawurldecode( $query_vars['author_name'] ) ) );
		if ( $user_id ) {
			$query_vars['author'] = $user_id;
			unset( $query_vars['author_name'] );
		}
	}
	return $query_vars;
}
add_filter( 'request', 'tcd_membership_author_link_request' );

/**
 * ログインURLフィルター
 */
function tcd_membership_login_url( $login_url, $redirect, $force_reauth ) {
	// 管理画面操作中の場合は変更なし
	if ( is_admin() ) {
		return $login_url;
	}

	$login_url = get_tcd_membership_memberpage_url( 'login' );

	if ( $redirect ) {
		$login_url = add_query_arg( 'redirect_to', rawurlencode( rawurldecode( $redirect ) ), $login_url );
	}

	if ( $force_reauth ) {
		$login_url = add_query_arg( 'reauth', '1', $login_url );
	}

	return $login_url;
}
add_filter( 'login_url', 'tcd_membership_login_url', 10, 3 );

/**
 * ログアウトURLフィルター
 */
function tcd_membership_logout_url( $logout_url, $redirect ) {
	if ( ! is_admin() ) {
		$logout_url = get_tcd_membership_memberpage_url( 'logout' );
		if ( $redirect ) {
			$logout_url = add_query_arg( 'redirect_to', rawurlencode( rawurldecode( $redirect ) ), $logout_url );
		}
	}
	return $logout_url;
}
add_filter( 'logout_url', 'tcd_membership_logout_url', 10, 2 );

/**
 * ユーザー登録URLフィルター
 */
function tcd_membership_register_url( $register_url ) {
	return get_tcd_membership_memberpage_url( 'registration' );
}
add_filter( 'register_url', 'tcd_membership_register_url', 10, 1 );

/**
 * パスワード再設定URLフィルター
 */
function tcd_membership_lostpassword_url( $lostpassword_url, $redirect ) {
	$lostpassword_url = get_tcd_membership_memberpage_url( 'reset_password' );
	if ( $redirect ) {
		$lostpassword_url = add_query_arg( 'redirect_to', rawurlencode( rawurldecode( $redirect ) ), $lostpassword_url );
	}
	return $lostpassword_url;
}
add_filter( 'lostpassword_url', 'tcd_membership_lostpassword_url', 10, 2 );

/**
 * ログインアクション
 */
function tcd_membership_action_login() {
	global $dp_options, $tcd_membership_vars;

	nocache_headers();

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$user = wp_signon();
		$error_messages = array();

		if ( is_wp_error( $user ) ) {
			foreach ( $user->get_error_codes() as $code ) {
				switch ( $code ) {
					case 'empty_username' :
						$error_messages[] = __( 'Please enter an email address.', 'tcd-w' );
						break;

					case 'empty_password' :
						$error_messages[] = __( 'Please enter a password.', 'tcd-w' );
						break;

					case 'invalid_email' :
					case 'invalid_username' :
					case 'incorrect_password' :
						$error_messages[] = __( 'Email address or password is incorrect.', 'tcd-w' );
						break;

					case 'spammer_account' :
						$error_messages[] = __( 'Your account has been marked as a spammer.', 'tcd-w' );
						break;
				}
			}

			$tcd_membership_vars['login']['errors'] = $user;
			$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
			$user = false;

		} else {
			// ログイン成功時ログイン記憶があればメールアドレスをクッキー保存
			if ( ! empty( $_POST['log'] ) && ! empty( $_POST['rememberme'] ) ) {
				$tcd_login_email = wp_unslash( $_POST['log'] );
				// 可能なら暗号化
				if ( function_exists( 'openssl_decrypt' ) && defined( 'NONCE_KEY' ) && NONCE_KEY ) {
					$tcd_login_email = openssl_encrypt( $tcd_login_email, 'AES-128-ECB', NONCE_KEY );
				}
				setcookie( 'tcd_login_email', $tcd_login_email, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );

			// ログイン記憶がなければクッキー削除
			} else {
				setcookie( 'tcd_login_email', '', time() - YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
			}
		}

		// ajaxログイン
		if ( ! empty( $_POST['ajax_login'] ) ) {
			$json = array(
				'success' => false
			);

			if ( $user ) {
				$json['success'] = true;

				// ここでログインさせないと各種条件分岐が動作しない
				wp_set_current_user( $user->ID, $user->user_login );

				// ヘッダー会員メニューのHTML取得
				ob_start();
				the_tcd_membership_header_member_menu( $user );
				$json['header_member_menu'] = ob_get_clean();

				// 会員メニューのHTML取得
				ob_start();
				the_tcd_membership_member_menu( $user );
				$json['member_menu'] = ob_get_clean();

				// スマホ固定フッターバーのHTML取得
				if ( is_mobile() && in_array( $dp_options['membership']['loggedin_footer_bar_display'], array( 'type1', 'type2' ) ) ) {
					ob_start();
					get_template_part( 'template-parts/footer-bar' );
					$json['footer_bar'] = ob_get_clean();
				}

			} elseif ( ! empty( $tcd_membership_vars['error_message'] ) ) {
				$json['error_message'] = $tcd_membership_vars['error_message'];
			} else {
				$json['error_message'] = __( 'Login failed.', 'tcd-w' );
			}

			// JSON出力
			wp_send_json( $json );
			exit;
		}

		// ログイン成功時はリダイレクト
		if ( $user ) {
			if ( ! empty( $_REQUEST['redirect_to'] ) ) {
				$redirect_to = $_REQUEST['redirect_to'];
			} else {
				$redirect_to = get_tcd_membership_memberpage_url( 'news' );
			}
			wp_safe_redirect( $redirect_to );
			exit;
		}

	// ログイン済みの場合はリダイレクト
	} elseif ( current_user_can( 'read' ) ) {
		if ( ! empty( $_REQUEST['redirect_to'] ) ) {
			$redirect_to = $_REQUEST['redirect_to'];
		} else {
			$redirect_to = user_trailingslashit( home_url() );
		}
		wp_safe_redirect( $redirect_to );
		exit;
	}

	if ( ! empty( $_REQUEST['message'] ) ) {
		switch ( $_REQUEST['message'] ) {
			case 'require_login' :
				$tcd_membership_vars['message'] = __( 'Please login.', 'tcd-w' );
				break;
			case 'registration_account_complete' :
				$tcd_membership_vars['message'] = __( 'Registration complete. Please login.', 'tcd-w' );
				break;
			case 'password_changed' :
				$tcd_membership_vars['message'] = __( 'Password changed.', 'tcd-w' );
				break;
		}
	}
}
add_action( 'tcd_membership_action-login', 'tcd_membership_action_login' );

/**
 * ログアウトアクション
 */
function tcd_membership_action_logout() {
	if ( current_user_can( 'read' ) ) {
		$user = wp_get_current_user();
		wp_logout();
	}
	wp_safe_redirect( user_trailingslashit( home_url() ) );
	exit;
}
add_action( 'tcd_membership_action-logout', 'tcd_membership_action_logout' );

/**
 * 仮会員登録アクション
 */
function tcd_membership_action_registration() {
	global $dp_options, $tcd_membership_vars, $wpdb;

	nocache_headers();

	if ( ! tcd_membership_users_can_register() ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Disable registration.', 'tcd-w' );
	}

	// 成功時のリダイレクトで完了画面表示
	if ( isset( $_GET['complete_email'], $_GET['nonce'] ) ) {
		if ( $_GET['complete_email'] && $_GET['nonce'] && is_email( $_GET['complete_email'] ) && wp_verify_nonce( $_GET['nonce'], 'registration_complete-' . $_GET['complete_email'] ) ) {
			$tcd_membership_vars['registration']['complete'] = true;
			$tcd_membership_vars['registration']['complete_email'] = $_GET['complete_email'];
		} else {
			$tcd_membership_vars['error_message'] = __( 'Invalid nonce token.', 'tcd-w' );
		}
		return;
	}

	if ( current_user_can( 'read' ) ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );
		$error_messages = array();

		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-registration' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} else {
			if ( empty( $formdata['email'] ) ) {
				$error_messages[] = __( 'Please enter an email address.', 'tcd-w' );
			} elseif ( ! is_email( $formdata['email'] ) ) {
				$error_messages[] = __( 'E-mail address format is incorrect.', 'tcd-w' );
			} elseif ( 100 < strlen( $formdata['email'] ) ) {
				$error_messages[] = __( 'E-mail address must be 100 characters or less.', 'tcd-w' );
			} elseif ( email_exists( $formdata['email'] ) ) {
				$error_messages[] = __( 'This email is already registered, please choose another one.', 'tcd-w' );
			}

			if ( empty( $formdata['pass1'] ) ) {
				$error_messages[] = __( 'Please enter a password.', 'tcd-w' );
			} elseif ( 8 > strlen( $formdata['pass1'] ) ) {
				$error_messages[] = __( 'Passwords must be at least 8 characters.', 'tcd-w' );
			} elseif ( empty( $formdata['pass2'] ) || $formdata['pass1'] !== $formdata['pass2'] ) {
				$error_messages[] = __( 'Please enter the same password in both password fields.', 'tcd-w' );
			}
		}

		// エラーがなければtcd_membership_actionsテーブルに保存
		if ( ! $error_messages ) {
			// 重複しないトークン生成
			do {
				$registration_token = wp_generate_password( 20, false, false );
				$wpdb->flush();
			} while ( get_tcd_membership_meta_by_meta( 'registration_token', $registration_token ) );

			// 本会員登録url
			$registration_account_url = add_query_arg( 'token', rawurlencode( $registration_token ), get_tcd_membership_memberpage_url( 'registration_account' ) );

			$action_id = insert_tcd_membership_action( 'registration', 0, 0, 0 );
			if ( $action_id ) {
				// パスワードは可能なら暗号化
				$password = $formdata['pass1'];
				if ( function_exists( 'openssl_decrypt' ) && defined( 'NONCE_KEY' ) && NONCE_KEY ) {
					$password = openssl_encrypt( $password, 'AES-128-ECB', NONCE_KEY );
				}

				// メタ保存
				update_tcd_membership_action_meta( $action_id, 'registration_email', $formdata['email'] );
				update_tcd_membership_action_meta( $action_id, 'registration_password', $password );
				update_tcd_membership_action_meta( $action_id, 'registration_token', $registration_token );
				update_tcd_membership_action_meta( $action_id, 'registration_expire', current_time( 'timestamp', true ) + DAY_IN_SECONDS );

				// メール送信
				$replaces = array(
					'[user_email]' => $formdata['email'],
					'[registration_account_url]' => $registration_account_url
				);
				if ( ! tcd_membership_mail( 'registration', $formdata['email'], $replaces ) ) {
					$error_messages[] = __( 'Failed to send mail.', 'tcd-w' );
					delete_tcd_membership_action_by_id( $action_id );
				}
			} else {
				$error_messages[] = __( 'Failed to save the database.', 'tcd-w' );
			}
		}

		// エラーメッセージ
		if ( $error_messages ) {
			$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
		} else {
			$tcd_membership_vars['registration']['complete'] = true;
			$tcd_membership_vars['registration']['complete_email'] = $formdata['email'];
		}

		// ajax
		if ( ! empty( $formdata['ajax_registration'] ) ) {
			$json = array(
				'success' => false
			);

			if ( ! empty( $tcd_membership_vars['error_message'] ) ) {
				$json['error_message'] = $tcd_membership_vars['error_message'];
			} else {
				$json['success'] = true;
				if ( $dp_options['membership']['registration_complete_desc'] ) {
					$json['registration_complete_desc'] = wpautop( str_replace( '[user_email]', $formdata['email'], $dp_options['membership']['registration_complete_desc'] ) );
				}
			}

			// JSON出力
			wp_send_json( $json );
			exit;
		}

		// 成功時、再送を防ぐためリダイレクト
		if ( ! $error_messages ) {
			$redirect = get_tcd_membership_memberpage_url( 'registration' );
			$redirect = add_query_arg( 'complete_email', rawurlencode( $formdata['email'] ), $redirect );
			$redirect = add_query_arg( 'nonce', wp_create_nonce( 'registration_complete-' . $formdata['email'] ), $redirect );
			wp_safe_redirect( $redirect );
			exit;
		}
	}
}
add_action( 'tcd_membership_action-registration', 'tcd_membership_action_registration' );

/**
 * 本会員登録・アカウント作成アクション
 */
function tcd_membership_action_registration_account() {
	global $dp_options, $tcd_membership_vars, $wpdb, $gender_options, $receive_options, $notify_options;

	nocache_headers();

	if ( ! tcd_membership_users_can_register() ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Disable registration.', 'tcd-w' );
	}

	// 成功時のリダイレクトで完了画面表示
	if ( isset( $_GET['complete_user_id'], $_GET['nonce'] ) ) {
		if ( $_GET['complete_user_id'] && $_GET['nonce'] && wp_verify_nonce( $_GET['nonce'], 'registration_account_complete-' . $_GET['complete_user_id'] ) ) {
			$user = get_user_by( 'id', $_GET['complete_user_id'] );
			if ( $user ) {
				$tcd_membership_vars['registration_account']['complete'] = true;
				$tcd_membership_vars['registration_account']['user'] = $user;
				$tcd_membership_vars['registration_account']['user_email'] = $user->user_email;
				$tcd_membership_vars['registration_account']['user_display_name'] = $user->display_name;
			} else {
				$tcd_membership_vars['error_message'] = __( 'Not foud user.', 'tcd-w' );
			}
		} else {
			$tcd_membership_vars['error_message'] = __( 'Invalid nonce token.', 'tcd-w' );
		}

		// ここで終了
		return;
	}

	// check token
	if ( empty( $_REQUEST['token'] ) ) {
		$tcd_membership_vars['error_message'] = __( 'Invalid request.', 'tcd-w' );
	} else {
		// tokenから仮会員登録済みのデータを取得
		$registration_token = wp_unslash( $_REQUEST['token'] );
		$action_meta = get_tcd_membership_meta_by_meta( 'registration_token', $registration_token );
		if ( $action_meta ) {
			$registration = get_tcd_membership_action_by_id( $action_meta->action_id );
			$registration_email = get_tcd_membership_action_meta( $action_meta->action_id, 'registration_email' );
			$registration_password = get_tcd_membership_action_meta( $action_meta->action_id, 'registration_password' );
			$registration_expire = get_tcd_membership_action_meta( $action_meta->action_id, 'registration_expire' );
			if ( empty( $registration->type ) || 'registration' !== $registration->type || ! $registration_email || ! $registration_password ) {
				$tcd_membership_vars['error_message'] = __( 'Invalid token.', 'tcd-w' );
			} elseif ( ! $registration_expire || current_time( 'timestamp', true ) > $registration_expire ) {
				$tcd_membership_vars['error_message'] = __( 'Expired token.', 'tcd-w' );
			} elseif ( email_exists( $registration_email ) ) {
				$tcd_membership_vars['error_message'] = __( 'This email is already registered.', 'tcd-w' );
			} else {
				// 正常なトークンフラグ
				$tcd_membership_vars['registration_account']['valid_registration_token'] = true;

				// パスワードは複合化
				if ( function_exists( 'openssl_decrypt' ) && defined( 'NONCE_KEY' ) && NONCE_KEY ) {
					$registration_password = openssl_decrypt( $registration_password, 'AES-128-ECB', NONCE_KEY );
				}

				$tcd_membership_vars['registration_account']['email'] = $registration_email;
				$tcd_membership_vars['registration_account']['password'] = $registration_password;
				$tcd_membership_vars['registration_account']['registration_token'] = $registration_token;
			}
		} else {
			$tcd_membership_vars['error_message'] = __( 'Invalid token.', 'tcd-w' );
		}
	}

	// トークンエラーがある場合は終了
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) {
		return;
	}

	if ( current_user_can( 'read' ) ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	$error_messages = array();

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-registration_account' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} else {
			if ( ! empty( $formdata['display_name'] ) ) {
				// 全角スペースありのtrim
				$formdata['display_name'] = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $formdata['display_name'] );
				// サニタイズ
				$formdata['display_name'] = tcd_membership_sanitize_content( $formdata['display_name'] );
			}
			if ( empty( $formdata['display_name'] ) ) {
				$error_messages[] = __( 'Please enter a username.', 'tcd-w' );
			} elseif ( tcd_membership_check_forbidden_words( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Username', 'tcd-w' ) );
			} elseif ( 3 > mb_strlen( $formdata['display_name'] ) || 50 < mb_strlen( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( 'Username must be between %d and %d characters length.', 'tcd-w' ), 3, 50 );
			} elseif ( tcd_membership_user_field_exists( 'display_name', $formdata['display_name'] ) ) {
				$error_messages[] = __( 'This username is already registered, please choose another one.', 'tcd-w' );
			}

			if ( $dp_options['membership']['show_account_area'] && empty( $formdata['area'] ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), get_tcd_user_profile_area_label() );
			}

			if ( $dp_options['membership']['show_account_gender'] && ( empty( $formdata['gender'] ) || ! array_key_exists( $formdata['gender'], $gender_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Gender', 'tcd-w' ) );
			}

			if ( $dp_options['membership']['use_mail_magazine'] && ( empty( $formdata['mail_magazine'] ) || ! array_key_exists( $formdata['mail_magazine'], $receive_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Mail magazine', 'tcd-w' ) );
			}

			if ( $dp_options['membership']['use_member_news_notify'] && ( empty( $formdata['member_news_notify'] ) || ! array_key_exists( $formdata['member_news_notify'], $notify_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), esc_html( $dp_options['membership']['member_news_notify_label'] ) );
			}

			if ( $dp_options['membership']['use_social_notify'] && ( empty( $formdata['social_notify'] ) || ! array_key_exists( $formdata['social_notify'], $notify_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), esc_html( $dp_options['membership']['social_notify_label'] ) );
			}
		}

		// エラーがなければユーザー追加
		if ( ! $error_messages ) {
			$user_id = wp_insert_user( array(
				'display_name' => $formdata['display_name'],
				'nickname' => $formdata['display_name'],
				'user_login' => $registration_email,	// user_loginにはメールアドレスを使用
				'user_pass' => $registration_password,
				'user_email' => $registration_email,
				'user_nicename' => wp_generate_password( 20, false, false ),	// URLには使用しないので乱数
				'role' => apply_filters( 'tcd_membership_account_create_user_role', 'contributor' )
			) );

			if ( is_wp_error( $user_id ) ) {
				$error_messages[] = __( 'Failed to create account.', 'tcd-w' );
				$error_messages = array_merge( $error_messages, $user_id->get_error_messages() );
			} elseif ( ! $user_id ) {
				$error_messages[] = __( 'Failed to create account.', 'tcd-w' );
			} else {
				$tcd_membership_vars['registration_account']['complete'] = true;

				// メタ保存
				if ( $dp_options['membership']['show_account_area'] ) {
					$meta_key = 'area';
					$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['show_account_gender'] ) {
					$meta_key = 'gender';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'man';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['show_account_birthday'] ) {
					$meta_key = '_birthday';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : '';
					update_user_meta( $user_id, $meta_key, $meta_value );
					update_user_meta( $user_id, 'birthday', get_tcd_user_profile_birthday( $meta_value ) );
				}

				if ( $dp_options['membership']['use_mail_magazine'] ) {
					$meta_key = 'mail_magazine';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				} else {
					// オプション変更時対策でyesを入れておく
					update_user_meta( $user_id, 'mail_magazine', 'yes' );
				}

				if ( $dp_options['membership']['use_member_news_notify'] ) {
					$meta_key = 'member_news_notify';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				} else {
					// オプション変更時対策でyesを入れておく
					update_user_meta( $user_id, 'member_news_notify', 'yes' );
				}

				if ( $dp_options['membership']['use_social_notify'] ) {
					$meta_key = 'social_notify';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				} else {
					// オプション変更時対策でyesを入れておく
					update_user_meta( $user_id, 'social_notify', 'yes' );
				}

				// 同一メールアドレスの仮登録情報を全削除
				$results = get_tcd_membership_meta_by_meta( 'registration_email', 'test6@example.com', false );
				if ( $results ) {
					foreach ( $results as $result ) {
						delete_tcd_membership_action_by_id( $result->action_id );
					}
				}

				// メール送信 メール必須ではないので送信エラー処理は無し
				$adminmailto = $dp_options['membership']['mail_registration_account_admin_to'];
				if ( ! $adminmailto ) {
					$adminmailto = get_bloginfo( 'admin_email' );
				}
				$replaces = array(
					'[user_email]' => $registration_email,
					'[user_display_name]' => $formdata['display_name'],
					'[user_name]' => $formdata['display_name'],
					'[login_url]' => get_tcd_membership_memberpage_url( 'login' ),
					'[author_url]' => get_author_posts_url( $user_id ),
					'[reset_password_url]' => get_tcd_membership_memberpage_url( 'reset_password' )
				);
				tcd_membership_mail( 'registration_account', $registration_email, $replaces );
				tcd_membership_mail( 'registration_account_admin', $adminmailto, $replaces );

				// action hook
				do_action( 'tcd_membership_account_created', $user_id, $formdata );
			}
		}

		// 成功時、再送を防ぐためリダイレクト
		if ( ! empty( $tcd_membership_vars['registration_account']['complete'] ) ) {
			// 完了見出し説明文が空の場合はログイン画面へ
			if ( empty( $dp_options['membership']['registration_account_complete_headline'] ) && empty( $dp_options['membership']['registration_account_complete_desc'] ) ) {
				$redirect = get_tcd_membership_memberpage_url( 'login' );
				$redirect = add_query_arg( 'message', 'registration_account_complete', $redirect );
			} else {
				$redirect = get_tcd_membership_memberpage_url( 'registration_account' );
				$redirect = add_query_arg( 'complete_user_id', $user_id, $redirect );
				$redirect = add_query_arg( 'nonce', wp_create_nonce( 'registration_account_complete-' . $user_id ), $redirect );
			}

			wp_safe_redirect( $redirect );
			exit;
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-registration_account', 'tcd_membership_action_registration_account' );

/**
 * アカウント編集アクション
 */
function tcd_membership_action_edit_account() {
	global $dp_options, $tcd_membership_vars, $wpdb, $gender_options, $receive_options, $notify_options;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-edit_account' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} else {
			if ( ! empty( $formdata['display_name'] ) ) {
				// 全角スペースありのtrim
				$formdata['display_name'] = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $formdata['display_name'] );
				// サニタイズ
				$formdata['display_name'] = tcd_membership_sanitize_content( $formdata['display_name'] );
			}
			if ( empty( $formdata['display_name'] ) ) {
				$error_messages[] = __( 'Please enter a username.', 'tcd-w' );
			} elseif ( tcd_membership_check_forbidden_words( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Username', 'tcd-w' ) );
			} elseif ( 3 > mb_strlen( $formdata['display_name'] ) || 50 < mb_strlen( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( 'Username must be between %d and %d characters length.', 'tcd-w' ), 3, 50 );
			} elseif ( tcd_membership_user_field_exists( 'display_name', $formdata['display_name'], $user->ID ) ) {
				$error_messages[] = __( 'This username is already registered, please choose another one.', 'tcd-w' );
			}

			if ( $dp_options['membership']['show_account_area'] && empty( $formdata['area'] ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), get_tcd_user_profile_area_label() );
			}

			if ( $dp_options['membership']['show_account_gender'] && ( empty( $formdata['gender'] ) || ! array_key_exists( $formdata['gender'], $gender_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Gender', 'tcd-w' ) );
			}

			if ( empty( $formdata['email'] ) ) {
				$error_messages[] = __( 'Please enter an email address.', 'tcd-w' );
			} elseif ( $user->user_email !== $formdata['email'] ) {
				if ( ! is_email( $formdata['email'] ) ) {
					$error_messages[] = __( 'E-mail address format is incorrect.', 'tcd-w' );
				} elseif ( 100 < strlen( $formdata['email'] ) ) {
					$error_messages[] = __( 'E-mail address must be 100 characters or less.', 'tcd-w' );
				} elseif ( tcd_membership_user_field_exists( 'user_email', $formdata['email'], $user->ID ) ) {
					$error_messages[] = __( 'This email is already registered, please choose another one.', 'tcd-w' );
				}
			}

			if ( $dp_options['membership']['use_mail_magazine'] && ( empty( $formdata['mail_magazine'] ) || ! array_key_exists( $formdata['mail_magazine'], $receive_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Mail magazine', 'tcd-w' ) );
			}

			if ( $dp_options['membership']['use_member_news_notify'] && ( empty( $formdata['member_news_notify'] ) || ! array_key_exists( $formdata['member_news_notify'], $notify_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), esc_html( $dp_options['membership']['member_news_notify_label'] ) );
			}

			if ( $dp_options['membership']['use_social_notify'] && ( empty( $formdata['social_notify'] ) || ! array_key_exists( $formdata['social_notify'], $notify_options ) ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), esc_html( $dp_options['membership']['social_notify_label'] ) );
			}
		}

		// エラーがなければ更新
		if ( ! $error_messages ) {
			//パスワード変更時・メールアドレス変更時のメール送信はしないように
			add_filter( 'send_password_change_email', '__return_false', 100 );
			add_filter( 'send_email_change_email', '__return_false', 100 );

			$user_id = wp_update_user( array(
				'ID' => $user->ID,
				'display_name' => $formdata['display_name'],
				'nickname' => $formdata['display_name'],
				'user_email' => $formdata['email']
			) );

			if ( is_wp_error( $user_id ) ) {
				$error_messages[] = __( 'Failed to update account.', 'tcd-w' );
				$error_messages = array_merge( $error_messages, $user_id->get_error_messages() );
			} elseif ( ! $user_id ) {
				$error_messages[] = __( 'Failed to update account.', 'tcd-w' );
			} else {
				$tcd_membership_vars['edit_account']['complete'] = true;

				// メーアドレス変更時にはuser_loginも更新
				if ( $user->user_email !== $formdata['email'] ) {
					$result = $wpdb->update(
						$wpdb->users,
						array(
							'user_login' => $formdata['email']
						),
						array(
							'ID' => $user->ID
						),
						array(
							'%s'
						),
						array(
							'%d',
						)
					);

					// 再ログインさせる
					clean_user_cache( $user );
					$user = get_user_by( 'id', $user->ID );
					if ( $user ) {
						wp_clear_auth_cookie();
						wp_set_current_user( $user->ID, $user->user_login );
						wp_set_auth_cookie( $user->ID );
						do_action( 'wp_login', $user->user_login );
					}
				}

				// メタ保存
				if ( $dp_options['membership']['show_account_area'] ) {
					$meta_key = 'area';
					$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['show_account_gender'] ) {
					$meta_key = 'gender';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'man';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['show_account_birthday'] ) {
					$meta_key = '_birthday';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : '';
					update_user_meta( $user_id, $meta_key, $meta_value );
					update_user_meta( $user_id, 'birthday', get_tcd_user_profile_birthday( $meta_value ) );
				}

				if ( $dp_options['membership']['use_mail_magazine'] ) {
					$meta_key = 'mail_magazine';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['use_member_news_notify'] ) {
					$meta_key = 'member_news_notify';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				if ( $dp_options['membership']['use_social_notify'] ) {
					$meta_key = 'social_notify';
					$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : 'yes';
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				// action hook
				do_action( 'tcd_membership_account_updated', $user_id, $formdata );
			}
		}

		// 成功時、再送を防ぐためリダイレクト
		if ( ! empty( $tcd_membership_vars['edit_account']['complete'] ) ) {
			$redirect = get_tcd_membership_memberpage_url( 'edit_account' );
			$redirect = add_query_arg( 'message', 'updated', $redirect );
			wp_safe_redirect( $redirect );
			exit;
		}

	// 成功時のリダイレクトでメッセージ表示
	} elseif ( ! empty( $_REQUEST['message'] ) ) {
		switch ( $_REQUEST['message'] ) {
			case 'updated' :
				$tcd_membership_vars['message'] = __( 'Updated account.', 'tcd-w' );
				break;
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-edit_account', 'tcd_membership_action_edit_account' );

/**
 * プロフィール編集アクション
 */
function tcd_membership_action_edit_profile() {
	global $dp_options, $tcd_membership_vars, $wpdb, $gender_options, $receive_options, $notify_options;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-edit_profile' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} else {
			if ( ! empty( $formdata['display_name'] ) ) {
				// 全角スペースありのtrim
				$formdata['display_name'] = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $formdata['display_name'] );
				// サニタイズ
				$formdata['display_name'] = tcd_membership_sanitize_content( $formdata['display_name'] );
			}
			if ( empty( $formdata['display_name'] ) ) {
				$error_messages[] = __( 'Please enter a username.', 'tcd-w' );
			} elseif ( tcd_membership_check_forbidden_words( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Username', 'tcd-w' ) );
			} elseif ( 3 > mb_strlen( $formdata['display_name'] ) || 50 < mb_strlen( $formdata['display_name'] ) ) {
				$error_messages[] = sprintf( __( 'Username must be between %d and %d characters length.', 'tcd-w' ), 3, 50 );
			} elseif ( tcd_membership_user_field_exists( 'display_name', $formdata['display_name'], $user->ID ) ) {
				$error_messages[] = __( 'This username is already registered, please choose another one.', 'tcd-w' );
			}

			if ( $dp_options['membership']['show_profile_area'] && empty( $formdata['area'] ) ) {
				$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), get_tcd_user_profile_area_label() );
			}

			if ( $dp_options['membership']['show_profile_desc'] && ! empty( $formdata['description'] ) && tcd_membership_check_forbidden_words( $formdata['description'] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Biography', 'tcd-w' ) );
			}
		}

		// エラーがなければ更新
		if ( ! $error_messages ) {
			// display_name変更時
			if ( $user->display_name !== $formdata['display_name'] ) {
				$user_id = wp_update_user( array(
					'ID' => $user->ID,
					'display_name' => $formdata['display_name'],
					'nickname' => $formdata['display_name']
				) );

				if ( is_wp_error( $user_id ) ) {
					$error_messages[] = __( 'Failed to update username.', 'tcd-w' );
					$error_messages = array_merge( $error_messages, $user_id->get_error_messages() );
				} elseif ( ! $user_id ) {
					$error_messages[] = __( 'Failed to update username.', 'tcd-w' );
				}
			}

			// ファイルアップロード header_image
			if ( ! empty( $_FILES['header_image']['name'] ) ) {
				$upload = tcd_user_profile_image_field_upload( array(
					'user_id' => $user->ID,	// 確認画面はないのでこの時点でuser_idを渡してユーザーメタ上書き
					'file_input_name' => 'header_image',
					'width' => 1920,
					'height' => 500,
					'crop' => true
				) );

				// 成功
				if ( ! empty( $upload['url'] ) ) {

				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Header image', 'tcd-w' ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Header image', 'tcd-w' ) );
				}

			// 画像削除フラグあり
			} elseif ( ! empty( $formdata['delete-header_image'] ) ) {
				tcd_user_profile_delete_image( $user->ID, 'header_image' );
			}

			// ファイルアップロード profile_image
			if ( ! empty( $_FILES['profile_image']['name'] ) ) {
				$upload = tcd_user_profile_image_field_upload( array(
					'user_id' => $user->ID,	// 確認画面はないのでこの時点でuser_idを渡してユーザーメタ上書き
					'file_input_name' => 'profile_image',
					'width' => 300,	// width, height, crop で元ファイルをリサイズ
					'height' => 300,
					'crop' => true,
					'thumbnails' => array(
						array( 96, 96, true )
					)
				) );

				// 成功
				if ( ! empty( $upload['url'] ) ) {

				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Profile image', 'tcd-w' ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Profile image', 'tcd-w' ) );
				}

			// 画像削除フラグあり
			} elseif ( ! empty( $formdata['delete-profile_image'] ) ) {
				tcd_user_profile_delete_image( $user->ID, 'profile_image' );
			}

			// メタ保存
			if ( $dp_options['membership']['show_profile_area'] ) {
				$meta_key = 'area';
				$meta_value = isset( $formdata[$meta_key] ) ? $formdata[$meta_key] : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			if ( $dp_options['membership']['show_profile_job'] ) {
				$meta_key = 'job';
				$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			if ( $dp_options['membership']['show_profile_desc'] ) {
				$meta_key = 'description';
				$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			if ( $dp_options['membership']['show_profile_website'] ) {
				$formdata['user_url'] = tcd_membership_sanitize_content( $formdata['user_url'] );
				if ( $user->user_url !== $formdata['user_url'] ) {
					$result = $wpdb->update(
						$wpdb->users,
						array(
							'user_url' => $formdata['user_url']
						),
						array(
							'ID' => $user->ID
						),
						array(
							'%s'
						),
						array(
							'%d',
						)
					);
				}
			}

			if ( $dp_options['membership']['show_profile_facebook'] ) {
				$meta_key = 'facebook_url';
				$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			if ( $dp_options['membership']['show_profile_twitter'] ) {
				$meta_key = 'twitter_url';
				$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			if ( $dp_options['membership']['show_profile_instagram'] ) {
				$meta_key = 'instagram_url';
				$meta_value = isset( $formdata[$meta_key] ) ? tcd_membership_sanitize_content( $formdata[$meta_key] ) : '';
				update_user_meta( $user->ID, $meta_key, $meta_value );
			}

			// キャッシュクリアしてユーザー再取得
			clean_user_cache( $user );
			$user = get_user_by( 'id', $user->ID );

			// action hook
			do_action( 'tcd_membership_profile_updated', $user->ID, $formdata );

			if ( ! $error_messages ) {
				$tcd_membership_vars['edit_profile']['complete'] = true;
			}
		}

		// 成功時、再送を防ぐためリダイレクト
		if ( ! $error_messages ) {
			$redirect = get_tcd_membership_memberpage_url( 'edit_profile' );
			$redirect = add_query_arg( 'message', 'updated', $redirect );
			wp_safe_redirect( $redirect );
			exit;
		}

	// 成功時のリダイレクトでメッセージ表示
	} elseif ( ! empty( $_REQUEST['message'] ) ) {
		switch ( $_REQUEST['message'] ) {
			case 'updated' :
				$tcd_membership_vars['message'] = __( 'Updated profile.', 'tcd-w' );
				break;
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-edit_profile', 'tcd_membership_action_edit_profile' );

/**
 * パスワード再発行アクション
 */
function tcd_membership_action_reset_password() {
	global $dp_options, $tcd_membership_vars, $wpdb;

	nocache_headers();

	$error_messages = array();

	// check token
	if ( isset( $_REQUEST['token'] ) ) {
		// tokenから該当ユーザーIDを取得
		$reset_password_token = wp_unslash( $_REQUEST['token'] );
		$sql = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1";
		$user_id = $wpdb->get_var( $wpdb->prepare( $sql, 'reset_password_token', $reset_password_token ) );
		if ( $user_id ) {
			$user = get_user_by( 'id', $user_id );
			$reset_password_token_expire = get_user_meta( $user_id, 'reset_password_token_expire', true );

			// 有効期限切れ
			if ( ! $reset_password_token_expire || current_time( 'timestamp', true ) > $reset_password_token_expire ) {
				$tcd_membership_vars['error_message'] = __( 'Expired token.', 'tcd-w' );
			// 該当ユーザー無し
			} elseif ( ! $user ) {
				$tcd_membership_vars['error_message'] = __( 'Not foud user.', 'tcd-w' );
			} else {
				$tcd_membership_vars['reset_password']['token'] = $reset_password_token;
				$tcd_membership_vars['reset_password']['user'] = $user;
			}
		} else {
			$tcd_membership_vars['error_message'] = __( 'Invalid token.', 'tcd-w' );
		}
	}

	// トークンエラーがある場合はここで終了
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) {
		return;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		// 正常なトークンがある場合は新しいパスワード入力
		if ( ! empty( $tcd_membership_vars['reset_password']['token'] ) && ! empty( $user ) ) {
			// validation
			if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-reset_password' ) ) {
				$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
			} elseif ( empty( $formdata['new_pass1'] ) ) {
				$error_messages[] = __( 'Please enter a new password.', 'tcd-w' );
			} elseif ( 8 > strlen( $formdata['new_pass1'] ) ) {
				$error_messages[] = __( 'Passwords must be at least 8 characters.', 'tcd-w' );
			} elseif ( empty( $formdata['new_pass2'] ) || $formdata['new_pass1'] !== $formdata['new_pass2'] ) {
				$error_messages[] = __( 'Please enter the same password in both new password fields.', 'tcd-w' );
			} else {
				// 新しいパスワードセット
				reset_password( $user, $formdata['new_pass1'] );

				// ユーザーメタ削除
				delete_user_meta( $user->ID, 'reset_password_token' );
				delete_user_meta( $user->ID, 'reset_password_token_expire' );

				// ログイン中なら再ログインさせる
				if ( current_user_can( 'read' ) ) {
					clean_user_cache( $user );
					$user = get_user_by( 'id', $user->ID );
					if ( $user ) {
						wp_clear_auth_cookie();
						wp_set_current_user( $user->ID, $user->user_login );
						wp_set_auth_cookie( $user->ID );
						do_action( 'wp_login', $user->user_login );
					}
				}

				// 再送を防ぐためリダイレクト
				if ( current_user_can( 'read' ) ) {
					$redirect = get_tcd_membership_memberpage_url( 'reset_password' );
				} else {
					$redirect = get_tcd_membership_memberpage_url( 'login' );
				}
				$redirect = add_query_arg( 'message', 'password_changed', $redirect );
				wp_safe_redirect( $redirect );
				exit;
			}

		// メールアドレス入力
		} else {
			// validation
			if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-reset_password' ) ) {
				$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
			} elseif ( empty( $formdata['email'] ) ) {
				$error_messages[] = __( 'Please enter an email address.', 'tcd-w' );
			} elseif ( ! is_email( $formdata['email'] ) ) {
				$error_messages[] = __( 'E-mail address format is incorrect.', 'tcd-w' );
			} elseif ( 100 < strlen( $formdata['email'] ) ) {
				$error_messages[] = __( 'E-mail address must be 100 characters or less.', 'tcd-w' );
			} else {
				$user = get_user_by( 'email', $formdata['email'] );
				if ( ! $user ) {
					$error_messages[] = __( 'This email is not registered.', 'tcd-w' );
				} else {
					// 重複しないトークン生成
					$sql = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1";
					do {
						$reset_password_token = wp_generate_password( 20, false, false );
						$wpdb->flush();
					} while ( $wpdb->get_var( $wpdb->prepare( $sql, 'reset_password_token', $reset_password_token ) ) );

					// トークン・有効期限（24時間）をユーザーメタに保存
					update_user_meta( $user->ID, 'reset_password_token', $reset_password_token );
					update_user_meta( $user->ID, 'reset_password_token_expire', current_time( 'timestamp', true ) + DAY_IN_SECONDS );

					// メール送信
					$replaces = array(
						'[user_email]' => $formdata['email'],
						'[user_display_name]' => $user->display_name,
						'[user_name]' => $user->display_name,
						'[reset_password_url]' => add_query_arg( 'token', $reset_password_token, get_tcd_membership_memberpage_url( 'reset_password' ) )
					);
					if ( tcd_membership_mail( 'reset_password', $formdata['email'], $replaces ) ) {
						// 成功時、再送を防ぐためリダイレクト
						$redirect = get_tcd_membership_memberpage_url( 'reset_password' );
						$redirect = add_query_arg( 'reset_password_email', rawurlencode( $formdata['email'] ), $redirect );
						$redirect = add_query_arg( 'nonce', wp_create_nonce( 'reset_password-' . $formdata['email'] ), $redirect );
						wp_safe_redirect( $redirect );
						exit;
					} else {
						$error_messages[] = __( 'Failed to send mail.', 'tcd-w' );
						delete_user_meta( $user->ID, 'reset_password_token', $reset_password_token );
					}
				}
			}
		}

	} else {
		// メール送信成功時のリダイレクトでメッセージ表示
		if ( isset( $_GET['reset_password_email'], $_GET['nonce'] ) ) {
			if ( $_GET['reset_password_email'] && $_GET['nonce'] && is_email( $_GET['reset_password_email'] ) && wp_verify_nonce( $_GET['nonce'], 'reset_password-' . $_GET['reset_password_email'] ) ) {
				$tcd_membership_vars['reset_password']['email'] = $_GET['reset_password_email'];
				$tcd_membership_vars['message'] = sprintf( __( 'Sent email to %s.<br>Please read email and set a new password.', 'tcd-w' ), $_GET['reset_password_email'] );
			} else {
				$tcd_membership_vars['error_message'] = __( 'Invalid nonce token.', 'tcd-w' );
			}
		}

		// 新しいパスワード設定成功時のリダイレクトでメッセージ表示
		if ( ! empty( $_REQUEST['message'] ) && 'password_changed' === $_REQUEST['message'] ) {
			$tcd_membership_vars['complete'] = true;
			$tcd_membership_vars['message'] = __( 'Password changed.', 'tcd-w' );
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-reset_password', 'tcd_membership_action_reset_password' );

/**
 * パスワード変更アクション
 */
function tcd_membership_action_change_password() {
	global $dp_options, $tcd_membership_vars;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-change_password' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} elseif ( empty( $formdata['current_pass'] ) ) {
			$error_messages[] = __( 'Please enter a current password.', 'tcd-w' );
		} elseif ( ! wp_check_password( $formdata['current_pass'], $user->user_pass, $user->ID ) ) {
			$error_messages[] = __( 'Current password is incorrect.', 'tcd-w' );
		} elseif ( empty( $formdata['new_pass1'] ) ) {
			$error_messages[] = __( 'Please enter a new password.', 'tcd-w' );
		} elseif ( 8 > strlen( $formdata['new_pass1'] ) ) {
			$error_messages[] = __( 'Passwords must be at least 8 characters.', 'tcd-w' );
		} elseif ( empty( $formdata['new_pass2'] ) || $formdata['new_pass1'] !== $formdata['new_pass2'] ) {
			$error_messages[] = __( 'Please enter the same password in both new password fields.', 'tcd-w' );
		} else {
			// 新しいパスワードセット
			reset_password( $user, $formdata['new_pass1'] );

			// 再ログインさせる
			if ( current_user_can( 'read' ) ) {
				clean_user_cache( $user );
				$user = get_user_by( 'id', $user->ID );
				if ( $user ) {
					wp_clear_auth_cookie();
					wp_set_current_user( $user->ID, $user->user_login );
					wp_set_auth_cookie( $user->ID );
					do_action( 'wp_login', $user->user_login );
				}
			}

			// 再送を防ぐためリダイレクト
			$redirect = get_tcd_membership_memberpage_url( 'change_password' );
			$redirect = add_query_arg( 'message', 'password_changed', $redirect );
			wp_safe_redirect( $redirect );
			exit;
		}

	// 新しいパスワード設定成功時のリダイレクトでメッセージ表示
	} elseif ( ! empty( $_REQUEST['message'] ) && 'password_changed' === $_REQUEST['message'] ) {
		$tcd_membership_vars['message'] = __( 'Password changed.', 'tcd-w' );
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-change_password', 'tcd_membership_action_change_password' );

/**
 * 退会アクション
 */
function tcd_membership_action_delete_account() {
	global $dp_options, $tcd_membership_vars;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		// validation
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-delete_account' ) ) {
			$error_messages[] = __( 'Invalid nonce token.', 'tcd-w' );
		} else {
			// メール送信 メール必須ではないので送信エラー処理は無し
			$adminmailto = $dp_options['membership']['mail_withdraw_admin_to'];
			$replaces = array(
				'[user_email]' => $user->user_email,
				'[user_display_name]' => $user->display_name,
				'[user_name]' => $user->display_name
			);
			tcd_membership_mail( 'withdraw', $user->user_email, $replaces );
			tcd_membership_mail( 'withdraw_admin', $adminmailto, $replaces );

			// 削除実行
			require_once( ABSPATH . 'wp-admin/includes/user.php' );
			wp_delete_user( $user->ID );
			wp_logout();

			// action hook
			do_action( 'tcd_membership_account_deleted', $user->ID );

			// リダイレクト
			$redirect = user_trailingslashit( home_url() );
			if ( false === strpos( $uri, '?' ) ) {
				$redirect .= '?';
			} else {
				$redirect .= '&';
			}
			$redirect .= 'account_deleted';
			wp_safe_redirect( $redirect );
			exit;
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-delete_account', 'tcd_membership_action_delete_account' );

/**
 * ユーザー削除時に関連データも削除する
 */
function tcd_membership_deleted_user( $user_id, $reassign ) {
	global $wpdb;

	// action_id配列取得
	$tablename = get_tcd_membership_tablename( 'actions' );
	$sql = "SELECT id FROM {$tablename} WHERE user_id = %d || target_user_id = %d";
	$action_ids = $wpdb->get_col( $wpdb->prepare( $sql, $user_id, $user_id ) );
	if ( $action_ids ) {
		// タイムアウト対策
		set_time_limit( 30 );

		delete_tcd_membership_action( array(
			'action_ids' => $action_ids
		) );
	}

	// コメント削除
	$sql = "SELECT comment_ID FROM {$wpdb->comments} WHERE user_id = %d";
	$comment_ids = $wpdb->get_col( $wpdb->prepare( $sql, $user_id, $user_id ) );
	if ( $comment_ids ) {
		foreach ( $comment_ids as $comment_id ) {
			// タイムアウト対策
			set_time_limit( 15 );

			wp_delete_comment( $comment_id, true );
		}
	}
}
add_action( 'deleted_user', 'tcd_membership_deleted_user', 10, 2 );

/**
 * 重複するユーザーフィールドがあるか
 */
function tcd_membership_user_field_exists( $field, $value, $exclude_user_id = null ) {
	global $wpdb;

	if ( ! $field || ! $value ) {
		return true;
	}

	$sql = "SELECT ID FROM {$wpdb->users} WHERE {$field} = %s";
	$prepares = array( $value );

	if ( $exclude_user_id && is_numeric( $exclude_user_id ) ) {
		$sql .= " AND ID != %d";
		$prepares[] = $exclude_user_id;
	}

	$sql .= " LIMIT 1";

	return $wpdb->get_var( $wpdb->prepare( $sql, $prepares ) );
}

/**
 * マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合にメッセージを返す
 */
function tcd_membership_multisite_other_site_logged_in_message() {
	if ( is_multisite() && is_user_logged_in() && ! current_user_can( 'read' ) ) {
		$ms_message = __( 'We detect you logged in other site on this network.<br>If you request login to this site, contact to administrator.', 'tcd-w' );
		return apply_filters( 'tcd_membership_multisite_other_site_logged_in_message', $ms_message );
	}
	return false;
}

/**
 * Export Members表示
 */
function tcd_membership_export_users_do_page() {
?>
<div class="wrap">
	<h2><?php _e( 'Export Members', 'tcd-w' ); ?></h2>
	<form action="" method="post">
		<h4 class="theme_option_headline2"><?php _e( 'Registration date', 'tcd-w' ); ?></h4>
		<input type="text" class="datepicker" name="date_from" value="">
		<?php _e( ' - ', 'tcd-w' ); ?>
		<input type="text" class="datepicker" name="date_to" value="">
		<h4 class="theme_option_headline2"><?php _e( 'Registration type', 'tcd-w' ); ?></h4>
		<select name="registration_type">
			<option value="standard"><?php _e( 'Standard Member (Account created in WordPress Users.)', 'tcd-w' ); ?></option>
			<option value="provisional"><?php _e( 'Provisional registration', 'tcd-w' ); ?></option>
		</select>
		<h4 class="theme_option_headline2"><?php _e( 'Mail Magazine setting', 'tcd-w' ); ?></h4>
		<select name="mail_magazine">
			<option value=""><?php _e( 'Not specified', 'tcd-w' ); ?></option>
			<option value="yes"><?php _e( 'Do receive', 'tcd-w' ); ?></option>
			<option value="no"><?php _e( 'Do not receive', 'tcd-w' ); ?></option>
		</select>
		<h4 class="theme_option_headline2"><?php _e( 'CSV Encoding', 'tcd-w' ); ?></h4>
		<select name="csv_encoding">
			<option value=""><?php _e( 'UTF-8', 'tcd-w' ); ?></option>
			<option value="sjis"><?php _e( 'Shift JIS (for Japanese Microsoft Excel)', 'tcd-w' ); ?></option>
		</select>
		<input type="submit" class="button-ml" name="do_export_users" value="<?php echo __( 'Export', 'tcd-w' ); ?>">
		<?php wp_nonce_field( 'tcd_membership_export_users' ); ?>
	</form>
	<script>
		jQuery(function($){
			$('.datepicker').datepicker({
				dateFormat: 'yy-mm-dd',
				maxDate: 0
			});
			$('select[name="registration_type"]').change(function(){
				if ($(this).val() == 'provisional') {
					$('select[name="mail_magazine"]').attr('disabled', 'disabled');
				} else {
					$('select[name="mail_magazine"]').removeAttr('disabled');
				}
			}).trigger('change');
		});
	</script>
<?php
}

/**
 * Export Members admin init
 */
function tcd_membership_export_users_admin_init( $in ) {
	global $pagenow;
	// Export Members
	if ( 'admin.php' === $pagenow && ! empty( $_REQUEST['page'] ) && 'tcd_membership_export_users' === $_REQUEST['page'] ) {

		// CSV dowonload
		if ( ! empty( $_POST['do_export_users'] ) ) {
			check_admin_referer( 'tcd_membership_export_users' );

			// タイムアウト対策
			set_time_limit( 600 );

			$current_ts = current_time( 'timestamp', false );
			$current_ts_gmt = current_time( 'timestamp', true );
			$current_ts_offset = $current_ts - $current_ts_gmt;

			// エンコード
			$internal_encoding = mb_internal_encoding();
			if ( ! empty( $_POST['csv_encoding'] ) && 'sjis' == $_POST['csv_encoding'] ) {
				$csv_encoding = 'SJIS-win';
			} elseif ( 'UTF-8' != $internal_encoding ) {
				$csv_encoding = 'UTF-8';
			} else {
				$csv_encoding = null;
			}

			// ファイル名
			$filename = get_bloginfo( 'name' ) . '-' . 'export_members.csv';

			// ヘッダー
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename="' . rawurlencode( $filename ) . '"' );

			// ファイルストリーム
			$fp = fopen( 'php://output','w' );

			// 仮会員の場合
			if ( ! empty( $_POST['registration_type'] ) && 'provisional' == $_POST['registration_type'] ) {
				global $wpdb;

				// csvヘッダ
				$csv_header = array(
					__( 'Email Address', 'tcd-w' ),
					__( 'Registration date', 'tcd-w' )
				);

				// エンコード
				if ( $csv_encoding ) {
					mb_convert_variables( $csv_encoding, $internal_encoding, $csv_header );
				}

				// csvヘッダ出力
				fputcsv( $fp, $csv_header, ',', '"' );

				// 登録日指定
				if ( ! empty( $_POST['date_from'] ) && ! empty( $_POST['date_to'] ) ) {
					$date_from_ts = strtotime( $_POST['date_from'] ) - $current_ts_offset;
					$date_to_ts = strtotime( $_POST['date_to'] ) + 86400 - 1 - $current_ts_offset;
					$where_date = " AND act.created_gmt >= '" . date( 'Y-m-d H:i:s', $date_from_ts ) . "'";
					$where_date .= " AND act.created_gmt <= '" . date( 'Y-m-d H:i:s', $date_to_ts ) . "'";
				} elseif ( ! empty( $_POST['date_from'] ) ) {
					$date_from_ts = strtotime( $_POST['date_from'] ) - $current_ts_offset;
					$where_date = " AND act.created_gmt >= '" . date( 'Y-m-d H:i:s', $date_from_ts ) . "'";
				} elseif ( ! empty( $_POST['date_to'] ) ) {
					$date_to_ts = strtotime( $_POST['date_to'] ) + 86400 - 1 - $current_ts_offset;
					$where_date = " AND act.created_gmt <= '" . date( 'Y-m-d H:i:s', $date_to_ts ) . "'";
				} else {
					$where_date = '';
				}

				// 仮会員取得
				$tablename_actions = get_tcd_membership_tablename( 'actions' );
				$tablename_action_metas = get_tcd_membership_tablename( 'action_metas' );
				$sql = "SELECT act.id, act.created_gmt, actemail.meta_value FROM {$tablename_actions} AS act "
					 . "INNER JOIN {$tablename_action_metas} AS actemail ON (act.id = actemail.action_id AND actemail.meta_key = 'registration_email') "
					 . "WHERE act.type = 'registration' "
					 . $where_date
					 . "ORDER BY act.created_gmt ASC";
				$results = $wpdb->get_results( $sql );

				// データ出力
				if ( $results ) {
					foreach ( $results as $user ) {
						$row_data = array(
							$user->meta_value,
							$user->created_gmt
						);

						// 登録日時をGMTからローカル時間に
						if ( 0 != $current_ts_offset ) {
							$row_data[1] = date( 'Y-m-d H:i:s', strtotime( $row_data[1] ) + $current_ts_offset );
						}

						// メールと日付のみのためエンコードは不要

						fputcsv( $fp, $row_data, ',', '"' );
					}
				}

			} else {
				global $receive_options, $gender_options;

				// csvヘッダ
				$csv_header = array(
					__( 'User ID', 'tcd-w' ),
					__( 'Username', 'tcd-w' ),
					__( 'Email Address', 'tcd-w' ),
					__( 'Mail Magazine', 'tcd-w' ),
					__( 'Gender', 'tcd-w' ),
					__( 'Birthday', 'tcd-w' ),
					__( 'Registration date', 'tcd-w' )
				);

				// エンコード
				if ( $csv_encoding ) {
					mb_convert_variables( $csv_encoding, $internal_encoding, $csv_header );
				}

				// csvヘッダ出力
				fputcsv( $fp, $csv_header, ',', '"' );

				$args = array(
					'orderby' => 'ID',
					'order' => 'ASC'
				);

				// 登録日指定 wp_users.user_registeredはgmtなので注意
				if ( ! empty( $_POST['date_from'] ) && ! empty( $_POST['date_to'] ) ) {
					$date_from_ts = strtotime( $_POST['date_from'] ) - $current_ts_offset;
					$date_to_ts = strtotime( $_POST['date_to'] ) + 86400 - 1 - $current_ts_offset;
					$args['date_query'] = array(
						'after' => array(
							'year'		=> date( 'Y', $date_from_ts ),
							'month'		=> (int) date( 'm', $date_from_ts ),
							'day'		=> (int) date( 'd', $date_from_ts ),
							'hour'		=> (int) date( 'H', $date_from_ts ),
							'minute'	=> (int) date( 'i', $date_from_ts ),
							'second'	=> (int) date( 's', $date_from_ts )
						),
						'before' => array(
							'year'		=> date( 'Y', $date_to_ts ),
							'month'		=> (int) date( 'm', $date_to_ts ),
							'day'		=> (int) date( 'd', $date_to_ts ),
							'hour'		=> (int) date( 'H', $date_to_ts ),
							'minute'	=> (int) date( 'i', $date_to_ts ),
							'second'	=> (int) date( 's', $date_to_ts )
						),
						'inclusive' => true,
					);
				} elseif ( ! empty( $_POST['date_from'] ) ) {
					$date_from_ts = strtotime( $_POST['date_from'] ) - $current_ts_offset;
					$args['date_query'] = array(
						'after' => array(
							'year'		=> date( 'Y', $date_from_ts ),
							'month'		=> (int) date( 'm', $date_from_ts ),
							'day'		=> (int) date( 'd', $date_from_ts ),
							'hour'		=> (int) date( 'H', $date_from_ts ),
							'minute'	=> (int) date( 'i', $date_from_ts ),
							'second'	=> (int) date( 's', $date_from_ts )
						),
						'inclusive' => true,
					);
				} elseif ( ! empty( $_POST['date_to'] ) ) {
					$date_to_ts = strtotime( $_POST['date_to'] ) + 86400 - 1 - $current_ts_offset;
					$args['date_query'] = array(
						'before' => array(
							'year'		=> date( 'Y', $date_to_ts ),
							'month'		=> (int) date( 'm', $date_to_ts ),
							'day'		=> (int) date( 'd', $date_to_ts ),
							'hour'		=> (int) date( 'H', $date_to_ts ),
							'minute'	=> (int) date( 'i', $date_to_ts ),
							'second'	=> (int) date( 's', $date_to_ts )
						),
						'inclusive' => true,
					);
				}

				// メルマガ設定指定
				if ( ! empty( $_POST['mail_magazine'] ) && array_key_exists( $_POST['mail_magazine'], $receive_options ) ) {
					$mail_magazine_label = $receive_options[$_POST['mail_magazine']];
					$args['meta_key'] = 'mail_magazine';
					$args['meta_value'] = $_POST['mail_magazine'];
				} else {
					$mail_magazine_label = null;
				}

				// ユーザー取得
				$users = get_users( $args );

				// データ出力
				if ( $users ) {
					foreach ( $users as $user ) {
						$row_data = array(
							$user->ID,
							$user->display_name,
							$user->user_email,
							$user->mail_magazine,
							$user->gender,
							$user->birthday,
							$user->user_registered
						);

						// メルマガ表記
						if ( $mail_magazine_label ) {
							$row_data[3] = $mail_magazine_label;
						} elseif ( $row_data[3] && array_key_exists( $row_data[3], $receive_options ) ) {
							$row_data[3] = $receive_options[$row_data[3]];
						}

						// 性別表記
						if ( $row_data[4] && array_key_exists( $row_data[4], $gender_options ) ) {
							$row_data[4] = $gender_options[$row_data[4]]['label'];
						}

						// 登録日時をGMTからローカル時間に
						if ( 0 != $current_ts_offset ) {
							$row_data[6] = date( 'Y-m-d H:i:s', strtotime( $row_data[6] ) + $current_ts_offset );
						}

						// エンコード
						if ( $csv_encoding ) {
							mb_convert_variables( $csv_encoding, $internal_encoding, $row_data );
						}

						fputcsv( $fp, $row_data, ',', '"' );
					}
				}
			}

			fclose( $fp );
			exit;
		}

		// date picker
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'jquery-ui-smoothness', get_template_directory_uri() . '/admin/css/smoothness/jquery-ui.min.css', array(), '1.11.4', 'screen' );
	}
}
add_action( 'admin_init', 'tcd_membership_export_users_admin_init' );
