<?php

function tcd_page_authors_meta_box() {
	add_meta_box(
		'tcd_page_authors_meta_box', // ID of meta box
		__( 'Author list', 'tcd-w' ), // label
		'show_tcd_page_authors_meta_box', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_authors_meta_box' );

function show_tcd_page_authors_meta_box( $post ) {

	echo '<input type="hidden" name="tcd_page_authors_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">' . "\n";

	$cf_key = 'authors_num';
	$cf_value = absint( $post->$cf_key );
	if ( ! $cf_value ) $cf_value = 8;
	echo '<dt class="label"><label>' . __( 'Number of authors per page', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1">';
	echo '</dd>' . "\n";

	$cf_key = 'authors_num_mobile';
	$cf_value = absint( $post->$cf_key );
	if ( ! $cf_value ) $cf_value = 4;
	echo '<dt class="label"><label>' . __( 'Number of authors per page for mobile', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1">';
	echo '</dd>' . "\n";

	$cf_key = 'authors_exclude';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Authors to exclude', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="large-text" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '">';
	echo '<br><small class="description">' . __( 'Enter a comma-seperated list of user ID numbers, example 2,4,10', 'tcd-w' ) . '</small>';
	echo '</dd>' . "\n";

	$cf_key = 'show_search_form';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Search form', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1"' . checked( $cf_value, 1, false) . '>' . __( 'Show search form', 'tcd-w' ) . '</label>';
	echo '</dd>' . "\n";

	echo '</dl>' . "\n";

	echo <<< EOM
<script>
jQuery(function($){
	$('select#page_template').change(function(){
		if (this.value.indexOf('authors') > -1) {
			$('#tcd_page_authors_meta_box-hide').attr('checked', 'checked');
			$('#tcd_page_authors_meta_box').show().removeClass('closed');
		} else {
			$('#tcd_page_authors_meta_box-hide').removeAttr('checked');
			$('#tcd_page_authors_meta_box').hide();
		}
	}).trigger('change');
});
</script>
EOM;
}

function save_tcd_page_authors_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_authors_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_authors_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// save or delete
	$cf_keys = array(
		'authors_num',
		'authors_num_mobile',
		'authors_exclude',
		'show_search_form'
	);
	foreach ( $cf_keys as $cf_key ) {
		$old = get_post_meta( $post_id, $cf_key, true );
		$new = isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '';

		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $cf_key, $new );
		} elseif ( ! $new && $old ) {
			delete_post_meta( $post_id, $cf_key, $old );
		}
	}
}
add_action( 'save_post', 'save_tcd_page_authors_meta_box' );

function tcd_page_authors_hidden_meta_boxes( $hidden, $screen, $use_defaults ) {
	$hidden[] = 'tcd_page_authors_meta_box';
	return array_unique( $hidden );
}
add_action( 'hidden_meta_boxes', 'tcd_page_authors_hidden_meta_boxes', 10, 3 );

// authorsの改ページでpagedを使うため、/pagename/{本文内ページ番号}/page/{ページ番号}/ のリライトを有効にする
function tcd_page_authors_rewrite_rules_array( $rules ) {
	if ( ! get_option('permalink_structure') ) return $rules;

	if ( ! isset( $rules['(.?.+?)/([0-9]+)/page/?([0-9]{1,})/?'] ) ) {
		// 「(.?.+?)/page/?([0-9]{1,})/?$」以降リライトルールをバックアップして削除
		$backups = array();
		$is_found = 0;

		foreach ( $rules as $key => $value ) {
			if ( '(.?.+?)/page/?([0-9]{1,})/?$' === $key ) {
				$is_found = 1;
			}
			if ( $is_found ) {
				$backups[$key] = $rules[$key];
				unset( $rules[$key] );
			}
		}

		if ( $is_found ) {
			// リライトルール追加
			$rules['(.?.+?)/([0-9]+)/page/?([0-9]{1,})/?'] = 'index.php?pagename=$matches[1]&page=$matches[2]&paged=$matches[3]';

			// バックアップしたリライトルールを戻す
			$rules = $rules + $backups;
		}
	}

	return $rules;
}
add_filter( 'rewrite_rules_array', 'tcd_page_authors_rewrite_rules_array' );

// 固定ページテンプレート「Author list」を使用しているページを取得
function get_authors_page() {
	$pages = get_pages( array(
		'sort_order' => 'asc',
		'sort_column' => 'menu_order',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page__authors.php',
		'number' => 1,
		'post_type' => 'page',
		'post_status' => 'publish'
	) );
	if ( $pages ) {
		return array_shift( $pages );
	}
	return false;
}
