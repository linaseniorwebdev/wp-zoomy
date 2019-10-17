<?php

/**
 * 管理画面 ブログ一覧のアクション一覧にフロントエンド編集追加
 */
function tcd_membership_blog_post_row_actions( $actions, $post ) {
	global $dp_options;

	if ( $dp_options['membership']['use_front_edit_blog'] && ! empty( $post->post_type ) && 'post' === $post->post_type && current_user_can( 'edit_post', $post->ID ) ) {
		$actions_old = $actions;
		$actions = array();
		foreach( $actions_old as $key => $value ) {
			$actions[$key] = $value;

			if ( 'inline hide-if-no-js' === $key ) {
				$actions['frontend-edit'] = '<a href="' . get_tcd_membership_memberpage_url( 'edit_blog', $post->ID ) .'" target="_blank">' . __( 'Frontend Edit', 'tcd-w' ) . '</a>';
			}
		}
	}
	return $actions;
}
add_filter( 'post_row_actions', 'tcd_membership_blog_post_row_actions', 10, 2 );

/**
 * ブログ投稿アクション
 */
function tcd_membership_action_add_blog() {
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
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to add %s.', 'tcd-w' ), $dp_options['blog_label'] );
		return;
	}

	// テンプレート指定
	$tcd_membership_vars['template'] = 'edit_blog';

	// 成功時のリダイレクトでメッセージ表示
	if ( ! empty( $_REQUEST['complete'] ) ) {
		$tcd_membership_vars['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['add_blog']['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['browser_back_alert_messege'] = __( 'Do not use browser back button here.', 'tcd-w' );
		return;
	}

	// 空のWP_Post生成
	$tcd_membership_post = get_tcd_membership_post_to_add( 'post' );

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		if ( ! isset( $formdata['post_id'] ) || empty( $formdata['nonce'] ) || ! wp_verify_nonce( $formdata['nonce'], 'tcd-membership-add_blog-' . $formdata['post_id'] ) ) {
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
				$formdata['main_image'] = $upload['url'];
				// _main_imageは保存時にテンポラリー画像から取得

				// テンポラリー画像として登録
				tcd_membership_add_temp_image( $upload );

			// エラー
			} elseif ( is_string( $upload ) ) {
				$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Main photo', 'tcd-w' ), $upload );
			} else {
				$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) );
			}
		} elseif ( ! empty( $formdata['delete-file_main_image'] ) ) {
			$formdata['main_image'] = '';
		}
		if ( empty( $formdata['main_image'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) ) . sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) );
		}

		// ファイルアップロード image,image1-image9
		for ( $i = 0; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			if ( ! empty( $_FILES['file_image' . $si]['name'] ) ) {
				$upload = tcd_membership_meta_image_field_upload( array(
					'post_id' => 0,
					'file_input_name' => 'file_image' . $si,
					'meta_key' => 'image' . $si,
					'width' => 850,
					'height' => 0,
					'crop' => false,
					'thumbnails' => array()
				) );

				// 成功
				if ( ! empty( $upload['url'] ) ) {
					$formdata['image' . $si] = $upload['url'];
					// _imageは保存時にテンポラリー画像から取得

					// テンポラリー画像として登録
					tcd_membership_add_temp_image( $upload );

				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Image', 'tcd-w' ) . ( $i + 1 ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Image', 'tcd-w' ) . ( $i + 1 ) );
				}
			} elseif ( ! empty( $formdata['delete-file_image' . $si] ) ) {
				$formdata['image' . $si] = '';
			}
		}

		// validation
		if ( empty( $formdata['category'] ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Category', 'tcd-w' ) );
		} else {
			$term = get_term_by( 'id', $formdata['category'], 'category' );
			if ( ! $term || is_wp_error( $term ) ) {
				$error_messages[] = __( 'Invalid category.', 'tcd-w' );
			}
		}

		if ( ! empty( $formdata['post_title'] ) ) {
			$formdata['post_title'] = tcd_membership_sanitize_content( $formdata['post_title'] );
		}
		if ( empty( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
		} elseif( tcd_membership_check_forbidden_words( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
		}

		$post_statuses = get_tcd_membership_post_statuses( $tcd_membership_post );
		if ( empty( $formdata['post_status'] ) || ! in_array( $formdata['post_status'], array_keys( $post_statuses ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), implode( ' or ', $post_statuses ) );
		}

		// リピーターサニタイズ、削除された行を詰める
		$formdata = tcd_membership_blog_repeater_sanitize( $formdata );

		// リピーター
		for ( $i = 0; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			if ( ! empty( $formdata['headline' . $si] ) && tcd_membership_check_forbidden_words( $formdata['headline' . $si] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Headline', 'tcd-w' ) . ( $i + 1 ) );
			}
			if ( ! empty( $formdata['description' . $si] ) && tcd_membership_check_forbidden_words( $formdata['description' . $si] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Enter text', 'tcd-w' ) . ( $i + 1 ) );
			}
		}

		// エラーあり
		if ( $error_messages ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

		// エラーなし
		} else {
			// プレビュー確認
			if ( ! empty( $formdata['to_confirm'] ) ) {
				$tcd_membership_vars['add_blog']['confirm'] = true;
				$tcd_membership_vars['confirm_page_leave'] = __( 'Post is not completed yet. Do you really leave this page?', 'tcd-w' );
				$tcd_membership_vars['browser_back_alert_messege'] = __( 'If use browser back button, may be lost input data.', 'tcd-w' );

				// tcd_membership_postにフォーム値セット
				$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

				// リピーターから本文生成
				$tcd_membership_post->post_content = tcd_membership_blog_build_content( $formdata );

			// 完了
			} elseif ( ! empty( $formdata['to_complete'] ) ) {
				// 記事保存
				$post_id = wp_insert_post( array(
					'post_author' => $user->ID,
					'post_content' => tcd_membership_blog_build_content( $formdata ),
					'post_name' => '',
					'post_parent' => 0,
					'post_status' => $formdata['post_status'],
					'post_title' => $formdata['post_title'],
					'post_type' => 'post',
					'comment_status' => 'open',
					'ping_status' => 'open'
				) );

				if ( $post_id ) {
					// テンポラリー画像からmain_imageのurlに対応する画像情報配列を取得
					$_main_image = tcd_membership_get_temp_image( $formdata['main_image'], true );

					// タクソノミー・メタ保存
					wp_set_object_terms( $post_id, intval( $formdata['category'] ), 'category', false );
					update_post_meta( $post_id, 'main_image', $formdata['main_image'] );
					update_post_meta( $post_id, '_main_image', $_main_image );

					// リピーター保存
					for ( $i = 0; $i < 10; $i++ ) {
						$si = 0 < $i ? $i : '';
						$_image = '';

						update_post_meta( $post_id, 'headline' . $si, $formdata['headline' . $si] );
						update_post_meta( $post_id, 'description' . $si, $formdata['description' . $si] );
						update_post_meta( $post_id, 'image' . $si, $formdata['image' . $si] );
						// 画像があればテンポラリー画像からurlに対応する画像情報配列を取得
						if ( $formdata['image' . $si] ) {
							$_image = tcd_membership_get_temp_image( $formdata['image' . $si], true );
						}
						update_post_meta( $post_id, '_image' . $si, $_image );
					}

					// フロント投稿からのpendingと判断できるようにメタ保存
					if ( 'pending' === $formdata['post_status'] ) {
						update_post_meta( $post_id, '_tcd_membership_pending', 1 );
					}

					// リダイレクト
					$redirect = get_tcd_membership_memberpage_url( 'add_blog' );
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
add_action( 'tcd_membership_action-add_blog', 'tcd_membership_action_add_blog' );

/**
 * ブログ編集アクション
 */
function tcd_membership_action_edit_blog() {
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
	if ( ! $tcd_membership_post || 'post' !== $tcd_membership_post->post_type ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Incorrect post id.', 'tcd-w' );
		return;
	} elseif ( $tcd_membership_post->post_author != $user->ID && ! current_user_can( 'edit_post', $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to edit this %s.', 'tcd-w' ), $dp_options['blog_label'] );
		return;
	}

	// 成功時のリダイレクトでメッセージ表示
	if ( ! empty( $_REQUEST['complete'] ) ) {
		$tcd_membership_vars['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['edit_blog']['complete'] = $_REQUEST['complete'];
		$tcd_membership_vars['browser_back_alert_messege'] = __( 'Do not use browser back button here.', 'tcd-w' );
		return;
	}

	// POST
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$formdata = wp_unslash( $_POST );

		if ( empty( $formdata['post_id'] ) || empty( $formdata['nonce'] ) || ! wp_verify_nonce( $formdata['nonce'], 'tcd-membership-edit_blog-' . $formdata['post_id'] ) ) {
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
				$formdata['main_image'] = $upload['url'];
				// _main_imageは保存時にテンポラリー画像から取得

				// テンポラリー画像として登録
				tcd_membership_add_temp_image( $upload );

			// エラー
			} elseif ( is_string( $upload ) ) {
				$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Main photo', 'tcd-w' ), $upload );
			} else {
				$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) );
			}
		} elseif ( ! empty( $formdata['delete-file_main_image'] ) ) {
			$formdata['main_image'] = '';
		}
		if ( empty( $formdata['main_image'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) ) . sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Main photo', 'tcd-w' ) );
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
					$formdata['image' . $si] = $upload['url'];
					// _imageは保存時にテンポラリー画像から取得

					// テンポラリー画像として登録
					tcd_membership_add_temp_image( $upload );
				// エラー
				} elseif ( is_string( $upload ) ) {
					$error_messages[] = sprintf( __( 'Failed to upload %s. (%s)', 'tcd-w' ), __( 'Image', 'tcd-w' ) . ( $i + 1 ), $upload );
				} else {
					$error_messages[] = sprintf( __( 'Failed to upload %s.', 'tcd-w' ), __( 'Image', 'tcd-w' ) . ( $i + 1 ) );
				}
			} elseif ( ! empty( $formdata['delete-file_image' . $si] ) ) {
				$formdata['image' . $si] = '';
			}
		}

		// validation
		if ( empty( $formdata['category'] ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), __( 'Category', 'tcd-w' ) );
		} else {
			$term = get_term_by( 'id', $formdata['category'], 'category' );
			if ( ! $term || is_wp_error( $term ) ) {
				$error_messages[] = __( 'Invalid category.', 'tcd-w' );
			}
		}

		if ( ! empty( $formdata['post_title'] ) ) {
			$formdata['post_title'] = tcd_membership_sanitize_content( $formdata['post_title'] );
		}
		if ( empty( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s is required.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
			$tcd_membership_post->post_title = '';
		} elseif( tcd_membership_check_forbidden_words( $formdata['post_title'] ) ) {
			$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Title', 'tcd-w' ) );
		}

		$post_statuses = get_tcd_membership_post_statuses( $tcd_membership_post );
		if ( empty( $formdata['post_status'] ) || ! in_array( $formdata['post_status'], array_keys( $post_statuses ) ) ) {
			$error_messages[] = sprintf( __( 'Please select a %s.', 'tcd-w' ), implode( ' or ', $post_statuses ) );
		}

		// リピーターサニタイズ、削除された行を詰める
		$formdata = tcd_membership_blog_repeater_sanitize( $formdata );

		// リピーター
		for ( $i = 0; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			if ( ! empty( $formdata['headline' . $si] ) && tcd_membership_check_forbidden_words( $formdata['headline' . $si] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Headline', 'tcd-w' ) . ( $i + 1 ) );
			}
			if ( ! empty( $formdata['description' . $si] ) && tcd_membership_check_forbidden_words( $formdata['description' . $si] ) ) {
				$error_messages[] = sprintf( __( '%s has forbidden words.', 'tcd-w' ), __( 'Enter text', 'tcd-w' ) . ( $i + 1 ) );
			}
		}

		// エラーあり
		if ( $error_messages ) {
			// tcd_membership_postにフォーム値セット
			$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

		// エラーなし
		} else {
			// プレビュー確認
			if ( ! empty( $formdata['to_confirm'] ) ) {
				$tcd_membership_vars['edit_blog']['confirm'] = true;
				$tcd_membership_vars['confirm_page_leave'] = __( 'Edit is not completed yet. Do you really leave this page?', 'tcd-w' );
				$tcd_membership_vars['browser_back_alert_messege'] = __( 'If use browser back button, may be lost input data.', 'tcd-w' );

				// tcd_membership_postにフォーム値セット
				$tcd_membership_post = tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata );

				// リピーターから本文生成
				$tcd_membership_post->post_content = tcd_membership_blog_build_content( $formdata );

			// 完了
			} elseif ( ! empty( $formdata['to_complete'] ) ) {
				// 記事保存
				$post_id = wp_update_post( array(
					'ID' => $formdata['post_id'],
					'post_author' => $user->ID,
					'post_content' => tcd_membership_blog_build_content( $formdata ),
					'post_name' => '',
					'post_parent' => 0,
					'post_status' => $formdata['post_status'],
					'post_title' => $formdata['post_title'],
					'post_type' => 'post',
					'comment_status' => 'open',
					'ping_status' => 'open'
				) );

				if ( $post_id ) {
					// タクソノミー保存
					wp_set_object_terms( $post_id, intval( $formdata['category'] ), 'category', false );

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

					// リピーターは順番が変わっている可能性があるため旧画像を先に取得しておく
					$images_old = array();
					$_images_old = array();
					for ( $i = 0; $i < 10; $i++ ) {
						$si = 0 < $i ? $i : '';

						$image_old = get_post_meta( $post_id, 'image' . $si, true );
						if ( $image_old ) {
							$images_old[$i] = $image_old;
							$_images_old[$i] = get_post_meta( $post_id, '_image' . $si, true );
						}
					}

					// リピーター保存
					for ( $i = 0; $i < 10; $i++ ) {
						$si = 0 < $i ? $i : '';
						$image = '';
						$_image = '';

						update_post_meta( $post_id, 'headline' . $si, $formdata['headline' . $si] );
						update_post_meta( $post_id, 'description' . $si, $formdata['description' . $si] );

						// 画像あり
						if ( $formdata['image' . $si] ) {
							$image = $formdata['image' . $si];

							// 旧画像にあれば旧画像から抜き出し
							$j = array_search( $formdata['image' . $si], $images_old );
							if ( false !== $j ) {
								$_image = $_images_old[$j];
								unset( $images_old[$j] );
								unset( $_images_old[$j] );

							// 旧画像にない場合はテンポラリー画像からurlに対応する画像情報配列を取得
							} else {
								$_image = tcd_membership_get_temp_image( $formdata['image' . $si], true );
							}
						}
						update_post_meta( $post_id, 'image' . $si, $image );
						update_post_meta( $post_id, '_image' . $si, $_image );
					}

					// 旧画像で未使用のものを削除
					foreach( $_images_old as $_image_old ) {
						tcd_membership_delete_image_from_meta( $_image_old );
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
					$redirect = get_tcd_membership_memberpage_url( 'edit_blog' );
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
		$terms = get_the_terms( $tcd_membership_post->ID, 'category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$tcd_membership_post->category = $term->term_id;
				break;
			}
		}

		// pending使用で編集者未満で公開中ならpendingに変更
		if ( $dp_options['membership']['use_front_edit_blog_pending'] && ! current_user_can( 'edit_others_posts' ) && 'publish' === $tcd_membership_post->post_status ) {
			$tcd_membership_post->post_status = 'pending';
		}
	}

	// エラーメッセージ
	if ( $error_messages ) {
		$tcd_membership_vars['error_message'] = implode( '<br>', $error_messages );
	}
}
add_action( 'tcd_membership_action-edit_blog', 'tcd_membership_action_edit_blog' );

/**
 * ブログ削除アクション
 */
function tcd_membership_action_delete_blog() {
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
	if ( ! $tcd_membership_post || 'post' !== $tcd_membership_post->post_type || ! in_array( $tcd_membership_post->post_status, array( 'publish', 'private', 'pending', 'draft' ) ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = __( 'Incorrect post id.', 'tcd-w' );
		return;
	} elseif ( $tcd_membership_post->post_author != $user->ID && ! current_user_can( 'delete_post', $_REQUEST['post_id'] ) ) {
		$tcd_membership_vars['template'] = 'error';
		$tcd_membership_vars['error_message'] = sprintf( __( 'You do not have permission to delete this %s.', 'tcd-w' ), $dp_options['blog_label'] );
		return;
	}

	// ノンスがついている場合は削除（ゴミ箱）
	if ( ! empty( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'tcd-membership-delete_blog-' . $_REQUEST['post_id'] ) ) {
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
add_action( 'tcd_membership_action-delete_blog', 'tcd_membership_action_delete_blog' );

/**
 * リピーターからブログ本文を生成
 */
function tcd_membership_blog_build_content( $arr ) {
	$post_content = '';

	$arr = (array) $arr;

	for ( $i = 0; $i < 10; $i++ ) {
		$si = 0 < $i ? $i : '';

		if ( ! empty( $arr['headline' . $si] ) ) {
			$post_content .= '<h2 class="headline">' . esc_html( $arr['headline' . $si] ) . '</h2>' . "\n";
		}

		if ( ! empty( $arr['description' . $si] ) ) {
			$post_content .= "\n" . esc_html( $arr['description' . $si] ) . "\n\n";
		}

		if ( ! empty( $arr['image' . $si] ) ) {
			$post_content .= '<p class="align1"><img src="' . esc_attr( $arr['image' . $si] ) . '" alt=""></p>' . "\n";

		}
	}

	return trim( $post_content );
}

/**
 * リピーターサニタイズ 配列用
 * $post にオブジェクトがあればセット
 */
function tcd_membership_blog_repeater_sanitize( $arr ) {
	global $tcd_membership_post;

	$new_arr = array();
	$n = 0;

	// 削除された行を詰めながらサニタイズ
	for ( $i = 0; $i < 10; $i++ ) {
		$si = 0 < $i ? $i : '';
		$sn = 0 < $n ? $n : '';

		if ( isset( $arr['headline' . $si] ) || isset( $arr['description' . $si] ) || isset( $arr['image' . $si] ) ) {
			if ( isset( $arr['headline' . $si] ) ) {
				$new_arr['headline' . $sn] = tcd_membership_sanitize_content( $arr['headline' . $si] );
			} else {
				$new_arr['headline' . $sn] = '';
			}
			if ( isset( $arr['description' . $si] ) ) {
				$new_arr['description' . $sn] = tcd_membership_sanitize_content( $arr['description' . $si] );
			} else {
				$new_arr['description' . $sn] = '';
			}
			if ( isset( $arr['image' . $si] ) ) {
				$new_arr['image' . $sn] = $arr['image' . $si];
			} else {
				$new_arr['image' . $sn] = '';
			}
			$n++;
		}
	}

	// 削除された分の空行追加
	if ( 10 > $n ) {
		for ( $i = $n; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			$new_arr['headline' . $si] = '';
			$new_arr['description' . $si] = '';
			$new_arr['image' . $si] = '';
		}
	}

	return array_merge( $arr, $new_arr );
}

/**
 * ブログプレビューか
 */
function is_tcd_membership_preview_blog() {
	global $tcd_membership_vars, $tcd_membership_post;
	return (
		! empty( $tcd_membership_vars['memberpage_type'] ) &&
		in_array( $tcd_membership_vars['memberpage_type'], array( 'add_blog', 'edit_blog' ) ) &&
		! empty( $tcd_membership_vars[$tcd_membership_vars['memberpage_type']]['confirm'] ) &&
		$tcd_membership_post
	);
}

/**
 * プレビューフォーム出力
 */
function the_tcd_membership_preview_form() {
	global $tcd_membership_vars, $tcd_membership_post;
?>
			<form class="p-membership-form js-membership-form--normal" action="" method="post">
				<div class="p-membership-form__button">
					<button class="p-button p-rounded-button p-submit-button" name="to_complete" type="submit" value="1"><?php _e( 'Save', 'tcd-w' ); ?></button>
					<button class="p-membership-form__back-button" name="to_input" type="submit" value="1"><?php _e( 'Back', 'tcd-w' ); ?></button>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $tcd_membership_post->ID ); ?>">
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-' . $tcd_membership_vars['memberpage_type'] . '-' . $tcd_membership_post->ID ) ); ?>">
<?php
	// post値維持用のinput[type="hidden"]出力
	echo "\t\t\t\t\t";
	foreach ( get_tcd_membership_form_input_keys( $tcd_membership_post->post_type ) as $key ) :
		echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $tcd_membership_post->$key ) . '">';
	endforeach;
	echo "\n";
?>
				</div>
			</form>
<?php
}

/**
 * 新規投稿時に空のWP_Postオブジェクトを生成して返す
 */
function get_tcd_membership_post_to_add( $post_type = 'post', $metas = array() ) {
	global $dp_options;

	$_post = new stdClass;
	$_post->ID = 0;
	$_post->post_author = get_current_user_id();
	$_post->post_title = '';
	$_post->post_content = '';
	$_post->post_name = '';
	$_post->post_status = 'publish';
	$_post->post_type = $post_type;
	$_post->post_date = current_time( 'mysql', false );
	$_post->post_date_gmt = current_time( 'mysql', true );
	$_post = new WP_Post( $_post );

	if ( 'post' === $post_type && ! $metas ) {
		$metas = array();
		foreach ( get_tcd_membership_form_input_keys( $post_type ) as $key ) {
			if ( ! in_array( $key, array( 'post_title', 'post_status' ) ) ) {
		 		$metas[$key] = '';
		 	}
		}

	} elseif ( $post_type === $dp_options['photo_slug'] && ! $metas ) {
 		$metas = array(
			'category' => null,
			'main_image' => '',
			'textalign' => 'center'
		);
	}

	if ( $metas && is_array( $metas ) ){
		foreach ( $metas as $meta_key => $meta_value ) {
			$_post->$meta_key = $meta_value;
		}
	}

	if ( ! tcd_membership_current_user_can_publish( $_post ) ) {
		$_post->post_status = 'pending';
	}

	return $_post;
}

/**
 * WP_Postオブジェクトにフォーム配列を代入して返す
 */
function tcd_membership_set_post_data_from_array( $tcd_membership_post, $formdata ) {

	foreach ( get_tcd_membership_form_input_keys( $tcd_membership_post->post_type ) as $key ) {
		if ( isset( $formdata[$key] ) ) {
			$tcd_membership_post->$key = $formdata[$key];
		} else {
			$tcd_membership_post->$key = '';
		}
	}

	return $tcd_membership_post;
}

/**
 * フォーム維持するinputキー配列を返す
 */
function get_tcd_membership_form_input_keys( $post_type = 'post' ) {
	global $dp_options;

	$input_keys = array();

	if ( 'post' === $post_type ) {
		$input_keys = array(
			'post_title',
			'post_status',
			'category',
			'main_image'
		);

		for ( $i = 0; $i < 10; $i++ ) {
			$si = 0 < $i ? $i : '';
			$input_keys[] = 'headline' . $si;
			$input_keys[] = 'description' . $si;
			$input_keys[] = 'image' . $si;
		}

	} elseif ( $post_type === $dp_options['photo_slug'] ) {
		$input_keys = array(
			'post_title',
			'post_content',
			'post_status',
			'category',
			'main_image',
			'textalign'
		);
	}

	return $input_keys;
}

/**
 * テキストの無害化
 */
function tcd_membership_sanitize_content( $content, $allowable_tags = '' ) {
	$content = preg_replace( '!<style.*?>.*?</style.*?>!is', '', $content );
	$content = preg_replace( '!<script.*?>.*?</script.*?>!is', '', $content );
	$content = strip_shortcodes( $content );
	$content = strip_tags( $content, $allowable_tags );
	$content = str_replace( ']]>', ']]&gt;', $content );
	return $content;
}

/**
 * 拒否単語が含めていれば該当した拒否単語を返す
 */
function tcd_membership_check_forbidden_words( $content ) {
	global $dp_options;

	if ( empty( $content ) ) {
		return false;
	}

	$forbidden_words = trim( $dp_options['membership']['forbidden_words'] );

	if ( ! empty( $forbidden_words ) ) {
		foreach ( explode( "\n", $forbidden_words ) as $word ) {
			$word = trim( $word );

			if ( ! empty( $word ) ) {
				$pattern = '#' . str_replace( '#', '\#', $word ) . '#isu';
				if ( false !== mb_stripos( $content, $word ) || @preg_match( $pattern, $content ) ) {
					return $word;
				}
			}
		}
	}

	return false;
}

/**
 * pending対応のユーザーが公開・非公開記事編集可能か
 */
function tcd_membership_current_user_can_publish( $post = null ) {
	global $dp_options;

	$user_id = get_current_user_id();

	if ( empty( $post->post_type ) || ! $user_id ) {
		return false;
	}

	// 編集
	if ( $post->ID ) {
		// 投稿者でもなく編集権限もなければfalse
		if ( $user_id != $post->post_author && ! current_user_can( 'edit_post', $post->ID ) ) {
			return false;
		}

	// 新規投稿
	} else {
		// 投稿者でなければfalse
		if ( $user_id != $post->post_author ) {
			return false;
		}
	}

	// 写真
	if ( $post->post_type === $dp_options['photo_slug'] ) {
		// pending使用しないもしくは編集者以上ならtrue
		if ( ! $dp_options['membership']['use_front_edit_photo_pending'] || current_user_can( 'edit_others_posts' ) ) {
			return true;
		}

	// ブログ
	} elseif ( 'post' === $post->post_type ) {
		// pending使用しないもしくは編集者以上ならtrue
		if ( ! $dp_options['membership']['use_front_edit_blog_pending'] || current_user_can( 'edit_others_posts' ) ) {
			return true;
		}
	}

	return false;
}

/**
 * pending対応のステータス配列を返す
 */
function get_tcd_membership_post_statuses( $post = null ) {
	global $dp_options;

	if ( empty( $post->post_type ) ) {
		return array();
	}

	if ( tcd_membership_current_user_can_publish( $post ) ) {
		$post_statuses['publish'] = __( 'Publish', 'tcd-w' );
	}

	if ( $post->post_type === $dp_options['photo_slug'] && $dp_options['membership']['use_front_edit_photo_pending'] ) {
		$post_statuses['pending'] = $dp_options['membership']['pending_label'];
		$post_statuses['draft'] = __( 'Draft', 'tcd-w' );
	} elseif ( 'post' === $post->post_type && $dp_options['membership']['use_front_edit_blog_pending'] ) {
		$post_statuses['pending'] = $dp_options['membership']['pending_label'];
		$post_statuses['draft'] = __( 'Draft', 'tcd-w' );
	} else {
		$post_statuses['private'] = __( 'Private', 'tcd-w' );
	}

	return $post_statuses;
}
