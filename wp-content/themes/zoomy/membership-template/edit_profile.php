<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<main class="l-main has-bg--pc">
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( 'profile' ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-edit-profile">
<?php
tcd_membership_edit_profile_form();
?>
		</div>
	</div>
</main>
<?php
get_footer();
