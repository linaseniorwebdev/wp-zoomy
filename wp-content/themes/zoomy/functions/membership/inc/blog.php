<?php
global $dp_options, $guest_permission_options;
?>
<?php // ブログ設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Blog settings', 'tcd-w' ); ?></h3>
	<ul>
		<li><label><input name="dp_options[membership][use_front_edit_blog]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_front_edit_blog'] ); ?>><?php _e( 'User can add/edit/delete blog in frontend', 'tcd-w' ); ?></label></li>
		<li>
			<label><input name="dp_options[membership][use_front_edit_blog_pending]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_front_edit_blog_pending'] ); ?>><?php _e( 'Requires review of Administrator or Editor for publish blog', 'tcd-w' ); ?></label>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Pending label', 'tcd-w' ); ?> : 
			<input type="text" name="dp_options[membership][pending_label]" value="<?php echo esc_attr( $dp_options['membership']['pending_label'] ); ?>" size="10">
		</li>
		<li><label><input name="dp_options[membership][use_like_blog]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_like_blog'] ); ?>><?php _e( 'Use Like', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Guest permission settings', 'tcd-w' ); ?></h3>
	<fieldset class="radios">
		<?php foreach ( $guest_permission_options as $option ) : ?>
		<label><input type="radio" name="dp_options[membership][guest_permission_blog]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['membership']['guest_permission_blog'] ); ?>><?php printf( $option['label'], __( 'Blog', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ); ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 投稿編集設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Add / Edit blog settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Add blog note below "Preview Confirm" button', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][add_blog_note]"><?php echo esc_textarea( $dp_options['membership']['add_blog_note'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Edit blog note below "Preview Confirm" button', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_note]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_note'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Add / Edit blog complete message settings', 'tcd-w' ); ?></h4>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to published', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to published', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_blog_complete_publish_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_blog_complete_publish_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to published', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_complete_publish_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_complete_publish_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to private', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to private', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_blog_complete_private_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_blog_complete_private_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to private', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_complete_private_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_complete_private_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to pending', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to pending', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_blog_complete_pending_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_blog_complete_pending_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to pending', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_complete_pending_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_complete_pending_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to draft', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to draft', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_blog_complete_draft_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_blog_complete_draft_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to draft', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_complete_draft_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_complete_draft_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to update (No status change)', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of update', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_blog_complete_update_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_blog_complete_update_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of update', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_blog_complete_update_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_blog_complete_update_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
