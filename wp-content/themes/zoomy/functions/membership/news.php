<?php

/**
 * このページでのNewsは会員向けお知らせ(member_news)+コメントされた+フォローされた+いいねされたを含んだものになります。
 */

/**
 * News配列取得
 */
function get_tcd_membership_news( $user_id = null, $type = null ) {
	global $wpdb;

	if ( ! $user_id ) {
		$user_id = (int) get_current_user_id();
	} elseif ( is_a( $user_id, 'WP_User') ) {
		$user_id = (int) $user_id->ID;
	}

	if ( 'member_news' !== $type && 0 >= $user_id ) {
		return false;
	}

	$tablename = get_tcd_membership_tablename( 'actions' );

	if ( 'all' === $type || ! $type ) {
		$sql = "SELECT * FROM {$tablename} "
			 . "WHERE type = 'member_news' "
			 . "OR ( type IN ( 'comment', 'follow', 'like' ) AND target_user_id = %d ) "
			 . "ORDER BY created_gmt DESC";
		return $wpdb->get_results( $wpdb->prepare( $sql, $user_id ) );

	} elseif ( 'member_news' === $type ) {
		$sql = "SELECT * FROM {$tablename} "
			 . "WHERE type = 'member_news' "
			 . "ORDER BY created_gmt DESC";
		return $wpdb->get_results( $sql );

	} elseif ( 'social' === $type ) {
		$sql = "SELECT * FROM {$tablename} "
			 . "WHERE type IN ( 'comment', 'follow', 'like' ) AND target_user_id = %d "
			 . "ORDER BY created_gmt DESC";
		return $wpdb->get_results( $wpdb->prepare( $sql, $user_id ) );

	} else {
		$sql = "SELECT * FROM {$tablename} "
			 . "WHERE type = %s AND target_user_id = %d "
			 . "ORDER BY created_gmt DESC";
		return $wpdb->get_results( $wpdb->prepare( $sql, $type, $user_id ) );
	}
}

/**
 * News未読数を取得
 */
function get_tcd_membership_news_unread_number( $user_id = null, $type = null, $created_gmt_from = null ) {
	global $wpdb;

	if ( ! $user_id ) {
		$user_id = (int) get_current_user_id();
	} elseif ( is_a( $user_id, 'WP_User') ) {
		$user_id = (int) $user_id->ID;
	}

	if ( 0 >= $user_id ) {
		return false;
	}

	$created_gmt_from_ts = null;
	if ( $created_gmt_from ) {
	}

	$tablename_actions = get_tcd_membership_tablename( 'actions' );
	$tablename_action_metas = get_tcd_membership_tablename( 'action_metas' );

	if ( 'all' === $type || ! $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "LEFT JOIN {$tablename_action_metas} AS actread ON (act.id = actread.action_id AND actread.meta_key = 'read') "
			 . "WHERE ( act.type = 'member_news' OR ( act.type IN ( 'comment', 'follow', 'like' ) AND act.target_user_id = %d ) ) "
			 . "AND ( actread.meta_value IS NULL OR NOT FIND_IN_SET( %d, actread.meta_value ) ) ";

		$prepare = array( $user_id, $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} elseif ( 'member_news' === $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "LEFT JOIN {$tablename_action_metas} AS actread ON (act.id = actread.action_id AND actread.meta_key = 'read') "
			 . "WHERE act.type = 'member_news' "
			 . "AND ( actread.meta_value IS NULL OR NOT FIND_IN_SET( %d, actread.meta_value ) ) ";

		$prepare = array( $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} elseif ( 'social' === $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "LEFT JOIN {$tablename_action_metas} AS actread ON (act.id = actread.action_id AND actread.meta_key = 'read') "
			 . "WHERE ( act.type IN ( 'comment', 'follow', 'like' ) AND act.target_user_id = %d ) "
			 . "AND ( actread.meta_value IS NULL OR NOT FIND_IN_SET( %d, actread.meta_value ) ) ";

		$prepare = array( $user_id, $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} else {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "LEFT JOIN {$tablename_action_metas} AS actread ON (act.id = actread.action_id AND actread.meta_key = 'read') "
			 . "WHERE act.type = %s AND act.target_user_id = %d "
			 . "AND ( actread.meta_value IS NULL OR NOT FIND_IN_SET( %d, actread.meta_value ) ) ";

		$prepare = array( $type, $user_id, $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );
	}
}

/**
 * News 指定日以降の新着お知らせ数を取得
 */
function get_tcd_membership_news_recently_number( $user_id = null, $type = null, $created_gmt_from = null ) {
	global $wpdb;

	if ( ! $user_id ) {
		$user_id = (int) get_current_user_id();
	} elseif ( is_a( $user_id, 'WP_User') ) {
		$user_id = (int) $user_id->ID;
	}

	if ( 0 >= $user_id ) {
		return false;
	}

	$created_gmt_from_ts_min = mktime( 0, 0, 0, 1, 1, 2000 );
	if ( is_string( $created_gmt_from ) && preg_match('#^\d{4}[-/]\d{1,2}[-/]\d{1,2}#', $created_gmt_from ) ) {
		$created_gmt_from = strtotime( $created_gmt_from );
	}
	if ( $created_gmt_from && is_numeric( $created_gmt_from ) && $created_gmt_from >= $created_gmt_from_ts_min ) {
		$created_gmt_from_ts = (int) $created_gmt_from;
	} else {
		$created_gmt_from_ts = null;
	}

	$tablename_actions = get_tcd_membership_tablename( 'actions' );
	$tablename_action_metas = get_tcd_membership_tablename( 'action_metas' );

	if ( 'all' === $type || ! $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "WHERE ( act.type = 'member_news' OR ( act.type IN ( 'comment', 'follow', 'like' ) AND act.target_user_id = %d ) ) ";

		$prepare = array( $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} elseif ( 'member_news' === $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "WHERE act.type = 'member_news' ";

		$prepare = array();

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} elseif ( 'social' === $type ) {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "WHERE ( act.type IN ( 'comment', 'follow', 'like' ) AND act.target_user_id = %d ) ";

		$prepare = array( $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );

	} else {
		$sql = "SELECT COUNT(DISTINCT act.id) FROM {$tablename_actions} AS act "
			 . "WHERE act.type = %s AND act.target_user_id = %d ";

		$prepare = array( $type, $user_id );

		if ( $created_gmt_from_ts ) {
			$sql .= "AND act.created_gmt >= %s";
			$prepare[] = date( 'Y-m-d H:i:s', $created_gmt_from_ts );
		}

		return $wpdb->get_var( $wpdb->prepare( $sql, $prepare ) );
	}
}

/**
 * News 既読判別
 */
function is_tcd_membership_news_read( $action_id, $user_id = null ) {
	global $wpdb;

	if ( ! $user_id ) {
		$user_id = (int) get_current_user_id();
	} elseif ( is_a( $user_id, 'WP_User') ) {
		$user_id = (int) $user_id->ID;
	}

	$action_id = (int) $action_id;

	if ( 0 < $action_id && 0 < $user_id ) {
		$tablename = get_tcd_membership_tablename( 'action_metas' );
		$sql = "SELECT meta_id FROM {$tablename} WHERE action_id = %d AND meta_key = %s AND FIND_IN_SET( %d, meta_value ) LIMIT 1";
		$meta_id = $wpdb->get_var( $wpdb->prepare( $sql, $action_id, 'read', $user_id ) );

		if ( $meta_id ) {
			return $meta_id;
		}
	}

	return false;
}

/**
 * Newsを既読にする
 */
function tcd_membership_news_read( $action_id, $user_id = null ) {
	global $wpdb;

	if ( ! $user_id ) {
		$user_id = (int) get_current_user_id();
	} elseif ( is_a( $user_id, 'WP_User') ) {
		$user_id = (int) $user_id->ID;
	}

	$action_id = (int) $action_id;

	if ( 0 < $action_id && 0 < $user_id ) {
		// 既読済みの場合は終了
		if ( is_tcd_membership_news_read( $action_id, $user_id ) ) {
			return null;
		}

		$tablename = get_tcd_membership_tablename( 'action_metas' );
		$sql = "SELECT * FROM {$tablename} WHERE action_id = %d AND meta_key = %s LIMIT 1";
		$result = $wpdb->get_row( $wpdb->prepare( $sql, $action_id, 'read' ) );

		if ( $result ) {
			if ( $result->meta_value ) {
				$meta_value = $result->meta_value . ',' . $user_id;
			} else {
				$meta_value = $user_id;
			}

			$result2 = $wpdb->update(
				$tablename,
				array(
					'meta_value' => $meta_value
				),
				array(
					'meta_id' => $result->meta_id,
					'action_id' => $action_id,
					'meta_key' => 'read'
				),
				array(
					'%s'
				),
				array(
					'%d',
					'%d',
					'%s',
				)
			);

			if ( $result2 ) {
				return $result->meta_id;
			}

		} else {
			$result = $wpdb->insert(
				$tablename,
				array(
					'action_id' => $action_id,
					'meta_key' => 'read',
					'meta_value' => $user_id
				),
				array(
					'%d',
					'%s',
					'%s'
				)
			);

			if ( $result ) {
				return $wpdb->insert_id;
			}
		}
	}

	return false;
}

/**
 * News 記事削除時（ゴミ箱含む）に該当記事に関するNewsを削除
 */
function tcd_membership_news_delete_by_post_id( $post_id ) {
	$post_id = intval( $post_id );
	if ( 0 < $post_id ) {
		delete_tcd_membership_action( array(
			'post_id' => intval( $post_id )
		) );
	}
}
add_action( 'before_delete_post', 'tcd_membership_news_delete_by_post_id' );
add_action( 'trashed_post', 'tcd_membership_news_delete_by_post_id' );
