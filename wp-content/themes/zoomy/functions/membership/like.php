<?php

/**
 * ajaxでのいいね追加削除
 */
function ajax_toggle_like() {
	global $dp_options;

	$json = array(
		'result' => false
	);

	if ( ! isset( $_POST['post_id'] ) ) {
		$json['message'] = __( 'Invalid request.', 'tcd-w' );
	} elseif ( ! current_user_can( 'read' ) ) {
		$json['message'] = __( 'Require login.', 'tcd-w' );
	} else {
		$user_id = get_current_user_id();
		$post_id = (int) $_POST['post_id'];

		if ( 0 < $post_id ) {
			$target_post = get_post( $post_id );
		}
		if ( empty( $target_post->post_status ) ) {
			$json['message'] = __( 'Invalid request.', 'tcd-w' );
		} elseif ( 'publish' !== $target_post->post_status ) {
			$json['message'] = sprintf( __( 'Disable like in %s.', 'tcd-w' ), __( 'Not publish article', 'tcd-w' ) );
		} elseif ( ! in_array( $target_post->post_type, array( 'post', $dp_options['photo_slug'] ) ) ) {
			$json['message'] = sprintf( __( 'Disable like in %s.', 'tcd-w' ), $target_post->post_type );
		} elseif ( 'post' === $target_post->post_type && ! $dp_options['membership']['use_like_blog'] ) {
			$json['message'] = sprintf( __( 'Disable like in %s.', 'tcd-w' ), $dp_options['blog_label'] ? $dp_options['blog_label']: __( 'Blog', 'tcd-w' ) );
		} elseif ( $dp_options['photo_slug'] === $target_post->post_type && ! $dp_options['membership']['use_like_photo'] ) {
			$json['message'] = sprintf( __( 'Disable like in %s.', 'tcd-w' ), $dp_options['photo_label'] ? $dp_options['photo_label']: __( 'Photo', 'tcd-w' ) );
		} elseif ( $target_post->post_author == $user_id ) {
			$json['message'] = __( 'You can not "LIKE" own post.', 'tcd-w' );
		} else {

			// いいね済みの場合、いいね削除
			if ( is_liked( $post_id, $user_id ) ) {
				$result = remove_like( $post_id, $user_id );
				if ( $result ) {
					$json['result'] = 'removed';
					$likes_number = get_likes_number( $post_id );
					$json['likes_number'] = $likes_number;
					update_post_meta( $post_id, '_likes', $likes_number );
				} else {
					$json['message'] = 'Remove like error: ' . __( 'Failed to save the database.', 'tcd-w' );
				}

			// いいねしていない場合、いいね追加
			} else {
				$result = add_like( $post_id, $user_id );
				if ( $result ) {
					$json['result'] = 'added';
					$likes_number = get_likes_number( $post_id );
					$json['likes_number'] = $likes_number;
					update_post_meta( $post_id, '_likes', $likes_number );
				} else {
					$json['message'] = 'Add like error: ' . __( 'Failed to save the database.', 'tcd-w' );
				}
			}
		}
	}

	// JSON出力
	wp_send_json( $json );
	exit;
}
add_action( 'wp_ajax_toggle_like', 'ajax_toggle_like' );
add_action( 'wp_ajax_nopriv_toggle_like', 'ajax_toggle_like' );

/**
 * tcd_membership_actionsテーブルからいいね数取得
 */
function get_likes_number( $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$post_id = (int) $post_id;
	if ( 0 >= $post_id ) {
		return null;
	}

	global $wpdb;

	$tablename = get_tcd_membership_tablename( 'actions' );
	$sql = "SELECT COUNT(id) FROM {$tablename} WHERE type = 'like' AND post_id = %d";
	return $wpdb->get_var( $wpdb->prepare( $sql, $post_id ) );
}

/**
 * いいね追加
 */
function add_like( $post_id, $user_id = 0 ) {
	// いいね済みの場合
	if ( is_liked( $post_id, $user_id ) ) {
		return 0;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	$post_id = (int) $post_id;
	if ( 0 >= $post_id ) {
		return null;
	}

	$target_post = get_post( $post_id );
	if ( empty( $target_post->post_status ) || 'publish' !== $target_post->post_status ) {
		return null;
	}

	if ( insert_tcd_membership_action( 'like', $user_id, $target_post->post_author, $post_id ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * いいね削除
 */
function remove_like( $post_id, $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	$post_id = (int) $post_id;
	if ( 0 >= $post_id ) {
		return null;
	}

	$target_post = get_post( $post_id );
	if ( empty( $target_post->post_status ) || 'publish' !== $target_post->post_status ) {
		return null;
	}

	// いいねしていない場合
	if ( false === is_liked( $post_id, $user_id ) ) {
		return 0;
	}

	if ( delete_tcd_membership_action( array(
		'type' => 'like',
		'user_id' => $user_id,
		'post_id' => $post_id
	) ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * いいね済みかを判別
 */
function is_liked( $post_id = null, $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return null;
	}

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	$post_id = (int) $post_id;
	if ( 0 >= $post_id ) {
		return null;
	}

	$target_post = get_post( $post_id );
	if ( empty( $target_post->post_status ) || 'publish' !== $target_post->post_status ) {
		return null;
	}

	if ( get_tcd_membership_action( 'like', $user_id, $target_post->post_author, $post_id ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * 記事保存時に_likeメタが空なら0をセット
 */
function save_post_likes_zero( $post_id, $post = null ) {
	global $dp_options;

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( ! empty( $post->post_type ) && in_array( $post->post_type, array( 'post', $dp_options['photo_slug'] ) ) && '' === get_post_meta( $post_id, '_likes', true ) ) {
		update_post_meta( $post_id, '_likes', 0 );
	}
}
add_action( 'save_post', 'save_post_likes_zero', 10, 2 );

/**
 * いいね数ランキング記事一覧取得関数
 *
 * @param string $like_range 期間指定 [ '' | day | daily | week | weekly | month | monthly | year | yearly ]
 * @param string $query_args WP_Queryの引数指定
 * @param string $output     出力形式 [ ''（WP_Query以外） | WP_Query ]
 *
 * @return WP_Query|array
 *
 * 期間アクセス数テーブルからランキング一覧作成する場合（期間指定ありもしくはカスタムフィールドアクセス数未使用）戻り値のpost->likesにアクセス数が入ります。またアクセス数が0のものは戻り値に含まれません。
 */
function get_posts_likes_ranking( $like_range = null, $query_args = array(), $output = null ) {
	$query_args_defaults = array(
		'ignore_sticky_posts' => 1,
	);
	$query_args = wp_parse_args( (array) $query_args, $query_args_defaults );

	$like_range = strtolower( $like_range );
	if ( ! in_array( $like_range, array( 'day', 'daily', 'week', 'weekly', 'month', 'monthly', 'year', 'yearly' ) ) ) {
		$like_range = '';
	}

	$output = strtolower( $output );

	if ( ! $like_range ) {
		// カスタムフィールドアクセス数降順
		$query_args2 = $query_args;
		$query_args2['meta_key'] = '_likes';
		$query_args2['orderby'] = 'meta_value_num';
		$query_args2['order'] = 'DESC';
		if ( isset( $query_args2['meta_value'] ) ) {
			unset( $query_args2['meta_value'] );
		}

		$_wp_query = new WP_Query( $query_args2 );

		// ランダム対応
		if ( ! empty( $query_args['orderby'] ) && 'rand' === $query_args['orderby'] && $_wp_query->posts ) {
			mt_shuffle( $_wp_query->posts );
		}

		if ( 'wp_query' === $output ) {
			return $_wp_query;
		} else {
			return (array) $_wp_query->posts;
		}
	}

	// 期間指定をグローバル変数にセット
	$GLOBALS['_like_range'] = $like_range;

	// posts_clausesフィルター追加
	add_filter( 'posts_clauses', '_get_posts_likes_ranking_posts_clauses', 999, 2 );

	// WP Query実行
	$_wp_query = new WP_Query( $query_args );

	// posts_clausesフィルター削除
	remove_filter( 'posts_clauses', '_get_posts_likes_ranking_posts_clauses', 999, 2 );

	// グローバル変数の期間指定を削除
	unset( $GLOBALS['_like_range'] );

	// ランダム対応
	if ( !empty( $query_args['orderby'] ) && 'rand' === $query_args['orderby'] && $_wp_query->posts ) {
		mt_shuffle( $_wp_query->posts );
	}

	if ( 'wp_query' === $output ) {
		return $_wp_query;
	} else {
		return (array) $_wp_query->posts;
	}
}

/**
 * いいね数ランキング記事一覧取得用posts_clausesフィルター
 */
function _get_posts_likes_ranking_posts_clauses( $clauses, $wp_query ) {
	// グローバル変数に期間指定があれば
	if ( isset( $GLOBALS['_like_range'] ) ) {
		$like_range = $GLOBALS['_like_range'];

		global $wpdb;

		// テーブル名
		$tablename = get_tcd_membership_tablename( 'actions' );

		// fields
		$clauses['fields'] .= ", COUNT(DISTINCT actions_like.id) AS likes";

		// join
		$clauses['join'] .= " INNER JOIN {$tablename} AS actions_like ON (actions_like.type = 'like' AND {$wpdb->posts}.ID = actions_like.post_id)";

		// groupby
		$clauses['groupby'] = "{$wpdb->posts}.ID";

		// orderby
		$clauses['orderby'] = "likes DESC, " . $clauses['orderby'];

		// 期間指定値からfrom日時タイムスタンプ計算
		if ( in_array( $like_range, array( '24h', 'day', 'daily' ) ) ) {
			$from_ts = current_time( 'timestamp', true ) - DAY_IN_SECONDS;
		} elseif ( in_array( $like_range, array( 'week', 'weekly' ) ) ) {
			$from_ts = current_time( 'timestamp', true ) - WEEK_IN_SECONDS;
		} elseif ( in_array( $like_range, array( 'month', 'monthly' ) ) ) {
			$from_ts = strtotime( '-1 month', current_time( 'timestamp', true ) );
		} elseif ( in_array( $like_range, array( 'year', 'yearly' ) ) ) {
			$from_ts = current_time( 'timestamp', true ) - YEAR_IN_SECONDS;
		} else {
			$from_ts = null;
		}

		if ( $from_ts ) {
			// where
			$clauses['where'] .= " AND actions_like.created_gmt >= '" . date( 'Y-m-d H:i:s', $from_ts ) . "'";
		}
	}

	return $clauses;
}
