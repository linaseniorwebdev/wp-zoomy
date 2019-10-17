<?php
global $dp_options, $tcd_membership_vars;

get_header();

$user = wp_get_current_user();
?>
<main class="l-main has-bg--pc">
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( 'account' ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-delete-account">
			<form id="js-membership-delete-account" class="p-membership-form js-delete-confirm" action="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'delete_account' ) ); ?>" method="post">
				<h2 class="p-member-page-headline"><?php echo esc_html( get_tcd_membership_memberpage_title( 'delete_account' ) ); ?></h2>
				<div class="p-membership-form__body p-body">
<?php
if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
					<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
endif;
?>
					<p><?php _e( 'When you delete an account, All data such as posted photos, blogs, comments etc will be deleted.<br>Deleted account can not be restored.', 'tcd-w' ); ?></p>
				</div>
				<div class="p-delete-account__author p-author">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( get_author_posts_url( $user->ID ) ); ?>" target="_blank">
						<div class="p-author__thumbnail">
							<div class="p-hover-effect__image"><?php echo get_avatar( $user->ID, 300 ); ?></div>
						</div>
						<h3 class="p-author__name"><?php echo esc_html( $user->display_name ); ?></h3>
					</a>
				</div>
				<h2 class="p-delete-account__confirm-headline p-member-page-headline--color"><?php _e( 'Would you like to delete the account?', 'tcd-w' ); ?></h2>
				<div class="p-membership-form__button">
					<button class="p-button p-rounded-button p-submit-button" type="submit"><?php _e( 'Delete account', 'tcd-w' ); ?></button>
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-delete_account' ) ); ?>">
				</div>
			</form>
		</div>
	</div>
</main>
<?php
get_footer();
