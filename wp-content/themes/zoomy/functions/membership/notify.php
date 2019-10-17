<?php

/**
 * テーマ変更後の最初の読み込みで実行されるアクションで通知スケジュールイベントセット
 */
function set_tcd_membership_notify_after_switch_theme() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	set_tcd_membership_notify_schedule_event( $dp_options );
}
add_action( 'after_switch_theme', 'set_tcd_membership_notify_after_switch_theme', 12 );

/**
 * 通知スケジュールイベントセット
 */
function set_tcd_membership_notify_schedule_event( $dp_options, $old_dp_options = false ) {
	if ( empty( $dp_options['membership'] ) ) {
		return false;
	}

	$notify_types = array(
		'member_news_notify',
		'social_notify'
	);

	// スケジュールセットフラグ
	$set_flags = array();
	foreach ( $notify_types as $notify_type ) {
		$set_flags[$notify_type] = false;
	}

	// $old_dp_optionsがある場合は設定変更があるかチェック
	if ( ! empty( $old_dp_options['membership'] ) ) {
		foreach ( $notify_types as $notify_type ) {
			// 使用フラグ変更あり
			if ( $dp_options['membership']['use_' . $notify_type] != $old_dp_options['membership']['use_' . $notify_type] ) {
				$set_flags[$notify_type] = true;

			// 時間変更あり
			} elseif ( $dp_options['membership'][$notify_type . '_hour'] != $old_dp_options['membership'][$notify_type . '_hour'] || $dp_options['membership'][$notify_type . '_minute'] != $old_dp_options['membership'][$notify_type . '_minute'] ) {
				$set_flags[$notify_type] = true;

			// 日付タイプ変更あり
			} elseif ( $dp_options['membership'][$notify_type . '_schedule_type'] != $old_dp_options['membership'][$notify_type . '_schedule_type'] ) {
				$set_flags[$notify_type] = true;

			// type2 日数間隔変更あり
			} elseif ( 'type2' === $dp_options['membership'][$notify_type . '_schedule_type'] && $dp_options['membership'][$notify_type . '_schedule_type2'] != $old_dp_options['membership'][$notify_type . '_schedule_type2'] ) {
				$set_flags[$notify_type] = true;

			// type3 曜日変更あり
			} elseif ( 'type3' === $dp_options['membership'][$notify_type . '_schedule_type'] && $dp_options['membership'][$notify_type . '_schedule_type3'] != $old_dp_options['membership'][$notify_type . '_schedule_type3'] ) {
				$set_flags[$notify_type] = true;

			// type4 指定日付変更あり
			} elseif ( 'type4' === $dp_options['membership'][$notify_type . '_schedule_type'] && $dp_options['membership'][$notify_type . '_schedule_type4'] != $old_dp_options['membership'][$notify_type . '_schedule_type4'] ) {
				$set_flags[$notify_type] = true;
			}
		}

	} else {
		foreach ( $notify_types as $notify_type ) {
			// 使用フラグあり
			if ( $dp_options['membership']['use_' . $notify_type] ) {
				$set_flags[$notify_type] = true;
			}
		}
	}

	foreach ( $notify_types as $notify_type ) {
		// フラグあればスケジュールイベントセット
		if ( $set_flags[$notify_type] ) {
			// スケジュール削除
			wp_clear_scheduled_hook( 'tcd_membership_cron_' . $notify_type, array( true ) );

			// 使用フラグ変更あり
			if ( $dp_options['membership']['use_' . $notify_type] ) {
				$next_event_timestamp = tcd_membership_notify_next_event_timestamp( $notify_type, (int) get_option( 'tcd_membership_' . $notify_type . '_last_timestamp' ), $dp_options );
				if ( $next_event_timestamp ) {
					// array( true ) を指定することで通知後の次回通知のスケジュールイベントセットさせる
					wp_schedule_single_event( $next_event_timestamp, 'tcd_membership_cron_' . $notify_type, array( true ) );
				}
			}
		}
	}
}

/**
 * 通知 次回送信日時のタイムスタンプ(GMT)を返す
 */
function tcd_membership_notify_next_event_timestamp( $notify_type, $last_timestamp_gmt = null, $dp_options = null ) {
	global $dp_default_options;

	// $notify_typeチェック
	if ( ! $notify_type || ! in_array( $notify_type, array( 'member_news_notify', 'social_notify' ), true ) ) {
		return false;
	}

	if ( ! $dp_options ) {
		$dp_options = $GLOBALS['dp_options'];
	}

	if ( ! isset( $dp_options['membership'][$notify_type . '_schedule_type'] ) ) {
		$dp_options['membership'] = array_merge( $dp_default_options['membership'], $dp_options['membership']);
	}

	// 使用フラグ無し
	if ( empty( $dp_options['membership']['use_' . $notify_type] ) ) {
		return false;
	}

	$current_ts = current_time( 'timestamp', false );
	$current_ts_gmt = current_time( 'timestamp', true );
	$current_ts_offset = $current_ts - $current_ts_gmt;

	if ( $last_timestamp_gmt && is_int( $last_timestamp_gmt ) ) {
		$ts = $last_timestamp_gmt;
	} else {
		$ts = $current_ts_gmt;
		$last_timestamp_gmt = null;
	}

	// 日付指定
	if ( 'type4' === $dp_options['membership'][$notify_type . '_schedule_type'] ) {
		// $last_timestamp_gmtは無視して現日付から
		$ts_day = (int) date( 'j', $current_ts_gmt );
		$ts_maxday = (int) date( 't', $current_ts_gmt );
		$select_days = array();
		$next_day = 0;

		// 指定日付
		foreach ( (array) $dp_options['membership'][$notify_type . '_schedule_type4'] as $day ) {
			$day = (int) $day;
			if ( 0 < $day ) {
				$select_days[] = $day;
			}
		}
		// 指定日付が空なら暫定的に1日と15日にする
		if ( ! $select_days ) {
			$select_days = array( 1, 15 );
		}

		$select_days = array( 15, 31 );

		// 同月から次の日付を探す
		if ( $ts_day < $ts_maxday ) {
			foreach ( $select_days as $day ) {
				$day = (int) $day;
				if ( $day > $ts_day ) {
					if ( $day > $ts_maxday ) {
						$next_day = $ts_maxday;
					} else {
						$next_day = $day;
					}
					break;
				}
			}
		}

		// 翌月
		if ( ! $next_day ) {
			$ts = strtotime( 'first day of next month', $ts );
			$ts_day = (int) date( 'j', $ts );
			$ts_maxday = (int) date( 't', $ts );

			foreach ( $select_days as $day ) {
				$day = (int) $day;
				if ( $day >= $ts_day ) {
					if ( $day > $ts_maxday ) {
						$next_day = $ts_maxday;
					} else {
						$next_day = $day;
					}
					break;
				}
			}
		}

		if ( ! $next_day ) {
			return false;
		}

		$ts = mktime( 0, 0, 0, date( 'n', $ts ), $next_day, date( 'Y', $ts ) );

	// 曜日指定
	} elseif ( 'type3' === $dp_options['membership'][$notify_type . '_schedule_type'] ) {
		$daynames = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
		if ( isset( $daynames[$dp_options['membership'][$notify_type . '_schedule_type3']] ) ) {
			$dayname = $daynames[$dp_options['membership'][$notify_type . '_schedule_type3']];
		} else {
			$dayname = 'sunday';
		}

		// $last_timestamp_gmtは無視して現日付から次の曜日取得
		$ts = strtotime( 'next ' . $dayname, $current_ts_gmt );

	// N日ごと
	} elseif ( 'type2' === $dp_options['membership'][$notify_type . '_schedule_type'] ) {
		$day_interval = absint( $dp_options['membership'][$notify_type . '_schedule_type2'] );
		if ( ! $day_interval ) {
			$day_interval = 1;
		}
		$ts = strtotime( '+' . $day_interval . ' day', $ts );

		// 現在日時より古い場合は現在日時から再取得
		if ( $ts < $current_ts_gmt ) {
			$ts = strtotime( '+' . $day_interval . ' day', $current_ts_gmt );
		}

	// 毎日
	} else {
		$day_interval = 1;
		$ts = strtotime( '+1 day', $ts );

		// 現在日時より古い場合は現在日時から再取得
		if ( $ts < $current_ts_gmt ) {
			$ts = strtotime( '+1 day', $current_ts_gmt );
		}
	}

	// 時間
	$hour = absint( $dp_options['membership'][$notify_type . '_hour'] );
	if ( 24 <= $hour ) {
		$hour = 23;
	}
	$minute = absint( $dp_options['membership'][$notify_type . '_minute'] );
	if ( 60 <= $minute ) {
		$minute = 59;
	}
	$ts = strtotime( $hour . ':' . $minute . ':00', $ts );

	// タイムゾーンオフセット
	$ts -= $current_ts_offset;

	// 初回で毎日の場合は可能なら当日にセット
	if ( ! $last_timestamp_gmt && ! empty( $day_interval ) && 1 === $day_interval && $ts - DAY_IN_SECONDS > $current_ts_gmt ) {
		$ts -= DAY_IN_SECONDS;
	}

	// 現在日時より小さい場合はfalseを返す
	if ( $ts < $current_ts_gmt ) {
		return false;
	}

	return $ts;
}

/**
 * お知らせ通知 CRONアクションに追加
 */
add_action( 'tcd_membership_cron_member_news_notify', 'tcd_membership_member_news_notify_send' );

/**
 * お知らせ通知 送信
 */
function tcd_membership_member_news_notify_send( $set_next_schedule = false ) {
	global $dp_options;

	$notify_type = 'member_news_notify';

	$current_ts = current_time( 'timestamp', false );
	$current_ts_gmt = current_time( 'timestamp', true );

	// 前回通知タイムスタンプ
	$last_timestamp_gmt = (int) get_option( 'tcd_membership_' . $notify_type . '_last_timestamp' );

	if ( $dp_options['membership']['use_' . $notify_type] ) {
		$sent_count = 0;
		$sent_error_count = 0;

		$users = get_users( array(
			'meta_key' => $notify_type,
			'meta_value' => 'yes',
			'orderby' => 'ID',
			'order' => 'ASC'
		) );

		if ( $users ) {
			foreach ( $users as $user ) {
				// タイムアウト対策
				set_time_limit( 15 );

				// 未読取得
				$news_count = (int) get_tcd_membership_news_recently_number( $user->ID, 'member_news', $last_timestamp_gmt );

				// 未読があればメール送信
				if ( 0 < $news_count ) {
					$replaces = array(
						'[user_display_name]' => $user->display_name,
						'[user_email]' => $user->user_email,
						'[mypage_news_url]' => get_tcd_membership_memberpage_url( 'news' ),
						'[news_count]' => $news_count
					);
					if ( tcd_membership_mail( $notify_type, $user->user_email, $replaces ) ) {
						$sent_count++;
					} else {
						$sent_error_count++;
					}
				}
			}
		}
	}

	// オプションにタイムスタンプ保存
	update_option( 'tcd_membership_' . $notify_type . '_last_timestamp', $current_ts_gmt );

	// オプションにログ保存
	$notify_log = get_option( 'tcd_membership_notify_log', array() );
	if ( $dp_options['membership']['use_' . $notify_type] ) {
		$notify_log[$notify_type][$current_ts_gmt]['sent_count'] = $sent_count;
		$notify_log[$notify_type][$current_ts_gmt]['sent_error_count'] = $sent_error_count;
		$notify_log[$notify_type][$current_ts_gmt]['users_count'] = count( $users );
		
	} else {
		$notify_log[$notify_type][$current_ts_gmt]['error'] = 'Empty "use_' . $notify_type . '" option';
	}
	$notify_log[$notify_type][$current_ts_gmt]['date'] = date( 'Y-m-d H:i:s', $current_ts );
	$notify_log[$notify_type][$current_ts_gmt]['date_gmt'] = date( 'Y-m-d H:i:s', $current_ts_gmt );
	update_option( 'tcd_membership_notify_log', $notify_log );

	// フラグがあれば次回スケジュールセット
	if ( $set_next_schedule ) {
		// スケジュールイベント引数 削除時にも必須なので注意
		$schedule_event_args = array( true );

		// お知らせ通知 スケジュール削除
		wp_clear_scheduled_hook( 'tcd_membership_cron_' . $notify_type, $schedule_event_args );

		// スケジュールイベントセット
		$next_event_timestamp = tcd_membership_notify_next_event_timestamp( $notify_type, $current_ts_gmt );
		if ( $next_event_timestamp ) {
			wp_schedule_single_event( $next_event_timestamp, 'tcd_membership_cron_' . $notify_type, $schedule_event_args );
		}
	}
}

/**
 * いいねコメントフォロー通知 CRONアクションに追加
 */
add_action( 'tcd_membership_cron_social_notify', 'tcd_membership_social_notify_send' );

/**
 * いいねコメントフォロー通知 送信
 */
function tcd_membership_social_notify_send( $set_next_schedule = false ) {

	global $dp_options;

	$notify_type = 'social_notify';

	$current_ts = current_time( 'timestamp', false );
	$current_ts_gmt = current_time( 'timestamp', true );

	// 前回通知タイムスタンプ
	$last_timestamp_gmt = (int) get_option( 'tcd_membership_' . $notify_type . '_last_timestamp' );

	if ( $dp_options['membership']['use_' . $notify_type] ) {
		$sent_count = 0;
		$sent_error_count = 0;

		$users = get_users( array(
			'meta_key' => $notify_type,
			'meta_value' => 'yes',
			'orderby' => 'ID',
			'order' => 'ASC'
		) );

		if ( $users ) {
			foreach ( $users as $user ) {
				// タイムアウト対策
				set_time_limit( 15 );

				// 未読取得
				$likes_count = (int) get_tcd_membership_news_recently_number( $user->ID, 'like', $last_timestamp_gmt );
				$comments_count = (int) get_tcd_membership_news_recently_number( $user->ID, 'comment', $last_timestamp_gmt );
				$follows_count = (int) get_tcd_membership_news_recently_number( $user->ID, 'follow', $last_timestamp_gmt );
				$total_count = $likes_count + $comments_count + $follows_count;

				// 未読があればメール送信
				if ( 0 < $total_count ) {
					$replaces = array(
						'[user_display_name]' => $user->display_name,
						'[user_email]' => $user->user_email,
						'[mypage_news_url]' => get_tcd_membership_memberpage_url( 'news' ),
						'[total_count]' => $total_count,
						'[likes_count]' => $likes_count,
						'[comments_count]' => $comments_count,
						'[follows_count]' => $follows_count
					);
					if ( tcd_membership_mail( $notify_type, $user->user_email, $replaces ) ) {
						$sent_count++;
					} else {
						$sent_error_count++;
					}
				}
			}
		}
	}

	// オプションにタイムスタンプ保存
	update_option( 'tcd_membership_' . $notify_type . '_last_timestamp', $current_ts_gmt );

	// オプションにログ保存
	$notify_log = get_option( 'tcd_membership_notify_log', array() );
	if ( $dp_options['membership']['use_' . $notify_type] ) {
		$notify_log[$notify_type][$current_ts_gmt]['sent_count'] = $sent_count;
		$notify_log[$notify_type][$current_ts_gmt]['sent_error_count'] = $sent_error_count;
		$notify_log[$notify_type][$current_ts_gmt]['users_count'] = count( $users );
		
	} else {
		$notify_log[$notify_type][$current_ts_gmt]['error'] = 'Empty "use_' . $notify_type . '" option';
	}
	$notify_log[$notify_type][$current_ts_gmt]['date'] = date( 'Y-m-d H:i:s', $current_ts );
	$notify_log[$notify_type][$current_ts_gmt]['date_gmt'] = date( 'Y-m-d H:i:s', $current_ts_gmt );
	update_option( 'tcd_membership_notify_log', $notify_log );

	// フラグがあれば次回スケジュールセット
	if ( $set_next_schedule ) {
		// スケジュールイベント引数 削除時にも必須なので注意
		$schedule_event_args = array( true );

		// お知らせ通知 スケジュール削除
		wp_clear_scheduled_hook( 'tcd_membership_cron_' . $notify_type, $schedule_event_args );

		// スケジュールイベントセット
		$next_event_timestamp = tcd_membership_notify_next_event_timestamp( $notify_type, $current_ts_gmt );
		if ( $next_event_timestamp ) {
			wp_schedule_single_event( $next_event_timestamp, 'tcd_membership_cron_' . $notify_type, $schedule_event_args );
		}
	}
}

/**
 * いいねコメントフォロー通知のブロック型ショートコード処理
 */
function tcd_membership_mail_social_notify_filter( $text = null, $replaces = array(), $mailto = null ) {
	if ( $text ) {
		$social_notify_replaces = array(
			array(
				'[likes_count]',
				'[has_likes_count]',
				'[/has_likes_count]'
			),
			array(
				'[comments_count]',
				'[has_comments_count]',
				'[/has_comments_count]'
			),
			array(
				'[follows_count]',
				'[has_follows_count]',
				'[/has_follows_count]'
			)
		);
		foreach( $social_notify_replaces as $a ) {
			if ( isset( $replaces[$a[0]] ) ) {
				if ( ! empty( $replaces[$a[0]] ) ) {
					$text = str_replace( $a[1], '', $text );
					$text = str_replace( $a[2], '', $text );
				} else {
					$text = preg_replace( '#' . preg_quote ( $a[1] ) . '.*?' .preg_quote ( $a[2] ) . '#su', '', $text );
				}
			}
		}
	}
	return $text;
}
add_filter( 'tcd_membership_mail_subject-social_notify', 'tcd_membership_mail_social_notify_filter', 10, 3 );
add_filter( 'tcd_membership_mail_body-social_notify', 'tcd_membership_mail_social_notify_filter', 10, 3 );
