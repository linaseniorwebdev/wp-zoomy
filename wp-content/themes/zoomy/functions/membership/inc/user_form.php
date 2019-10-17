<?php
global $dp_options;
?>
<div class="theme_option_message" style="margin-top: 0;">
    <p><?php _e( 'Front-end User Registration', 'tcd-w' ); ?></p>
    <p><?php _e( '1.Click “Join”, then enter their email address and password. 2.Click “Register”.  So your website will then ask them confirm their email. 3.Check their email for the confirmation, and click on the link in the email from your website. 4.Complete the form by entering the username, Area, and others. 5.New account is made!', 'tcd-w' ); ?></p>
    <p><?php _e( 'The Username will use as the display name, nickname, and the URL of each of author page. When you log into the WordPress, please use the mail address as username of WordPress.', 'tcd-w' ); ?></p>
    <p><?php _e( 'If you try to select a username and see that it has already been claimed, you will need to select a different one.', 'tcd-w' ); ?></p>
	<p><?php _e( 'Frontend registered member is set the "Contributor" User Role. Ignore the setting of "New User Default Role" setting in <a href="options-general.php" target="_blank">WordPress General Settings</a>.', 'tcd-w' ); ?></p>
	<p><?php _e( '"Contributor" and "Subscriber" User Role can not access the <a href="index.php" target="_blank">WordPress backend</a>.', 'tcd-w' ); ?></p>
</div>
<?php // ログインフォーム設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Login form settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Description below login form', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the description displayed under the login button.', 'tcd-w' ); ?></p>   
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][login_form_desc]"><?php echo esc_textarea( $dp_options['membership']['login_form_desc'] ); ?></textarea>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 仮登録設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Registration settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Registration title', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the contents to display the temporary member registration form.', 'tcd-w' ); ?></p>  
	<input class="regular-text" type="text" name="dp_options[membership][registration_headline]" value="<?php echo esc_attr( $dp_options['membership']['registration_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Registration description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][registration_desc]"><?php echo esc_textarea( $dp_options['membership']['registration_desc'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Registration Complete title', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][registration_complete_headline]" value="<?php echo esc_attr( $dp_options['membership']['registration_complete_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Registration Complete description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][registration_complete_desc]"><?php echo esc_textarea( $dp_options['membership']['registration_complete_desc'] ); ?></textarea>
	<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [user_email]</p>
	<h4 class="theme_option_headline2"><?php _e( 'Registration description below login form', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][login_registration_desc]"><?php echo esc_textarea( $dp_options['membership']['login_registration_desc'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Registration button label below login form', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][login_registration_button_label]" value="<?php echo esc_attr( $dp_options['membership']['login_registration_button_label'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // アカウント設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Account settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Registration Account title', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the contents to display the member registration form and form item to be used.', 'tcd-w' ); ?></p>  
	<input class="regular-text" type="text" name="dp_options[membership][registration_account_headline]" value="<?php echo esc_attr( $dp_options['membership']['registration_account_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Registration Account description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][registration_account_desc]"><?php echo esc_textarea( $dp_options['membership']['registration_account_desc'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Registration Account Complete title', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][registration_account_complete_headline]" value="<?php echo esc_attr( $dp_options['membership']['registration_account_complete_headline'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Registration Account Complete description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][registration_account_complete_desc]"><?php echo esc_textarea( $dp_options['membership']['registration_account_complete_desc'] ); ?></textarea>
	<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [user_email], [user_display_name], [login_url], [login_button]</p>
	<p><?php _e( 'If both "Registration Account Complete title" and "Registration Account Complete description" are empty, displayed the login form.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Display fields settings', 'tcd-w' ); ?></h4>
	<ul>
		<li><label><input name="dp_options[membership][show_account_area]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_account_area'] ); ?>><?php _e( 'Show area field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_account_gender]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_account_gender'] ); ?>><?php _e( 'Show gender field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_account_birthday]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_account_birthday'] ); ?>><?php _e( 'Show birthday field', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // プロフィールフォーム設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Profile settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Display fields settings', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set form items to be used in the member profile.', 'tcd-w' ); ?></p>
	<ul>
		<li><label><input name="dp_options[membership][show_profile_area]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_area'] ); ?>><?php _e( 'Show area field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_job]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_job'] ); ?>><?php _e( 'Show job field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_desc]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_desc'] ); ?>><?php _e( 'Show description field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_website]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_website'] ); ?>><?php _e( 'Show website field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_twitter]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_twitter'] ); ?>><?php _e( 'Show twitter field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_instagram]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_instagram'] ); ?>><?php _e( 'Show instagram field', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][show_profile_facebook]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['show_profile_facebook'] ); ?>><?php _e( 'Show facebook field', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // エリア設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Residence area settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Residence area label', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Set the label and item of the area field.', 'tcd-w' ); ?></p>
	<input class="regular-text" type="text" name="dp_options[membership][area_label]" value="<?php echo esc_attr( $dp_options['membership']['area_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Residence area select options', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][area]"><?php echo esc_textarea( $dp_options['membership']['area'] ); ?></textarea>
	<p class="description"><?php _e( 'Please enter One option per line.', 'tcd-w' ); ?></p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
