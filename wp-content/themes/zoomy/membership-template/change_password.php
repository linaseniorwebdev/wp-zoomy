<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<main class="l-main has-bg--pc">
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( 'account' ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-change-password">
			<form class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'change_password' ) ); ?>" method="post">
				<h2 class="p-member-page-headline"><?php echo esc_html( get_tcd_membership_memberpage_title( 'change_password' ) ); ?></h2>
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
?>
					<table class="p-membership-form__table">
						<tr>
							<th><label for="current_pass"><?php _e( 'Current Password', 'tcd-w' ); ?></label></th>
							<td><input type="password" id="current_pass" name="current_pass" value="" minlength="8" required></td>
						</tr>
						<tr>
							<th><label for="new_pass1"><?php _e( 'New Password', 'tcd-w' ); ?></label></th>
							<td><input type="password" id="new_pass1" name="new_pass1" value="" minlength="8" required></td>
						</tr>
						<tr>
							<th><label for="new_pass2"><?php _e( 'New Password (confirm)', 'tcd-w' ); ?></label></th>
							<td><input type="password" id="new_pass2" name="new_pass2" value="" minlength="8" required></td>
						</tr>
					</table>
					<div class="p-membership-form__button">
						<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Set new password', 'tcd-w' ); ?></button>
						<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-change_password' ) ); ?>">
					</div>
					<p class="p-membership-form__reset_password"><a href="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'reset_password' ) ); ?>"><?php esc_html_e( 'Lost your password?', 'tcd-w' ); ?></a></p>
 				</div>
			</form>
		</div>
	</div>
</main>
<?php
get_footer();
