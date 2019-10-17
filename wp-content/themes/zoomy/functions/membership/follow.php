<?php

/**
 * ajaxでのフォロー追加削除
 */
function ajax_toggle_follow() {
	global $dp_options;

	$json = array(
		'result' => false
	);

	if ( ! isset( $_POST['user_id'] ) ) {
		$json['message'] = __( 'Invalid request.', 'tcd-w' );
	} elseif ( ! current_user_can( 'read' ) ) {
		$json['message'] = __( 'Require login.', 'tcd-w' );
	} else {
		$user_id = get_current_user_id();
		$target_user_id = (int) $_POST['user_id'];

		if ( 0 < $target_user_id ) {
			$target_user = get_user_by( 'id', $target_user_id );
		}
		if ( empty( $target_user ) ) {
			$json['message'] = __( 'Invalid request.', 'tcd-w' );
		} elseif ( ! $dp_options['membership']['use_follow'] ) {
			$json['message'] = __( 'Disable follow.', 'tcd-w' );
		} elseif ( $target_user_id == $user_id ) {
			$json['message'] = __( 'You can not own follow.', 'tcd-w' );
		} else {

			// フォロー済みの場合、フォロー削除
			if ( is_following( $target_user_id, $user_id ) ) {
				$result = remove_follow( $target_user_id, $user_id );
				if ( $result ) {
					$json['result'] = 'removed';
					$json['text'] = __( 'Follow', 'tcd-w' );;
				} else {
					$json['message'] = 'Remove follow error: ' . __( 'Failed to save the database.', 'tcd-w' );
				}

			// フォローしていない場合、フォロー追加
			} else {
				$result = add_follow( $target_user_id, $user_id );
				if ( $result ) {
					$json['result'] = 'added';
					$json['text'] = __( 'Following', 'tcd-w' );;
				} else {
					$json['message'] = 'Add follow error: ' . __( 'Failed to save the database.', 'tcd-w' );
				}
			}
		}
	}

	// JSON出力
	wp_send_json( $json );
	exit;
}
add_action( 'wp_ajax_toggle_follow', 'ajax_toggle_follow' );
add_action( 'wp_ajax_nopriv_toggle_follow', 'ajax_toggle_follow' );

/**
 * フォロー追加
 */
function add_follow( $target_user_id, $user_id = 0 ) {
	// フォロー済みの場合
	if ( is_following( $target_user_id, $user_id ) ) {
		return 0;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	$target_user_id = (int) $target_user_id;
	if ( 0 >= $target_user_id ) {
		return null;
	}

	$target_user = get_user_by( 'id', $target_user_id );
	if ( ! $target_user ) {
		return null;
	}

	if ( insert_tcd_membership_action( 'follow', $user_id, $target_user_id, 0 ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * フォロー削除
 */
function remove_follow( $target_user_id, $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	$target_user_id = (int) $target_user_id;
	if ( 0 >= $target_user_id ) {
		return null;
	}

	$target_user = get_user_by( 'id', $target_user_id );
	if ( ! $target_user ) {
		return null;
	}

	// フォローしていない場合
	if ( false === is_following( $target_user_id, $user_id ) ) {
		return 0;
	}

	if ( delete_tcd_membership_action( array(
		'type' => 'follow',
		'user_id' => $user_id,
		'target_user_id' => $target_user_id
	) ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * フォロー済みかを判別
 */
function is_following( $target_user_id, $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	$target_user_id = (int) $target_user_id;
	if ( 0 >= $target_user_id ) {
		return null;
	}

	$target_user = get_user_by( 'id', $target_user_id );
	if ( ! $target_user ) {
		return null;
	}

	if ( get_tcd_membership_action( 'follow', $user_id, $target_user_id, 0 ) ) {
		return true;
	} else {
		return false;
	}
}
