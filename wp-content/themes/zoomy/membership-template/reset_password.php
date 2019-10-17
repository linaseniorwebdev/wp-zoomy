<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<main class="l-main has-bg--pc">
<?php
if ( current_user_can( 'read' ) ) :
?>
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( 'account' ) ); ?></h1>
		</div>
	</div>
<?php
endif;

// 完了画面
if ( ! empty( $tcd_membership_vars['complete'] ) && ! empty( $tcd_membership_vars['message'] ) ) :
?>
	<div class="l-inner">
		<div class="p-member-page p-reset-password">
			<div class="p-membership-form__complete-static">
				<h2 class="p-member-page-headline"><?php echo esc_html( $tcd_membership_vars['message'] ); ?></h2>
			</div>
		</div>
	</div>
<?php
// フォーム表示
else :
?>
	<div class="l-inner">
		<div class="p-member-page p-reset-password">
			<form class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'reset_password' ) ); ?>" method="post">
				<h2 class="p-member-page-headline"><?php echo esc_html( get_tcd_membership_memberpage_title( 'reset_password' ) ); ?></h2>
				<div class="p-membership-form__body p-body">
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

	// 新しいパスワード入力フォーム表示
	if ( ! empty( $tcd_membership_vars['reset_password']['token'] ) ) :
?>
					<table class="p-membership-form__table">
						<tr>
							<th><label for="new_pass1"><?php _e( 'New Password', 'tcd-w' ); ?></label></th>
							<td><input type="password" id="new_pass1" name="new_pass1" value="" minlength="8" required></td>
						</tr>
						<tr>
							<th><label for="new_pass2"><?php _e( 'New Password (confirm)', 'tcd-w' ); ?></label></th>
							<td><input type="password" id="new_pass2" name="new_pass2" value="" minlength="8" required></td>
						</tr>
					</table>
					<p><?php _e( 'Please enter a registerd email address.<br>Will send you a reset password email to the entered email address.', 'tcd-w' ); ?></p>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Set new password', 'tcd-w' ); ?></button>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-reset_password' ) ); ?>">
						<input type="hidden" name="token" value="<?php echo esc_attr( $tcd_membership_vars['reset_password']['token'] ); ?>">
					</div>
<?php
	// メールアドレス入力フォーム表示
	else :
?>
					<table class="p-membership-form__table">
						<tr>
							<th><label for="email"><?php _e( 'Email Address', 'tcd-w' ); ?></label></th>
							<td><input type="email" id="email" name="email" value="<?php echo esc_attr( isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : '' ); ?>" required></td>
						</tr>
					</table>
					<p><?php _e( 'Please enter a registerd email address.<br>Will send you a reset password email to the entered email address.', 'tcd-w' ); ?></p>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Reset Password', 'tcd-w' ); ?></button>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-reset_password' ) ); ?>">
					</div>
<?php
	endif;
?>
 				</div>
			</form>
		</div>
	</div>
<?php
endif;
?>
</main>
<?php
get_footer();
