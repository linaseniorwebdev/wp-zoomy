<?php
global $dp_options;
?>
<?php // マイページ設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mypage settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Mypage page settings', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Set a page to be displayed as a "Mypage".', 'tcd-w' ); ?></p>
<?php
$exclude_pages = array();
if ( 'page' === get_option( 'show_on_front' ) ) {
	$exclude_pages = array(
		get_option( 'page_on_front' ),
		get_option( 'page_for_posts' )
	);
}
wp_dropdown_pages( array(
	'exclude' => $exclude_pages,
	'name' => 'dp_options[membership][memberpage_page_id]',
	'selected' => $dp_options['membership']['memberpage_page_id'],
	'show_option_none' => ' '
) );
?>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // マイページタイトル設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mypage headline settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Mypage news headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mypage_headline_news]" value="<?php echo esc_attr( $dp_options['membership']['mypage_headline_news'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Add photo headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mypage_headline_add_photo]" value="<?php echo esc_attr( $dp_options['membership']['mypage_headline_add_photo'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Add blog headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mypage_headline_add_blog]" value="<?php echo esc_attr( $dp_options['membership']['mypage_headline_add_blog'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Profile headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mypage_headline_profile]" value="<?php echo esc_attr( $dp_options['membership']['mypage_headline_profile'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Account headline', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][mypage_headline_account]" value="<?php echo esc_attr( $dp_options['membership']['mypage_headline_account'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // マイページお知らせ設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mypage news settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Mypage news number', 'tcd-w' ); ?></h4>
	<input type="number" class="small-text" name="dp_options[membership][mypage_news_num]" value="<?php echo esc_attr( $dp_options['membership']['mypage_news_num'] ); ?>" min="1">
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // マイページお知らせ広告 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mypage news banner settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'This banner will be displayed above or below mypage news.', 'tcd-w' ); ?></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Above left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_code1]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_code1'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually. If an advertisement code is entered in the above setting field, the following setting will be invalid.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_image1'] ); ?>" name="dp_options[membership][mypage_ad_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_image1'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_url1]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_url1'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Above right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_code2]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_code2'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_image2">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_image2'] ); ?>" name="dp_options[membership][mypage_ad_image2]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_image2'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_image2'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_image2'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_url2]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_url2'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Below left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_code3]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_code3'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_image3">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_image3'] ); ?>" name="dp_options[membership][mypage_ad_image3]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_image3'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_image3'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_image3'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_url3]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_url3'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Below right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_code4]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_code4'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_image4">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_image4'] ); ?>" name="dp_options[membership][mypage_ad_image4]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_image4'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_image4'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_image4'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_url4]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_url4'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Above banner for mobile', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_mobile_code1]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_mobile_code1'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually. If an advertisement code is entered in the above setting field, the following setting will be invalid.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_mobile_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_mobile_image1'] ); ?>" name="dp_options[membership][mypage_ad_mobile_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_mobile_image1'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_mobile_image1'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_mobile_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_mobile_url1]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_mobile_url1'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Below banner for mobile', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[membership][mypage_ad_mobile_code2]"><?php echo esc_textarea( $dp_options['membership']['mypage_ad_mobile_code2'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
				<p><?php printf( __( 'Recommend image size. Width:%dpx, Height:%dpx', 'tcd-w' ), 300, 250 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js mypage_ad_mobile_image2">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_mobile_image2'] ); ?>" name="dp_options[membership][mypage_ad_mobile_image2]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['membership']['mypage_ad_mobile_image2'] ) { echo wp_get_attachment_image( $dp_options['membership']['mypage_ad_mobile_image2'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['membership']['mypage_ad_mobile_image2'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][mypage_ad_mobile_url2]" value="<?php echo esc_attr( $dp_options['membership']['mypage_ad_mobile_url2'] ); ?>">
				<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
