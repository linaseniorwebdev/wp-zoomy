<?php

function tcd_page_ranking_meta_box() {
	add_meta_box(
		'tcd_page_ranking_meta_box', // ID of meta box
		__( 'Ranking', 'tcd-w' ), // label
		'show_tcd_page_ranking_meta_box', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_ranking_meta_box' );

function show_tcd_page_ranking_meta_box( $post ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	echo '<input type="hidden" name="tcd_page_ranking_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">' . "\n";

	// 投稿タイプの選択
	$cf_key = 'rank_post_type';
	$rank_post_type = array(
		'name' => __( 'Post type of ranking', 'tcd-w' ),
		'id' => $cf_key,
		'type' => 'checkbox',
		'std' => array( 'post' ),
		'options' => array(
			array(
				'name' => $dp_options['blog_label'],
				'value' => 'post'
			),
			array(
				'name' => $dp_options['photo_label'],
				'value' => 'photo'
			)
		)
	);
	$cf_value = get_post_meta( $post->ID, $cf_key, true );
	if ( ! $cf_value ) $cf_value = $rank_post_type['std'];

	echo '<dt class="label"><label for="' . esc_attr( $rank_post_type['id'] ) . '">' . esc_html( $rank_post_type['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio cf">';
	foreach ( $rank_post_type['options'] as $rank_post_type_option ) {
		echo '<li><label><input type="checkbox" name="' . $rank_post_type['id'] . '[]" value="' . esc_attr( $rank_post_type_option['value'] ) . '"' . checked( true, in_array( $rank_post_type_option['value'], (array) $cf_value ), false ) . ' />' . esc_html( $rank_post_type_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	// ランキングタイプの選択
	$cf_key = 'rank_type';
	$rank_type = array(
		'name' => __( 'Ranking type', 'tcd-w' ),
		'id' => $cf_key,
		'type' => 'radio',
		'std' => 'views',
		'options' => array(
			array(
				'name' => __( 'Views ranking', 'tcd-w' ),
				'value' => 'views'
			),
			array(
				'name' => __( 'Like ranking', 'tcd-w' ),
				'value' => 'likes'
			)
		)
	);
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = $rank_type['std'];

	echo '<dt class="label"><label for="' . esc_attr( $rank_type['id'] ) . '">' . esc_html( $rank_type['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio cf">';
	foreach ( $rank_type['options'] as $rank_type_option ) {
		echo '<li><label><input type="radio" name="' . $rank_type['id'] . '" value="' . esc_attr( $rank_type_option['value'] ) . '"' . checked( $cf_value, $rank_type_option['value'], false ) . ' />' . esc_html( $rank_type_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	// ランキング数
	$cf_key = 'rank_post_num';
	$cf_value = absint( $post->$cf_key );
	if ( ! $cf_value ) $cf_value = 10;
	echo '<dt class="label"><label>' . __( 'Number of ranks', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1">';
	echo '</dd>' . "\n";

	// ランクカラー
	echo '<dt class="label"><label>' . __( 'Rank color setting', 'tcd-w' ) . '</label></dt>';
	echo '<dd class="content">' . "\n";
	echo '<table class="theme_option_table" style="width: auto;">' . "\n";

	for ( $i = 1; $i <= 3; $i++ ) {
		$cf_key = 'rank_font_color' . $i;
		$cf_value = $post->$cf_key;
		$cf_default = '#ffffff';
		if ( ! $cf_value ) $cf_value = $cf_default;
		echo '<tr><td><label>' . sprintf( __('Rank %d font color:', 'tcd-w' ), $i ) . '</label></td>';
		echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

		$cf_key = 'rank_bg_color' . $i;
		$cf_value = $post->$cf_key;
		if ( 1 == $i ) {
			$cf_default = '#ff4000';
		} elseif ( 2 == $i ) {
			$cf_default = '#ffbf00';
		} elseif ( 3 == $i ) {
			$cf_default = '#85b200';
		} else {
			$cf_default = '#cccccc';
		}
		if ( ! $cf_value ) $cf_value = $cf_default;
		echo '<tr><td><label>' . sprintf( __('Rank %d background color:', 'tcd-w' ), $i ) , '</label></td>';
		echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";
	}

	$cf_key = 'rank_font_color0';
	$cf_value = $post->$cf_key;
	$cf_default = '#ffffff';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Other rank font color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	$cf_key = 'rank_bg_color0';
	$cf_value = $post->$cf_key;
	$cf_default = '#cccccc';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Other rank background color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	$cf_key = 'rank_term_font_color';
	$cf_value = $post->$cf_key;
	$cf_default = '#000000';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Ranking term font color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	$cf_key = 'rank_term_bg_color';
	$cf_value = $post->$cf_key;
	$cf_default = '#d9eff6';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Ranking term background color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	echo '</table>' . "\n";
	echo '</dd>' . "\n";

	echo '</dl>' . "\n";

	echo <<< EOM
<script>
jQuery(function($){
	$('select#page_template').change(function(){
		if (this.value.indexOf('ranking') > -1) {
			$('#tcd_page_ranking_meta_box-hide').attr('checked', 'checked');
			$('#tcd_page_ranking_meta_box').show().removeClass('closed');
		} else {
			$('#tcd_page_ranking_meta_box-hide').removeAttr('checked');
			$('#tcd_page_ranking_meta_box').hide();
		}
	}).trigger('change');
});
</script>
EOM;
}

function save_tcd_page_ranking_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_ranking_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_ranking_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
		'rank_post_type',
		'rank_type',
		'rank_post_num',
		'rank_term_font_color',
		'rank_term_bg_color'
	);
	for ( $i = 0; $i <= 3; $i++ ) {
		$cf_keys[] = 'rank_font_color' . $i;
		$cf_keys[] = 'rank_bg_color' . $i;
	}
	foreach ( $cf_keys as $cf_key ) {
		update_post_meta( $post_id, $cf_key, isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '' );
	}
}
add_action( 'save_post', 'save_tcd_page_ranking_meta_box' );

function tcd_page_ranking_hidden_meta_boxes( $hidden, $screen, $use_defaults ) {
	$hidden[] = 'tcd_page_ranking_meta_box';
	return array_unique( $hidden );
}
add_action( 'hidden_meta_boxes', 'tcd_page_ranking_hidden_meta_boxes', 10, 3 );
