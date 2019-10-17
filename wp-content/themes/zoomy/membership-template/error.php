<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<main class="l-main">
	<div class="l-inner">
		<div class="p-member-page p-member-page--error">
			<div class="p-membership-form__body p-body">
<?php
if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
				<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
else :
?>
				<div class="p-membership-form__error"><p><?php _e( 'Error has occurred.', 'tcd-w' ); ?></p></div>
<?php
endif;

?>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
