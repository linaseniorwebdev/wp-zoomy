<?php

/**
 * コンテンツビルダー コンテンツ一覧取得
 */
function cb_get_contents() {
	global $dp_options;		// $dp_optionsは保存時にWPが使用するため使えない
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	return array(
		'blog' => array(
			'name' => 'blog',
			'label' => $dp_options['blog_label'],
			'default' => array(
				'cb_display' => 0,
				'cb_headline' => __( 'Blog', 'tcd-w' ),
				'cb_headline_color' => '#000000',
				'cb_headline_font_size' => 32,
				'cb_headline_font_size_mobile' => 22,
				'cb_desc' => '',
				'cb_desc_color' => '#000000',
				'cb_desc_font_size' => 16,
				'cb_desc_font_size_mobile' => 14,
				'cb_list_type' => 'all',
				'cb_category' => 0,
				'cb_order' => 'date',
				'cb_post_num' => 4,
				'cb_show_date' => 1,
				'cb_show_category' => 1,
				'cb_show_comments_number' => 1,
				'cb_show_views_number' => 1,
				'cb_show_likes_number' => 1,
				'cb_show_within_hours' => 0,
				'cb_within_hours' => 24,
				'cb_hide_posts_duplicature_other_content' => 0,
				'cb_show_archive_link' => 0,
				'cb_archive_link_text' => __( 'Blog archive', 'tcd-w' ),
				'cb_archive_link_target_blank' => 0,
				'cb_archive_link_font_color' => '#ffffff',
				'cb_archive_link_bg_color' => $dp_options['primary_color'],
				'cb_archive_link_font_color_hover' => '#ffffff',
				'cb_archive_link_bg_color_hover' => $dp_options['secondary_color'],
				'cb_background_color' => '#f5f5f5'
			),
			'cb_list_type_options' => array(
				'all' => __( 'All posts', 'tcd-w' ),
				'category' => __( 'Select category', 'tcd-w' ),
				'recommend_post' => __( 'Recommend post', 'tcd-w' ),
				'recommend_post2' => __( 'Recommend post2', 'tcd-w' ),
				'pickup_post' => __( 'Pickup post', 'tcd-w' )
			),
			'cb_order_options' => array(
				'date' => __( 'Date (DESC)', 'tcd-w' ),
				'date2' => __( 'Date (ASC)', 'tcd-w' ),
				'random' => __( 'Random', 'tcd-w' )
			)
		),
		'photo' => array(
			'name' => 'photo',
			'label' => $dp_options['photo_label'],
			'default' => array(
				'cb_display' => 0,
				'cb_headline' => __( 'Photo', 'tcd-w' ),
				'cb_headline_color' => '#000000',
				'cb_headline_font_size' => 32,
				'cb_headline_font_size_mobile' => 22,
				'cb_desc' => '',
				'cb_desc_color' => '#000000',
				'cb_desc_font_size' => 16,
				'cb_desc_font_size_mobile' => 14,
				'cb_list_type' => 'all',
				'cb_category' => 0,
				'cb_order' => 'date',
				'cb_post_num' => 4,
				'cb_show_date' => 1,
				'cb_show_category' => 1,
				'cb_show_comments_number' => 1,
				'cb_show_views_number' => 1,
				'cb_show_likes_number' => 1,
				'cb_show_within_hours' => 0,
				'cb_within_hours' => 24,
				'cb_hide_posts_duplicature_other_content' => 0,
				'cb_show_archive_link' => 0,
				'cb_archive_link_text' => __( 'Photo archive', 'tcd-w' ),
				'cb_archive_link_target_blank' => 0,
				'cb_archive_link_font_color' => '#ffffff',
				'cb_archive_link_bg_color' => $dp_options['primary_color'],
				'cb_archive_link_font_color_hover' => '#ffffff',
				'cb_archive_link_bg_color_hover' => $dp_options['secondary_color'],
				'cb_background_color' => ''
			),
			'cb_list_type_options' => array(
				'all' => __( 'All posts', 'tcd-w' ),
				'category' => __( 'Select category', 'tcd-w' ),
				'recommend_post' => __( 'Recommend post', 'tcd-w' ),
				'recommend_post2' => __( 'Recommend post2', 'tcd-w' ),
				'pickup_post' => __( 'Pickup post', 'tcd-w' )
			),
			'cb_order_options' => array(
				'date' => __( 'Date (DESC)', 'tcd-w' ),
				'date2' => __( 'Date (ASC)', 'tcd-w' ),
				'random' => __( 'Random', 'tcd-w' )
			)
		),
		'ad' => array(
			'name' => 'ad',
			'label' => __( 'Advertisement', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_ad_code1' => '',
				'cb_ad_image1' => '',
				'cb_ad_url1' => '',
				'cb_ad_code2' => '',
				'cb_ad_image2' => '',
				'cb_ad_url2' => '',
				'cb_background_color' => ''
			)
		),
		'wysiwyg' => array(
			'name' => 'wysiwyg',
			'label' => __( 'Free space', 'tcd-w' ),
			'default' => array(
				'cb_display' => 0,
				'cb_wysiwyg_editor' => '',
				'cb_background_color' => ''
			)
		)
	);
}

/**
 * コンテンツビルダー js/css
 */
function cb_admin_scripts() {
	wp_enqueue_style( 'tcd-cb', get_template_directory_uri() . '/admin/css/contents-builder.css', array(), version_num() );
	wp_enqueue_script( 'tcd-cb', get_template_directory_uri() . '/admin/js/contents-builder.js', array( 'jquery-ui-sortable' ), version_num(), true);
	wp_enqueue_style( 'editor-buttons' );
}
add_action( 'admin_print_scripts-appearance_page_theme_options', 'cb_admin_scripts' );
add_action( 'admin_print_scripts-toplevel_page_theme_options', 'cb_admin_scripts' );

/**
 * コンテンツビルダー入力設定
 */
function cb_inputs() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_desing_plus_option();
?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Contents Builder', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Please set contents of front page with contents builder.', 'tcd-w' ); ?></p>
		<div class="theme_option_message"><?php echo __( '<p>You can build contents freely with this function.</p><p>FIRST STEP: Click Add content button.<br>SECOND STEP: Select content from dropdown menu to show on each column.</p><p>You can change row by dragging MOVE button and you can delete row by clicking DELETE button.</p>', 'tcd-w' ); ?></div>

		<div id="contents_builder_wrap">
			<div id="contents_builder" data-delete-confirm="<?php _e( 'Are you sure you want to delete this content?', 'tcd-w' ); ?>">
<?php
	if ( ! empty( $dp_options['contents_builder'] ) ) :
		foreach ( $dp_options['contents_builder'] as $key => $content ) :
			$cb_index = 'cb_' . ( $key + 1 );
?>
				<div class="cb_row">
					<ul class="cb_button cf">
						<li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
						<li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
					</ul>
					<div class="cb_column_area cf">
						<div class="cb_column">
							<input type="hidden" value="<?php echo $cb_index; ?>" class="cb_index">
							<?php the_cb_content_select( $cb_index, $content['cb_content_select'] ); ?>
							<?php if ( ! empty( $content['cb_content_select'] ) ) the_cb_content_setting( $cb_index, $content['cb_content_select'], $content ); ?>
						</div>
					</div><!-- END .cb_column_area -->
				</div><!-- END .cb_row -->
<?php
		endforeach;
	endif;
?>
			</div><!-- END #contents_builder -->
			<div id="cb_add_row_buttton_area">
				<input type="button" value="<?php echo __( 'Add content', 'tcd-w' ); ?>" class="button-secondary add_row">
			</div>
			<p><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></p>
		</div><!-- END #contents_builder_wrap -->

<?php
	// コンテンツビルダー追加用 非表示
	$cb_index = 'cb_cloneindex';
?>
		<div id="contents_builder-clone" class="hidden">
			<div class="cb_row">
				<ul class="cb_button cf">
					<li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
					<li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
				</ul>
				<div class="cb_column_area cf">
					<div class="cb_column">
						<input type="hidden" class="cb_index" value="cb_cloneindex">
						<?php the_cb_content_select( $cb_index ); ?>
					</div>
				</div><!-- END .cb_column_area -->
			</div><!-- END .cb_row -->
<?php
	foreach ( cb_get_contents() as $key => $value ) :
		the_cb_content_setting( 'cb_cloneindex', $key );
	endforeach;
?>
		</div><!-- END #contents_builder-clone.hidden -->
	</div>
<?php
}

/**
 * コンテンツビルダー用 コンテンツ選択プルダウン
 */
function the_cb_content_select( $cb_index = 'cb_cloneindex', $selected = null ) {
	$cb_contents = cb_get_contents();

	if ( $selected && isset( $cb_contents[$selected] ) ) {
		$add_class = ' hidden';
	} else {
		$add_class = '';
	}

	$out = '<select name="dp_options[contents_builder][' . esc_attr( $cb_index ) . '][cb_content_select]" class="cb_content_select' . $add_class . '">';
	$out .= '<option value="">' . __( 'Choose the content', 'tcd-w' ) . '</option>';

	foreach ( $cb_contents as $key => $value ) {
		$out .= '<option value="' . esc_attr( $key ) . '"' . selected( $key, $selected, false ) . '>' . esc_html( $value['label'] ) . '</option>';
	}

	$out .= '</select>';

	echo $out;
}

/**
 * コンテンツビルダー用 コンテンツ設定
 */
function the_cb_content_setting( $cb_index = 'cb_cloneindex', $cb_content_select = null, $value = array() ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_desing_plus_option();

	$cb_contents = cb_get_contents();

	// 不明なコンテンツの場合は終了
	if ( ! $cb_content_select || ! isset( $cb_contents[$cb_content_select] ) ) return false;

	// コンテンツデフォルト値に入力値をマージ
	if ( isset( $cb_contents[$cb_content_select]['default'] ) ) {
		$value = array_merge( (array) $cb_contents[$cb_content_select]['default'], $value );
	}
?>
	<div class="cb_content_wrap cf cb_content-<?php echo esc_attr( $cb_content_select ); ?>">

<?php
	// ブログ
	if ( 'blog' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
			<p><?php _e( 'This is posts list of blog.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the heading.', 'tcd-w' ); ?></p>
			<textarea class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline]" rows="2"><?php echo esc_textarea( $value['cb_headline'] ); ?></textarea>
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color]" value="<?php echo esc_attr( $value['cb_headline_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_headline_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size]" value="<?php echo esc_attr( $value['cb_headline_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the description.', 'tcd-w' ); ?></p>
			<textarea class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc]" rows="4"><?php echo esc_textarea( $value['cb_desc'] ); ?></textarea>
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_color]" value="<?php echo esc_attr( $value['cb_desc_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_desc_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size]" value="<?php echo esc_attr( $value['cb_desc_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size_mobile]" value="<?php echo esc_attr( $value['cb_desc_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
<?php
		if ( ! empty( $cb_contents[$cb_content_select]['cb_list_type_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post type', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Select the type of post you want to display.', 'tcd-w' ); ?></p>
			<p class="description"><?php _e( 'Recommended posts and Pickup posts can be set from post edit screen / quick edit.', 'tcd-w' ); ?></p>
			<ul class="cb_list_type-radios">
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_list_type_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_list_type]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_list_type'], $k, false ) . '> '. esc_html( $v ) . '</label>';
				if ( 'category' == $k ) :
					echo '&nbsp;&nbsp;';
					wp_dropdown_categories( array(
						'class' => '',
						'echo' => 1,
						'hide_empty' => 0,
						'hierarchical' => 1,
						'id' => '',
						'name' => 'dp_options[contents_builder][' . $cb_index . '][cb_category]',
						'selected' => $value['cb_category'],
						'show_count' => 0,
						'value_field' => 'term_id'
					) );
				endif;
				echo '</li>';
			endforeach;
?>
			</ul>
<?php
		endif;

		if ( ! empty( $cb_contents[$cb_content_select]['cb_order_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Display order', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Select the order of the post from date (DESC) or date (ASC) or random.', 'tcd-w' ); ?></p>
			<ul>
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_order_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_order]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_order'], $k, false ) . '> '. esc_html( $v ) . '</label></li>';
			endforeach;
?>
			</ul>
<?php
		endif;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post number', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the number of displayed articles', 'tcd-w' ); ?></p>
			<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_post_num]" value="<?php echo esc_attr( $value['cb_post_num'] ); ?>" min="4">
			<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the display of each item.', 'tcd-w' ); ?></p>
			<ul>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="checkbox" value="1" <?php checked( $value['cb_show_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="checkbox" value="1" <?php checked( $value['cb_show_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_comments_number]" type="hidden" value="">
		<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_comments_number]" type="checkbox" value="1" <?php checked( $value['cb_show_comments_number'], 1 ); ?>><?php _e( 'Display comments number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_views_number]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_views_number]" type="checkbox" value="1" <?php checked( $value['cb_show_views_number'], 1 ); ?>><?php _e( 'Display views number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_likes_number]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_likes_number]" type="checkbox" value="1" <?php checked( $value['cb_show_likes_number'], 1 ); ?>><?php _e( 'Display likes number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_within_hours]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_within_hours]" type="checkbox" value="1" <?php checked( $value['cb_show_within_hours'], 1 ); ?>><?php _e( 'Display only articles within arbitrary hours', 'tcd-w' ); ?></label>
					<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_within_hours]" value="<?php echo esc_attr( $value['cb_within_hours'] ); ?>" min="1"><span><?php _e( 'hours', 'tcd-w' ); ?></span>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_hide_posts_duplicature_other_content]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_hide_posts_duplicature_other_content]" type="checkbox" value="1" <?php checked( $value['cb_hide_posts_duplicature_other_content'], 1 ); ?>><?php _e( 'Do not display posts displayed posts in other contents', 'tcd-w' ); ?></label>
				</li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the archive page button to be displayed at the bottom.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_archive_link]" type="checkbox" value="1" <?php checked( $value['cb_show_archive_link'], 1 ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
			<table>
				<tr>
					<td><label><?php _e( 'Archive link label', 'tcd-w' ); ?></td>
					<td><input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_text]" value="<?php echo esc_attr( $value['cb_archive_link_text'] ); ?>" size="30"></td>
				</tr>
				<tr>
					<td colspan="2"><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_target_blank]" type="checkbox" value="1" <?php checked( $value['cb_archive_link_target_blank'], 1 ); ?>> <?php _e( 'Use target blank for this link', 'tcd-w' ); ?></label></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color]" value="<?php echo esc_attr( $value['cb_archive_link_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_font_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_font_color_hover'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color_hover'] ); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker"<?php if ( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) echo ' data-default-color="' . esc_attr( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) . '"'; ?>>

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// Photo
	elseif ( 'photo' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
			<p><?php _e( 'This is posts list of photo.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the heading.', 'tcd-w' ); ?></p>
			<textarea class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline]" rows="2"><?php echo esc_textarea( $value['cb_headline'] ); ?></textarea>
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_color]" value="<?php echo esc_attr( $value['cb_headline_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_headline_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size]" value="<?php echo esc_attr( $value['cb_headline_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_headline_font_size_mobile]" value="<?php echo esc_attr( $value['cb_headline_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the description.', 'tcd-w' ); ?></p>
			<textarea class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc]" rows="4"><?php echo esc_textarea( $value['cb_desc'] ); ?></textarea>
			<table style="margin-top: 5px;">
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_color]" value="<?php echo esc_attr( $value['cb_desc_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_desc_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size]" value="<?php echo esc_attr( $value['cb_desc_font_size'] ); ?>" min="1"><span>px</span></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font size for mobile', 'tcd-w' ); ?></label></td>
					<td><input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_desc_font_size_mobile]" value="<?php echo esc_attr( $value['cb_desc_font_size_mobile'] ); ?>" min="1"><span>px</span></td>
				</tr>
			</table>
<?php
		if ( ! empty( $cb_contents[$cb_content_select]['cb_list_type_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post type', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Select the type of post you want to display.', 'tcd-w' ); ?></p>
			<p class="description"><?php _e( 'Recommended posts and Pickup posts can be set from post edit screen / quick edit.', 'tcd-w' ); ?></p>
			<ul class="cb_list_type-radios">
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_list_type_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_list_type]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_list_type'], $k, false ) . '> '. esc_html( $v ) . '</label>';
				if ( 'category' == $k ) :
					echo '&nbsp;&nbsp;';
					wp_dropdown_categories( array(
						'class' => '',
						'echo' => 1,
						'hide_empty' => 0,
						'hierarchical' => 1,
						'id' => '',
						'name' => 'dp_options[contents_builder][' . $cb_index . '][cb_category]',
						'selected' => $value['cb_category'],
						'taxonomy' => $dp_options['photo_category_slug'],
						'show_count' => 0,
						'value_field' => 'term_id'
					) );
				endif;
				echo '</li>';
			endforeach;
?>
			</ul>
<?php
		endif;

		if ( ! empty( $cb_contents[$cb_content_select]['cb_order_options'] ) ) :
?>
			<h4 class="theme_option_headline2"><?php _e( 'Display order', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Select the order of the post from date (DESC) or date (ASC) or random.', 'tcd-w' ); ?></p>
			<ul>
<?php
			foreach ( $cb_contents[$cb_content_select]['cb_order_options'] as $k => $v ) :
				echo '<li><label><input type="radio" name="dp_options[contents_builder][' . $cb_index . '][cb_order]" value="' . esc_attr( $k ) . '" ' . checked( $value['cb_order'], $k, false ) . '> '. esc_html( $v ) . '</label></li>';
			endforeach;
?>
			</ul>
<?php
		endif;
?>
			<h4 class="theme_option_headline2"><?php _e( 'Post number', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the number of displayed articles', 'tcd-w' ); ?></p>
			<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_post_num]" value="<?php echo esc_attr( $value['cb_post_num'] ); ?>" min="4">
			<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the display of each item.', 'tcd-w' ); ?></p>
			<ul>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_date]" type="checkbox" value="1" <?php checked( $value['cb_show_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_category]" type="checkbox" value="1" <?php checked( $value['cb_show_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_comments_number]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_comments_number]" type="checkbox" value="1" <?php checked( $value['cb_show_comments_number'], 1 ); ?>><?php _e( 'Display comments number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_views_number]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_views_number]" type="checkbox" value="1" <?php checked( $value['cb_show_views_number'], 1 ); ?>><?php _e( 'Display views number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_likes_number]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_likes_number]" type="checkbox" value="1" <?php checked( $value['cb_show_likes_number'], 1 ); ?>><?php _e( 'Display likes number', 'tcd-w' ); ?></label>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_within_hours]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_within_hours]" type="checkbox" value="1" <?php checked( $value['cb_show_within_hours'], 1 ); ?>><?php _e( 'Display only articles within arbitrary hours', 'tcd-w' ); ?></label>
					<input type="number" class="small-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_within_hours]" value="<?php echo esc_attr( $value['cb_within_hours'] ); ?>" min="1"><span><?php _e( 'hours', 'tcd-w' ); ?></span>
				</li>
				<li>
					<input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_hide_posts_duplicature_other_content]" type="hidden" value="">
					<label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_hide_posts_duplicature_other_content]" type="checkbox" value="1" <?php checked( $value['cb_hide_posts_duplicature_other_content'], 1 ); ?>><?php _e( 'Do not display posts displayed posts in other contents', 'tcd-w' ); ?></label>
				</li>
			</ul>
			<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Set the archive page button to be displayed at the bottom.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_show_archive_link]" type="checkbox" value="1" <?php checked( $value['cb_show_archive_link'], 1 ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
			<table>
				<tr>
					<td><label><?php _e( 'Archive link label', 'tcd-w' ); ?></td>
					<td><input type="text" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_text]" value="<?php echo esc_attr( $value['cb_archive_link_text'] ); ?>" size="30"></td>
				</tr>
				<tr>
					<td colspan="2"><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_target_blank]" type="checkbox" value="1" <?php checked( $value['cb_archive_link_target_blank'], 1 ); ?>> <?php _e( 'Use target blank for this link', 'tcd-w' ); ?></label></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color]" value="<?php echo esc_attr( $value['cb_archive_link_font_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_font_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_font_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_font_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_font_color_hover'] ); ?>"></td>
				</tr>
				<tr>
					<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></td>
					<td><input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_archive_link_bg_color_hover]" value="<?php echo esc_attr( $value['cb_archive_link_bg_color_hover'] ); ?>" class="c-color-picker" data-default-color="<?php echo esc_attr( $cb_contents[$cb_content_select]['default']['cb_archive_link_bg_color_hover'] ); ?>"></td>
				</tr>
			</table>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker"<?php if ( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) echo ' data-default-color="' . esc_attr( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) . '"'; ?>>

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// 広告
	elseif ( 'ad' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_contents[$cb_content_select]['label'] ); ?><span></span></h3>
		<div class="cb_content">
			<p><?php _e( 'Please set banner.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
				<div class="sub_box_content">
					<div class="theme_option_content">
						<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
						<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
						<textarea class="large-text" cols="50" rows="10" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_code1]"><?php echo esc_textarea( $value['cb_ad_code1'] ); ?></textarea>
					</div>
					<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
					<div class="theme_option_content">
						<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
						<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 580, 160 ); ?></p>
						<div class="image_box cf">
							<div class="cf cf_media_field hide-if-no-js cb_ad_image1">
								<input type="hidden" value="<?php echo esc_attr( $value['cb_ad_image1'] ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_image1]" class="cf_media_id">
								<div class="preview_field"><?php if ( $value['cb_ad_image1'] ) { echo wp_get_attachment_image( $value['cb_ad_image1'], 'medium' ); } ?></div>
								<div class="button_area">
									<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
									<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_ad_image1'] ) { echo 'hidden'; } ?>">
								</div>
							</div>
						</div>
						<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
						<input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_url1]" value="<?php echo esc_attr( $value['cb_ad_url1'] ); ?>">
					</div>
				</div>
			</div>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
				<div class="sub_box_content">
					<div class="theme_option_content">
						<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
						<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
						<textarea class="large-text" cols="50" rows="10" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_code2]"><?php echo esc_textarea( $value['cb_ad_code2'] ); ?></textarea>
					</div>
					<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
					<div class="theme_option_content">
						<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
						<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 580, 160 ); ?></p>
						<div class="image_box cf">
							<div class="cf cf_media_field hide-if-no-js cb_ad_image2">
								<input type="hidden" value="<?php echo esc_attr( $value['cb_ad_image2'] ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_image2]" class="cf_media_id">
								<div class="preview_field"><?php if ( $value['cb_ad_image2'] ) { echo wp_get_attachment_image( $value['cb_ad_image2'], 'medium' ); } ?></div>
								<div class="button_area">
									<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
									<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_ad_image2'] ) { echo 'hidden'; } ?>">
								</div>
							</div>
						</div>
						<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
						<input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_ad_url2]" value="<?php echo esc_attr( $value['cb_ad_url2'] ); ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker"<?php if ( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) echo ' data-default-color="' . esc_attr( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) . '"'; ?>>

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>

<?php
	// フリーススペース
	elseif ( 'wysiwyg' == $cb_content_select ) :
?>
		<h3 class="cb_content_headline"><?php _e( 'WYSIWYG editor', 'tcd-w' ); ?><span></span></h3>
		<div class="cb_content">
			<p><?php _e( 'Please create content freely as you like blog posts.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_display]" type="checkbox" value="1" <?php checked( $value['cb_display'], 1 ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set a href attribute to the ID below.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>

			<?php
				wp_editor(
					$value['cb_wysiwyg_editor'],
					'cb_wysiwyg_editor-' . $cb_index,
					array(
						'textarea_name' => 'dp_options[contents_builder][' . $cb_index . '][cb_wysiwyg_editor]',
						'textarea_rows' => 10,
						'editor_class' => 'change_content_headline'
					)
				);
			?>
			<h4 class="theme_option_headline2"><?php _e( 'Content background color', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_background_color]" value="<?php echo esc_attr( $value['cb_background_color'] ); ?>" class="c-color-picker"<?php if ( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) echo ' data-default-color="' . esc_attr( $cb_contents[$cb_content_select]['default']['cb_background_color'] ) . '"'; ?>>

			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>
<?php
	else :
?>
		<h3 class="cb_content_headline"><?php echo esc_html( $cb_content_select ); ?></h3>
		<div class="cb_content">
			<ul class="cb_content_button cf">
				<li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
				<li><a href="#" class="button-secondary close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
			</ul>
		</div>
<?php
	endif;
?>
	</div><!-- END .cb_content_wrap -->
<?php
}

/**
 * コンテンツビルダー用 保存整形
 */
function cb_validate( $input = array() ) {
	if ( ! empty( $input['contents_builder'] ) ) {
		$cb_contents = cb_get_contents();
		$cb_data = array();

		foreach ( $input['contents_builder'] as $key => $value ) {
			// クローン用はスルー
			if ( in_array( $key, array( 'cb_cloneindex', 'cb_cloneindex2' ), true ) ) continue;

			// コンテンツデフォルト値に入力値をマージ
			if ( ! empty( $value['cb_content_select'] ) && isset( $cb_contents[$value['cb_content_select']]['default'] ) ) {
				$value = array_merge( (array) $cb_contents[$value['cb_content_select']]['default'], $value );
			}

			// ブログ
			if ( 'blog' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_headline'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_headline'] ) );
				$value['cb_headline_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_headline_color'] ) );
				$value['cb_headline_font_size'] = absint( $value['cb_headline_font_size'] );
				$value['cb_headline_font_size_mobile'] = absint( $value['cb_headline_font_size_mobile'] );
				$value['cb_desc'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_desc'] ) );
				$value['cb_desc_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_desc_color'] ) );
				$value['cb_desc_font_size'] = absint( $value['cb_desc_font_size'] );
				$value['cb_desc_font_size_mobile'] = absint( $value['cb_desc_font_size_mobile'] );
				$value['cb_category'] = absint( $value['cb_category'] );
				$value['cb_post_num'] = absint( $value['cb_post_num'] );
				$value['cb_show_date'] = ! empty( $value['cb_show_date'] ) ? 1 : 0;
				$value['cb_show_category'] = ! empty( $value['cb_show_category'] ) ? 1 : 0;
				$value['cb_show_comments_number'] = ! empty( $value['cb_show_comments_number'] ) ? 1 : 0;
				$value['cb_show_views_number'] = ! empty( $value['cb_show_views_number'] ) ? 1 : 0;
				$value['cb_show_likes_number'] = ! empty( $value['cb_show_likes_number'] ) ? 1 : 0;
				$value['cb_show_within_hours'] = ! empty( $value['cb_show_within_hours'] ) ? 1 : 0;
				$value['cb_within_hours'] = absint( $value['cb_within_hours'] );
				$value['cb_hide_posts_duplicature_other_content'] = ! empty( $value['cb_hide_posts_duplicature_other_content'] ) ? 1 : 0;
				$value['cb_show_archive_link'] = ! empty( $value['cb_show_archive_link'] ) ? 1 : 0;
				$value['cb_archive_link_text'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_text'] ) );
				$value['cb_archive_link_target_blank'] = ! empty( $value['cb_archive_link_target_blank'] ) ? 1 : 0;
				$value['cb_archive_link_font_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_font_color'] ) );
				$value['cb_archive_link_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_bg_color'] ) );
				$value['cb_archive_link_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_font_color_hover'] ) );
				$value['cb_archive_link_bg_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_bg_color_hover'] ) );
				$value['cb_background_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_background_color'] ) );

				if ( ! empty( $value['cb_list_type'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_list_type_options'][$value['cb_list_type']] ) ) {
					$value['cb_list_type'] = null;
				}
				if ( empty( $value['cb_list_type'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_list_type'] ) ) {
					$value['cb_list_type'] = $cb_contents[$value['cb_content_select']]['default']['cb_list_type'];
				}

				if ( ! empty( $value['cb_order'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_order_options'][$value['cb_order']] ) ) {
					$value['cb_order'] = null;
				}
				if ( empty( $value['cb_order'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_order'] ) ) {
					$value['cb_order'] = $cb_contents[$value['cb_content_select']]['default']['cb_order'];
				}

			// 写真
			} elseif ( 'photo' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_headline'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_headline'] ) );
				$value['cb_headline_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_headline_color'] ) );
				$value['cb_headline_font_size'] = absint( $value['cb_headline_font_size'] );
				$value['cb_headline_font_size_mobile'] = absint( $value['cb_headline_font_size_mobile'] );
				$value['cb_desc'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_desc'] ) );
				$value['cb_desc_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_desc_color'] ) );
				$value['cb_desc_font_size'] = absint( $value['cb_desc_font_size'] );
				$value['cb_desc_font_size_mobile'] = absint( $value['cb_desc_font_size_mobile'] );
				$value['cb_category'] = absint( $value['cb_category'] );
				$value['cb_post_num'] = absint( $value['cb_post_num'] );
				$value['cb_show_date'] = ! empty( $value['cb_show_date'] ) ? 1 : 0;
				$value['cb_show_category'] = ! empty( $value['cb_show_category'] ) ? 1 : 0;
				$value['cb_show_comments_number'] = ! empty( $value['cb_show_comments_number'] ) ? 1 : 0;
				$value['cb_show_views_number'] = ! empty( $value['cb_show_views_number'] ) ? 1 : 0;
				$value['cb_show_likes_number'] = ! empty( $value['cb_show_likes_number'] ) ? 1 : 0;
				$value['cb_show_within_hours'] = ! empty( $value['cb_show_within_hours'] ) ? 1 : 0;
				$value['cb_within_hours'] = absint( $value['cb_within_hours'] );
				$value['cb_hide_posts_duplicature_other_content'] = ! empty( $value['cb_hide_posts_duplicature_other_content'] ) ? 1 : 0;
				$value['cb_show_archive_link'] = ! empty( $value['cb_show_archive_link'] ) ? 1 : 0;
				$value['cb_archive_link_text'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_text'] ) );
				$value['cb_archive_link_target_blank'] = ! empty( $value['cb_archive_link_target_blank'] ) ? 1 : 0;
				$value['cb_archive_link_font_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_font_color'] ) );
				$value['cb_archive_link_bg_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_bg_color'] ) );
				$value['cb_archive_link_font_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_font_color_hover'] ) );
				$value['cb_archive_link_bg_color_hover'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_archive_link_bg_color_hover'] ) );
				$value['cb_background_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_background_color'] ) );

				if ( ! empty( $value['cb_list_type'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_list_type_options'][$value['cb_list_type']] ) ) {
					$value['cb_list_type'] = null;
				}
				if ( empty( $value['cb_list_type'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_list_type'] ) ) {
					$value['cb_list_type'] = $cb_contents[$value['cb_content_select']]['default']['cb_list_type'];
				}

				if ( ! empty( $value['cb_order'] ) && ! isset( $cb_contents[$value['cb_content_select']]['cb_order_options'][$value['cb_order']] ) ) {
					$value['cb_order'] = null;
				}
				if ( empty( $value['cb_order'] ) && isset( $cb_contents[$value['cb_content_select']]['default']['cb_order'] ) ) {
					$value['cb_order'] = $cb_contents[$value['cb_content_select']]['default']['cb_order'];
				}

			// 広告
			} elseif ( 'ad' == $value['cb_content_select'] ) {
				$value['cb_display'] = ( $value['cb_display'] == 1 ) ? 1 : 0;
				$value['cb_background_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_background_color'] ) );

				for ( $i = 1; $i <= 2; $i++ ) {
					$value['cb_ad_code' . $i] = $value['cb_ad_code' . $i];
					$value['cb_ad_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $value['cb_ad_image' . $i] ) );
					$value['cb_ad_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $value['cb_ad_url' . $i] ) );
				}

			// フリースペース
			} elseif ( 'wysiwyg' == $value['cb_content_select'] ) {
				$value['cb_display'] = ! empty( $value['cb_display'] ) ? 1 : 0;
				$value['cb_background_color'] = wp_unslash( wp_filter_nohtml_kses( $value['cb_background_color'] ) );
			}

			$cb_data[] = $value;
		}

		$input['contents_builder'] = $cb_data;
	}

	return $input;
}

/**
 * クローン用のリッチエディター化処理をしないようにする
 * クローン後のリッチエディター化はjsで行う
 */
function cb_tiny_mce_before_init( $mceInit, $editor_id ) {
	if ( strpos( $editor_id, 'cb_cloneindex' ) !== false ) {
		$mceInit['wp_skip_init'] = true;
	}
	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'cb_tiny_mce_before_init', 10, 2 );
