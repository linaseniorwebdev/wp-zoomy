<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post;

// プレビュー確認はsingle-photo.php
if ( is_tcd_membership_preview_photo() ) :
	get_template_part( 'single-photo' );
	return;
endif;

get_header();
?>
<main class="l-main has-bg--pc">
<?php
// 完了画面
if ( ! empty( $tcd_membership_vars['complete'] ) ) :
?>
	<div class="l-inner">
		<div class="p-member-page p-edit-photo">
			<div class="p-membership-form__complete-static">
<?php
	$headline = null;
	$desc = null;
	switch ( $tcd_membership_vars['complete'] ) :
		case 'publish' :
			if ( $dp_options['membership']['edit_photo_complete_publish_headline'] ) :
				$headline = $dp_options['membership']['edit_photo_complete_publish_headline'];
			else :
				$headline = sprintf( __( '%s was published.', 'tcd-w' ), $dp_options['photo_label'] );
			endif;
			if ( $dp_options['membership']['edit_photo_complete_publish_desc'] ) :
				$desc = $dp_options['membership']['edit_photo_complete_publish_desc'];
			endif;
			break;

		case 'private' :
			if ( $dp_options['membership']['edit_photo_complete_private_headline'] ) :
				$headline = $dp_options['membership']['edit_photo_complete_private_headline'];
			else :
				$headline = sprintf( __( '%s saved as private.', 'tcd-w' ), $dp_options['photo_label'] );
			endif;
			if ( $dp_options['membership']['edit_photo_complete_private_desc'] ) :
				$desc = $dp_options['membership']['edit_photo_complete_private_desc'];
			endif;
			break;

		case 'pending' :
			if ( $dp_options['membership']['edit_photo_complete_pending_headline'] ) :
				$headline = $dp_options['membership']['edit_photo_complete_pending_headline'];
			else :
				$headline = sprintf( __( '%s saved as pending.', 'tcd-w' ), $dp_options['photo_label'] );
			endif;
			if ( $dp_options['membership']['edit_photo_complete_pending_desc'] ) :
				$desc = $dp_options['membership']['edit_photo_complete_pending_desc'];
			endif;
			break;

		case 'draft' :
			if ( $dp_options['membership']['edit_photo_complete_draft_headline'] ) :
				$headline = $dp_options['membership']['edit_photo_complete_draft_headline'];
			else :
				$headline = sprintf( __( '%s saved as draft.', 'tcd-w' ), $dp_options['photo_label'] );
			endif;
			if ( $dp_options['membership']['edit_photo_complete_draft_desc'] ) :
				$desc = $dp_options['membership']['edit_photo_complete_draft_desc'];
			endif;
			break;

		case 'updated' :
			if ( $dp_options['membership']['edit_photo_complete_update_headline'] ) :
				$headline = $dp_options['membership']['edit_photo_complete_update_headline'];
			else :
				$headline = sprintf( __( '%s updated.', 'tcd-w' ), $dp_options['photo_label'] );
			endif;
			if ( $dp_options['membership']['edit_photo_complete_update_desc'] ) :
				$desc = $dp_options['membership']['edit_photo_complete_update_desc'];
			endif;
			break;

		default :
			$headline = sprintf( __( '%s saved.', 'tcd-w' ), $dp_options['photo_label'] );
			break;
	endswitch;
?>
				<h2 class="p-member-page-headline--color"><?php echo esc_html( $headline ); ?></h2>
<?php
	if ( $desc ) :
		if ( false !== strpos( $desc, '[post_url]' ) ) :
			$desc = str_replace( '[post_url]', get_permalink( $_REQUEST['post_id'] ), $desc );
		endif;
		if ( false !== strpos( $desc, '[author_url]' ) ) :
			$desc = str_replace( '[author_url]', get_author_posts_url( get_current_user_id() ), $desc );
		endif;
?>
				<div class="p-membership-form__body p-body p-membership-form__desc"><?php echo wpautop( $desc ); ?></div>
<?php
	endif;
?>
				<div class="p-membership-form__button">
					<a class="p-button p-rounded-button" href="<?php echo esc_attr( get_author_posts_url( get_current_user_id() ) ); ?>"><?php _e( 'Profile page', 'tcd-w' ); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php
// フォーム表示
else:
?>
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( $tcd_membership_vars['memberpage_type'] ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-edit-photo">
			<form id="js-membership-edit-photo" class="p-membership-form js-membership-form--normal" action="" enctype="multipart/form-data" method="post">
				<div class="p-membership-form__body p-body p-membership-form__top">
<?php
	if ( ! empty( $tcd_membership_vars['error_message'] ) ) :
?>
					<div class="p-membership-form__error"><?php echo wpautop( $tcd_membership_vars['error_message'] ); ?></div>
<?php
	endif;
?>
					<p class="p-membership-form__category"><?php
	wp_dropdown_categories( array(
		'class' => '',
		'echo' => 1,
		'hide_empty' => 0,
		'hierarchical' => 0,
		'id' => '',
		'name' => 'category',
		'selected' => $tcd_membership_post->category,
		'taxonomy' => $dp_options['photo_category_slug'],
		'show_option_none' => __( 'Select category', 'tcd-w' ),
		'option_none_value' => '',
		'show_count' => 0,
		'value_field' => 'term_id',
		'required' => true
	) );

	echo '<span class="p-membership-form__remark">' . __( '* Please select category (Required).', 'tcd-w' ) . '</span>';
					?></p>
<?php
	tcd_membership_image_upload_field( array(
		'indent' => 6,
		'input_name' => 'file_main_image',
		'overlay_headline' => '<h3 class="p-membership-form__image-upload__label-headline">' . __( 'Select photo', 'tcd-w' ) . '<span class="p-membership-form__remark">' . __( ' (Requied)', 'tcd-w' ) . '</span></h3>',
		'overlay_desc' => sprintf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 1200, 675 ) . '<br>' . sprintf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 675, 1000 ),
		'image_url' => $tcd_membership_post->main_image,
		'hidden_inputs' => array(
			'main_image' => $tcd_membership_post->main_image
		)
	) );
?>
					<p class="p-membership-form__remark"><?php _e( '* This photo will be a thumbnail preview.', 'tcd-w' ); ?><br><?php _e( '* Please select a local photo file, or drag and drop.', 'tcd-w' ); ?></p>
				</div>
				<div class="p-membership-form__body p-body p-membership-form__bottom">
					<p class="p-membership-form__post_title"><input type="text" name="post_title" value="<?php echo esc_attr( $tcd_membership_post->post_title ); ?>" placeholder="<?php esc_attr_e( 'Photo title (Required)', 'tcd-w' ); ?>" required></p>

					<input type="radio" class="p-membership-form__textalign-radio" id="p-membership-form__textalign-radio-center" name="textalign" value="center" <?php checked( 'center', $tcd_membership_post->textalign ); ?>>
					<input type="radio" class="p-membership-form__textalign-radio" id="p-membership-form__textalign-radio-left" name="textalign" value="left" <?php checked( 'left', $tcd_membership_post->textalign ); ?>>
					<div class="p-membership-form__textalign">
						<label class="p-membership-form__textalign-label-center" for="p-membership-form__textalign-radio-center"><span>Center</span></label><label class="p-membership-form__textalign-label-left" for="p-membership-form__textalign-radio-left"><span>Left</span></label>
					</div>
					<textarea class="p-membership-form__post_content" name="post_content" placeholder="<?php esc_attr_e( 'Enter content', 'tcd-w' ); ?>" rows="10"><?php echo esc_textarea( $tcd_membership_post->post_content ); ?></textarea>
				</div>
				<div class="p-membership-form__post_status">
<?php
	foreach ( get_tcd_membership_post_statuses( $tcd_membership_post ) as $post_status => $post_status_label ) :
?>
					<label><input type="radio" name="post_status" value="<?php echo esc_attr( $post_status ); ?>" <?php checked( $post_status, $tcd_membership_post->post_status ); ?>><?php echo esc_html( $post_status_label ); ?></label>
<?php
	endforeach;
?>
				</div>
				<div class="p-membership-form__button">
					<button class="p-button p-rounded-button p-submit-button" name="to_confirm" type="submit" value="1"><?php _e( 'Preview Confirm', 'tcd-w' ); ?></button>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $tcd_membership_post->ID ); ?>">
					<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'tcd-membership-' . $tcd_membership_vars['memberpage_type'] . '-' . $tcd_membership_post->ID ) ); ?>">
				</div>
<?php
	if ( 'add_photo' === $tcd_membership_vars['memberpage_type'] && ! empty( $dp_options['membership']['add_photo_note'] ) ) :
?>
				<div class="p-membership-form__body p-body p-membership-form__note">
					<?php echo wpautop( $dp_options['membership']['add_photo_note'] ); ?>
				</div>
<?php
	elseif ( 'edit_photo' === $tcd_membership_vars['memberpage_type'] && ! empty( $dp_options['membership']['edit_photo_note'] ) ) :
?>
				<div class="p-membership-form__body p-body p-membership-form__note">
					<?php echo wpautop( $dp_options['membership']['edit_photo_note'] ); ?>
				</div>
<?php
	endif;
?>
			</form>
		</div>
	</div>
<?php
endif;
?>
</main>
<?php
get_footer();
