<?php

/**
メタ main_image にはアップロードした画像urlが入ります。
メタ _main_image には配列で各種情報が入ります。
array(
	'file' => 画像ファイルのフルパス,
	'url' => 画像url,
	'width' => 画像横幅,
	'height' => 画像高さ,
	'type' => MIME type,
	（リサイズ設定している場合はオリジナル画像ではなくリサイズ画像に差し変わります。またAjaxアップロードの場合はリサイズされた状態で送信されています。）
	'thumbnails' => array(	// サムネイル配列
		'300x300' => サムネイル画像url （300x300は実画像サイズではなくサムネイル指定サイズでファイル名につくものは実画像サイズ）,
		'600x600' => サムネイル画像url
	)
)
*/

/**
 * メイン画像 メタボックス追加
 */
function tcd_membership_main_image_add_meta_box() {
	global $dp_options;

	add_meta_box(
		'tcd_membership_main_image_meta_box', // ID of meta box
		__( 'Main photo', 'tcd-w' ), // label
		'tcd_membership_main_image_show_meta_box', // callback function
		array( 'post', $dp_options['photo_slug'] ), // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_membership_main_image_add_meta_box', 9 );

/**
 * メイン画像 記事編集フォームにenctype出力
 */
function tcd_membership_blog_post_edit_form_tag( $post ) {
	global $dp_options;

	if ( in_array( $post->post_type, array( 'post', $dp_options['photo_slug'] ) ) ) {
		echo ' enctype="multipart/form-data"';
	}
}
add_action( 'post_edit_form_tag', 'tcd_membership_blog_post_edit_form_tag' );

/**
 * メイン画像 メタボックス表示
 */
function tcd_membership_main_image_show_meta_box() {
	global $post;

 	echo '<input type="hidden" name="tcd_membership_main_image_meta_box_nonce" value="' . wp_create_nonce( 'tcd_membership_main_image_meta_box-' . $post->ID ) . '">';

	echo get_tcd_membership_meta_image_field( $post->ID, 'main_image' );
	echo '<p>' . __( 'It is used for thumbnails preferentially over post thumbnail.', 'tcd-w' ) . '<br>' . __( 'It is not register <a href="./upload.php">Media library</a>.', 'tcd-w' ) . '</p>';
}

/**
 * メイン画像 メタボックス保存処理
 */
function tcd_membership_main_image_save_post( $post_id, $post ) {
	global $dp_options;

	// verify nonce
	if ( ! isset( $_POST['tcd_membership_main_image_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_membership_main_image_meta_box_nonce'], 'tcd_membership_main_image_meta_box-' . $post_id ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	if ( current_user_can( 'upload_files' ) ) {
		global $_wp_additional_image_sizes;

		if ( $post->post_type === $dp_options['photo_slug'] ) {
			tcd_membership_meta_image_field_upload( array(
				'post_id' => $post_id,
				'file_input_name' => 'main_image',
				'post_type_photo' => true,	// 写真投稿タイプフラグ 正方形or縦長or横長でリサイズサイズ変更
				'width' => 1200,
				'height' => 1000,
				'crop' => false,
				'thumbnails' => array(
					$_wp_additional_image_sizes['size1'],
					$_wp_additional_image_sizes['size2']
				)
			) );
		} else {
			tcd_membership_meta_image_field_upload( array(
				'post_id' => $post_id,
				'file_input_name' => 'main_image',
				'width' => 850,	// width, height, crop で元ファイルをリサイズ
				'height' => 0,
				'crop' => false,
				'thumbnails' => array(
					$_wp_additional_image_sizes['size1'],
					$_wp_additional_image_sizes['size2']
				)
			) );
		}
	}
}
add_action( 'save_post', 'tcd_membership_main_image_save_post', 10, 2 );

/**
 * カスタムフィールド メディア登録しない画像ファイルフィールド出力
 */
function get_tcd_membership_meta_image_field( $post_id, $meta_key, $accept = null ) {
	if ( ! current_user_can( 'upload_files' ) || ! $post_id || ! $meta_key ) {
		return false;
	}

	if ( ! $accept ) {
		$accept = 'image/jpeg,image/png,image/gif';
	}

	$image_url = get_post_meta( $post_id, $meta_key, true );

	$ret = '<div class="meta_image_field">' . "\n";
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
 * カスタムフィールド メディア登録しない画像ファイル用js
 */
function tcd_membership_meta_image_field_scripts( $hook_suffix ) {
	global $dp_options, $typenow;
	if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) && in_array( $typenow, array( 'post', $dp_options['photo_slug'] ) ) ) {
		wp_enqueue_script( 'tcd_membership_meta_image_image', get_template_directory_uri() . '/admin/js/meta_image_delete.js', array( 'jquery' ), version_num() );
	}
}
add_action( 'admin_enqueue_scripts', 'tcd_membership_meta_image_field_scripts' );

/**
 * カスタムフィールド メディア登録しない画像ファイル用 アップロード・リサイズ・メタ保存処理
 */
function tcd_membership_meta_image_field_upload( $args ) {
	$default_args = array(
		'post_id' => 0,
		'file_input_name' => null,
		'file_input_name_array_key' => null, // $_FILES['file_input_name'][1]形式の場合の1の部分
		'meta_key' => null,
		'width' => null,	// width, height, crop で元ファイルをリサイズ
		'height' => null,
		'crop' => null,
		'post_type_photo' => true,	// 写真投稿タイプフラグ 正方形or縦長or横長でリサイズサイズ変更
		'thumbnails' => array()	// 元ファイルとは別にサムネイル生成 width, height, cropの配列を追加
		/* example
		'thumbnails' => array(
			array( 64, 64, true ),
			array( 1200, 0, false )
		)
		*/
	);

	$args = array_merge( $default_args, $args );

	if ( ! $args['file_input_name'] ) {
		return false;
	}

	if ( ! $args['meta_key'] && null !== $args['file_input_name_array_key'] ) {
		$args['meta_key'] = $args['file_input_name'] . '_' . $args['file_input_name_array_key'];
	} elseif ( ! $args['meta_key'] ) {
		$args['meta_key'] = $args['file_input_name'];
	}

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	// EXIF回転、EXIF削除フィルター追加
	add_filter( 'wp_handle_upload', '_filter_tcd_wp_handle_upload_exif' );

	if ( null !== $args['file_input_name_array_key'] && ! empty( $_FILES[$args['file_input_name']][$args['file_input_name_array_key']]['name'] ) ) {
		$wp_handle_upload = wp_handle_upload( $_FILES[$args['file_input_name']][$args['file_input_name_array_key']], array(
			'mimes' => array(
				'jpg|jpeg|jpe'	=> 'image/jpeg',
				'gif'			=> 'image/gif',
				'png'			=> 'image/png',
			),
			'test_form' => false,
			'unique_filename_callback' => '_tcd_membership_meta_image_field_unique_filename_callback'
		) );
	}

	if ( ! empty( $_FILES[$args['file_input_name']]['name'] ) ) {
		$wp_handle_upload = wp_handle_upload( $_FILES[$args['file_input_name']], array(
			'mimes' => array(
				'jpg|jpeg|jpe'	=> 'image/jpeg',
				'gif'			=> 'image/gif',
				'png'			=> 'image/png',
			),
			'test_form' => false,
			'unique_filename_callback' => '_tcd_membership_meta_image_field_unique_filename_callback'
		) );
	}

	// ファイル削除のみ
	if ( empty( $wp_handle_upload ) && ! empty( $_POST['delete-meta-image-' . $args['meta_key']] ) ) {
		tcd_membership_meta_image_delete( $args['post_id'], $args['meta_key'] );
		return;
	}

	// EXIF回転、EXIF削除フィルター削除
	remove_filter( 'wp_handle_upload', '_filter_tcd_wp_handle_upload_exif' );

	if ( ! empty( $wp_handle_upload['file'] ) && ! empty( $wp_handle_upload['url'] ) ) {
		// Windows directory separator対策 /に置換しないとメタ保存された際に\が消える
		if ( false !== strpos( $wp_handle_upload['file'], '\\' ) ) {
			$wp_handle_upload['file'] = str_replace( '\\', '/' , $wp_handle_upload['file'] );
		}

		// 旧ファイル削除
		if ( $args['post_id'] ) {
			tcd_membership_meta_image_delete( $args['post_id'], $args['meta_key'] );
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

		// 写真投稿タイプフラグがあればリサイズサイズ上書き
		if ( $args['post_type_photo'] && $imagesize ) {
			global $_wp_additional_image_sizes;

			// 正方形
			if ( $imagesize[0] == $imagesize[1] && isset( $_wp_additional_image_sizes['size-photo3'] ) ) {
				$args['width'] = $_wp_additional_image_sizes['size-photo3']['width'];
				$args['height'] = $_wp_additional_image_sizes['size-photo3']['height'];
				$args['crop'] = $_wp_additional_image_sizes['size-photo3']['crop'];

				// 設定サイズ以下ならリサイズ実行不要
				if ( $imagesize[0] <= $args['width'] && $imagesize[1] <= $args['height'] ) {
					$args['width'] = 0;
					$args['height'] = 0;
				}

			// 縦長
			} elseif ( $imagesize[0] < $imagesize[1] && isset( $_wp_additional_image_sizes['size-photo2'] ) ) {
				$args['width'] = $_wp_additional_image_sizes['size-photo2']['width'];
				$args['height'] = $_wp_additional_image_sizes['size-photo2']['height'];
				$args['crop'] = $_wp_additional_image_sizes['size-photo2']['crop'];

				// 設定サイズ以下ならリサイズ実行不要
				if ( $imagesize[0] <= $args['width'] && $imagesize[1] <= $args['height'] ) {
					$args['width'] = 0;
					$args['height'] = 0;

				// 縦横比を比較して設定値の方が縦長なら横幅は成り行きに
				} elseif ( $args['width'] && $args['height'] && $args['height'] / $args['width'] < $imagesize[1] / $imagesize[0] ) {
					$args['width'] = 0;
				}

			// 横長
			} elseif ( isset( $_wp_additional_image_sizes['size-photo1'] ) ) {
				$args['width'] = $_wp_additional_image_sizes['size-photo1']['width'];
				$args['height'] = $_wp_additional_image_sizes['size-photo1']['height'];
				$args['crop'] = $_wp_additional_image_sizes['size-photo1']['crop'];

				// 設定サイズ以下ならリサイズ実行不要
				if ( $imagesize[0] <= $args['width'] && $imagesize[1] <= $args['height'] ) {
					$args['width'] = 0;
					$args['height'] = 0;

				// 縦横比を比較して設定値の方が横長なら高さは成り行きに
				} elseif ( $args['width'] && $args['height'] && $args['height'] / $args['width'] > $imagesize[1] / $imagesize[0] ) {
					$args['height'] = 0;
				}
			}
		}

		// リサイズ実行
		if ( $args['width'] || $args['height'] ) {
			$resize = image_make_intermediate_size( $wp_handle_upload['file'], $args['width'], $args['height'], $args['crop'] );

			// リサイズ成功時は元ファイルに上書き
			if ( ! empty( $resize['file'] ) ) {
				// renameが「The process cannot access the file because it is being used by another process. (code: 32)」になる場合があるので少し待つ
				usleep ( 100 );

				rename( dirname( $wp_handle_upload['file'] ) . '/' . $resize['file'], $wp_handle_upload['file'] );
				$wp_handle_upload['width'] = $resize['width'];
				$wp_handle_upload['height'] = $resize['height'];
			}
		}

		if ( $args['post_id'] ) {
			// meta_keyにurl保存
			update_post_meta( $args['post_id'], $args['meta_key'], $wp_handle_upload['url'] );

			// _meta_keyに全データ保存
			update_post_meta( $args['post_id'], '_' . $args['meta_key'], $wp_handle_upload );
		}

		return $wp_handle_upload;

	} elseif ( ! empty( $wp_handle_upload['error'] ) ) {
		return $wp_handle_upload['error'];
	}

	return false;
}

/**
 * カスタムフィールド メディア登録しない画像ファイル用 ユニークファイル名コールバック
 */
function _tcd_membership_meta_image_field_unique_filename_callback( $dir, $name, $ext ) {
	do {
		// ランダム文字列生成 (英小文字+数字)
		$randname = strtolower( wp_generate_password( 8, false, false ) );
	} while ( file_exists( $dir . '/' . $randname . $ext ) );
	return $randname . $ext;
}

/**
 * カスタムフィールド メディア登録しない画像ファイル用 メタ画像削除
 */
function tcd_membership_meta_image_delete( $post_id, $meta_key ) {
	if ( ! $post_id ) {
		return false;
	}

	$_meta = get_post_meta( $post_id, '_' . $meta_key, true );

	tcd_membership_delete_image_from_meta( $_meta );

	update_post_meta( $post_id, $meta_key, '' );
	update_post_meta( $post_id, '_' . $meta_key, '' );

	return true;
}

/**
 * カスタムフィールド メディア登録しない画像ファイル用 画像ファイル削除
 */
function tcd_membership_delete_image_from_meta( $_meta ) {
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
 * 記事がメイン画像を持っているか
 */
function has_main_image( $post = null, $meta_key = 'main_image' ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$meta = get_post_meta( $post->ID, $meta_key, true );
	$_meta = get_post_meta( $post->ID, '_' . $meta_key, true );

	if ( $meta || $_meta ) {
		return true;
	} else {
		return false;
	}
}

/**
 * 記事のメイン画像imgタグ出力
 */
function the_main_image( $size = 'full', $alt = null ) {
	echo get_meta_image( null, 'main_image', $size, $alt );
}

/**
 * 記事のメイン画像タグを返す
 */
function get_main_image( $size = 'full', $alt = null ) {
	return get_meta_image( null, 'main_image', $size, $alt );
}

/**
 * 記事のメイン画像urlを返す
 */
function get_main_image_url( $size = 'full' ) {
	return get_meta_image_url( null, 'main_image', $size );
}

/**
 * 記事のメタ画像imgタグ出力
 */
function the_meta_image( $meta_key = 'main_image', $size = 'full', $alt = null ) {
	echo get_meta_image( null, $meta_key, $size, $alt );
}

/**
 * 記事のメタ画像imgタグを返す
 */
function get_meta_image( $post = null, $meta_key = 'main_image', $size = 'full', $alt = null ) {
	$html = '';
	$src = get_meta_image_url( $post, $meta_key, $size );

	if ( $src ) {
		$html = '<img src="' . esc_attr( $src ) . '" alt="' . esc_attr( strip_tags( $alt ) ) . '">';
	}

	return apply_filters( 'get_meta_image', $html, $post, $meta_key, $size, $alt );
}

/**
 * 記事のメタ画像urlを返す
 */
function get_meta_image_url( $post = null, $meta_key = 'main_image', $size = 'full' ) {
	global $_wp_additional_image_sizes;

	$post = get_post( $post );
	if ( ! $post ) {
		return false;
	}

	$src = false;
	$meta = get_post_meta( $post->ID, $meta_key, true );
	$_meta = get_post_meta( $post->ID, '_' . $meta_key, true );

	if (! is_array( $_meta ) ) {
		$_meta2 = maybe_unserialize( $_meta );
		if ( $_meta2 && is_array( $_meta2 ) ) {
			$_meta = $_meta2;
		}
	}

	// フルサイズURL
	if ( $meta ) {
		$src = $meta;
	}

	// サムネイルURLを探す
	if ( $_meta && $size && 'full' != $size ) {
		$size_key = null;

		if ( is_string( $size ) && isset( $_wp_additional_image_sizes[$size] ) ) {
			$size_key = $_wp_additional_image_sizes[$size]['width'] . 'x' . $_wp_additional_image_sizes[$size]['height'];
		} elseif ( is_array( $size ) ) {
			if ( isset( $size['width'], $size['height'] ) ) {
				$size_key = $size['width'] . 'x' . $size['height'];
			} elseif ( isset( $size['width'] ) ) {
				$size_key = $size['width'] . 'x' . $size['width'];
			} elseif ( isset( $size[0], $size[1] ) ) {
				$size_key = $size[0] . 'x' . $size[1];
			} elseif ( isset( $size[0] ) ) {
				$size_key = $size[0] . 'x' . $size[0];
			}
		}

		if ( $size_key && isset( $_meta['thumbnails'][$size_key] ) ) {
			$src = $_meta['thumbnails'][$size_key];
		}
	}

	return apply_filters( 'get_meta_image_url', $src, $post, $meta_key, $size );
}

/**
 * フロント用画像アップロードフィールド 投稿用・ユーザー用兼用
 */
function tcd_membership_image_upload_field( $args = array() ) {
	$default_args = array(
		'drop_attribute' => '',
		'echo' => true,
		'hidden_inputs' => array(),
		'image_url' => '',	// 現在の画像url
		'indent' => 7,
		'input_id' => null,
		'input_name' => null,
		'overlay_headline' => '<h3 class="p-membership-form__image-upload__label-headline">' . __( 'Select photo', 'tcd-w' ) . '</h3>',
		'overlay_desc' => '',
		'show_delete_button' => true
	);
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'tcd_membership_image_upload_field_args', $args );

	if ( ! $args['input_name'] ) {
		return false;
	}

	if ( ! $args['input_id'] ) {
		$args['input_id'] = $args['input_name'];
	}

	$args = apply_filters( 'tcd_membership_image_upload_field-' . $args['input_name'], $args );

	if ( $args['drop_attribute'] && is_array( $args['drop_attribute'] ) ) {
		$args['drop_attribute'] = implode( ' ', $args['drop_attribute'] );
	}
	if ( $args['drop_attribute'] ) {
		$args['drop_attribute'] = ' ' . trim( $args['drop_attribute'] );
	} else {
		$args['drop_attribute'] = '';
	}

	$ret = str_repeat( "\t" , $args['indent'] );
	$ret .= '<div class="p-membership-form__image-upload__drop' . ( $args['image_url'] ? ' has-image' : '' ) . '"' . $args['drop_attribute'] . '>' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 1 );
	$ret .= '<div class="p-membership-form__image-upload__drop-inner"' . ( $args['image_url'] ? ' style="background-image:url(' . esc_url( $args['image_url'] ) . ');"' : '' ) . '>' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 2 );
	$ret .= '<label class="p-membership-form__image-upload__drop-inner2" for="' . esc_attr( $args['input_id'] ) . '">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 3 );
	$ret .= '<div class="p-membership-form__image-upload__drop-inner3">' . "\n";

	if ( $args['overlay_headline'] ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 4 );
		$ret .= $args['overlay_headline'] . "\n";
	}

	if ( $args['overlay_desc'] ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 4 );
		$ret .= '<div class="p-membership-form__image-upload__label-desc">' . $args['overlay_desc'] . "</div>\n";
	}

	$ret .= str_repeat( "\t" , $args['indent'] + 3 ) . "</div>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 2 ) . "</label>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 1 );
	$ret .= '<input type="file" id="' . esc_attr( $args['input_id'] ) . '" name="' . esc_attr( $args['input_name'] ) . '" accept="image/jpeg,image/png,image/gif" class="p-membership-form__image-upload__input">' . "\n";

	if ( $args['show_delete_button'] ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 1 );
		$ret .= '<input type="hidden" class="p-membership-form__image-upload__delete-hidden p-membership-form__overlay-button" id="delete-' . esc_attr( $args['input_id'] ) . '" name="delete-' . esc_attr( $args['input_name'] ) . '" value="0"><button class="p-membership-form__image-upload__delete-button p-membership-form__overlay-button">' . esc_attr__( 'Delete', 'tcd-w' ) . '</button>' . "\n";
	}

	$ret .= str_repeat( "\t" , $args['indent'] + 1 ) . "</div>\n";

	if ( $args['hidden_inputs'] && is_array( $args['hidden_inputs'] ) ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 1 );
		foreach( $args['hidden_inputs'] as $hidden_input_name => $hidden_input_value ) {
			$ret .= '<input class="p-membership-form__image-upload__hidden" name="' . esc_attr( $hidden_input_name ) . '" type="hidden" value="' . esc_attr( $hidden_input_value ) . '">';
		}
		$ret .= "\n";
	}

	$ret .= str_repeat( "\t" , $args['indent'] ) . "</div>\n";

	$ret = apply_filters( 'tcd_membership_image_upload_field', $ret, $args );

	if ( $args['echo'] ) {
		echo $ret;
	} else {
		return $ret;
	}
}

/**
 * フロント用画像アップロードフィールド シンプル版
 */
function tcd_membership_image_upload_field_tiny( $args = array() ) {
	$default_args = array(
		'echo' => true,
		'hidden_inputs' => array(),
		'image_url' => '',	// 現在の画像url
		'indent' => 7,
		'input_id' => null,
		'input_name' => null,
		'show_delete_button' => true,
		'tiny_label' => __( 'Select photo', 'tcd-w' )
	);
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'tcd_membership_image_upload_field_tiny_args', $args );

	if ( ! $args['input_name'] ) {
		return false;
	}

	if ( ! $args['input_id'] ) {
		$args['input_id'] = $args['input_name'];
	}

	$args = apply_filters( 'tcd_membership_image_upload_field-' . $args['input_name'], $args );

	$ret = str_repeat( "\t" , $args['indent'] );
	$ret .= '<div class="p-membership-form__image-upload-tiny">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 1 );
	$ret .= '<div class="p-membership-form__image-upload__drop' . ( $args['image_url'] ? ' has-image' : '' ) . '">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 2 );
	$ret .= '<div class="p-membership-form__image-upload__drop-inner"' . ( $args['image_url'] ? ' style="background-image:url(' . esc_url( $args['image_url'] ) . ');"' : '' ) . '>' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 3 );
	$ret .= '<label class="p-membership-form__image-upload__drop-inner2" for="' . esc_attr( $args['input_id'] ) . '">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 4 );
	$ret .= '<div class="p-membership-form__image-upload__drop-inner3">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 4 ) . "</div>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 3 ) . "</label>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 2 );
	$ret .= '<input type="file" id="' . esc_attr( $args['input_id'] ) . '" name="' . esc_attr( $args['input_name'] ) . '" accept="image/jpeg,image/png,image/gif" class="p-membership-form__image-upload__input">' . "\n";

	if ( $args['show_delete_button'] ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 2 );
		$ret .= '<input type="hidden" class="p-membership-form__image-upload__delete-hidden p-membership-form__overlay-button" id="delete-' . esc_attr( $args['input_id'] ) . '" name="delete-' . esc_attr( $args['input_name'] ) . '" value="0"><button class="p-membership-form__image-upload__delete-button p-membership-form__overlay-button">' . esc_attr__( 'Delete', 'tcd-w' ) . '</button>' . "\n";
	}

	$ret .= str_repeat( "\t" , $args['indent'] + 2 ) . "</div>\n";

	if ( $args['hidden_inputs'] && is_array( $args['hidden_inputs'] ) ) {
		$ret .= str_repeat( "\t" , $args['indent'] + 2 );
		foreach( $args['hidden_inputs'] as $hidden_input_name => $hidden_input_value ) {
			$ret .= '<input class="p-membership-form__image-upload__hidden" name="' . esc_attr( $hidden_input_name ) . '" type="hidden" value="' . esc_attr( $hidden_input_value ) . '">';
		}
		$ret .= "\n";
	}

	$ret .= str_repeat( "\t" , $args['indent'] + 1 ) . "</div>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 1 );
	$ret .= '<div class="p-membership-form__image-upload-tiny__drop">' . "\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 2 );
	$ret .= '<label class="p-membership-form__image-upload-tiny__label" for="' . esc_attr( $args['input_id'] ) . '">' . esc_html( $args['tiny_label'] ) . "</label>\n";

	$ret .= str_repeat( "\t" , $args['indent'] + 1 ) . "</div>\n";

	$ret .= str_repeat( "\t" , $args['indent'] ) . "</div>\n";

	$ret = apply_filters( 'tcd_membership_image_upload_field_tiny', $ret, $args );

	if ( $args['echo'] ) {
		echo $ret;
	} else {
		return $ret;
	}
}

/**
 * 記事削除時にメディア登録していない画像削除
 */
function tcd_membership_image_delete_before_delete_post( $post_id ) {
	global $dp_options;

	$post = get_post( $post_id );

	$meta_image_keys = array();

	if ( 'post' === $post->post_type ) {
		$meta_image_keys = array(
			'main_image',
			'image'
		);

		for ( $i = 0; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			$meta_image_keys[] = 'image' . $si;
		}

	} elseif ( $dp_options['photo_slug'] === $post->post_type ) {
		$meta_image_keys = array(
			'main_image'
		);
	}

	if ( $meta_image_keys ) {
		foreach ( $meta_image_keys as $meta_image_key ) {
			tcd_membership_meta_image_delete( $post_id, $meta_image_key );
		}
	}
}
add_action( 'before_delete_post', 'tcd_membership_image_delete_before_delete_post' );

/**
 * ajaxでのフロント用画像アップロード 投稿用・ユーザー用兼用
 */
function tcd_membership_ajax_image_upload() {
	global $dp_options, $tcd_membership_vars, $_wp_additional_image_sizes;

	$json = array(
		'success' => false
	);

	if ( ! isset( $_POST['type'], $_POST['nonce'] ) && ! in_array( $_POST['type'], $tcd_membership_vars['memberpage_image_upload_types'] ) ) {
		$json['message'] = __( 'Invalid request.', 'tcd-w' );
	} elseif ( ! current_user_can( 'read' ) ) {
		$json['message'] = __( 'Require login.', 'tcd-w' );

	// プロフィール編集
	} elseif ( 'edit_profile' === $_POST['type'] ) {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-edit_profile' ) ) {
			$json['message'] = __( 'Invalid nonce.', 'tcd-w' );
		} else {
			$user_id = get_current_user_id();

			// ファイルアップロード header_image
			if ( ! empty( $_FILES['header_image']['name'] ) ) {
				$upload = tcd_user_profile_image_field_upload( array(
					'user_id' => $user_id,	// 確認画面はないのでこの時点でuser_idを渡してユーザーメタ上書き
					'file_input_name' => 'header_image',
					'width' => 1920,
					'height' => 500,
					'crop' => true
				) );

				// 成功 確認画面はないので$json['uploaded']は不要
				if ( ! empty( $upload['url'] ) ) {
					$json['header_image'] = $upload['url'];

				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Header image', 'tcd-w' ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Header image', 'tcd-w' ) );
				}
			}

			// ファイルアップロード profile_image
			if ( ! empty( $_FILES['profile_image']['name'] ) ) {
				$upload = tcd_user_profile_image_field_upload( array(
					'user_id' => $user_id,	// 確認画面はないのでこの時点でuser_idを渡してユーザーメタ上書き
					'file_input_name' => 'profile_image',
					'width' => 300,	// width, height, crop で元ファイルをリサイズ
					'height' => 300,
					'crop' => true,
					'thumbnails' => array(
						array( 96, 96, true )
					)
				) );

				// 成功 確認画面はないので$json['uploaded']は不要
				if ( ! empty( $upload['url'] ) ) {
					$json['profile_image'] = $upload['url'];

				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Profile image', 'tcd-w' ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Profile image', 'tcd-w' ) );
				}
			}
		}

	// ブログ・写真 追加・編集
	} else {
		if ( ! isset( $_POST['post_id'] ) || ! wp_verify_nonce( $_POST['nonce'], 'tcd-membership-' . $_POST['type'] . '-' . $_POST['post_id'] ) ) {
			$json['message'] = __( 'Invalid nonce.', 'tcd-w' );

		// ブログ 追加・編集
		} elseif ( in_array( $_POST['type'], array( 'add_blog', 'edit_blog' ) ) ) {
			// ブログ 編集はpostチェック
			if ( 'edit_blog' === $_POST['type'] ) {
				$post = get_post( $_POST['post_id'] );
				if ( ! $post || 'post' !== $post->post_type ) {
					$json['message'] = __( 'Incorrect post id.', 'tcd-w' );
				} elseif ( get_current_user_id() != $post->post_author && ! current_user_can( 'edit_post', $_POST['post_id'] ) ) {
					$json['message'] = sprintf( __( 'You do not have permission to edit this %s.', 'tcd-w' ), $dp_options['blog_label'] );
				}
			}

			if ( empty( $json['message'] ) ){
				// ファイルアップロード main_image
				if ( ! empty( $_FILES['file_main_image']['name'] ) ) {
					$upload = tcd_membership_meta_image_field_upload( array(
						'post_id' => 0, // post_idを指定するとプレビュー確認時に上書きされてしまう
						'file_input_name' => 'file_main_image',
						'meta_key' => 'main_image',
						'width' => 850,
						'height' => 0,
						'crop' => false,
						'thumbnails' => array(
							$_wp_additional_image_sizes['size1'],
							$_wp_additional_image_sizes['size2']
						)
					) );

					// 成功
					if ( ! empty( $upload['url'] ) ) {
						$json['uploaded']['main_image'] = $upload['url'];
						// _main_imageは保存時にテンポラリー画像から取得

						// テンポラリー画像として登録
						tcd_membership_add_temp_image( $upload );

					// エラー
					} elseif ( is_string( $upload ) ) {
						$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Main photo', 'tcd-w' ), $upload );
					} else {
						$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) );
					}
				}

				// ファイルアップロード image,image1-image9
				for ( $i = 0; $i < 10; $i++ ) {
					$si = 0 < $i ? $i : '';
					if ( ! empty( $_FILES['file_image' . $si]['name'] ) ) {
						$upload = tcd_membership_meta_image_field_upload( array(
							'post_id' => 0, // post_idを指定するとプレビュー確認時に上書きされてしまう
							'file_input_name' => 'file_image' . $si,
							'meta_key' => 'image' . $si,
							'width' => 850,
							'height' => 0,
							'crop' => false,
							'thumbnails' => array()
						) );

						// 成功
						if ( ! empty( $upload['url'] ) ) {
							$json['uploaded']['image' . $si] = $upload['url'];
							// _imageは保存時にテンポラリー画像から取得

							// テンポラリー画像として登録
							tcd_membership_add_temp_image( $upload );
						}
					}
				}
			}

		// 写真 追加・編集
		} elseif ( in_array( $_POST['type'], array( 'add_photo', 'edit_photo' ) ) ) {
			// ブログ 編集はpostチェック
			if ( 'edit_photo' === $_POST['type'] ) {
				$post = get_post( $_POST['post_id'] );
				if ( ! $post || $post->post_type !== $dp_options['photo_slug'] ) {
					$json['message'] = __( 'Incorrect post id.', 'tcd-w' );
				} elseif ( get_current_user_id() != $post->post_author && ! current_user_can( 'edit_post', $_POST['post_id'] ) ) {
					$json['message'] = sprintf( __( 'You do not have permission to edit this %s.', 'tcd-w' ), $dp_options['photo_label'] );
				}
			}

			if ( empty( $json['message'] ) ){
				if ( ! empty( $_FILES['file_main_image']['name'] ) ) {
					$upload = tcd_membership_meta_image_field_upload( array(
						'post_id' => 0, // post_idを指定するとプレビュー確認時に上書きされてしまう
						'file_input_name' => 'file_main_image',
						'meta_key' => 'main_image',
						'post_type_photo' => true,	// 写真投稿タイプフラグ 正方形or縦長or横長でリサイズサイズ変更
						'thumbnails' => array(
							$_wp_additional_image_sizes['size1'],
							$_wp_additional_image_sizes['size2']
						)
					) );

					// 成功
					if ( ! empty( $upload['url'] ) ) {
						$json['uploaded']['main_image'] = $upload['url'];
						// _main_imageは保存時にテンポラリー画像から取得

						// テンポラリー画像として登録
						tcd_membership_add_temp_image( $upload );

					// エラー
					} elseif ( is_string( $upload ) ) {
						$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Photo', 'tcd-w' ), $upload );
					} else {
						$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) );
					}
				}
			}

		} else {
			$json['message'] = __( 'Invalid request.', 'tcd-w' );
		}
	}

	// メッセージがなければ成功にする
	if ( empty( $json['message'] ) ) {
		$json['success'] = true;
	}

	// JSON出力
	wp_send_json( $json );
	exit;
}
add_action( 'wp_ajax_tcd_membership_image_upload', 'tcd_membership_ajax_image_upload' );

/**
 * テンポラリー画像として登録
 * 後で未使用のものを削除するためプレビュー確認時にアップロードした画像情報保存をオプションに保存
 */
function tcd_membership_add_temp_image( $upload, $meta_type = 'post', $user_id = null ) {
	if ( $upload && ! is_array( $upload ) ) {
		$upload = maybe_unserialize( $upload );
	}

	if ( empty( $upload['file'] ) || empty( $upload['url'] ) ) {
		return false;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	$temp_images = get_option( 'tcd_membership_temp_images' );

	if ( ! is_array( $temp_images ) ) {
		$temp_images = array();
	} else {
		// 同じパスのものがあれば終了
		foreach ( $temp_images as $temp_image ) {
			if ( $upload['url'] === $temp_image['url'] ) {
				return false;
			}
		}
	}

	$upload['meta_type'] = $meta_type;
	$upload['user_id'] = $user_id;
	$upload['timestamp'] = current_time( 'timestamp', true );

	$temp_images[] = $upload;

	update_option( 'tcd_membership_temp_images', $temp_images, false );
}

/**
 * テンポラリー画像配列からurlを元に画像情報取得
 */
function tcd_membership_get_temp_image( $find_url, $delete_after_find = false, $args = array() ) {

	$default_args = array(
		'find_key' => 'url'
	);
	$args = wp_parse_args( $args, $default_args );

	$temp_images = get_option( 'tcd_membership_temp_images' );

	if ( ! is_array( $temp_images ) ) {
		return false;
	}

	if ( ! empty( $args['find_key'] ) ) {
		$find_key = $args['find_key'];
	} else {
		$find_key = 'url';
	}

	$ret = false;

	foreach ( $temp_images as $key => $temp_image ) {
		if ( isset( $temp_image[$find_key] ) && $find_url === $temp_image[$find_key] ) {
			$ret = $temp_image;
			break;
		}
	}

	// 見つからない場合は終了
	if ( ! $ret ) {
		return false;
	}

	// テンポラリー画像用に付与した情報を削除
	if ( isset( $ret['meta_type'] ) ) {
		unset( $ret['meta_type'] );
	}
	if ( isset( $ret['user_id'] ) ) {
		unset( $ret['user_id'] );
	}
	if ( isset( $ret['timestamp'] ) ) {
		unset( $ret['timestamp'] );
	}

	// 削除フラグがあれば削除してオプション更新
	if ( $delete_after_find && $key ) {
		unset( $temp_images[$key] );
		// array_merge()で数字キーを降りなおす
		update_option( 'tcd_membership_temp_images', array_merge( $temp_images ) );
	}

	return $ret;
}

/**
 * テンポラリー画像チェック
 * テンポラリー画像の中から未使用のものがあればファイル削除
 */
function tcd_membership_check_temp_images() {
	global $wpdb;

	$temp_images = get_option( 'tcd_membership_temp_images' );

	if ( ! is_array( $temp_images ) ) {
		return false;
	}

	$deleted_count = 0;

	// 3日前を閾値に
	$check_ts = current_time( 'timestamp', true ) - DAY_IN_SECONDS * 3;

	foreach ( $temp_images as $key => $temp_image ) {
		if ( ! isset( $temp_image['timestamp'], $temp_image['url'] ) || $temp_image['timestamp'] > $check_ts ) {
			continue;
		}

		// ユーザーメタ
		if ( isset( $temp_image['meta_type'] ) && in_array( $temp_image['meta_type'], array( 'user', 'user_meta' ) ) ) {
			// ユーザーメタから一致するurlを探す
			$user_meta_sql = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_value = %s LIMIT 1";
			$user_id = $wpdb->get_var( $wpdb->prepare( $user_meta_sql, $temp_image['url'] ) );
			// 一致urlが無ければ実ファイル削除
			if ( ! $user_id ) {
				tcd_user_profile_delete_image_from_meta( $temp_image );
			}

		// ポストメタ
		} else {
			// ポストメタから一致するurlを探す
			$post_meta_sql = "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_value = %s LIMIT 1";
			$post_id = $wpdb->get_var( $wpdb->prepare( $post_meta_sql, $temp_image['url'] ) );
			// 一致urlが無ければ実ファイル削除
			if ( ! $post_id ) {
				tcd_membership_delete_image_from_meta( $temp_image );
			}
		}

		// テンポラリー画像配列から削除
		unset( $temp_images[$key] );

		$deleted_count++;
	}

	// テンポラリー画像配列が変更されていれば保存
	if ( $deleted_count ) {
		// array_merge()で数字キーを降りなおす
		update_option( 'tcd_membership_temp_images', array_merge( $temp_images ) );
	}
}

/**
 * テンポラリー画像削除の定期実行
 */
function tcd_membership_check_temp_images_cron() {
	$last_ts = (int) get_option( 'tcd_membership_temp_images_last_timestamp', 0 );

	// 前回実行時から3日以上経過していればテンポラリー画像チェック
	if ( ! $last_ts || $last_ts + DAY_IN_SECONDS * 3 < current_time( 'timestamp', true ) ) {
		tcd_membership_check_temp_images();
		update_option( 'tcd_membership_temp_images_last_timestamp', current_time( 'timestamp', true ) );
	}
}
add_action( 'admin_print_footer_scripts', 'tcd_membership_check_temp_images_cron', 99 );
