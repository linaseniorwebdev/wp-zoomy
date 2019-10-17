<?php
global $dp_options;

// 未読通知から新着通知への仕様変更での変数名置換
if ( false !== strpos( $dp_options['membership']['mail_member_news_notify_subject'], '[unread_count]' ) ||  false !== strpos( $dp_options['membership']['mail_member_news_notify_body'], '[unread_count]' ) ) {
	$dp_options['membership']['mail_member_news_notify_subject'] = str_replace( '[unread_count]', '[news_count]', $dp_options['membership']['mail_member_news_notify_subject'] );
	$dp_options['membership']['mail_member_news_notify_body'] = str_replace( '[unread_count]', '[news_count]', $dp_options['membership']['mail_member_news_notify_body'] );
}

if ( false !== strpos( $dp_options['membership']['mail_social_notify_subject'], 'unread_' ) ||  false !== strpos( $dp_options['membership']['mail_social_notify_body'], 'unread_' ) ) {
	foreach ( array(
		'[unread_count]' => '[total_count]',
		'[unread_likes_count]' => '[likes_count]',
		'[unread_comments_count]' => '[comments_count]',
		'[unread_follows_count]' => '[follows_count]',
		'[has_unread_likes]' => '[has_likes_count]',
		'[/has_unread_likes]' => '[/has_likes_count]',
		'[has_unread_comments]' => '[has_comments_count]',
		'[/has_unread_comments]' => '[/has_comments_count]',
		'[has_unread_follows]' => '[has_follows_count]',
		'[/has_unread_follows]' => '[/has_follows_count]'
	) as $search => $replace ) {
		$dp_options['membership']['mail_social_notify_subject'] = str_replace( $search, $replace, $dp_options['membership']['mail_social_notify_subject'] );
		$dp_options['membership']['mail_social_notify_body'] = str_replace( $search, $replace, $dp_options['membership']['mail_social_notify_body'] );
	}
}
?>
<?php // メール設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mail settings', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Set up automatic reply mail and notification mail.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'From email', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="email" name="dp_options[membership][mail_from_email]" value="<?php echo esc_attr( $dp_options['membership']['mail_from_email'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'From name', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mail_from_name]" value="<?php echo esc_attr( $dp_options['membership']['mail_from_name'] ); ?>">
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Registration mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Registration mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_registration_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_registration_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Registration mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_registration_body]"><?php echo esc_textarea( $dp_options['membership']['mail_registration_body'] ); ?></textarea>
				<p class="description">
					<?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_email], [registration_account_url]
					<br><?php _e( '[registration_account_url] will expire in 24 hours.', 'tcd-w' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Registration Account mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Registration Account mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_registration_account_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_registration_account_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Registration Account mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_registration_account_body]"><?php echo esc_textarea( $dp_options['membership']['mail_registration_account_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [author_url], [login_url], [reset_password_url]</p>
				<h4 class="theme_option_headline2"><?php _e( 'Destination email for Registration admin notify', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_registration_account_admin_to]" value="<?php echo esc_attr( $dp_options['membership']['mail_registration_account_admin_to'] ); ?>">
				<p class="description"><?php _e( 'If empty, do not send admin notify.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Registration Account mail subject for admin notify', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_registration_account_admin_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_registration_account_admin_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Registration Account mail message for admin notify', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_registration_account_admin_body]"><?php echo esc_textarea( $dp_options['membership']['mail_registration_account_admin_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [author_url], [login_url], [reset_password_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Reset Password mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Reset Password mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_reset_password_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_reset_password_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Reset Password mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_reset_password_body]"><?php echo esc_textarea( $dp_options['membership']['mail_reset_password_body'] ); ?></textarea>
				<p class="description">
					<?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [reset_password_url]
					<br><?php _e( '[reset_password_url] will expire in 24 hours.', 'tcd-w' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Withdraw mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Withdraw mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_withdraw_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_withdraw_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Withdraw mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_withdraw_body]"><?php echo esc_textarea( $dp_options['membership']['mail_withdraw_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email]</p>
				<h4 class="theme_option_headline2"><?php _e( 'Destination email for Withdraw admin notify', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_withdraw_admin_to]" value="<?php echo esc_attr( $dp_options['membership']['mail_withdraw_admin_to'] ); ?>">
				<p class="description"><?php _e( 'If empty, do not send admin notify.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Withdraw mail subject for admin notify', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_withdraw_admin_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_withdraw_admin_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Withdraw mail message for admin notify', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_withdraw_admin_body]"><?php echo esc_textarea( $dp_options['membership']['mail_withdraw_admin_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Report mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Destination email', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_report_to]" value="<?php echo esc_attr( $dp_options['membership']['mail_report_to'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Report mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_report_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_report_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Report mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_report_body]"><?php echo esc_textarea( $dp_options['membership']['mail_report_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [post_id], [post_url], [post_type], [post_type_label], [report_comment]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Member News Notify mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Member News Notify mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_member_news_notify_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_member_news_notify_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Member News Notify mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_member_news_notify_body]"><?php echo esc_textarea( $dp_options['membership']['mail_member_news_notify_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [mypage_news_url], [news_count]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Social Notify mail', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Social Notify mail subject', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mail_social_notify_subject]" value="<?php echo esc_attr( $dp_options['membership']['mail_social_notify_subject'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Social Notify mail message', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mail_social_notify_body]"><?php echo esc_textarea( $dp_options['membership']['mail_social_notify_body'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [blog_name], [blog_url], [user_display_name], [user_email], [mypage_news_url], [total_count], [likes_count], [comments_count], [follows_count], [has_likes_count][/has_likes_count], [has_comments_count][/has_comments_count], [has_follows_count][/has_follows_count]
				<br><?php printf( __( 'If %s is not empty, %s inner text is displayed.', 'tcd-w' ), '[likes_count]', '[has_likes_count][/has_likes_count]' ) ; ?>
				<br><?php printf( __( 'If %s is not empty, %s inner text is displayed.', 'tcd-w' ), '[comments_count]', '[has_comments_count][/has_comments_count]' ) ; ?>
				<br><?php printf( __( 'If %s is not empty, %s inner text is displayed.', 'tcd-w' ), '[follows_count]', '[has_follows_count][/has_follows_count]' ) ; ?></p>
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
