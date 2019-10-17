<?php

/**
 * 管理画面 写真一覧のアクション一覧にフロントエンド編集追加
 */
function tcd_membership_photo_post_row_actions( $actions, $post ) {
	global $dp_options;

	if ( $dp_options['membership']['use_front_edit_photo'] && ! empty( $post->post_type ) && $post->post_type === $dp_options['photo_slug'] && current_user_can( 'edit_post', $post->ID ) ) {
		$actions_old = $actions;
		$actions = array();
		foreach( $actions_old as $key => $value ) {
			$actions[$key] = $value;

			if ( 'inline hide-if-no-js' === $key ) {
				$actions['frontend-edit'] = '<a href="' . get_tcd_membership_memberpage_url( 'edit_photo', $post->ID ) .'" target="_blank">' . __( 'Frontend Edit', 'tcd-w' ) . '</a>';
			}
		}
	}
	return $actions;
}
add_filter( 'post_row_actions', 'tcd_membership_photo_post_row_actions', 10, 2 );

/**
 * 写真 メタボックス追加
 */
function tcd_membership_photo_add_meta_box() {
	global $dp_options;

	add_meta_box(
		'tcd_membership_main_photo_meta_box', // ID of meta box
		$dp_options['photo_label'], // label
		'tcd_membership_main_photo_show_meta_box', // callback function
		$dp_options['photo_slug'], // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_membership_photo_add_meta_box' );

/**
 * 写真 メタボックス表示
 */
function tcd_membership_main_photo_show_meta_box() {
	global $post;

 	echo '<input type="hidden" name="tcd_membership_photo_meta_box_nonce" value="' . wp_create_nonce( 'tcd_membership_photo_meta_box-' . $post->ID ) . '">';

	echo '<dl class="tcd_custom_fields">' . "\n";

	// text align
	$cf_key = 'textalign';
	$text_align = array(
		'name' => __( 'Text align', 'tcd-w' ),
		'id' => $cf_key,
		'std' => 'center',
		'options' => array(
			array(
				'name' => __( 'Align center', 'tcd-w' ),
				'value' => 'center'
			),
			array(
				'name' => __( 'Align left', 'tcd-w' ),
				'value' => 'left'
			)
		)
	);
	$cf_value = get_post_meta( $post->ID, $cf_key, true );
	if ( ! $cf_value ) $cf_value = $text_align['std'];

	echo '<dt class="label"><label for="' . esc_attr( $text_align['id'] ) . '">' . esc_html( $text_align['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio cf">';
	foreach ( $text_align['options'] as $text_align_option ) {
		echo '<li><label><input type="radio" name="' . $text_align['id'] . '" value="' . esc_attr( $text_align_option['value'] ) . '"' . checked( $cf_value, $text_align_option['value'], false ) . ' />' . esc_html( $text_align_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>' . "\n";

	echo '</dl>' . "\n";
}

/**
 * 写真 メタボックス保存処理
 */
function tcd_membership_photo_save_post( $post_id, $post ) {
	global $dp_options;

	// verify nonce
	if ( ! isset( $_POST['tcd_membership_photo_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_membership_photo_meta_box_nonce'], 'tcd_membership_photo_meta_box-' . $post_id ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check post_type
	if ( empty( $post->post_type ) || $post->post_type !== $dp_options['photo_slug'] ) {
		return $post_id;
	}

	// check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// validate
	if ( ! empty( $_POST['textalign'] ) && in_array( $_POST['textalign'], array( 'center', 'left' ) ) ) {
		$textalign = $_POST['textalign'];
	} else {
		$textalign = 'center';
	}

	// save
	update_post_meta( $post_id, 'textalign', $textalign );
}
add_action( 'save_post', 'tcd_membership_photo_save_post', 10, 2 );

/**
 * 写真投稿アクション
 */
function tcd_membership_action_add_photo() {
	global $dp_options, $tcd_membership_vars, $tcd_membership_post, $_wp_additional_image_sizes;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to add %s.', 'tcd-w' ), $dp_options['photo_label'] );
		return;
	}

	// テンプレート指定
	$tcd_membership_vars['template'] = 'edit_photo';

	// 成功時のリダイレクトでメッセージ表示
	if ( ! empty( $_REQUEST['complete'] ) ) {
		$tcd_membership_vars['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['add_photo']['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['browser_back_alert_messege'] = __( 'Do not use browser back button here.', 'tcd-w' );
		return;
	}

	// 空のWP_Post生成
	$tcd_membership_post = get_tcd_membership_post_to_add( $dp_options['photo_slug'] );

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		if ( ! isset( $formdata['post_id'] ) || empty( $formdata['nonce'] ) || ! wp_verify_nonce( $formdata['nonce'], 'tcd-membership-add_photo-' . $formdata['post_id'] ) ) {
			$error_messages[] = __( 'Invalid nonce.', 'tcd-w' );
		}

		// プレビューからの戻る
		if ( ! empty( $formdata['to_input'] ) ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

			// ここで終了
			return;
		}

		// ファイルアップロード main_image
		if ( ! empty( $_FILES['file_main_image']['name'] ) ) {
			$upload = tcd_membership_meta_image_field_upload( array(
				'post_id' => 0,
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
				$formdata['main_image'] = $upload['url'];
				// _main_imageは保存時にテンポラリー画像から取得

				// テンポラリー画像として登録
				tcd_membership_add_temp_image( $upload );

			// エラー
			} elseif ( is_string( $upload ) ) {
				$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Photo', 'tcd-w' ), $upload );
			} else {
				$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) );
			}
		} elseif ( ! empty( $formdata['delete-file_main_image'] ) ) {
			$formdata['main_image'] = '';
		}
		if ( empty( $formdata['main_image'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ) . sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) );
		}

		// validation
		if ( empty( $formdata['category'] ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Category', 'tcd-w' ) );
		} else {
			$term = get_term_by( 'id', $formdata['category'], $dp_options['photo_category_slug'] );
			if ( ! $term || is_wp_error( $term ) ) {
				$error_messages[] = __( 'Invalid category.', 'tcd-w' );
			}
		}

		if ( empty( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
			$formdata['post_title'] = '';
		} else {
			$formdata['post_title'] = tcd_membership_sanitize_content( $formdata['post_title'] );
		}
		if( tcd_membership_check_forbidden_words( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
		}

		if ( empty( $formdata['textalign'] ) || ! in_array( $formdata['textalign'], array( 'center', 'left' ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Text align', 'tcd-w' ) );
		}

		if ( empty( $formdata['post_content'] ) ) {
			$formdata['post_content'] = '';
		} else {
			$formdata['post_content'] = tcd_membership_sanitize_content( $formdata['post_content'] );
		}
		if( tcd_membership_check_forbidden_words( $formdata['post_content'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Content', 'tcd-w' ) );
		}

		$post_statuses = get_tcd_membership_post_statuses( $tcd_membership_post );
		if ( empty( $formdata['post_status'] ) || ! in_array( $formdata['post_status'], array_keys( $post_statuses ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), implode( ' or ', $post_statuses ) );
		}

		// エラーあり
		if ( $error_messages ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

		// エラーなし
		} else {
			// プレビュー確認
			if ( ! empty( $formdata['to_confirm'] ) ) {
				$tcd_membership_vars['add_photo']['confirm'] = true;
				$tcd_membership_vars['confirm_page_leave'] = __( 'Post is not completed yet. Do you really leave this page?', 'tcd-w' );
				$tcd_membership_vars['browser_back_alert_messege'] = __( 'If use browser back button, may be lost input data.', 'tcd-w' );

				// tcd_membership_postにフォーム値セット
				$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

			// 完了
			} elseif ( ! empty( $formdata['to_complete'] ) ) {
				// 記事保存
				$post_id = wp_insert_post( array(
					'post_author' => $user->ID,
					'post_content' => $formdata['post_content'],
					'post_name' => '',
					'post_parent' => 0,
					'post_status' => $formdata['post_status'],
					'post_title' => $formdata['post_title'],
					'post_type' => $dp_options['photo_slug'],
					'comment_status' => 'open',
					'ping_status' => 'open'
				) );

				if ( $post_id ) {
					// テンポラリー画像からmain_imageのurlに対応する画像情報配列を取得
					$_main_image = tcd_membership_get_temp_image( $formdata['main_image'], true );

					// タクソノミー・メタ保存
					wp_set_object_terms( $post_id, intval( $formdata['category'] ), $dp_options['photo_category_slug'], false );
					update_post_meta( $post_id, 'main_image', $formdata['main_image'] );
					update_post_meta( $post_id, '_main_image', $_main_image );
					update_post_meta( $post_id, 'textalign', $formdata['textalign'] );

					// フロント投稿からのpendingと判断できるようにメタ保存
					if ( 'pending' === $formdata['post_status'] ) {
						update_post_meta( $post_id, '_tcd_membership_pending', 1 );
					}

					// リダイレクト
					$redirect = get_tcd_membership_memberpage_url( 'add_photo' );
					$redirect = add_query_arg( 'complete', $formdata['post_status'], $redirect );
					$redirect = add_query_arg( 'post_id', $post_id, $redirect );
					wp_safe_redirect( $redirect );
					exit;
				} else {
					$error_messages[] = __( 'Failed to save.', 'tcd-w' );
				}
			}
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-add_photo', 'tcd_membership_action_add_photo' );

/**
 * 写真編集アクション
 */
function tcd_membership_action_edit_photo() {
	global $dp_options, $tcd_membership_vars, $tcd_membership_post, $_wp_additional_image_sizes, $wpdb;

	nocache_headers();

	$error_messages = array();
	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	if ( empty( $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Invalid request.', 'tcd-w' );
		return;
	}

	$tcd_membership_post = get_post( $_REQUEST['post_id'] );
	if ( ! $tcd_membership_post || $tcd_membership_post->post_type !== $dp_options['photo_slug'] ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Incorrect post id.', 'tcd-w' );
		return;
	} elseif ( $tcd_membership_post->post_author != $user->ID && ! current_user_can( 'edit_post', $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to edit this %s.', 'tcd-w' ), $dp_options['photo_label'] );
		return;
	}

	// 成功時のリダイレクトでメッセージ表示
	if ( ! empty( $_REQUEST['complete'] ) ) {
		$tcd_membership_vars['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['edit_photo']['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['browser_back_alert_messege'] = __( 'Do not use browser back button here.', 'tcd-w' );
		return;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		if ( empty( $formdata['post_id'] ) || empty( $formdata['nonce'] ) || ! wp_verify_nonce( $formdata['nonce'], 'tcd-membership-edit_photo-' . $formdata['post_id'] ) ) {
			$error_messages[] = __( 'Invalid nonce.', 'tcd-w' );
		}

		// プレビューからの戻る
		if ( ! empty( $formdata['to_input'] ) ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

			// ここで終了
			return;
		}

		// ファイルアップロード main_image
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
				$formdata['main_image'] = $upload['url'];
				// _main_imageは保存時にテンポラリー画像から取得

				// テンポラリー画像として登録
				tcd_membership_add_temp_image( $upload );

			// エラー
			} elseif ( is_string( $upload ) ) {
				$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Photo', 'tcd-w' ), $upload );
			} else {
				$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) );
			}
		} elseif ( ! empty( $formdata['delete-file_main_image'] ) ) {
			$formdata['main_image'] = '';
		}
		if ( empty( $formdata['main_image'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ) . sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) );
		}

		// validation
		if ( empty( $formdata['category'] ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Category', 'tcd-w' ) );
		} else {
			$term = get_term_by( 'id', $formdata['category'], $dp_options['photo_category_slug'] );
			if ( ! $term || is_wp_error( $term ) ) {
				$error_messages[] = __( 'Invalid category.', 'tcd-w' );
			}
		}

		if ( empty( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
			$formdata['post_title'] = '';
		} else {
			$formdata['post_title'] = tcd_membership_sanitize_content( $formdata['post_title'] );
		}
		if( tcd_membership_check_forbidden_words( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
		}

		if ( empty( $formdata['textalign'] ) || ! in_array( $formdata['textalign'], array( 'center', 'left' ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Text align', 'tcd-w' ) );
		}

		if ( empty( $formdata['post_content'] ) ) {
			$formdata['post_content'] = '';
		} else {
			$formdata['post_content'] = tcd_membership_sanitize_content( $formdata['post_content'] );
		}
		if( tcd_membership_check_forbidden_words( $formdata['post_content'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Content', 'tcd-w' ) );
		}

		$post_statuses = get_tcd_membership_post_statuses( $tcd_membership_post );
		if ( empty( $formdata['post_status'] ) || ! in_array( $formdata['post_status'], array_keys( $post_statuses ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), implode( ' or ', $post_statuses ) );
		}

		// エラーあり
		if ( $error_messages ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

		// エラーなし
		} else {
			// プレビュー確認
			if ( ! empty( $formdata['to_confirm'] ) ) {
				$tcd_membership_vars['edit_photo']['confirm'] = true;
				$tcd_membership_vars['confirm_page_leave'] = __( 'Post is not completed yet. Do you really leave this page?', 'tcd-w' );
				$tcd_membership_vars['browser_back_alert_messege'] = __( 'If use browser back button, may be lost input data.', 'tcd-w' );

				// tcd_membership_postにフォーム値セット
				$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

			// 完了
			} elseif ( ! empty( $formdata['to_complete'] ) ) {
				// 記事保存
				$post_id = wp_update_post( array(
					'ID' => $formdata['post_id'],
					'post_author' => $user->ID,
					'post_content' => $formdata['post_content'],
					'post_name' => '',
					'post_parent' => 0,
					'post_status' => $formdata['post_status'],
					'post_title' => $formdata['post_title'],
					'post_type' => $dp_options['photo_slug'],
					'comment_status' => 'open',
					'ping_status' => 'open'
				) );

				if ( $post_id ) {
					// タクソノミー・メタ保存
					wp_set_object_terms( $post_id, intval( $formdata['category'] ), $dp_options['photo_category_slug'], false );
					update_post_meta( $post_id, 'textalign', $formdata['textalign'] );

					// 画像urlが変わっていれば
					$main_image_old = get_post_meta( $post_id, 'main_image', true );
					if ( $main_image_old && $main_image_old != $formdata['main_image'] ) {
						// 旧画像ファイルを削除
						$_main_image_old = get_post_meta( $post_id, '_main_image', true );
						tcd_membership_delete_image_from_meta( $_main_image_old );

						// テンポラリー画像からmain_imageのurlに対応する画像情報配列を取得
						$_main_image = tcd_membership_get_temp_image( $formdata['main_image'], true );

						update_post_meta( $post_id, 'main_image', $formdata['main_image'] );
						update_post_meta( $post_id, '_main_image', $_main_image );
					}

					// フロント投稿からのpendingと判断できるようにメタ保存
					if ( 'pending' === $formdata['post_status'] ) {
						update_post_meta( $post_id, '_tcd_membership_pending', 1 );
					}

					// リダイレクト後のメッセージ
					if ( $tcd_membership_post->post_status == $formdata['post_status'] ) {
						$complete_message = 'updated';
					} else {
						$complete_message = $formdata['post_status'];
					}

					// リダイレクト
					$redirect = get_tcd_membership_memberpage_url( 'edit_photo' );
					$redirect = add_query_arg( 'complete', $complete_message, $redirect );
					$redirect = add_query_arg( 'post_id', $post_id, $redirect );
					wp_safe_redirect( $redirect );
					exit;
				} else {
					$error_messages[] = __( 'Failed to save.', 'tcd-w' );
				}
			}
		}

	} else {
		// タクソノミーをフォーム用にセット
		$terms = get_the_terms( $tcd_membership_post->ID, $dp_options['photo_category_slug'] );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$tcd_membership_post->category = $term->term_id;
				break;
			}
		}

		// textalignメタ対策
		if ( ! $tcd_membership_post->textalign || ! in_array( $tcd_membership_post->textalign, array( 'center', 'left' ) ) ) {
			$tcd_membership_post->textalign = 'center';
		}

		// pending使用で編集者未満で公開中ならpendingに変更
		if ( $dp_options['membership']['use_front_edit_photo_pending'] && ! current_user_can( 'edit_others_posts' ) && 'publish' === $tcd_membership_post->post_status ) {
			$tcd_membership_post->post_status = 'pending';
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-edit_photo', 'tcd_membership_action_edit_photo' );

/**
 * 写真削除アクション
 */
function tcd_membership_action_delete_photo() {
	global $dp_options, $tcd_membership_vars, $tcd_membership_post;

	nocache_headers();

	$user = wp_get_current_user();

	if ( ! $user ) {
		wp_safe_redirect( user_trailingslashit( home_url() ) );
		exit;
	}

	if ( empty( $_REQUEST['post_id'] ) || ! is_numeric( $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Invalid request.', 'tcd-w' );
		return;
	}

	$tcd_membership_post = get_post( intval( $_REQUEST['post_id'] ) );
	if ( ! $tcd_membership_post || $tcd_membership_post->post_type !== $dp_options['photo_slug'] || ! in_array( $tcd_membership_post->post_status, array( 'publish', 'private', 'pending', 'draft' ) ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Incorrect post id.', 'tcd-w' );
		return;
	} elseif ( $tcd_membership_post->post_author != $user->ID && ! current_user_can( 'delete_post', $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to delete this %s.', 'tcd-w' ), $dp_options['photo_label'] );
		return;
	}

	// ノンスがついている場合は削除（ゴミ箱）
	if ( ! empty( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'tcd-membership-delete_photo-' . $_REQUEST['post_id'] ) ) {
		if ( wp_trash_post( $_REQUEST['post_id'] ) ) {
			// 削除成功時はリダイレクト
			if ( ! empty( $_REQUEST['redirect_to'] ) ) {
				$redirect_to = $_REQUEST['redirect_to'];
			} else {
				$redirect_to = get_author_posts_url( $user->ID );
			}
			wp_safe_redirect( $redirect_to );
			exit;
		} else {
			$tcd_membership_vars['template'] = 'error';
			$tcd_membership_vars['error_message'] = __( 'Failed to delete.', 'tcd-w' );
			return;
		}
	}

	// テンプレート指定
	$tcd_membership_vars['template'] = 'delete_article';
}
add_action( 'tcd_membership_action-delete_photo', 'tcd_membership_action_delete_photo' );

/**
 * 写真プレビューか
 */
function is_tcd_membership_preview_photo() {
	global $tcd_membership_vars, $tcd_membership_post;
	return (
		! empty( $tcd_membership_vars['memberpage_type'] ) &&
		in_array( $tcd_membership_vars['memberpage_type'], array( 'add_photo', 'edit_photo' ) ) &&
		! empty( $tcd_membership_vars[$tcd_membership_vars['memberpage_type']]['confirm'] ) &&
		$tcd_membership_post
	);
}
