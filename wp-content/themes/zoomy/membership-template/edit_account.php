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
		<div class="p-member-page p-edit-account">
<?php
tcd_membership_edit_account_form();
?>
			<div class="p-edit-account__bottom">
				<h2 class="p-member-page-headline"><?php _e( 'Change Password, Delete Account', 'tcd-w' ); ?></h2>
				<div class="p-membership-form__body p-body">
					<p><a href="<?php echo esc_html( get_tcd_membership_memberpage_url( 'change_password' ) ); ?>"><?php _e( 'Change password', 'tcd-w' ); ?></a></p>
					<p><a href="<?php echo esc_html( get_tcd_membership_memberpage_url( 'delete_account' ) ); ?>"><?php _e( 'Delete account', 'tcd-w' ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
