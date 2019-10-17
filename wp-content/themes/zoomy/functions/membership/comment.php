<?php

/**
 * コメント保存時、tcd_membership_actionsテーブルにレコード追加
 */
function tcd_membership_insert_comment_action( $comment_id, $comment ) {
	// 承認済み以外は終了
	if ( ! in_array( $comment->comment_approved, array( 1, '1', 'approve' ), true ) ) {
		return;
	}

	// 記事がない場合は終了
	$post = get_post( $comment->comment_post_ID );
	if ( ! $comment->comment_post_ID || ! $post ) {
		return;
	}

	// 投稿者とコメント者が同じ場合は終了
	if ( $comment->user_id && $post->post_author == $comment->user_id ) {
		return;
	}

	// コメントIDがメタテーブルに保存済みの場合は終了
	if ( get_tcd_membership_meta_by_meta( 'comment_id', $comment_id ) ) {
		return;
	}

	// アクション保存
	$action_id = insert_tcd_membership_action( 'comment', $comment->user_id, $post->post_author, $comment->comment_post_ID );
	if ( $action_id ) {
		// メタ保存
		update_tcd_membership_action_meta( $action_id, 'comment_id', $comment_id );
	}
}
add_action( 'wp_insert_comment', 'tcd_membership_insert_comment_action', 10, 2 );

/**
 * コメント承認時、tcd_membership_actionsテーブルにレコード追加
 */
function tcd_membership_wp_set_comment_status( $comment_id, $comment_status ) {
	// 承認済みの場合のみ
	if ( in_array( $comment_status, array( 1, '1', 'approve' ), true ) ) {
		tcd_membership_insert_comment_action( $comment_id, get_comment( $comment_id ) );
	}
}
add_action( 'wp_set_comment_status', 'tcd_membership_wp_set_comment_status', 10, 2 );
