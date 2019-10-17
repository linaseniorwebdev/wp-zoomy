<?php
global $dp_options, $dp_default_options, $list_type_options, $post_order_options, $footer_bar_display_options, $footer_bar_button_options, $footer_bar_icon_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // フッター上ウィジェットの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Above footer widget settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Widget settings displayed between the main content and the footer area.', 'tcd-w' ); ?></p>
	<div class="checkboxes">
		<h4 class="theme_option_headline2"><?php _e( 'Display Settings for archive page', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
		<ul>
			<li><label><input name="dp_options[show_above_footer_widget_front]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_front'] ); ?>><?php _e( 'Display above footer widget on front page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_post'] ); ?>><?php _e( 'Display above footer widget on post archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_photo'] ); ?>><?php _e( 'Display above footer widget on photo archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_information]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_information'] ); ?>><?php _e( 'Display above footer widget on information archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_category]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_category'] ); ?>><?php _e( 'Display above footer widget on category archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_photo_category]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_photo_category'] ); ?>><?php _e( 'Display above footer widget on photo category archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_tag]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_tag'] ); ?>><?php _e( 'Display above footer widget on tag archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_date]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_date'] ); ?>><?php _e( 'Display above footer widget on date archive page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_archive_search]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_archive_search'] ); ?>><?php _e( 'Display above footer widget on search results page', 'tcd-w' ); ?></label></li>
		</ul>
		<p>
			<input type="button" class="button-secondary button-checkall" value="<?php echo __( 'Check all', 'tcd-w' ); ?>">
			<input type="button" class="button-secondary button-uncheckall" value="<?php echo __( 'Uncheck all', 'tcd-w' ); ?>">
		</p>
	</div>
	<div class="checkboxes">
		<h4 class="theme_option_headline2"><?php _e( 'Display Settings for single page', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
		<ul>
			<li><label><input name="dp_options[show_above_footer_widget_single_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_single_post'] ); ?>><?php _e( 'Display above footer widget on post single page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_single_page]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_single_page'] ); ?>><?php _e( 'Display above footer widget on page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_single_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_single_photo'] ); ?>><?php _e( 'Display above footer widget on photo single page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_author]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_author'] ); ?>><?php _e( 'Display above footer widget on author page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_404]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_404'] ); ?>><?php _e( 'Display above footer widget on 404 page', 'tcd-w' ); ?></label></li>
		</ul>
		<p>
			<input type="button" class="button-secondary button-checkall" value="<?php echo __( 'Check all', 'tcd-w' ); ?>">
			<input type="button" class="button-secondary button-uncheckall" value="<?php echo __( 'Uncheck all', 'tcd-w' ); ?>">
		</p>
	</div>
	<div class="checkboxes">
		<h4 class="theme_option_headline2"><?php _e( 'Display Settings for member page', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
		<ul>
			<li><label><input name="dp_options[show_above_footer_widget_login]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_login'] ); ?>><?php _e( 'Display above footer widget on login page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_registration]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_registration'] ); ?>><?php _e( 'Display above footer widget on registration page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_registration_account]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_registration_account'] ); ?>><?php _e( 'Display above footer widget on registration account page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_reset_password]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_reset_password'] ); ?>><?php _e( 'Display above footer widget on reset password page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_mypage_news]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_mypage_news'] ); ?>><?php _e( 'Display above footer widget on mypage news page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_mypage_add_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_mypage_add_photo'] ); ?>><?php _e( 'Display above footer widget on add photo page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_mypage_add_blog]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_mypage_add_blog'] ); ?>><?php _e( 'Display above footer widget on add blog page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_mypage_profile]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_mypage_profile'] ); ?>><?php _e( 'Display above footer widget on profile page', 'tcd-w' ); ?></label></li>
			<li><label><input name="dp_options[show_above_footer_widget_mypage_account]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_above_footer_widget_mypage_account'] ); ?>><?php _e( 'Display above footer widget on account page', 'tcd-w' ); ?></label></li>
		</ul>
		<p>
			<input type="button" class="button-secondary button-checkall" value="<?php echo __( 'Check all', 'tcd-w' ); ?>">
			<input type="button" class="button-secondary button-uncheckall" value="<?php echo __( 'Uncheck all', 'tcd-w' ); ?>">
		</p>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ブログコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Blog contents settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Display a carousel slider of blog posts in the footer area.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_footer_blog_top]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_top'], 1 ); ?>><?php _e( 'Show blog contents on top page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_blog]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog'], 1 ); ?>><?php _e( 'Show blog contents on subpage', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Type of posts', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $list_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[footer_blog_list_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['footer_blog_list_type'], $option['value'] ); ?>><?php echo $option['label']; ?><?php
			if ( 'type1' == $option['value'] ) :
				echo '&nbsp;&nbsp;';
				wp_dropdown_categories( array(
					'class' => '',
					'echo' => 1,
					'hide_empty' => 0,
					'hierarchical' => 1,
					'id' => '',
					'name' => 'dp_options[footer_blog_category]',
					'selected' => $dp_options['footer_blog_category'],
					'show_count' => 0,
					'value_field' => 'term_id'
				) );
			endif;
		?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Number of posts', 'tcd-w' ); ?></h4>
	<input type="number" class="small-text" name="dp_options[footer_blog_num]" value="<?php echo esc_attr( $dp_options['footer_blog_num'] ); ?>" min="1">
	<h4 class="theme_option_headline2"><?php _e( 'Post order', 'tcd-w' ); ?></h4>
	<select name="dp_options[footer_blog_post_order]">
		<?php foreach ( $post_order_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['footer_blog_post_order'] ); ?>><?php echo $option['label']; ?></option>
		<?php endforeach; ?>
	</select>
	<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
	<p><label><input name="dp_options[show_footer_blog_category]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Slide interval seconds', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set slide interval seconds. (3 to 15 seconds)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[footer_blog_slide_time_seconds]" value="<?php echo esc_attr( $dp_options['footer_blog_slide_time_seconds'] ); ?>" min="3" max="15"> <?php _e( ' seconds', 'tcd-w' ); ?>
	<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
	<input class="c-color-picker" name="dp_options[footer_blog_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_blog_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_blog_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターウィジェットの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Footer widget settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Widget settings displayed above copyright area.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Widget title color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set widget title color color of footer widget.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_title_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_title_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_title_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set font color of footer widget.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_font_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font color on hover', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set hover font color of footer widget.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_font_color_hover'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set background color of footer widget area.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[footer_widget_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_widget_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_widget_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // SNSボタンの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'SNS button setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please input URL to display the SNS icon and check for RSS button.', 'tcd-w' ); ?></p>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Instagram URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[instagram_url]" value="<?php echo esc_attr( $dp_options['instagram_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Twitter URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[twitter_url]" value="<?php echo esc_attr( $dp_options['twitter_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Pinterest URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[pinterest_url]" value="<?php echo esc_attr( $dp_options['pinterest_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Facebook URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[facebook_url]" value="<?php echo esc_attr( $dp_options['facebook_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Google+ URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[googleplus_url]" value="<?php echo esc_attr( $dp_options['googleplus_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Youtube URL', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[youtube_url]" value="<?php echo esc_attr( $dp_options['youtube_url'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Contact page URL (You can use mailto:)', 'tcd-w' ); ?></td>
			<td><input class="large-text" type="text" name="dp_options[contact_url]" value="<?php echo esc_attr( $dp_options['contact_url'] ); ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><label><input name="dp_options[show_rss]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_rss'] ); ?>><?php _e( 'Display RSS button', 'tcd-w' ); ?></label></td>
		</tr>
	</table>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // コピーライトの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Copyright setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the color scheme of the copyright display area.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set font color of copyright display area.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[copyright_font_color]" type="text" value="<?php echo esc_attr( $dp_options['copyright_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['copyright_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set background color of copyright display area.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[copyright_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['copyright_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['copyright_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターバーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Setting of the footer bar for smart phone', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the footer bar which is displayed with smart phone.', 'tcd-w' ); ?>
	<h4 class="theme_option_headline2"><?php _e( 'Display type of the footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please select how to display the footer bar. When you scroll a page by a certain amount, the footer bar is displayed with the selected animation. If you do not use the footer bar, please check "Hide".', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $footer_bar_display_options as $option ) : ?>
		<label><input type="radio" name="dp_options[footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['footer_bar_display'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the appearance of the footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the color and transparency of the footer bar.', 'tcd-w' ); ?></p>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_bg]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_bg'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Border color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_border]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_border'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_border'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Opacity of background', 'tcd-w' ); ?></td>
			<td><input type="number" class="small-text" name="dp_options[footer_bar_tp]" value="<?php echo esc_attr( $dp_options['footer_bar_tp'] ); ?>" min="0" max="1" step="0.1"></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the contents of the footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can display the button with icon in footer bar. (We recommend you to set max 4 buttons.)', 'tcd-w' ); ?><br><?php _e( 'You can select button types below.', 'tcd-w' ); ?></p>
	<table class="table-border">
		<tr>
			<th><?php _e( 'Default', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can set link URL.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Share', 'tcd-w' ); ?></th>
			<td><?php _e( 'Share buttons are displayed if you tap this button.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Telephone', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can call this number.', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<p><?php _e( 'Click "Add item", and set the button for footer bar. You can drag the item to change their order.', 'tcd-w' ); ?></p>
	<div class="repeater-wrapper">
		<div class="repeater sortable" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
			<?php
			if ( $dp_options['footer_bar_btns'] ) :
				foreach ( $dp_options['footer_bar_btns'] as $key => $value ) :
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo esc_attr( $key ); ?>">
				<h4 class="theme_option_subbox_headline"><?php echo esc_attr( $value['label'] ? $value['label'] : __( 'New item', 'tcd-w' ) ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1" <?php checked( $value['target'], 1 ); ?>><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
							<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
							<td>
								<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
									<?php foreach ( $footer_bar_button_options as $option ) : ?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value['type'], $option['value'] ); ?>><?php echo $option['label']; ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="large-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-url" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $value['url'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-number" style="<?php if ( $value['type'] !== 'type3' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value="<?php echo esc_attr( $value['number'] ); ?>"></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach ( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $value['icon'] ); ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php
				endforeach;
			endif;
			?>
			<?php
				$key = 'addindex';
				ob_start();
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo $key; ?>">
			<h4 class="theme_option_subbox_headline"><?php _e( 'New item', 'tcd-w' ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1"><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
								<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
								<td>
									<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
										<?php foreach ( $footer_bar_button_options as $option ) : ?>
										<option value="<?php echo esc_attr( $option['value'] ); ?>"><?php echo $option['label']; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="large-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value=""></td>
						</tr>
						<tr class="footer-bar-url">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value=""></td>
						</tr>
						<tr class="footer-bar-number" style="display: none;">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="large-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value=""></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach ( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>"<?php if ( 'file-text' == $option['value'] ) { echo ' checked="checked"'; } ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php $clone = ob_get_clean(); ?>
		</div>
		<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
