<?php

/**
 * ログインフォーム
 */
function tcd_membership_login_form( $args = array() ) {
	global $dp_options, $tcd_membership_vars;

	$default_args = array(
		'echo' => true,
		'form_id' => 'loginform',
		'label_username' => __( 'Email Address', 'tcd-w' ),
		'label_password' => __( 'Password', 'tcd-w' ),
		'label_remember' => __( 'Remember Me', 'tcd-w' ),
		'label_log_in' => __( 'Login', 'tcd-w' ),
		'modal' => false,
		'redirect' => ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '',
		'remember' => true,
		'value_username' => '',
		'value_remember' => false,
	);
	$args = wp_parse_args( $args, apply_filters( 'login_form_default_args', $default_args ) );
	$args = apply_filters( 'tcd_membership_login_form_args', $args );

	// マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
	$ms_message = tcd_membership_multisite_other_site_logged_in_message();
	if ( $ms_message ) :
		$ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
		if ( $args['echo'] ) :
			echo $ms_message;
			return false;
		else :
			return $ms_message;
		endif;
	endif;

	if ( ! $args['echo'] ) :
		ob_start();
	endif;

	if ( ! $args['value_username'] && ! empty( $_COOKIE['tcd_login_email'] ) ) :
		$tcd_login_email = $_COOKIE['tcd_login_email'];
		// メールアドレスでなければ復号化
		if ( ! is_email( $tcd_login_email ) && function_exists( 'openssl_decrypt' ) && defined( 'NONCE_KEY' ) && NONCE_KEY ) :
			$tcd_login_email = openssl_decrypt( $tcd_login_email, 'AES-128-ECB', NONCE_KEY );
		endif;
		if ( $tcd_login_email && is_email( $tcd_login_email ) ) :
			$args['value_username'] = $tcd_login_email;
		endif;
	endif;
?>
			<form id="<?php echo esc_attr( $args['form_id'] ); ?>" class="p-membership-form p-membership-form--login<?php if ( ! $args['modal'] ) echo ' js-membership-form--normal'; ?>" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'login' ) ); ?>" method="post">
				<h2 class="p-member-page-headline"><?php _e( 'Login', 'tcd-w' ); ?></h2>
				<div class="p-membership-form__body p-body<?php if ( $args['modal'] ) echo ' p-modal__body'; ?>">
<?php
	if ( ! empty( $tcd_membership_vars['message'] ) ) :
?>
					<div class="p-membership-form__message"><?php echo wpautop( $tcd_membership_vars['message'] ); ?></div>
<?php
	endif;
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
					<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
	endif;

	echo apply_filters( 'login_form_top', '', $args );
?>
					<p class="p-membership-form__login-email"><input type="email" name="log" value="<?php echo esc_attr( isset( $_REQUEST['log'] ) ? $_REQUEST['log'] : $args['value_username'] ); ?>" placeholder="<?php echo esc_attr( $args['label_username'] ); ?>" required></p>
					<p class="p-membership-form__login-password"><input type="password" name="pwd" value="" placeholder="<?php echo esc_attr( $args['label_password'] ); ?>" required></p>
<?php
	echo apply_filters( 'login_form_middle', '', $args );
?>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button js-submit-button" type="submit"><?php echo esc_html( $args['label_log_in'] ); ?></button>
<?php
	if ( $args['redirect'] ) :
?>
						<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $args['redirect'] ); ?>">
<?php
	endif;
	if ( $args['modal'] ) :
?>
						<input type="hidden" name="ajax_login" value="1">
<?php
	endif;
?>
					</div>
<?php
	if ( $args['remember'] ) :
?>
					<p class="p-membership-form__login-remember"><label><input name="rememberme" type="checkbox" value="forever"<?php if ( $args['value_remember'] ) echo ' checked'; ?>><?php echo esc_html( $args['label_remember'] ); ?></label></p>
<?php
	endif;
?>
					<p class="p-membership-form__login-reset_password"><a href="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'reset_password' ) ); ?>"><?php esc_html_e( 'Lost your password?', 'tcd-w' ); ?></a></p>
<?php
	if ( $dp_options['membership']['login_form_desc'] ) :
		echo wpautop( $dp_options['membership']['login_form_desc'] );
	endif;

	echo apply_filters( 'login_form_bottom', '', $args );
?>
 				</div>
			</form>
<?php
	if ( tcd_membership_users_can_register() ) :
?>
			<div class="p-membership-form__login-registration">
<?php
		if ( $dp_options['membership']['login_registration_desc'] ) :
?>
				<div class="p-membership-form__body p-body<?php if ( $args['modal'] ) echo ' p-modal__body'; ?> p-membership-form__desc"><?php echo wpautop( $dp_options['membership']['login_registration_desc'] ); ?></div>
<?php
		endif;
?>
				<p class="p-membership-form__button">
					<a class="p-button p-rounded-button" href="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'registration' ) ); ?>"><?php echo esc_html( $dp_options['membership']['login_registration_button_label'] ? $dp_options['membership']['login_registration_button_label'] : __( 'Registration here.', 'tcd-w' ) ); ?></a>
				</p>
 			</div>
<?php
	endif;

	if ( ! $args['echo'] ) :
		return ob_get_clean();
	endif;
}

/**
 * 仮会員登録フォーム
 */
function tcd_membership_registration_form( $args = array() ) {
	global $dp_options, $tcd_membership_vars;

	$default_args = array(
		'echo' => true,
		'form_id' => 'js-registration-form',
		'label_email' => __( 'Email Address', 'tcd-w' ),
		'label_password' => __( 'Password', 'tcd-w' ),
		'label_password_confirm' => __( 'Password (confirm)', 'tcd-w' ),
		'modal' => false
	);
	$args = wp_parse_args( $args, apply_filters( 'login_form_default_args', $default_args ) );
	$args = apply_filters( 'tcd_membership_registration_form_args', $args );

	// マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
	$ms_message = tcd_membership_multisite_other_site_logged_in_message();
	if ( $ms_message ) :
		$ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
		if ( $args['echo'] ) :
			echo $ms_message;
			return false;
		else :
			return $ms_message;
		endif;
	endif;

	if ( ! $args['echo'] ) :
		ob_start();
	endif;
?>
			<form id="<?php echo esc_attr( $args['form_id'] ); ?>" class="p-membership-form p-membership-form--registration<?php if ( ! empty( $tcd_membership_vars['registration']['complete'] ) ) echo ' is-complete'; ?>" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'registration' ) ); ?>" method="post">
				<div class="p-membership-form__input">
					<h2 class="p-member-page-headline--color"><?php echo esc_html( $dp_options['membership']['registration_headline'] ? $dp_options['membership']['registration_headline'] : __( 'Registration', 'tcd-w' ) ); ?></h2>
					<div class="p-membership-form__body p-body<?php if ( $args['modal'] ) echo ' p-modal__body'; ?>">
<?php
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
						<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
	endif;
?>
						<p class="p-membership-form__registration-email"><input type="email" name="email" value="<?php echo esc_attr( isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : '' ); ?>" placeholder="<?php echo esc_attr( $args['label_email'] ); ?>" maxlength="100" required></p>
						<p class="p-membership-form__registration-password"><input type="password" name="pass1" value="" placeholder="<?php echo esc_attr( $args['label_password'] ); ?>" minlength="8" required></p>
						<p class="p-membership-form__registration-password"><input type="password" name="pass2" value="" placeholder="<?php echo esc_attr( $args['label_password_confirm'] ); ?>" minlength="8" required></p>
<?php
	if ( $dp_options['membership']['registration_desc'] ) :
?>
						<div class="p-membership-form__desc p-body"><?php echo wpautop( $dp_options['membership']['registration_desc'] ); ?></div>
<?php
	endif;
?>
						<div class="p-membership-form__button">
							<button class="p-button p-rounded-button js-submit-button" type="submit"><?php _e( 'Register', 'tcd-w' ); ?></button>
							<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-registration' ) ); ?>">
<?php
	if ( $args['modal'] ) :
?>
							<input type="hidden" name="ajax_registration" value="1">
<?php
	endif;
?>
						</div>
	 				</div>
 				</div>
				<div class="p-membership-form__complete">
					<h2 class="p-member-page-headline--color"><?php echo esc_html( $dp_options['membership']['registration_complete_headline'] ? $dp_options['membership']['registration_complete_headline'] : __( 'Registration complete', 'tcd-w' ) ); ?></h2>
<?php
	if ( $dp_options['membership']['registration_complete_desc'] ) :
		$registration_complete_desc = null;
		if ( ! empty( $tcd_membership_vars['registration']['complete_email'] ) ) :
			$registration_complete_desc = str_replace( '[user_email]', $tcd_membership_vars['registration']['complete_email'], $dp_options['membership']['registration_complete_desc'] );
		endif;
?>
					<div class="p-membership-form__body p-body<?php if ( $args['modal'] ) echo ' p-modal__body'; ?> p-membership-form__desc"><?php echo wpautop( $registration_complete_desc ); ?></div>
<?php
	endif;
?>
				</div>
			</form>
<?php
	if ( ! $args['echo'] ) :
		return ob_get_clean();
	endif;
}

/**
 * 本会員登録・アカウント作成フォーム
 */
function tcd_membership_registration_account_form( $args = array() ) {
	global $dp_options, $tcd_membership_vars, $gender_options, $receive_options, $notify_options;

	$default_args = array(
		'echo' => true,
		'form_id' => 'js-registration-account-form',
		'label_display_name' => __( 'Username', 'tcd-w' ),
		'label_email' => __( 'Email Address', 'tcd-w' ),
		'label_gender' => __( 'Gender', 'tcd-w' ),
		'label_birthday' => __( 'Birthday', 'tcd-w' ),
		'label_mail_magazine' => __( 'Mail magazine', 'tcd-w' ),
		'label_member_news_notify' => $dp_options['membership']['member_news_notify_label'],
		'label_social_notify' => $dp_options['membership']['social_notify_label'],
		'label_required' => __( ' (Requied)', 'tcd-w' )
	);
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'tcd_membership_registration_account_form_args', $args );

	// マルチサイトの他サイトにログイン中でこのサイトのアクセス権がない場合はメッセージ表示して終了
	$ms_message = tcd_membership_multisite_other_site_logged_in_message();
	if ( $ms_message ) :
		$ms_message = '<div class="p-body">' . $ms_message . '</div>' . "\n";
		if ( $args['echo'] ) :
			echo $ms_message;
			return false;
		else :
			return $ms_message;
		endif;
	endif;

	if ( ! $args['echo'] ) :
		ob_start();
	endif;

	// 正常トークンフラグがある場合はフォーム表示
	if ( ! empty( $tcd_membership_vars['registration_account']['valid_registration_token'] ) ) :
?>
			<form id="<?php echo esc_attr( $args['form_id'] ); ?>" class="p-membership-form p-membership-form--registration_account" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'registration_account' ) ); ?>" method="post">
				<div class="p-membership-form__input">
					<h2 class="p-member-page-headline--color"><?php echo esc_html( $dp_options['membership']['registration_account_headline'] ? $dp_options['membership']['registration_account_headline'] : __( 'Registration Account', 'tcd-w' ) ); ?></h2>
					<div class="p-membership-form__body p-body">
<?php
		if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
						<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
		endif;
?>
						<table class="p-membership-form__table">
							<tr>
								<th><label for="display_name"><?php echo esc_html( $args['label_display_name'] ); ?><span class="is-required"><?php echo esc_html( $args['label_required'] ); ?></span></label></th>
								<td><input type="text" name="display_name" value="<?php echo esc_attr( isset( $_REQUEST['display_name'] ) ? $_REQUEST['display_name'] : '' ); ?>" minlength="3" maxlength="50" required data-confirm-label="<?php echo esc_attr( $args['label_display_name'] ); ?>"></td>
							</tr>
<?php
		if ( $dp_options['membership']['show_account_area'] ) :
?>
							<tr>
								<th><label for="area"><?php echo esc_html( get_tcd_user_profile_area_label() ); ?><span class="is-required"><?php echo esc_html( $args['label_required'] ); ?></span></label></th>
								<td><?php echo get_tcd_user_profile_input_area( isset( $_REQUEST['area'] ) ? $_REQUEST['area'] : '', true, get_tcd_user_profile_area_label() ); ?></td>
							</tr>
<?php
		endif;
		if ( ! empty( $tcd_membership_vars['registration_account']['email'] ) ) :
?>
							<tr>
								<th><?php echo esc_html( $args['label_email'] ); ?></th>
								<td><input class="readonly-email" type="text" value="<?php echo esc_attr( $tcd_membership_vars['registration_account']['email'] ); ?>" readonly data-confirm-label="<?php echo esc_attr( $args['label_email'] ); ?>"></td>
							</tr>
<?php
		endif;
		if ( $dp_options['membership']['show_account_gender'] ) :
?>
							<tr>
								<th><label for="gender"><?php echo esc_html( $args['label_gender'] ); ?></label></th>
								<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'gender', $gender_options, isset( $_REQUEST['gender'] ) ? $_REQUEST['gender'] : 'man', 'man', $args['label_gender'] ); ?></td>
							</tr>
<?php
		endif;
		if ( $dp_options['membership']['show_account_birthday'] ) :
?>
							<tr>
								<th><label for="birthday"><?php echo esc_html( $args['label_birthday'] ); ?></label></th>
								<td class="p-membership-form__table-birthday"><?php echo get_tcd_user_profile_input_birthday( '_birthday', isset( $_REQUEST['_birthday'] ) ? $_REQUEST['_birthday'] : '', $args['label_birthday'] ); ?></td>
							</tr>
<?php
		endif;
		if ( $dp_options['membership']['use_mail_magazine'] ) :
?>
							<tr>
								<th><label for="mail_magazine"><?php echo esc_html( $args['label_mail_magazine'] ); ?></label></th>
								<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'mail_magazine', $receive_options, isset( $_REQUEST['mail_magazine'] ) ? $_REQUEST['mail_magazine'] : 'yes', 'yes', $args['label_mail_magazine'] ); ?></td>
							</tr>
<?php
		endif;
		if ( $dp_options['membership']['use_member_news_notify'] ) :
?>
							<tr>
								<th><label for="member_news_notify"><?php echo esc_html( $args['label_member_news_notify'] ); ?></label></th>
								<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'member_news_notify', $notify_options, isset( $_REQUEST['member_news_notify'] ) ? $_REQUEST['member_news_notify'] : 'yes', 'yes', $args['label_member_news_notify'] ); ?></td>
							</tr>
<?php
		endif;
		if ( $dp_options['membership']['use_social_notify'] ) :
?>
							<tr>
								<th><label for="social_notify"><?php echo esc_html( $args['label_social_notify'] ); ?></label></th>
								<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'social_notify', $notify_options, isset( $_REQUEST['social_notify'] ) ? $_REQUEST['social_notify'] : 'yes', 'yes', $args['label_social_notify'] ); ?></td>
							</tr>
<?php
		endif;

		echo apply_filters( 'tcd_membership_registration_account_form_table', '', $args );
?>
						</table>
<?php
		echo apply_filters( 'tcd_membership_registration_account_form', '', $args );

		if ( $dp_options['membership']['registration_account_desc'] ) :
?>
						<div class="p-membership-form__desc"><?php echo wpautop( $dp_options['membership']['registration_account_desc'] ); ?></div>
<?php
		endif;
?>
						<div class="p-membership-form__button">
							<button class="p-button p-rounded-button" type="submit"><?php _e( 'Next', 'tcd-w' ); ?></button>
							<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-registration_account' ) ); ?>">
<?php
		if ( ! empty( $tcd_membership_vars['registration_account']['registration_token'] ) ) :
?>
							<input type="hidden" name="token" value="<?php echo esc_attr( $tcd_membership_vars['registration_account']['registration_token'] ); ?>">
<?php
		endif;
?>
						</div>
	 				</div>
 				</div>
				<div class="p-membership-form__confirm">
					<h2 class="p-member-page-headline--color"><?php _e( 'Input contents confirmation', 'tcd-w' ); ?></h2>
					<div class="p-membership-form__body p-body"></div>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button js-submit-button"><?php echo _e( 'Register', 'tcd-w' ); ?></button>
						<button class="p-membership-form__back-button js-back-button"><?php _e( 'Back', 'tcd-w' ); ?></button>
					</div>
 				</div>
<?php
		if ( $dp_options['membership']['registration_account_complete_headline'] || $dp_options['membership']['registration_account_complete_desc'] ) :
?>
				<div class="p-membership-form__complete">
<?php
			if ( $dp_options['membership']['registration_account_complete_headline'] ) :
?>
					<h2 class="p-member-page-headline--color"><?php echo esc_html( $dp_options['membership']['registration_account_complete_headline'] ); ?></h2>
<?php
			endif;
			if ( $dp_options['membership']['registration_account_complete_desc'] ) :
?>
					<div class="p-membership-form__body p-body p-membership-form__desc"></div>
<?php
			endif;
?>
				</div>
<?php
		endif;
?>
			</form>
<?php
		if ( ! $args['echo'] ) :
			return ob_get_clean();
		endif;

	// 完了画面
	elseif ( ! empty( $tcd_membership_vars['registration_account']['complete'] ) ) :
?>
			<div class="p-membership-form__complete-static">
<?php
		if ( $dp_options['membership']['registration_account_complete_headline'] ) :
?>
				<h2 class="p-member-page-headline--color"><?php echo esc_html( $dp_options['membership']['registration_account_complete_headline'] ); ?></h2>
<?php
		endif;
		if ( $dp_options['membership']['registration_account_complete_desc'] ) :
			$registration_account_complete_desc = $dp_options['membership']['registration_account_complete_desc'];
			$registration_account_complete_desc = str_replace( '[user_email]', $tcd_membership_vars['registration_account']['user_email'], $registration_account_complete_desc );
			$registration_account_complete_desc = str_replace( '[user_display_name]', $tcd_membership_vars['registration_account']['user_display_name'], $registration_account_complete_desc );
			$registration_account_complete_desc = str_replace( '[user_name]', $tcd_membership_vars['registration_account']['user_display_name'], $registration_account_complete_desc );
			$registration_account_complete_desc = str_replace( '[login_url]', get_tcd_membership_memberpage_url( 'login' ), $registration_account_complete_desc );
			$registration_account_complete_desc = str_replace( '[login_button]', '<a class="p-button p-rounded-button" href="' . get_tcd_membership_memberpage_url( 'login' ) . '">' . __( 'Login', 'tcd-w' ) . '</a>', $registration_account_complete_desc );
?>
				<div class="p-membership-form__body p-body p-membership-form__desc"><?php echo wpautop( $registration_account_complete_desc ); ?></div>
<?php
		endif;
?>
			</div>
<?php

	// エラー画面
	elseif ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
			<div class="p-membership-form__body p-body">
				<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
			</div>
<?php
	endif;
}

/**
 * アカウント編集フォーム
 */
function tcd_membership_edit_account_form( $args = array() ) {
	global $dp_options, $tcd_membership_vars, $gender_options, $receive_options, $notify_options;

	$default_args = array(
		'echo' => true,
		'form_id' => 'js-edit-account-form',
		'label_display_name' => __( 'Username', 'tcd-w' ),
		'label_email' => __( 'Email Address', 'tcd-w' ),
		'label_gender' => __( 'Gender', 'tcd-w' ),
		'label_birthday' => __( 'Birthday', 'tcd-w' ),
		'label_mail_magazine' => __( 'Mail magazine', 'tcd-w' ),
		'label_member_news_notify' => $dp_options['membership']['member_news_notify_label'],
		'label_social_notify' => $dp_options['membership']['social_notify_label'],
		'label_required' => __( ' (Requied)', 'tcd-w' ),
	);
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'tcd_membership_edit_account_form_args', $args );

	$user = wp_get_current_user();

	if ( ! $args['echo'] ) :
		ob_start();
	endif;
?>
			<form id="<?php echo esc_attr( $args['form_id'] ); ?>" class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'edit_account' ) ); ?>" method="post">
				<h2 class="p-member-page-headline"><?php _e( 'Edit Account', 'tcd-w' ); ?></h2>
				<div class="p-membership-form__body p-body">
<?php
	if ( ! empty( $tcd_membership_vars['message'] ) ) :
?>
					<div class="p-membership-form__message"><?php echo wpautop( $tcd_membership_vars['message'] ); ?></div>
<?php
	endif;
?><?php
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
					<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
	endif;
?>
					<table class="p-membership-form__table">
						<tr>
							<th><label for="display_name"><?php echo esc_html( $args['label_display_name'] ); ?><span class="is-required"><?php echo esc_html( $args['label_required'] ); ?></span></label></th>
							<td><input type="text" name="display_name" value="<?php echo esc_attr( isset( $_REQUEST['display_name'] ) ? $_REQUEST['display_name'] : $user->display_name ); ?>" minlength="3" maxlength="50" required></td>
						</tr>
<?php
	if ( $dp_options['membership']['show_account_area'] ) :
?>
						<tr>
							<th><label for="area"><?php echo esc_html( get_tcd_user_profile_area_label() ); ?></label></th>
							<td><?php echo get_tcd_user_profile_input_area( isset( $_REQUEST['area'] ) ? $_REQUEST['area'] : $user->area, true ); ?></td>
						</tr>
<?php
	endif;
?>
						<tr>
							<th><label for="email"><?php echo esc_html( $args['label_email'] ); ?></label></th>
							<td><input type="email" id="email" name="email" value="<?php echo esc_attr( isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : $user->user_email ); ?>" maxlength="100"></td>
						</tr>
<?php
	if ( $dp_options['membership']['show_account_gender'] ) :
?>
						<tr>
							<th><label for="gender"><?php echo esc_html( $args['label_gender'] ); ?></label></th>
							<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'gender', $gender_options, isset( $_REQUEST['gender'] ) ? $_REQUEST['gender'] : $user->gender, 'man' ); ?></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_account_birthday'] ) :
?>
						<tr>
							<th><label for="birthday"><?php echo esc_html( $args['label_birthday'] ); ?></label></th>
							<td class="p-membership-form__table-birthday"><?php echo get_tcd_user_profile_input_birthday( '_birthday', isset( $_REQUEST['_birthday'] ) ? $_REQUEST['_birthday'] : $user->_birthday ); ?></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['use_mail_magazine'] ) :
?>
						<tr>
							<th><label for="mail_magazine"><?php echo esc_html( $args['label_mail_magazine'] ); ?></label></th>
							<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'mail_magazine', $receive_options, isset( $_REQUEST['mail_magazine'] ) ? $_REQUEST['mail_magazine'] : $user->mail_magazine, 'yes' ); ?></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['use_member_news_notify'] ) :
?>
						<tr>
							<th><label for="member_news_notify"><?php echo esc_html( $args['label_member_news_notify'] ); ?></label></th>
							<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'member_news_notify', $notify_options, isset( $_REQUEST['member_news_notify'] ) ? $_REQUEST['member_news_notify'] : $user->member_news_notify, 'yes' ); ?></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['use_social_notify'] ) :
?>
						<tr>
							<th><label for="social_notify"><?php echo esc_html( $args['label_social_notify'] ); ?></label></th>
							<td class="p-membership-form__table-radios"><?php echo get_tcd_user_profile_input_radio( 'social_notify', $notify_options, isset( $_REQUEST['social_notify'] ) ? $_REQUEST['social_notify'] : $user->social_notify, 'yes' ); ?></td>
						</tr>
<?php
	endif;

	echo apply_filters( 'tcd_membership_edit_account_form_table', '', $args );
?>
					</table>
<?php
	echo apply_filters( 'tcd_membership_edit_account_form', '', $args );
?>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Save', 'tcd-w' ); ?></button>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-edit_account' ) ); ?>">
					</div>
 				</div>
			</form>
<?php
	if ( ! $args['echo'] ) :
		return ob_get_clean();
	endif;
}

/**
 * プロフィール編集フォーム
 */
function tcd_membership_edit_profile_form( $args = array() ) {
	global $dp_options, $tcd_membership_vars;

	$default_args = array(
		'echo' => true,
		'form_id' => 'js-edit-profile-form',
		'label_display_name' => __( 'Username', 'tcd-w' ),
		'label_job' => __( 'Job', 'tcd-w' ),
		'label_description' => __( 'Biography', 'tcd-w' ),
		'label_website' => __( 'Website', 'tcd-w' ),
		'label_facebook' => __( 'Facebook', 'tcd-w' ),
		'label_twitter' => __( 'Twitter', 'tcd-w' ),
		'label_instagram' => __( 'Instagram', 'tcd-w' )
	);
	$args = wp_parse_args( $args, $default_args );
	$args = apply_filters( 'tcd_membership_edit_profile_form_args', $args );

	$user = wp_get_current_user();

	if ( ! $args['echo'] ) :
		ob_start();
	endif;
?>
			<form id="<?php echo esc_attr( $args['form_id'] ); ?>" class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'edit_profile' ) ); ?>" enctype="multipart/form-data" method="post">
				<div class="p-membership-form__body p-body">
<?php
	if ( ! empty( $tcd_membership_vars['message'] ) ) :
?>
					<div class="p-membership-form__message"><?php echo wpautop( $tcd_membership_vars['message'] ); ?></div>
<?php
	endif;
?>
<?php
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
					<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
	endif;
?>
					<div class="p-edit-profile__image-upload">
						<div class="p-edit-profile__image-upload__header_image">
							<h2 class="p-member-page-headline"><?php _e( 'Header image', 'tcd-w' ); ?></h2>
<?php
	tcd_membership_image_upload_field( array(
		'drop_attribute' => ' data-max-width="1920" data-max-height="500" data-max-crop="1"',
		'indent' => 7,
		'input_name' => 'header_image',
		'overlay_desc' => __( 'It will be the image to be displayed in the header of the profile page.', 'tcd-w' ),
		'image_url' => $user->header_image
	) );
?>
							<p class="p-membership-form__remark"><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 1450, 500 ); ?><br><?php _e( '* Please select a local photo file, or drag and drop.', 'tcd-w' ); ?></p>
						</div>
						<div class="p-edit-profile__image-upload__profile_image">
							<h2 class="p-member-page-headline"><?php _e( 'Profile image', 'tcd-w' ); ?></h2>
<?php
	tcd_membership_image_upload_field( array(
		'drop_attribute' => ' data-max-width="300" data-max-height="300" data-max-crop="1"',
		'echo' => true,
		'indent' => 7,
		'input_name' => 'profile_image',
		'image_url' => $user->profile_image,
		'show_delete_button' => false
	) );
?>
							<p class="p-membership-form__remark"><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 200, 200 ); ?><br><?php _e( '* Please select a local photo file, or drag and drop.', 'tcd-w' ); ?></p>
						</div>
					</div>
					<h2 class="p-member-page-headline"><?php _e( 'Edit Profile', 'tcd-w' ); ?></h2>
					<table class="p-membership-form__table">
						<tr>
							<th><label for="display_name"><?php echo esc_html( $args['label_display_name'] ); ?></label></th>
							<td><input type="text" name="display_name" value="<?php echo esc_attr( isset( $_REQUEST['display_name'] ) ? $_REQUEST['display_name'] : $user->display_name ); ?>" minlength="3" maxlength="50" required></td>
						</tr>
<?php
	if ( $dp_options['membership']['show_profile_area'] ) :
?>
						<tr>
							<th><label for="area"><?php echo esc_html( get_tcd_user_profile_area_label() ); ?></label></th>
							<td><?php echo get_tcd_user_profile_input_area( isset( $_REQUEST['area'] ) ? $_REQUEST['area'] : $user->area, true ); ?></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_job'] ) :
?>
						<tr>
							<th><label for="job"><?php echo esc_html( $args['label_job'] ); ?></label></th>
							<td><input type="text" name="job" value="<?php echo esc_attr( isset( $_REQUEST['job'] ) ? $_REQUEST['job'] : $user->job ); ?>"></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_desc'] ) :
?>
						<tr>
							<th><label for="description"><?php echo esc_html( $args['label_description'] ); ?></label></th>
							<td><textarea name="description" rows="10"><?php echo esc_textarea( isset( $_REQUEST['description'] ) ? $_REQUEST['description'] : $user->description ); ?></textarea></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_website'] ) :
?>
						<tr>
							<th><label for="user_url"><?php echo esc_html( $args['label_website'] ); ?></label></th>
							<td><input type="url" name="user_url" value="<?php echo esc_attr( isset( $_REQUEST['user_url'] ) ? $_REQUEST['user_url'] : $user->user_url ); ?>"></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_facebook'] ) :
?>
						<tr>
							<th><label for="facebook_url"><?php echo esc_html( $args['label_facebook'] ); ?></label></th>
							<td><input type="url" name="facebook_url" value="<?php echo esc_attr( isset( $_REQUEST['facebook_url'] ) ? $_REQUEST['facebook_url'] : $user->facebook_url ); ?>"></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_twitter'] ) :
?>
						<tr>
							<th><label for="twitter_url"><?php echo esc_html( $args['label_twitter'] ); ?></label></th>
							<td><input type="url" name="twitter_url" value="<?php echo esc_attr( isset( $_REQUEST['twitter_url'] ) ? $_REQUEST['twitter_url'] : $user->twitter_url ); ?>"></td>
						</tr>
<?php
	endif;
	if ( $dp_options['membership']['show_profile_instagram'] ) :
?>
						<tr>
							<th><label for="instagram_url"><?php echo esc_html( $args['label_instagram'] ); ?></label></th>
							<td><input type="url" name="instagram_url" value="<?php echo esc_attr( isset( $_REQUEST['instagram_url'] ) ? $_REQUEST['instagram_url'] : $user->instagram_url ); ?>"></td>
						</tr>
<?php
	endif;

	echo apply_filters( 'tcd_membership_edit_profile_form_table', '', $args );
?>
					</table>
<?php
	echo apply_filters( 'tcd_membership_edit_profile_form', '', $args );
?>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Save', 'tcd-w' ); ?></button>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-edit_profile' ) ); ?>">
					</div>
 				</div>
			</form>
<?php
	if ( ! $args['echo'] ) :
		return ob_get_clean();
	endif;
}
