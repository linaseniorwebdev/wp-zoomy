<?php
global $dp_options, $dp_default_options, $guest_permission_options, $guest_permission_options2, $loggedin_footer_bar_display_options;
?>
<div class="theme_option_message" style="margin-top: 0;">
    <p><?php _e( 'Setting the membership system necessary for running membership site.', 'tcd-w' ); ?></p>
</div>
<?php // 基本設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Membership basic settings', 'tcd-w' ); ?></h3>
	<ul>
		<li><label><input name="dp_options[membership][use_follow]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_follow'] ); ?>><?php _e( 'Use "follow"', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][use_mail_magazine]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_mail_magazine'] ); ?>><?php _e( 'Use "Mail Magazine"', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][disable_wp_login_php]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['disable_wp_login_php'] ); ?>><?php _e( 'Disable "wp-login.php"', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Frontend member registration', 'tcd-w' ); ?></h4>
	<p><label><input name="dp_options[membership][users_can_register]" type="checkbox" value="1" <?php checked( 1, is_multisite() ? $dp_options['membership']['users_can_register'] : get_option( 'users_can_register' ) ); ?>><?php _e( 'Frontend registration available', 'tcd-w' ); ?></label></p>
<?php
if ( is_multisite() ) :
?>
	<p class="description"><?php printf( __( 'In multisite, it is influenced by multisite "Allow new registrations" setting. (Current setting: %s)', 'tcd-w' ), get_option( 'users_can_register' ) ? __( 'Registration avalable', 'tcd-w' ) : __( 'Registration disabled', 'tcd-w' ) ); ?></p>
<?php
else :
?>
	<p class="description"><?php _e( 'This setting change the "Anyone can register" setting in <a href="options-general.php" target="_blank">WordPress General Settings</a>.', 'tcd-w' ); ?></p>
<?php
endif;
?>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // お知らせ設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Information settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Guest permission settings', 'tcd-w' ); ?></h3>
	<fieldset class="radios">
		<?php foreach ( $guest_permission_options2 as $option ) : ?>
		<label><input type="radio" name="dp_options[membership][guest_permission_information]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['membership']['guest_permission_information'] ); ?>><?php printf( $option['label'], __( 'Information', 'tcd-w' ) ); ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // プロフィール設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Profile settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Guest permission settings', 'tcd-w' ); ?></h3>
	<fieldset class="radios">
		<?php foreach ( $guest_permission_options as $option ) : ?>
		<label><input type="radio" name="dp_options[membership][guest_permission_profile]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['membership']['guest_permission_profile'] ); ?>><?php printf( $option['label'], __( 'Profile', 'tcd-w' ), __( 'Profile', 'tcd-w' ) ); ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 報告する設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Report settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Report label', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][report_label]" value="<?php echo esc_attr( $dp_options['membership']['report_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Report description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="2" name="dp_options[membership][report_desc]"><?php echo esc_textarea( $dp_options['membership']['report_desc'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Report button label', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][report_button_label]" value="<?php echo esc_attr( $dp_options['membership']['report_button_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Report complete headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][report_complete_headline]" value="<?php echo esc_attr( $dp_options['membership']['report_complete_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Report complete description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="2" name="dp_options[membership][report_complete_desc]"><?php echo esc_textarea( $dp_options['membership']['report_complete_desc'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // Forbidden words ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Forbidden words settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'You can reject if forbidden words in the Username / Title / Text etc. at frontend post without comments.', 'tcd-w' ); ?><br><?php _e( 'Please use "Comment Moderation" or "Comment Blacklist" settings in <a href="options-discussion.php" target="_blank">Discussion Settings</a> for comments.', 'tcd-w' ); ?></p>
	<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][forbidden_words]"><?php echo esc_textarea( $dp_options['membership']['forbidden_words'] ); ?></textarea>
	<p class="description"><?php _e( 'Please enter One option per line.', 'tcd-w' ); ?></p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // logged-in footer bar ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Setting of the logged-in footer bar for smart phone', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the logged-in footer bar which is displayed with smart phone.', 'tcd-w' ); ?>
	<h4 class="theme_option_headline2"><?php _e( 'Display type of the logged-in footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please select how to display the logged-in footer bar. When you scroll a page by a certain amount, the logged-in footer bar is displayed with the selected animation. If you do not use the logged-in footer bar, please check "Display normal footer bar".', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $loggedin_footer_bar_display_options as $option ) : ?>
		<label><input type="radio" name="dp_options[membership][loggedin_footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['membership']['loggedin_footer_bar_display'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the appearance of the logged-in footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the color and transparency of the logged-in footer bar.', 'tcd-w' ); ?></p>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[membership][loggedin_footer_bar_bg]" type="text" value="<?php echo esc_attr( $dp_options['membership']['loggedin_footer_bar_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membership']['loggedin_footer_bar_bg'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Border color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[membership][loggedin_footer_bar_border]" type="text" value="<?php echo esc_attr( $dp_options['membership']['loggedin_footer_bar_border'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membership']['loggedin_footer_bar_border'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[membership][loggedin_footer_bar_color]" type="text" value="<?php echo esc_attr( $dp_options['membership']['loggedin_footer_bar_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membership']['loggedin_footer_bar_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Opacity of background', 'tcd-w' ); ?></td>
			<td><input type="number" class="small-text" name="dp_options[membership][loggedin_footer_bar_tp]" value="<?php echo esc_attr( $dp_options['membership']['loggedin_footer_bar_tp'] ); ?>" min="0" max="1" step="0.1"></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
