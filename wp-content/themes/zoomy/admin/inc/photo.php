<?php
global $dp_options, $dp_default_options, $post_order_options, $comment_type_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // Photoの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Photo page basic setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Label', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can change the name of Photo as you like. Default label is \"Photo\".', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[photo_label]" value="<?php echo esc_attr( $dp_options['photo_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Slug', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Slug is the string used for URL. You can use a-z and 0-9. Default slug is "photo".', 'tcd-w' ); ?></p>
	<p><strong><?php _e( 'Existing posts will not be visible if you change the slug.', 'tcd-w' ); ?></strong></p>
	<input class="regular-text hankaku" type="text" name="dp_options[photo_slug]" value="<?php echo esc_attr( $dp_options['photo_slug'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Photo category label', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can change the name of Photo category as you like. Default category label is \"photo-category\".', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[photo_category_label]" value="<?php echo esc_attr( $dp_options['photo_category_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Slug', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Slug is the string used for URL. You can use a-z and 0-9. Default slug is "photo-category".', 'tcd-w' ); ?></p>
	<p><strong><?php _e( 'Existing category will not be visible if you change the slug.', 'tcd-w' ); ?></strong></p>
	<input class="regular-text hankaku" type="text" name="dp_options[photo_category_slug]" value="<?php echo esc_attr( $dp_options['photo_category_slug'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Headline for page header', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the title of page header in photo archive page.', 'tcd-w' ); ?></p>
	<input class="regular-text" name="dp_options[photo_header_headline]" type="text" value="<?php echo esc_attr( $dp_options['photo_header_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Description for page header', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the description of page header in photo archive page.', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="2" name="dp_options[photo_header_desc]"><?php echo esc_textarea( $dp_options['photo_header_desc'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // Photoページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Photo title / contents setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of photo title', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the single page title.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[photo_title_font_size]" value="<?php echo esc_attr( $dp_options['photo_title_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of photo title for mobile', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the single page title for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[photo_title_font_size_mobile]" value="<?php echo esc_attr( $dp_options['photo_title_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Post title color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font color of the single page title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[photo_title_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_title_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_title_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of photo contents', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the single page contents.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[photo_content_font_size]" value="<?php echo esc_attr( $dp_options['photo_content_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of photo contents for mobile', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the single page contents for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[photo_content_font_size_mobile]" value="<?php echo esc_attr( $dp_options['photo_content_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'photo contents color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font color of the single page contents.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[photo_content_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_content_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_content_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for archive page', 'tcd-w' ); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_breadcrumb_archive_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_breadcrumb_archive_photo'] ); ?>> <?php _e( 'Display breadcrumb', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_date_archive_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_date_archive_photo'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_category_archive_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_category_archive_photo'] ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_comments_number_archive_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_comments_number_archive_photo'] ); ?>> <?php _e( 'Display comments number', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_views_number_archive_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_views_number_archive_photo'] ); ?>> <?php _e( 'Display views number', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_likes_number_archive_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_likes_number_archive_photo'] ); ?>> <?php _e( 'Display likes number', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for single page', 'tcd-w' ); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_breadcrumb_single_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_breadcrumb_single_photo'] ); ?>> <?php _e( 'Display breadcrumb', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_date_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_date_photo'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_category_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_category_photo'] ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_views_number_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_views_number_photo'] ); ?>> <?php _e( 'Display views number', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_likes_number_photo]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_likes_number_photo'] ); ?>> <?php _e( 'Display likes number', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_author_sns_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_author_sns_photo'] ); ?>><?php _e( 'Display author\'s SNS buttons', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_report_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_report_photo'] ); ?>><?php _e( 'Display "Report to administrator"', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sns_btm_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_sns_btm_photo'] ); ?>><?php _e( 'Display SNS buttons to the article bottom', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_comment_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_comment_photo'] ); ?>><?php _e( 'Display comment', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_trackback_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_trackback_photo'] ); ?>><?php _e( 'Display trackbacks', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Author headline of single page', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[photo_author_headline]" value="<?php echo esc_attr( $dp_options['photo_author_headline'] ); ?>">
	<table>
		<tr>
			<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[photo_author_headline_font_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_author_headline_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_author_headline_font_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[photo_author_headline_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_author_headline_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_author_headline_bg_color'] ); ?>"></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Comment headline of single page', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[photo_comment_headline]" value="<?php echo esc_attr( $dp_options['photo_comment_headline'] ); ?>">
	<table>
		<tr>
			<td><label><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[photo_comment_headline_font_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_comment_headline_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_comment_headline_font_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[photo_comment_headline_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['photo_comment_headline_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['photo_comment_headline_bg_color'] ); ?>"></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Comment type', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can select comment type.', 'tcd-w' ); ?></p>
	<fieldset class="cf radio_images">
		<?php foreach ( $comment_type_options as $option ) : ?>
		<label>
			<input type="radio" name="dp_options[comment_type_photo]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['comment_type_photo'] ); ?>>
			<?php echo $option['label']; ?>
			<img src="<?php echo esc_attr( $option['image_photo'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>">
		</label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 広告の登録1 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>1</h3>
	<p><?php _e( 'This banner will be displayed under profile.', 'tcd-w' ); ?></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[photo_single_ad_code1]"><?php echo esc_textarea( $dp_options['photo_single_ad_code1'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually. If an advertisement code is entered in the above setting field, the following setting will be invalid.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js photo_single_ad_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['photo_single_ad_image1'] ); ?>" name="dp_options[photo_single_ad_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['photo_single_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['photo_single_ad_image1'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['photo_single_ad_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[photo_single_ad_url1]" value="<?php echo esc_attr( $dp_options['photo_single_ad_url1'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[photo_single_ad_code2]"><?php echo esc_textarea( $dp_options['photo_single_ad_code2'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js photo_single_ad_image2">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['photo_single_ad_image2'] ); ?>" name="dp_options[photo_single_ad_image2]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['photo_single_ad_image2'] ) { echo wp_get_attachment_image( $dp_options['photo_single_ad_image2'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['photo_single_ad_image2'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[photo_single_ad_url2]" value="<?php echo esc_attr( $dp_options['photo_single_ad_url2'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Mobile device banner setup', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<p><?php _e( 'This banner will be displayed on mobile device.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[photo_single_mobile_ad_code1]"><?php echo esc_textarea( $dp_options['photo_single_mobile_ad_code1'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' );?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js photo_single_mobile_ad_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['photo_single_mobile_ad_image1'] ); ?>" name="dp_options[photo_single_mobile_ad_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['photo_single_mobile_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['photo_single_mobile_ad_image1'], 'medium' ); } ?></div>
						<div class="buttton_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['photo_single_mobile_ad_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[photo_single_mobile_ad_url1]" value="<?php echo esc_attr( $dp_options['photo_single_mobile_ad_url1'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
</div><!-- END .theme_option_field -->
