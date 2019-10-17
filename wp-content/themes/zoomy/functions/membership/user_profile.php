<?php

// 性別選択肢
global $gender_options;
$gender_options = array(
	'man' => array(
		'value' => 'man',
		'label' => __( 'Man', 'tcd-w' )
	),
	'woman' => array(
		'value' => 'woman',
		'label' => __( 'Woman', 'tcd-w' )
	),
	'notselected' => array(
		'value' => 'notselected',
		'label' => __( 'Not selected', 'tcd-w' )
	)
);

// メルマガ受信する・しない選択肢
global $receive_options;
$receive_options = array(
	'yes' => __( 'Do receive', 'tcd-w' ),
	'no' => __( 'Do not receive', 'tcd-w' )
);

// 通知する・しない選択肢
global $notify_options;
$notify_options = array(
	'yes' => __( 'Do notify', 'tcd-w' ),
	'no' => __( 'Do not notify', 'tcd-w' )
);

/**
 * 管理画面プロフィールURL項目にSNSを追加
 */
function tcd_user_profile_user_contactmethods( $methods, $user ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$user_contactmethods = array();

	if ( $dp_options['membership']['show_profile_facebook'] ) {
		$user_contactmethods['facebook_url'] = __( 'Facebook URL', 'tcd-w' );
	}

	if ( $dp_options['membership']['show_profile_twitter'] ) {
		$user_contactmethods['twitter_url'] = __( 'Twitter URL', 'tcd-w' );
	}

	if ( $dp_options['membership']['show_profile_instagram'] ) {
		$user_contactmethods['instagram_url'] = __( 'Instagram URL', 'tcd-w' );
	}

	return $user_contactmethods;
}
add_filter( 'user_contactmethods', 'tcd_user_profile_user_contactmethods', 10, 2 );

/**
 * 管理画面プロフィールに項目を追加
 */
function tcd_user_profile_edit_user_profile( $user ) {
	global $dp_options, $gender_options, $receive_options, $notify_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	wp_nonce_field( 'tcd_user_profile_edit_user_profile', 'tcd_user_profile_edit_user_profile_nonce', false );
?>
	<h3><?php _e( 'Other profile information', 'tcd-w' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="header_image"><?php _e( 'Profile image', 'tcd-w' ); ?></label></th>
			<td><?php echo get_tcd_user_profile_image_field( 'profile_image', $user ); ?>
			</td>
		</tr>
		<tr>
			<th><label for="header_image"><?php _e( 'Header image', 'tcd-w' ); ?></label></th>
			<td><?php echo get_tcd_user_profile_image_field( 'header_image', $user ); ?>
			</td>
		</tr>
<?php
	if ( $dp_options['membership']['show_account_area'] || $dp_options['membership']['show_profile_area'] ) {
?>
		<tr>
			<th><label for="area"><?php echo esc_html( get_tcd_user_profile_area_label() ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_area( $user->area ); ?></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['show_account_gender'] ) {
?>
		<tr>
			<th><label for="gender"><?php _e( 'Gender', 'tcd-w' ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_radio( 'gender', $gender_options, $user->gender, 'man' ); ?></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['show_account_birthday'] ) {
?>
		<tr>
			<th><label for="birthday"><?php _e( 'Birthday', 'tcd-w' ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_birthday( '_birthday', $user->_birthday ); ?></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['show_profile_job'] ) {
?>
		<tr>
			<th><label for="job"><?php _e( 'Job', 'tcd-w' ); ?></label></th>
			<td><input class="regular-text" id="job" name="job" type="text" value="<?php echo esc_attr( $user->job ); ?>"></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['use_mail_magazine'] ) {
?>
		<tr>
			<th><label for="mail_magazine"><?php _e( 'Mail magazine', 'tcd-w' ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_radio( 'mail_magazine', $receive_options, $user->mail_magazine, 'yes' ); ?></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['use_member_news_notify'] ) {
?>
		<tr>
			<th><label for="member_news_notify"><?php echo esc_html( $dp_options['membership']['member_news_notify_label'] ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_radio( 'member_news_notify', $notify_options, $user->member_news_notify, 'yes' ); ?></td>
		</tr>
<?php
	}
	if ( $dp_options['membership']['use_social_notify'] ) {
?>
		<tr>
			<th><label for="social_notify"><?php echo esc_html( $dp_options['membership']['social_notify_label'] ); ?></label></th>
			<td><?php echo get_tcd_user_profile_input_radio( 'social_notify', $notify_options, $user->social_notify, 'yes' ); ?></td>
		</tr>
<?php
	}
?>
	</table>
<?php
}
add_action( 'show_user_profile', 'tcd_user_profile_edit_user_profile', 11 );
add_action( 'edit_user_profile', 'tcd_user_profile_edit_user_profile', 11 );

/**
 * 管理画面プロフィールフォームにenctype出力
 */
function tcd_user_profile_edit_user_edit_form_tag() {
	echo ' enctype="multipart/form-data"';
}
add_action( 'user_edit_form_tag', 'tcd_user_profile_edit_user_edit_form_tag' );

/**
 * 管理画面プロフィール追加項目保存
 */
function tcd_user_profile_edit_user_profile_update( $user_id ) {
	if ( empty( $_POST['tcd_user_profile_edit_user_profile_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_user_profile_edit_user_profile_nonce'], 'tcd_user_profile_edit_user_profile' ) ) {
		return false;
	}

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$cf_keys = array(
		'header_image',
		'area',
		'gender',
		'_birthday',
		'job',
		'mail_magazine',
		'member_news_notify',
		'social_notify'
	);
	foreach ( $cf_keys as $cf_key ) {
		if ( isset( $_POST[$cf_key] ) ) {
			update_user_meta( $user_id, $cf_key, $_POST[$cf_key] );
		}
	}

	// 生年月日配列→文字列
	update_user_meta( $user_id, 'birthday', get_tcd_user_profile_birthday( isset( $_POST['_birthday'] ) ? $_POST['_birthday'] : '' ) );

	// upload files
	if ( current_user_can( 'upload_files' ) ) {
		// profile_image
		tcd_user_profile_image_field_upload( array(
			'user_id' => $user_id,
			'file_input_name' => 'profile_image',
			'width' => 300,	// width, height, crop で元ファイルをリサイズ
			'height' => 300,
			'crop' => true,
			'thumbnails' => array(	// サムネイル指定 ないサイズは読み込み時に自動生成されます
				array( 96, 96, true )
			)
		) );

		// header_image
		tcd_user_profile_image_field_upload( array(
			'user_id' => $user_id,
			'file_input_name' => 'header_image',
			'width' => 1920,	// width, height, crop で元ファイルをリサイズ
			'height' => 500,
			'crop' => true
		) );
	}
}
add_action( 'personal_options_update', 'tcd_user_profile_edit_user_profile_update' );
add_action( 'edit_user_profile_update', 'tcd_user_profile_edit_user_profile_update' );

/**
 * 住まいラベルを取得
 */
function get_tcd_user_profile_area_label() {
	global $dp_options;
	return ! empty( $dp_options['membership']['area_label'] ) ? $dp_options['membership']['area_label'] : __( 'Residence area', 'tcd-w' );
}

/**
 * 住まいセレクトを生成
 */
function get_tcd_user_profile_input_area( $value = null, $required = false, $confirm_label = null ) {
	global $dp_options;

	$ret = '<select id="area" name="area"' . ( $required ? ' required' : '' ) . ( $confirm_label ? ' data-confirm-label="' . esc_attr( $confirm_label ) . '"' : '' ) . '><option value=""></option>';

	foreach ( explode( "\n", $dp_options['membership']['area'] ) as $area ) {
		$area = trim( $area );
		if ( ! $area ) continue;

		$ret .= '<option value="' . esc_attr( $area ) . '"' . selected( $area, $value, false ) . '>' . esc_html( $area ) . '</option>';
	}

	return $ret . '</select>';
}

/**
 * ラジオを生成
 */
function get_tcd_user_profile_input_radio( $input_name, $radio_options, $current_value = null, $default_value = null, $confirm_label = null ) {
	if ( empty( $radio_options ) || ! is_array( $radio_options ) ) return false;

	if ( ! $current_value || ! array_key_exists( $current_value, $radio_options ) ) {
		$current_value = $default_value;
	}

	$ret = '';

	foreach ( $radio_options as $radio_option_value => $radio_option_label ) {
		if ( isset( $radio_option_label['label'], $radio_option_label['value'] ) ) {
			$radio_option_value = $radio_option_label['value'];
			$radio_option_label = $radio_option_label['label'];
		} elseif ( isset( $radio_option_label['label'] ) ) {
			$radio_option_label = $radio_option_label['label'];
		}
		if ( $ret ) {
			$ret .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$ret .= '<label><input name="' . esc_attr( $input_name ) . '" type="radio" value="' . esc_attr( $radio_option_value ) . '" ' . checked( $radio_option_value, $current_value, false ) . ( $confirm_label ? ' data-confirm-label="' . esc_attr( $confirm_label ) . '"' : '' ) . '> ' . esc_html( $radio_option_label ) . '</label>';
	}

	return $ret;
}

/**
 * 生年月日セレクトを生成
 */
function get_tcd_user_profile_input_birthday( $input_name, $current_value = null, $confirm_label = null ) {
	$max_year = date( 'Y' );
	$current_value_year = ! empty( $current_value['year'] ) ? $current_value['year'] : null;
	$current_value_month = ! empty( $current_value['month'] ) ? $current_value['month'] : null;
	$current_value_day = ! empty( $current_value['day'] ) ? $current_value['day'] : null;

	// year
	$year = '<select class="birthday-year" name="' . esc_attr( $input_name ) . '[year]"><option value=""></option>';
	for ( $i = 1900; $i <= $max_year; $i++ ) {
		$year .= '<option value="' . esc_attr( $i ) . '"' . selected( $i, $current_value_year, false ) . '>' . esc_html( $i ) . '</option>';
	}
	$year .= '</select>';

	// month
	$month = '<select class="birthday-month" name="' . esc_attr( $input_name ) . '[month]"><option value=""></option>';
	for ( $i = 1; $i <= 12; $i++ ) {
		$month .= '<option value="' . esc_attr( $i ) . '"' . selected( $i, $current_value_month, false ) . '>' . esc_html( $i ) . '</option>';
	}
	$month .= '</select>';

	// day
	$day = '<select class="birthday-day" name="' . esc_attr( $input_name ) . '[day]"><option value=""></option>';
	for ( $i = 1; $i <= 31; $i++ ) {
		$day .= '<option value="' . esc_attr( $i ) . '"' . selected( $i, $current_value_day, false ) . '>' . esc_html( $i ) . '</option>';
	}
	$day .= '</select>';

	$ret = sprintf( __( '%s / %s / %s', 'tcd-w' ), $year, $month, $day );

	// 確認用にダミー要素追加
	if ( $confirm_label ) {
		$ret .= '<input type="hidden" class="birthday-hidden" value="" data-confirm-label="' . esc_attr( $confirm_label ) . '" data-format-ymd="' . esc_attr__( 'y/m/d', 'tcd-w' ) . '" data-format-md="' . esc_attr__( 'm/d', 'tcd-w' ) . '">';
	}

	return $ret;
}

/**
 * 配列の生年月日を文字列に変換して返す
 */
function get_tcd_user_profile_birthday( $user_birthday = null ) {
	if ( null === $user_birthday ) {
		$user_birthday = wp_get_current_user();
	} elseif ( is_numeric( $user_birthday ) ) {
		$user_birthday = get_user_by( 'id', $user_birthday );
	}

	if ( is_a( $user_birthday, 'WP_User') ) {
		$user_birthday = $user_birthday->_birthday;
	}

	if ( $user_birthday ) {
		if ( is_array( $user_birthday ) ) {
			$user_birthday['year'] = ! empty( $user_birthday['year'] ) ? $user_birthday['year'] : null;
			$user_birthday['month'] = ! empty( $user_birthday['month'] ) ? $user_birthday['month'] : null;
			$user_birthday['day'] = ! empty( $user_birthday['day'] ) ? $user_birthday['day'] : null;

			if ( ! $user_birthday['year'] && $user_birthday['month'] && $user_birthday['day'] ) {
				return sprintf( __( '%s/%s', 'tcd-w' ), $user_birthday['month'], $user_birthday['day'] );
			} elseif ( $user_birthday['year'] && ! $user_birthday['month'] && ! $user_birthday['day'] ) {
				return sprintf( __( 'Year %s', 'tcd-w' ), $user_birthday['year'] );
			} else {
				return sprintf( __( '%s/%s/%s', 'tcd-w' ), $user_birthday['year'], $user_birthday['month'], $user_birthday['day'] );
			}
		} elseif ( is_string( $user_birthday ) ) {
			return $user_birthday;
		}
	}

	return '';
}

/**
 * ユーザーフォーム用 メディア登録しない画像ファイルフィールド出力
 */
function get_tcd_user_profile_image_field( $meta_key, $user, $accept = null ) {
	if ( ! current_user_can( 'upload_files' ) || ! $meta_key || empty( $user->ID ) ) {
		return false;
	}

	if ( ! $accept ) {
		$accept = 'image/jpeg,image/png,image/gif';
	}

	$image_url = $user->$meta_key;

	$ret = '<div class="user_profile_image_field">' . "\n";
	$ret .= "\t" . '<div class="preview_field">';

	if ( $image_url ) {
		$ret .= '<img src="' . esc_attr( $image_url ) . '" alt="">';
	}

	$ret .= '</div>' . "\n";
	$ret .= '<input type="file" name="' . esc_attr( $meta_key ) . '" accept="' . esc_attr( $accept ) . '">';

	if ( $image_url ) {
		$ret .= "\t" . '<div class="button_area">' . "\n";
		$ret .= "\t\t" . '<input type="button" class="button delete-button" value="' . __( 'Remove Image', 'tcd-w' ) . '" data-meta-key="' . esc_attr( $meta_key ) . '">' . "\n";
		$ret .= "\t" . '</div>' . "\n";
	}

	$ret .= '</div>' . "\n";

	return $ret;
}

/**
 * ユーザーフォームメディア登録しない画像ファイル用js
 */
function tcd_user_profile_image_field_scripts( $hook_suffix ) {
	if ( in_array( $hook_suffix, array( 'profile.php', 'user-edit.php' ) ) ) {
		wp_enqueue_script( 'tcd_user_profile_image', get_template_directory_uri() . '/admin/js/meta_image_delete.js', array( 'jquery' ), version_num() );
	}
}
add_action( 'admin_enqueue_scripts', 'tcd_user_profile_image_field_scripts' );

/**
 * ユーザーフォームメディア登録しない画像ファイル用 アップロード・リサイズ・メタ保存処理
 */
function tcd_user_profile_image_field_upload( $args ) {
	$default_args = array(
		'user_id' => 0,
		'file_input_name' => null,
		'meta_key' => null,
		'width' => null,	// width, height, crop で元ファイルをリサイズ
		'height' => null,
		'crop' => null,
		'thumbnails' => array()	// 元ファイルとは別にサムネイル生成 width, height, cropの配列を追加
		/* example
		'thumbnails' => array(
			array( 64, 64, true ),
			array( 1200, 0, false )
		)
		*/
	);

	$args = array_merge( $default_args, $args );

	if ( ! $args['user_id'] || ! $args['file_input_name'] ) {
		return false;
	}

	if ( ! $args['meta_key'] ) {
		$args['meta_key'] = $args['file_input_name'];
	}

	if ( ! empty( $_FILES[$args['file_input_name']]['name'] ) ) {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		// フィルターに渡すuser_id
		global $tcd_user_profile_image_user_id;
		$tcd_user_profile_image_user_id = $args['user_id'];

		// アップロードフォルダフィルター追加
		add_filter( 'upload_dir', '_filter_tcd_user_profile_image_field_upload_dir' );

		// EXIF回転、EXIF削除フィルター追加
		add_filter( 'wp_handle_upload', '_filter_tcd_wp_handle_upload_exif' );

		$wp_handle_upload = wp_handle_upload( $_FILES[$args['file_input_name']], array(
			'mimes' => array(
				'jpg|jpeg|jpe'	=> 'image/jpeg',
				'gif'			=> 'image/gif',
				'png'			=> 'image/png',
			),
			'test_form' => false,
			'unique_filename_callback' => '_tcd_user_profile_image_field_unique_filename_callback'
		) );

		// フィルター削除
		remove_filter( 'upload_dir', '_filter_tcd_user_profile_image_field_upload_dir' );
		remove_filter( 'wp_handle_upload', '_filter_tcd_wp_handle_upload_exif' );
		$tcd_user_profile_image_user_id = null;

		if ( ! empty( $wp_handle_upload['file'] ) && ! empty( $wp_handle_upload['url'] ) ) {
			// Windows directory separator対策 /に置換しないとメタ保存された際に\が消える
			if ( false !== strpos( $wp_handle_upload['file'], '\\' ) ) {
				$wp_handle_upload['file'] = str_replace( '\\', '/' , $wp_handle_upload['file'] );
			}

			// 旧ファイル削除
			if ( $args['user_id'] ) {
				tcd_user_profile_delete_image( $args['user_id'], $args['meta_key'] );
			}

			// 画像サイズ
			$imagesize = getimagesize( $wp_handle_upload['file'] );
			if ( $imagesize ) {
				$wp_handle_upload['width'] = $imagesize[0];
				$wp_handle_upload['height'] = $imagesize[1];
			}

			// サムネイル生成
			if ( $args['thumbnails'] && is_array( $args['thumbnails'] ) ) {
				foreach ( $args['thumbnails'] as $thumbnail ) {
					if ( ! $thumbnail || ! is_array( $thumbnail ) ) continue;

					if ( isset( $thumbnail['width'], $thumbnail['height'], $thumbnail['crop'] ) ) {
						$thumbnail_width = absint( $thumbnail['width'] );
						$thumbnail_height = absint( $thumbnail['height'] );
						$thumbnail_crop = (boolean) $thumbnail['crop'];
					} elseif ( isset( $thumbnail['width'], $thumbnail['height'] ) ) {
						$thumbnail_width = absint( $thumbnail['width'] );
						$thumbnail_height = absint( $thumbnail['height'] );
						$thumbnail_crop = false;
					} elseif ( isset( $thumbnail[0], $thumbnail[1], $thumbnail[2] ) ) {
						$thumbnail_width = absint( $thumbnail[0] );
						$thumbnail_height = absint( $thumbnail[1] );
						$thumbnail_crop = (boolean) $thumbnail[2];
					} elseif ( isset( $thumbnail[0], $thumbnail[1] ) ) {
						$thumbnail_width = absint( $thumbnail[0] );
						$thumbnail_height = absint( $thumbnail[1] );
						$thumbnail_crop = false;
					} elseif ( isset( $thumbnail[0] ) ) {
						$thumbnail_width = absint( $thumbnail[0] );
						$thumbnail_height = absint( $thumbnail[0] );
						$thumbnail_crop = false;
					} else {
						continue;
					}

					if ( $thumbnail_width || $thumbnail_height ) {
						$resize = image_make_intermediate_size( $wp_handle_upload['file'], $thumbnail_width, $thumbnail_height, $thumbnail_crop );

						// リサイズ成功時はurlをセット
						if ( ! empty( $resize['file'] ) ) {
							$wp_handle_upload['thumbnails'][$thumbnail_width . 'x' . $thumbnail_height] = dirname( $wp_handle_upload['url'] ) . '/' . $resize['file'];
						}
					}
				}
			}

			// リサイズ実行
			if ( $args['width'] || $args['height'] ) {
				$resize = image_make_intermediate_size( $wp_handle_upload['file'], $args['width'], $args['height'], $args['crop'] );

				// リサイズ成功時は元ファイルに上書き
				if ( ! empty( $resize['file'] ) ) {
					rename( dirname( $wp_handle_upload['file'] ) . '/' . $resize['file'], $wp_handle_upload['file'] );
					$wp_handle_upload['width'] = $resize['width'];
					$wp_handle_upload['height'] = $resize['height'];
				}
			}

			if ( $args['user_id'] ) {
				// meta_keyにurl保存
				update_user_meta( $args['user_id'], $args['meta_key'], $wp_handle_upload['url'] );

				// _meta_keyに全データ保存
				update_user_meta( $args['user_id'], '_' . $args['meta_key'], $wp_handle_upload );
			}

			return $wp_handle_upload;

		} elseif ( ! empty( $wp_handle_upload['error'] ) ) {
			return $wp_handle_upload['error'];
		}

	// ファイル削除のみ
	} elseif ( ! empty( $_POST['delete-meta-image-' . $args['meta_key']] ) ) {
		tcd_user_profile_delete_image( $args['user_id'], $args['meta_key'] );
	}

	return false;
}

/**
 * ユーザーフォームメディア登録しない画像ファイル用 アップロードフォルダフィルター
 */
function _filter_tcd_user_profile_image_field_upload_dir( $uploads ) {
	global $tcd_user_profile_image_user_id;
	$tcd_user_profile_image_user_id = intval( $tcd_user_profile_image_user_id );
	if ( 0 < $tcd_user_profile_image_user_id ) {
		$uploads['subdir'] = '/user/' . $tcd_user_profile_image_user_id;
		$uploads['path'] = $uploads['basedir'] . $uploads['subdir'];
		$uploads['url'] = $uploads['baseurl'] . $uploads['subdir'];
	}
	return $uploads;
}

/**
 * ユーザーフォームメディア登録しない画像ファイル用 ユニークファイル名コールバック
 */
function _tcd_user_profile_image_field_unique_filename_callback( $dir, $name, $ext ) {
	do {
		// ランダム文字列生成 (英小文字+数字)
		$randname = strtolower( wp_generate_password( 8, false, false ) );
	} while ( file_exists( $dir . '/' . $randname . $ext ) );
	return $randname . $ext;
}

/**
 * ユーザーフォームメディア登録しない画像ファイル用 画像削除
 */
function tcd_user_profile_delete_image( $user_id, $meta_key ) {
	$user_id = intval( $user_id );
	if ( 0 >= $user_id ) {
		return false;
	}

	$_meta = get_user_meta( $user_id, '_' . $meta_key, true );

	tcd_user_profile_delete_image_from_meta( $_meta );

	update_user_meta( $user_id, $meta_key, '' );
	update_user_meta( $user_id, '_' . $meta_key, '' );

	return true;
}
/**
 * ユーザーフォームメディア登録しない画像ファイル用 画像ファイル削除
 */
function tcd_user_profile_delete_image_from_meta( $_meta ) {
	if ( $_meta && ! is_array( $_meta ) ) {
		$_meta = maybe_unserialize( $_meta );
	}

	if ( ! empty( $_meta['file'] ) ) {
		if ( file_exists( $_meta['file'] ) ) {
			@unlink( $_meta['file'] );
		} else {
			$_meta = wp_unslash( $_meta );
			if ( file_exists( $_meta['file'] ) ) {
				@unlink( $_meta['file'] );
			}
		}

		if ( ! empty( $_meta['file'] ) && ! empty( $_meta['thumbnails'] ) && is_array( $_meta['thumbnails'] ) ) {
			$dir = dirname( $_meta['file'] );

			foreach ( $_meta['thumbnails'] as $thumbnail_url ) {
				$filepath = $dir . '/' . basename( $thumbnail_url );
				if ( file_exists( $filepath ) ) {
					@unlink( $filepath );
				}
			}
		}

		return true;
	}

	return false;
}

/**
 * get_avatarでプロフィール画像を使用するフィルター
 * Gravatarは使用しないようにpre_get_avatarにフック
 */
function tcd_pre_get_avatar( $avatar = '', $id_or_email, $args ) {
	// ディスカッション設定のデフォルトアバターの場合は終了
	if ( ! empty( $args['force_default'] ) ) {
		return $avatar;
	}

	if ( is_numeric( $id_or_email ) ) {
		$user_id = (int) $id_or_email;
	} elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
		$user_id = $user->ID;
	} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
		$user_id = (int) $id_or_email->user_id;
	}

	if ( empty( $user_id ) ) {
		return $avatar;
	}

	extract( $args );

	$profile_image = get_user_meta( $user_id, 'profile_image', true );
	$_profile_image = get_user_meta( $user_id, '_profile_image', true );

	if ( ! $profile_image || ! $_profile_image ) {
		return $avatar;
	}

	$size = (int) $size;
	$size_key = $size . 'x' . $size;

	if ( empty( $alt ) ) {
		$alt = get_the_author_meta( 'display_name', $user_id );
	}

	// generate a new size
	if ( ! empty( $_profile_image['file'] ) && empty( $_profile_image['thumbnails'][$size_key] ) ) {
		$resize = image_make_intermediate_size( $_profile_image['file'], $size, $size, true );
		// リサイズ成功時はurlをセットしてメタ更新
		if ( ! empty( $resize['file'] ) ) {
			$_profile_image['thumbnails'][$size_key] = dirname( $_profile_image['url'] ) . '/' . $resize['file'];
			update_user_meta( $user_id, '_profile_image', $_profile_image );
		}
	}

	// avater url
	if ( ! empty( $_profile_image['thumbnails'][$size_key] ) ) {
		$avater_url = $_profile_image['thumbnails'][$size_key];
	} elseif ( $profile_image ) {
		$avater_url = $profile_image;
	} elseif ( ! empty( $_profile_image['thumbnails']['url'] ) ) {
		$avater_url = $_profile_image['thumbnails']['url'];
	}

	$author_class = ! is_admin() && is_author( $user_id ) ? ' current-author' : '' ;

	$avatar = "<img alt='" . esc_attr( $alt ) . "' src='" . esc_url( $avater_url ) . "' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";

	return apply_filters( 'tcd_pre_get_avatar', $avatar );
}
add_filter( 'pre_get_avatar', 'tcd_pre_get_avatar', 10, 5 );

/**
 * 汎用 画像アップロードでEXIF情報から回転し、EXIF削除するフィルター
 */
function _filter_tcd_wp_handle_upload_exif( $upload ) {
	if ( ! isset( $upload['type'], $upload['file'] ) || 'image/jpeg' !== $upload['type'] || ! file_exists( $upload['file'] ) ) {
		return $upload;
	}

	// rotate

	$image = wp_get_image_editor( $upload['file'] );
	if ( function_exists( 'exif_read_data' ) ) {
		$exif = exif_read_data( $upload['file'] );
	} else {
		$exif = null;
	}

	if ( ! is_wp_error( $image ) && ! empty( $exif['Orientation'] ) ) {
		$rotated = false;

		switch ( $exif['Orientation'] ) {
			case 8:
				$image->rotate( 90 );
				$rotated = true;
				break;
			case 3:
				$image->rotate( 180 );
				$rotated = true;
				break;
			case 6:
				$image->rotate( -90 );
				$rotated = true;
				break;
		}

		if ( $rotated ) {
			$image->save( $upload['file'] );
		}

		$image = null;
	}

	// remove exif

	$jpeg_quality = apply_filters( 'jpeg_quality', 90 );

	if ( class_exists( 'Imagick' ) ) {
		$image = new Imagick( $upload['file'] );

		if ( $image->valid() ) {
			$image->setImageFormat( 'jpeg' );
			$image->setImageCompressionQuality( $jpeg_quality );
			$image->stripImage();
			$image->writeImage( $upload['file'] );
			$image->clear();
			$image->destroy();
		}
	} elseif ( function_exists( 'gd_info' ) ) {
		@$image = imagecreatefromjpeg( $upload['file'] );

		if ( $image ) {
			imagejpeg( $image, $upload['file'], $jpeg_quality );
			imagedestroy( $image );
		}
	}

	return $upload;
}
