<?php

/**
 * Mail Magazine カスタムカラム追加
 */
function tcd_membership_mail_magazine_manage_posts_columns( $columns ) {
	$new_columns = array();
	foreach ( $columns as $column_name => $column_display_name ) {
		// title カラムの前に post_id カラムを追加
		if ( isset( $columns['title'] ) && $column_name == 'title' ) {
			$new_columns['post_id'] = 'ID';
		}

		// date カラムの前に sent_status カラムを追加
		if ( isset( $columns['date'] ) && $column_name == 'date' ) {
			$new_columns['sent_status'] = __( 'Sent status', 'tcd-w' );
		}

		$new_columns[$column_name] = $column_display_name;
	}
	return $new_columns;
}
add_filter( 'manage_mail_magazine_posts_columns', 'tcd_membership_mail_magazine_manage_posts_columns', 10 );

/**
 * Mail Magazine カスタムカラム出力
 */
function tcd_membership_mail_magazine_manage_posts_custom_column( $column_name, $post_id ) {
	switch ( $column_name ) {
		case 'sent_status' :
			$sent_status = get_post_meta( $post_id, 'sent_status', true );
			if ( isset( $sent_status['users'], $sent_status['timestamp'] ) ) {
				printf(
					__( 'Sent to %d users on %s', 'tcd-w' ),
					$sent_status['users'],
					date( 'Y/m/d H:i:s', $sent_status['timestamp'] )
				);
			} elseif ( $sent_status && is_string( $sent_status ) ) {
				echo $sent_status;
			} elseif ( $sent_status ) {
				print_r( $sent_status );
			} else {
				$post = get_post( $post_id );
				if ( 'future' == $post->post_status ) {
					echo __( 'Future send', 'tcd-w' );
				} else {
					echo __( 'Unsent', 'tcd-w' );
				}
			}
			break;
	}
}
add_action( 'manage_posts_custom_column', 'tcd_membership_mail_magazine_manage_posts_custom_column', 10, 2 );

/**
 * Mail Magazine 編集画面でTCDのクイックタグを非表示に
 */
function tcd_membership_mail_magazine_disable_quicktags() {
	global $dp_options, $typenow;
	if ( 'mail_magazine' == $typenow ) {
		if ( $dp_options['use_quicktags'] ) {
			remove_action( 'admin_head', 'tcd_add_mce_button' );
			remove_action( 'admin_print_footer_scripts', 'tcd_add_quicktags' );
		}
	}
}
add_filter( 'current_screen', 'tcd_membership_mail_magazine_disable_quicktags', 100 );

/**
 * Mail Magazine カスタムフィールド メタボックス追加
 */
function tcd_membership_mail_magazine_add_meta_box() {
	add_meta_box(
		'tcd_membership_mail_magazine_meta_box', // ID of meta box
		__( 'Mail Magazine settings', 'tcd-w' ), // label
		'tcd_membership_mail_magazine_show_meta_box', // callback function
		'mail_magazine', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_membership_mail_magazine_add_meta_box' );

/**
 * Mail Magazine カスタムフィールド メタボックス表示
 */
function tcd_membership_mail_magazine_show_meta_box() {
	global $post;

	echo '<input type="hidden" name="tcd_membership_mail_magazine_meta_box_nonce" value="' . wp_create_nonce( 'tcd_membership_mail_magazine_meta_box_nonce-' . $post->ID ) . '">';
?>
<div class="theme_option_message">
    <p><?php _e( 'Simple mail magazine function to broadcast titles and contents.', 'tcd-w' ); ?></p>
    <p><?php _e( 'In case of a status other than publication, it will not be e-mailed until it is made public.Reservation transmission is possible by specifying future date and time on release date.(Please note that reservation send date and time is not accurate.', 'tcd-w' ); ?></p>
    <p><?php _e( 'When using reservation transmission, Cron setting is recommended on the server. If you do not set Cron, possibility that problems such as the transmission time being delayed from the schedule or not being transmitted.', 'tcd-w' ); ?></p>
    <p><?php _e( 'Cron is runs programs periodically. Please check the setting manual / support etc of your server setting.', 'tcd-w' ); ?></p>
    <p><?php _e( 'Depending on the server and plan, it may not be available', 'tcd-w' ); ?></p>
</div>
<?php

	echo '<dl class="tcd_custom_fields">' . "\n";

	// 宛先設定
	$destination = array(
		'name' => __( 'Bcc Destination', 'tcd-w' ),
		'id' => 'destination',
		'type' => 'radio',
		'std' => 'type1',
		'options' => array(
			array(
				'name' => __( 'Users making "Do receive" setting.', 'tcd-w' ),
				'value' => 'type1'
			),
			array(
				'name' => __( 'All users.', 'tcd-w' ),
				'value' => 'type2'
			)
		)
	);
	$cf_value = $post->destination;
	if ( ! $cf_value ) {
		$cf_value = $destination['std'];
	}

	echo '<dt class="label"><label for="' . esc_attr( $destination['id'] ) . '">' . esc_html( $destination['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio cf">';
	foreach ( $destination['options'] as $destination_option ) {
		echo '<li><label><input type="radio" id="' . esc_attr( $destination['id'] ) . '-' . esc_attr( $destination_option['value'] ) . '" name="' . $destination['id'] . '" value="' . esc_attr( $destination_option['value'] ) . '"' . checked( $cf_value, $destination_option['value'], false ) . ' />' . esc_html( $destination_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	// 宛先設定
	$mail_format = array(
		'name' => __( 'Mail Format', 'tcd-w' ),
		'id' => 'mail_format',
		'type' => 'radio',
		'std' => 'text',
		'options' => array(
			array(
				'name' => __( 'HTML mail', 'tcd-w' ),
				'value' => 'html'
			),
			array(
				'name' => __( 'TEXT mail (remove all html tags)', 'tcd-w' ),
				'value' => 'text'
			)
		)
	);
	$cf_value = $post->mail_format;
	if ( ! $cf_value ) {
		$cf_value = $mail_format['std'];
	}

	echo '<dt class="label"><label for="' . esc_attr( $mail_format['id'] ) . '">' . esc_html( $mail_format['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio side_content cf">';
	foreach ( $mail_format['options'] as $mail_format_option ) {
		echo '<li><label><input type="radio" id="' . esc_attr( $mail_format['id'] ) . '-' . esc_attr( $mail_format_option['value'] ) . '" name="' . $mail_format['id'] . '" value="' . esc_attr( $mail_format_option['value'] ) . '"' . checked( $cf_value, $mail_format_option['value'], false ) . ' />' . esc_html( $mail_format_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	$cf_key = 'from_email';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = get_option( 'admin_email' );
	echo '<dt class="label"><label>' . __( 'From email', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="large-text" name="' . esc_attr( $cf_key ) . '" type="email" value="' . esc_attr( $cf_value ) . '">';
	echo '</dd>' . "\n";

	$cf_key = 'from_name';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = get_bloginfo( 'name' );
	echo '<dt class="label"><label>' . __( 'From name', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="large-text" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '">';
	echo '</dd>' . "\n";

	$cf_key = 'to';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = get_option( 'admin_email' );
	echo '<dt class="label"><label>' . __( 'To email', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="large-text" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '">';
	echo '</dd>' . "\n";

	echo '<dt class="label"><label>' . __( 'Sent status', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';

	$sent_status = get_post_meta( $post->ID, 'sent_status', true );
	if ( isset( $sent_status['users'], $sent_status['timestamp'] ) ) {
		printf(
			__( 'Sent to %d users on %s', 'tcd-w' ),
			$sent_status['users'],
			date( 'Y/m/d H:i:s', $sent_status['timestamp'] )
		);
	} elseif ( $sent_status && is_string( $sent_status ) ) {
		echo $sent_status;
	} elseif ( $sent_status ) {
		print_r( $sent_status );
	} elseif ( 'future' == $post->post_status ) {
		echo __( 'Future send', 'tcd-w' );
	} else {
		echo __( 'Unsent', 'tcd-w' );
	}

	echo '</dd>' . "\n";

	echo '</dl>' . "\n";
}

/**
 * Mail Magazine カスタムフィールド保存
 */
function tcd_membership_mail_magazine_save_post( $post_id, $post, $update ) {
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
		// nothing
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// 送信済みなら終了
	$sent_status = get_post_meta( $post_id, 'sent_status', true );
	if ( $sent_status ) {
		return $post_id;
	}

	// ノンスがある場合のみメタ保存
	if ( ! empty( $_POST['tcd_membership_mail_magazine_meta_box_nonce'] ) && wp_verify_nonce( $_POST['tcd_membership_mail_magazine_meta_box_nonce'], 'tcd_membership_mail_magazine_meta_box_nonce-' . $post_id ) ) {
		$cf_keys = array(
			'destination',
			'mail_format',
			'from_email',
			'from_name',
			'to'
		);
		foreach ( $cf_keys as $cf_key ) {
			update_post_meta( $post_id, $cf_key, isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '' );
		}
	}

	// 公開中ならメール送信
	if ( 'publish' == $post->post_status ) {
		tcd_membership_mail_magazine_send_mail( $post_id, $post );
	}

	return $post_id;
}
add_action( 'save_post_mail_magazine', 'tcd_membership_mail_magazine_save_post', 10, 3 );

/**
 * Mail Magazine メール送信
 */
function tcd_membership_mail_magazine_send_mail( $post_id, $post ) {
	global $tcd_mail_magazine_vars;

	// 公開以外なら終了
	if ( 'publish' !== $post->post_status ) {
		return $post_id;
	}

	// 送信済みなら終了
	$sent_status = get_post_meta( $post_id, 'sent_status', true );
	if ( $sent_status ) {
		return $post_id;
	}

	$tcd_mail_magazine_vars = array();
	$tcd_mail_magazine_vars['post_id'] = $post_id;
	$tcd_mail_magazine_vars['destination'] = get_post_meta( $post_id, 'destination', true );
	$tcd_mail_magazine_vars['mail_format'] = get_post_meta( $post_id, 'mail_format', true );
	$tcd_mail_magazine_vars['from_email'] = get_post_meta( $post_id, 'from_email', true );
	$tcd_mail_magazine_vars['from_name'] = get_post_meta( $post_id, 'from_name', true );
	$tcd_mail_magazine_vars['to'] = get_post_meta( $post_id, 'to', true );

	if ( ! $tcd_mail_magazine_vars['from_email'] || ! is_email( $tcd_mail_magazine_vars['from_email'] ) ) {
		$tcd_mail_magazine_vars['from_email'] = get_option( 'admin_email' );
	}

	if ( ! $tcd_mail_magazine_vars['to'] ) {
		$tcd_mail_magazine_vars['to'] = $tcd_mail_magazine_vars['from_email'];
	}

	if ( 'type2' === $tcd_mail_magazine_vars['destination'] ) {
		$users = get_users( array(
			'orderby' => 'ID',
			'order' => 'ASC'
		) );
	} else {
		$users = get_users( array(
			'meta_key' => 'mail_magazine',
			'meta_value' => 'yes',
			'orderby' => 'ID',
			'order' => 'ASC'
		) );
	}

	if ( $users ) {
		$headers = array();

		foreach ( $users as $user ) {
			$headers[] = 'Bcc: ' . $user->user_email;
		}

		// HTMLメール
		if ( 'html' === $tcd_mail_magazine_vars['mail_format'] ) {
			$tcd_mail_magazine_vars['subject'] = $post->post_title;

			$content = apply_filters( 'the_content', $post->post_content );
			$tcd_mail_magazine_vars['message'] = <<< BOM
<html>
<head>
<title>{$post->post_title}</title>
</head>
<body>
{$content}
</body>
</html>
BOM;
			// コンテンツタイプフィルター追加
			add_filter( 'wp_mail_content_type', 'tcd_membership_mail_magazine_wp_mail_content_type_html', 20 );
		} else {
			$tcd_mail_magazine_vars['subject'] = $post->post_title;
			$tcd_mail_magazine_vars['message'] = strip_tags( $post->post_content );
		}

		// 送信元フィルター追加
		add_filter( 'wp_mail_from', 'tcd_membership_mail_magazine_wp_mail_from', 20 );
		add_filter( 'wp_mail_from_name', 'tcd_membership_mail_magazine_wp_mail_from_name', 20 );

		// 送信エラーフィルター追加
		add_action( 'wp_mail_failed', 'tcd_membership_mail_magazine_wp_mail_failed', 20 );

		// メール送信
		$result = wp_mail( $tcd_mail_magazine_vars['to'], $tcd_mail_magazine_vars['subject'], $tcd_mail_magazine_vars['message'], $headers );

		// フィルター削除
		remove_filter( 'wp_mail_from', 'tcd_membership_mail_magazine_wp_mail_from', 20 );
		remove_filter( 'wp_mail_from_name', 'tcd_membership_mail_magazine_wp_mail_from_name', 20 );
		remove_action( 'wp_mail_failed', 'tcd_membership_mail_magazine_wp_mail_failed', 20 );
		if ( 'html' === $tcd_mail_magazine_vars['mail_format'] ) {
			remove_filter( 'wp_mail_content_type', 'tcd_membership_mail_magazine_wp_mail_content_type_html', 20 );
		}

		// メタ保存
		$tcd_mail_magazine_vars['users'] = count( $users );
		update_post_meta( $post_id, '_sent_vars', $tcd_mail_magazine_vars );

		if ( $result ) {
			// 送信済みステータス
			update_post_meta( $post_id, 'sent_status', array(
				'users' => count( $users ),
				'timestamp' => current_time( 'timestamp' )
			) );
		}
	}
}

/**
 * Mail Magazine メール送信元メールアドレスフィルター
 */
function tcd_membership_mail_magazine_wp_mail_from( $from_email ) {
	global $tcd_mail_magazine_vars;
	return $tcd_mail_magazine_vars['from_email'];
}

/**
 * Mail Magazine メール送信元名フィルター
 */
function tcd_membership_mail_magazine_wp_mail_from_name( $from_name ) {
	global $tcd_mail_magazine_vars;
	return $tcd_mail_magazine_vars['from_name'];
}

/**
 * Mail Magazine コンテンツタイプフィルター
 */
function tcd_membership_mail_magazine_wp_mail_content_type_html( $content_type ) {
	return 'text/html';
}

/**
 * Mail Magazine メール送信エラーアクション
 */
function tcd_membership_mail_magazine_wp_mail_failed( $wp_error ) {
	global $tcd_mail_magazine_vars;
	if ( ! empty( $tcd_mail_magazine_vars['post_id'] ) ) {
		update_post_meta( $post_id, 'sent_status', $wp_error->get_error_messages() );
	}
}
