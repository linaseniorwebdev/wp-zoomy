<?php
global $dp_options, $dp_default_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // お知らせの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Information page basic setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Breadcrumb label', 'tcd-w' ); ?></h4>
	<p><?php _e( 'The breadcrumb is displayed at information archive and information single page. You can change name of page as you like.(default: Information)', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[information_label]" value="<?php echo esc_attr( $dp_options['information_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Slug', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Slug is the string used for URL. You can use a-z and 0-9. Default slug is "information".', 'tcd-w' ); ?></p>
	<p><strong><?php _e( 'Existing posts will not be visible if you change the slug.', 'tcd-w' ); ?></strong></p>
	<input class="regular-text hankaku" type="text" name="dp_options[information_slug]" value="<?php echo esc_attr( $dp_options['information_slug'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Headline for page header', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the title of page header in information archive and information single page.', 'tcd-w' ); ?></p>
	<input class="regular-text" name="dp_options[information_header_headline]" type="text" value="<?php echo esc_attr( $dp_options['information_header_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Description for page header', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the description of page header in information archive and information single page.', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="2" name="dp_options[information_header_desc]"><?php echo esc_textarea( $dp_options['information_header_desc'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // お知らせページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Information contents setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of information contents', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the information contents.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[information_content_font_size]" value="<?php echo esc_attr( $dp_options['information_content_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of information contents for mobile', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font size of the information contents for mobile.', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[information_content_font_size_mobile]" value="<?php echo esc_attr( $dp_options['information_content_font_size_mobile'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Information contents color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the font color of the information contents.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[information_content_color]" type="text" value="<?php echo esc_attr( $dp_options['information_content_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['information_content_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Archive post number', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the number of posts to be displayed in archive page. ', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[archive_information_num]" value="<?php echo esc_attr( $dp_options['archive_information_num'] ); ?>" min="1">
	<h4 class="theme_option_headline2"><?php _e( 'Settings for archive page', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
	<ul>
		<li><label><input name="dp_options[show_breadcrumb_archive_information]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_breadcrumb_archive_information'] ); ?>> <?php _e( 'Display breadcrumb', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_date_information]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_date_information'] ); ?>> <?php _e( 'Display date', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
