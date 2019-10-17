<?php

/**
 * Member News カスタムカラム追加
 */
function tcd_membership_member_news_manage_posts_columns( $columns ) {
	$new_columns = array();
	foreach ( $columns as $column_name => $column_display_name ) {
		// title カラムの前に post_id カラムを追加
		if ( isset( $columns['title'] ) && $column_name == 'title' ) {
			$new_columns['post_id'] = 'ID';
		}
		$new_columns[$column_name] = $column_display_name;
	}
	return $new_columns;
}
add_filter( 'manage_member_news_posts_columns', 'tcd_membership_member_news_manage_posts_columns' );

/**
 * Member News 保存前にタイトル生成
 */
function tcd_membership_member_news_wp_insert_post_data( $data, $postarr ) {

	if ( 'member_news' === $data['post_type'] ) {
		if ( isset( $postarr['ID'] ) ) {
			$data['post_name'] = 'member_news-' . $postarr['ID'];
		}
		if ( ! empty( $data['post_content'] ) ) {
			$content = $data['post_content'];
			$content = preg_replace( '!<style.*?>.*?</style.*?>!is', '', $content );
			$content = preg_replace( '!<script.*?>.*?</script.*?>!is', '', $content );
			$content = strip_shortcodes( $content );
			$content = strip_tags( $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			$content = str_replace( array( "\r\n", "\r", "\n", "&nbsp;" ), " ", $content );
			$content = htmlspecialchars( $content, ENT_QUOTES );
			$content = wp_trim_words( $content, 100, '...' );
			$data['post_title'] = $content;
		} else {
			$data['post_title'] = '';
		}
	}

	return $data;
}
add_filter( 'wp_insert_post_data', 'tcd_membership_member_news_wp_insert_post_data', 10, 2 );

/**
 * Member News 保存後にtcd_membership_actionsテーブルにデータ追加
 */
function tcd_membership_member_news_save_post( $post_id, $post, $update ) {
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

	// tcd_membership_actionsにあれば取得
	$action = get_tcd_membership_action( 'member_news', null, null, $post_id );

	// レコードあり
	if ( $action ) {
		// 公開中
		if ( 'publish' == $post->post_status ) {
			// 日付・投稿者変更は更新
			if ( $action->created_gmt != $post->post_date_gmt || $action->user_id != $post->post_author ) {
				update_tcd_membership_action( array(
					'id' => $action->id,
					'created_gmt' => $post->post_date_gmt,
					'user_id' => $post->post_author
				) );
			}

		// 公開以外ならレコード削除
		} else {
			delete_tcd_membership_action_by_id( $action->id );
		}

	// レコードなし
	} else {
		// 公開中ならレコード追加
		if ( 'publish' == $post->post_status ) {
			$action_id = insert_tcd_membership_action( 'member_news', $post->post_author, 0, $post_id, $post->post_date_gmt );
			if ( $action_id ) {
				// 既読用メタ保存
				update_tcd_membership_action_meta( $action_id, 'read', '' );
			}
		}
	}

	return $post_id;
}
add_action( 'save_post_member_news', 'tcd_membership_member_news_save_post', 10, 3 );
