<?php
global $dp_options, $dp_default_options, $header_content_type_options, $slider_content_type_options, $slider_content_type_mobile_options, $slide_effect_type_options, $font_type_options, $text_align_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header content setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'You can set header content as the first view of your site.', 'tcd-w' ); ?></p>
	<h4 class="theme_option_headline2"><?php _e( 'Header content type', 'tcd-w' ); ?></h4>
	<div class="theme_option_message"><?php echo __( '<p>Image slider:You can set 5 slides or 1 image as fixed header.</p><p>Video:You can display MP4 format videos.</p><p>Youtube:You can display Youtube videos.</p>', 'tcd-w' ); ?></div>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_content_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_content_type]" value="<?php echo esc_attr( $option['value'] ); ?>" data-toggle=".header_content-<?php echo esc_attr( $option['value'] ); ?>" data-hide="[class*=header_content-type]" <?php checked( $dp_options['header_content_type'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
</div>
<div class="theme_option_field cf header_content-type1" style="<?php if ( 'type1' != $dp_options['header_content_type'] ) echo 'display: none;'; ?>">
	<h3 class="theme_option_headline"><?php _e( 'Image slider', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set slider item.', 'tcd-w' ); ?></p>
<?php
for ( $i = 1; $i <= 5; $i++ ) :
?>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slide%s setting for PC', 'tcd-w' ), $i ); ?></h3>
		<div class="sub_box_content">
			<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Image for PC and Tablet.', 'tcd-w' ); ?></p>
			<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 1450, 750 ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js slider_image slider_image<?php echo esc_attr( $i ); ?>">
					<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_image' . $i] ); ?>" name="dp_options[slider_image<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
					<div class="preview_field"><?php if ( $dp_options['slider_image' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_image' . $i], 'full' ); /* Require full size for logo preview */ } ?></div>
					<div class="button_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_image' . $i] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Logo or Catchphrase', 'tcd-w' ); ?></h4>
			<fieldset class="cf select_type2">
				<?php foreach ( $slider_content_type_options as $option ) : ?>
				<label><input type="radio" name="dp_options[slider_content_type<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" data-toggle=".slide<?php echo $i; ?>-slider_content_type-<?php echo esc_attr( $option['value'] ); ?>" data-hide="[class*='slide<?php echo $i; ?>-slider_content_type-']" <?php checked( $dp_options['slider_content_type' . $i], $option['value'] ); ?>><?php echo $option['label']; ?></label>
				
				<?php endforeach; ?>
			</fieldset>
			<div class="slide<?php echo $i; ?>-slider_content_type-type1"<?php if ( 'type1' != $dp_options['slider_content_type' . $i] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Logo setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set logo image.', 'tcd-w' ); ?></p>
				<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 185, 22 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js slider_logo<?php echo $i; ?>">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_logo' . $i] ); ?>" name="dp_options[slider_logo<?php echo $i; ?>]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['slider_logo' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_logo' . $i], 'full' ); /* Require full size for logo preview */ } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_logo' . $i] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
				<div class="slider_logo_preview-wrapper" style="display: none;">
					<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
					<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
					<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_logo_width' . $i] ); ?>" name="dp_options[slider_logo_width<?php echo $i; ?>]" id="slider_logo_width<?php echo $i; ?>">
					<div class="slider_logo_preview slider_logo_preview-pc" data-logo-width-input="#slider_logo_width<?php echo $i; ?>" data-logo-img=".slider_logo<?php echo $i; ?> img" data-bg-img=".slider_image<?php echo $i; ?> img" data-display-overlay=".display_slider_overlay<?php echo $i; ?>" data-overlay-color=".slider_overlay_color<?php echo $i; ?>" data-overlay-opacity=".slider_overlay_opacity<?php echo $i; ?>"></div>
				</div>
			</div>
			<div class="slide<?php echo $i; ?>-slider_content_type-type2"<?php if ( 'type2' != $dp_options['slider_content_type' . $i] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set texts for catchphrase, font size, color and align.', 'tcd-w' ); ?></p>
				<textarea rows="2" class="large-text" name="dp_options[slider_catch<?php echo $i; ?>]"><?php echo esc_textarea( $dp_options['slider_catch' . $i] ); ?></textarea>
				<table>
					<tr>
						<td colspan="2"><label><input type="checkbox" name="dp_options[slider_catch_vertical<?php echo $i; ?>]" value="1" <?php checked( $dp_options['slider_catch_vertical' . $i], 1 ); ?>><?php _e( 'Display as vertical writing', 'tcd-w' ); ?></label></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_catch_font_size' . $i] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font type', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_catch_font_type<?php echo $i; ?>]">
								<?php foreach ( $font_type_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_catch_font_type' . $i] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_catch_align<?php echo $i; ?>]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_catch_align' . $i] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow1]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow1'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow2]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch<?php echo $i; ?>_shadow3]" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch<?php echo $i; ?>_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch' . $i . '_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch' . $i . '_shadow_color'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Description setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'You can set the description, and check "Display description" to set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" name="dp_options[display_slider_desc<?php echo $i; ?>]" value="1" data-toggle=".toggle-display_slider_desc<?php echo $i; ?>" <?php checked( $dp_options['display_slider_desc' . $i], 1 ); ?>><?php _e( 'Display description', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_slider_desc<?php echo $i; ?>"<?php if ( ! $dp_options['display_slider_desc' . $i] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set texts for description, font size, color and align.', 'tcd-w' ); ?></p>
				<textarea rows="2" class="large-text" name="dp_options[slider_desc<?php echo $i; ?>]"><?php echo esc_textarea( $dp_options['slider_desc' . $i] ); ?></textarea>
				<table>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_desc_font_size' . $i] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_desc_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_desc_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_desc_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_desc_align<?php echo $i; ?>]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_desc_align' . $i] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_desc<?php echo $i; ?>_shadow1]" value="<?php echo esc_attr( $dp_options['slider_desc' . $i . '_shadow1'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_desc<?php echo $i; ?>_shadow2]" value="<?php echo esc_attr( $dp_options['slider_desc' . $i . '_shadow2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_desc<?php echo $i; ?>_shadow3]" value="<?php echo esc_attr( $dp_options['slider_desc' . $i . '_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[slider_desc<?php echo $i; ?>_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['slider_desc' . $i . '_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_desc' . $i . '_shadow_color'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Button setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'You can set the button, and check "Display button" to set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" name="dp_options[display_slider_button<?php echo $i; ?>]" value="1" data-toggle=".toggle-display_slider_button<?php echo $i; ?>" <?php checked( $dp_options['display_slider_button' . $i], 1 ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_slider_button<?php echo $i; ?>"<?php if ( ! $dp_options['display_slider_button' . $i] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label for="dp_options[slider_button_label<?php echo $i; ?>]"><?php _e( 'Button label', 'tcd-w' ); ?></label></td>
						<td><input type="text" id="dp_options[slider_button_label<?php echo $i; ?>]" name="dp_options[slider_button_label<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_button_label' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label for="dp_options[slider_url<?php echo $i; ?>]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></td>
						<td>
							<input class="large-text" type="text" id="dp_options[slider_url<?php echo $i; ?>]" name="dp_options[slider_url<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_url' . $i] ); ?>">
							<label><input name="dp_options[slider_target<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['slider_target' . $i] ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?></label>
						</td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color_hover' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color_hover' . $i] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Overlay', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please check "use overlay", and set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" class="display_slider_overlay<?php echo $i; ?>" name="dp_options[display_slider_overlay<?php echo $i; ?>]" value="1" data-toggle=".toggle-display_slider_overlay<?php echo $i; ?>" <?php checked( $dp_options['display_slider_overlay' . $i], 1 ); ?>><?php _e( 'Display overlay', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_slider_overlay<?php echo $i; ?>"<?php if ( ! $dp_options['display_slider_overlay' . $i] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set color and opacity of overlay.', 'tcd-w' ); ?></p>
				<input class="slider_overlay_color<?php echo $i; ?> c-color-picker" name="dp_options[slider_overlay_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_overlay_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_overlay_color' . $i] ); ?>">
				<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="slider_overlay_opacity<?php echo $i; ?> small-text" name="dp_options[slider_overlay_opacity<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_overlay_opacity' . $i] ); ?>" min="0" max="1" step="0.1">
			</div>
			<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
<?php
endfor;
?>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slides setting for mobile', 'tcd-w' ), $i ); ?></h3>
		<div class="sub_box_content">
			<p><?php _e( 'Sets the display contents of the slider for mobile.', 'tcd-w' ); ?></p>
			<h4 class="theme_option_headline2"><?php _e( 'Slide content type', 'tcd-w' ); ?></h4>
			<fieldset class="cf select_type2">
				<?php foreach ( $slider_content_type_mobile_options as $option ) : ?>
				<label><input type="radio" name="dp_options[slider_content_type_mobile]" value="<?php echo esc_attr( $option['value'] ); ?>" data-toggle=".slider_content_type_mobile-<?php echo esc_attr( $option['value'] ); ?>" data-hide="[class*='slider_content_type_mobile-']" <?php checked( $dp_options['slider_content_type_mobile'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
				<?php endforeach; ?>
			</fieldset>
			<div class="slider_content_type_mobile-type1"<?php if ( 'type1' != $dp_options['slider_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Logo setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set logo image.', 'tcd-w' ); ?></p>
				<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 145, 18 ); ?></p>
				<p><?php _e( 'The logo set here will be displayed on all slides.', 'tcd-w' ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js slider_logo_mobile_type1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_logo_mobile_type1'] ); ?>" name="dp_options[slider_logo_mobile_type1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['slider_logo_mobile_type1'] ) { echo wp_get_attachment_image( $dp_options['slider_logo_mobile_type1'], 'full' ); /* Require full size for logo preview */ } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_logo_mobile_type1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
				<div class="slider_logo_preview-wrapper" style="display: none;">
					<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
					<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
					<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_logo_width_mobile_type1'] ); ?>" name="dp_options[slider_logo_width_mobile_type1]" id="slider_logo_width_mobile_type1">
					<div class="slider_logo_preview slider_logo_preview-mobile" data-logo-width-input="#slider_logo_width_mobile_type1" data-logo-img=".slider_logo_mobile_type1 img" data-bg-img=".slider_image_sp1 img, .slider_image1 img" data-display-overlay=".display_slider_overlay_mobile1" data-overlay-color=".slider_overlay_color_mobile1" data-overlay-opacity=".slider_overlay_opacity_mobile1"></div>
				</div>
			</div>
			<div class="slider_content_type_mobile-type2"<?php if ( 'type2' != $dp_options['slider_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set texts for catchphrase, font size, color and align.', 'tcd-w' ); ?></p>
				<p><?php _e( 'The catchphrase set here will be displayed on all slides.', 'tcd-w' ); ?></p>
				<textarea rows="2" class="large-text" name="dp_options[slider_catch_mobile_type2]"><?php echo esc_textarea( $dp_options['slider_catch_mobile_type2'] ); ?></textarea>
				<table>
					<tr>
						<td colspan="2"><label><input type="checkbox" name="dp_options[slider_catch_vertical_mobile_type2]" value="1" <?php checked( $dp_options['slider_catch_vertical_mobile_type2'], 1 ); ?>><?php _e( 'Display as vertical writing', 'tcd-w' ); ?></label></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_font_size_mobile_type2]" value="<?php echo esc_attr( $dp_options['slider_catch_font_size_mobile_type2'] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_color_mobile_type2]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_color_mobile_type2'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_color_mobile_type2'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font type', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_catch_font_type_mobile_type2]">
								<?php foreach ( $font_type_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_catch_font_type_mobile_type2'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[slider_catch_align_mobile_type2]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slider_catch_align_mobile_type2'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_shadow1_mobile_type2]" value="<?php echo esc_attr( $dp_options['slider_catch_shadow1_mobile_type2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_shadow2_mobile_type2]" value="<?php echo esc_attr( $dp_options['slider_catch_shadow2_mobile_type2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider_catch_shadow3_mobile_type2]" value="<?php echo esc_attr( $dp_options['slider_catch_shadow3_mobile_type2'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[slider_catch_shadow_color_mobile_type2]" type="text" value="<?php echo esc_attr( $dp_options['slider_catch_shadow_color_mobile_type2'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_catch_shadow_color_mobile_type2'] ); ?>"></td>
					</tr>
				</table>
			</div>
<?php
for ( $i = 1; $i <= 5; $i++ ) :
?>
			<div class="sub_box cf">
				<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slide%s setting for mobile', 'tcd-w' ), $i ); ?></h3>
				<div class="sub_box_content">
					<h4 class="theme_option_headline2"><?php _e( 'Image for smartphone', 'tcd-w' ); ?></h4>
					<p><?php _e( 'You can set image for smartphone.', 'tcd-w' ); ?></p>
					<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 750, 1334 ); ?></p>
					<div class="image_box cf">
						<div class="cf cf_media_field hide-if-no-js slider_image_sp slider_image_sp<?php echo $i; ?>">
							<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_image_sp' . $i] ); ?>" name="dp_options[slider_image_sp<?php echo $i; ?>]" class="cf_media_id">
							<div class="preview_field"><?php if ( $dp_options['slider_image_sp' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_image_sp' . $i], 'medium' ); } ?></div>
							<div class="button_area">
								<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
								<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_image_sp' . $i] ) { echo 'hidden'; } ?>">
							</div>
						</div>
					</div>

					<div class="slider_content_type_mobile-default"<?php if ( 'default' != $dp_options['slider_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
						<div class="slide<?php echo $i; ?>-slider_content_type-type1"<?php if ( 'type1' != $dp_options['slider_content_type' . $i] ) echo ' style="display: none;"'; ?>>
							<div class="slider_logo_preview-wrapper" style="display: none;">
								<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
								<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
								<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_logo_width_mobile' . $i] ); ?>" name="dp_options[slider_logo_width_mobile<?php echo $i; ?>]" id="slider_logo_width_mobile<?php echo $i; ?>">
								<div class="slider_logo_preview slider_logo_preview-mobile" data-logo-width-input="#slider_logo_width_mobile<?php echo $i; ?>" data-logo-img=".slider_logo<?php echo $i; ?> img" data-bg-img=".slider_image_sp<?php echo $i; ?> img, .slider_image<?php echo $i; ?> img" data-display-overlay=".display_slider_overlay<?php echo $i; ?>" data-overlay-color=".slider_overlay_color<?php echo $i; ?>" data-overlay-opacity=".slider_overlay_opacity<?php echo $i; ?>"></div>
							</div>
						</div>
						<div class="slide<?php echo $i; ?>-slider_content_type-type2"<?php if ( 'type2' != $dp_options['slider_content_type' . $i] ) echo ' style="display: none;"'; ?>>
							<h4 class="theme_option_headline2"><?php _e( 'Catchphrase Font size for mobile', 'tcd-w' ); ?></h4>
							<p><?php _e( 'You can set catchphrase font size for mobile.', 'tcd-w' ); ?></p>
							<input type="number" class="small-text" name="dp_options[slider_catch_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_catch_font_size_mobile' . $i] ); ?>" min="1"><span>px</span>
						</div>
						<div class="toggle-display_slider_desc<?php echo $i; ?>"<?php if ( ! $dp_options['display_slider_desc' . $i] ) echo ' style="display: none;"'; ?>>
							<h4 class="theme_option_headline2"><?php _e( 'Description Font size for mobile', 'tcd-w' ); ?></h4>
							<p><?php _e( 'You can set description font size for mobile.', 'tcd-w' ); ?></p>
							<input type="number" class="small-text" name="dp_options[slider_desc_font_size_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_desc_font_size_mobile' . $i] ); ?>" min="1"><span>px</span>
						</div>
					</div>
					<div class="slider_content_type_mobile-type1 slider_content_type_mobile-type2"<?php if ( ! in_array( $dp_options['slider_content_type_mobile'], array( 'type1', 'type2' ) ) ) echo ' style="display: none;"'; ?>>
						<h4 class="theme_option_headline2"><?php _e( 'Overlay', 'tcd-w' ); ?></h4>
						<p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please check "use overlay", and set detail options.', 'tcd-w' ); ?></p>
						<p><label><input type="checkbox" class="display_slider_overlay_mobile<?php echo $i; ?>" name="dp_options[display_slider_overlay_mobile<?php echo $i; ?>]" value="1" data-toggle=".toggle-display_slider_overlay_mobile<?php echo $i; ?>" <?php checked( $dp_options['display_slider_overlay_mobile' . $i], 1 ); ?>><?php _e( 'Display overlay', 'tcd-w' ); ?></label></p>
						<div class="toggle-display_slider_overlay_mobile<?php echo $i; ?>"<?php if ( ! $dp_options['display_slider_overlay_mobile' . $i] ) echo ' style="display: none;"'; ?>>
							<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
							<p><?php _e( 'Please set color and opacity of overlay.', 'tcd-w' ); ?></p>
							<input class="slider_overlay_color_mobile<?php echo $i; ?> c-color-picker" name="dp_options[slider_overlay_color_mobile<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_overlay_color_mobile' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_overlay_color_mobile' . $i] ); ?>">
							<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
							<input type="number" class="slider_overlay_opacity_mobile<?php echo $i; ?> small-text" name="dp_options[slider_overlay_opacity_mobile<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_overlay_opacity_mobile' . $i] ); ?>" min="0" max="1" step="0.1">
						</div>
					</div>
					<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
				</div>
			</div>
<?php
endfor;
?>
			<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Slide interval seconds', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set slide interval seconds. (3 to 15 seconds)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[slide_time_seconds]" value="<?php echo esc_attr( $dp_options['slide_time_seconds'] ); ?>" min="3" max="15"> <?php _e( ' seconds', 'tcd-w' ); ?>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>

<div class="theme_option_field cf header_content-type2 header_content-type3" style="<?php if ( 'type1' == $dp_options['header_content_type'] ) echo 'display: none;'; ?>">
	<div class="header_content-type2" style="<?php if ( 'type2' != $dp_options['header_content_type'] ) echo 'display: none;'; ?>">
		<h3 class="theme_option_headline"><?php _e( 'Video setting', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Please upload or select MP4 video.', 'tcd-w' ); ?></p>
		<h4 class="theme_option_headline2"><?php _e( 'Video file', 'tcd-w' ); ?></h4>
		<div class="image_box cf">
			<div class="cf cf_video_field hide-if-no-js header_video">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video'] ); ?>" name="dp_options[header_video]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['header_video'] && wp_get_attachment_url( $dp_options['header_video'] ) ) { echo '<p class="media_url">' . wp_get_attachment_url( $dp_options['header_video'] ) . '</p>'; } ?></div>
				<div class="buttton_area">
					<input type="button" value="<?php _e( 'Select Video', 'tcd-w' ); ?>" class="cfvf-select-video button">
					<input type="button" value="<?php _e( 'Remove Video', 'tcd-w' ); ?>" class="cfvf-delete-video button <?php if ( ! $dp_options['header_video'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
		<h4 class="theme_option_headline2"><?php _e( 'Substitute image', 'tcd-w' ); ?></h4>
		<p><?php _e( 'This image will be displayed instead of video in mobile.', 'tcd-w' ); ?></p>
			<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 750, 1334 ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js header_video_image">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_image'] ); ?>" name="dp_options[header_video_image]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['header_video_image'] ) { echo wp_get_attachment_image( $dp_options['header_video_image'], 'medium' ); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_video_image'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="header_content-type3" style="<?php if ( 'type3' != $dp_options['header_content_type'] ) echo 'display: none;'; ?>">
		<h3 class="theme_option_headline"><?php _e( 'Youtube setting', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Please enter Youtube URL.', 'tcd-w' ); ?></p>
		<h4 class="theme_option_headline2"><?php _e( 'Youtube URL', 'tcd-w' ); ?></h4>
		<input class="regular-text" type="text" name="dp_options[header_youtube_url]" value="<?php echo esc_attr( $dp_options['header_youtube_url'] ); ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Substitute image', 'tcd-w' ); ?></h4>
		<p><?php _e( 'This image will be displayed instead of Youtube video in mobile.', 'tcd-w' ); ?></p>
		<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 750, 1334 ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js header_youtube_image">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['header_youtube_image'] ); ?>" name="dp_options[header_youtube_image]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['header_youtube_image'] ) { echo wp_get_attachment_image( $dp_options['header_youtube_image'], 'medium' ); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_youtube_image'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Overlay contents setting for PC', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<h4 class="theme_option_headline2"><?php _e( 'Logo or Catchphrase', 'tcd-w' ); ?></h4>
			<fieldset class="cf select_type2">
				<?php foreach ( $slider_content_type_options as $option ) : ?>
				<label><input type="radio" name="dp_options[header_video_content_type]" value="<?php echo esc_attr( $option['value'] ); ?>" data-toggle=".header_video_content_type-<?php echo esc_attr( $option['value'] ); ?>" data-hide="[class*='header_video_content_type-']" <?php checked( $dp_options['header_video_content_type'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
				<?php endforeach; ?>
			</fieldset>
			<div class="header_video_content_type-type1"<?php if ( 'type1' != $dp_options['header_video_content_type'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Logo setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set logo image.', 'tcd-w' ); ?></p>
				<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 185, 22 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js header_video_logo">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_logo'] ); ?>" name="dp_options[header_video_logo]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['header_video_logo'] ) { echo wp_get_attachment_image( $dp_options['header_video_logo'], 'full' ); /* Require full size for logo preview */ } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_video_logo'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
				<div class="slider_logo_preview-wrapper" style="display: none;">
					<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
					<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
					<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_logo_width'] ); ?>" name="dp_options[header_video_logo_width]" id="header_video_logo_width">
					<div class="slider_logo_preview slider_logo_preview-pc header_video_logo_preview header_video_logo_preview-pc" data-logo-width-input="#header_video_logo_width" data-logo-img=".header_video_logo img" data-display-overlay=".display_header_video_overlay" data-overlay-color=".header_video_overlay_color" data-overlay-opacity=".header_video_overlay_opacity"></div>
				</div>
			</div>
			<div class="header_video_content_type-type2"<?php if ( 'type2' != $dp_options['header_video_content_type'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set texts for catchphrase, font size, color and align.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<textarea rows="2" class="large-text" name="dp_options[header_video_catch]"><?php echo esc_textarea( $dp_options['header_video_catch'] ); ?></textarea>
				<table>
					<tr>
						<td colspan="2"><label><input type="checkbox" name="dp_options[header_video_catch_vertical]" value="1" <?php checked( $dp_options['header_video_catch_vertical'], 1 ); ?>><?php _e( 'Display as vertical writing', 'tcd-w' ); ?></label></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_font_size]" value="<?php echo esc_attr( $dp_options['header_video_catch_font_size'] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_catch_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_catch_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_catch_color'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font type', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[header_video_catch_font_type]">
								<?php foreach ( $font_type_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_video_catch_font_type'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[header_video_catch_align]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_video_catch_align'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow1]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow1'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow2]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow3]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[header_video_catch_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_catch_shadow_color'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Description setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'You can set the description, and check "Display description" to set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" name="dp_options[display_header_video_desc]" value="1" data-toggle=".toggle-display_header_video_desc" <?php checked( $dp_options['display_header_video_desc'], 1 ); ?>><?php _e( 'Display description', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_header_video_desc"<?php if ( ! $dp_options['display_header_video_desc'] ) echo ' style="display: none;"'; ?>>
				<p><?php _e( 'Please set texts for description, font size, color and align.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
				<textarea rows="2" class="large-text" name="dp_options[header_video_desc]"><?php echo esc_textarea( $dp_options['header_video_desc'] ); ?></textarea>
				<table>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_desc_font_size]" value="<?php echo esc_attr( $dp_options['header_video_desc_font_size'] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_desc_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_desc_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_desc_color'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[header_video_desc_align]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_video_desc_align'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_desc_shadow1]" value="<?php echo esc_attr( $dp_options['header_video_desc_shadow1'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_desc_shadow2]" value="<?php echo esc_attr( $dp_options['header_video_desc_shadow2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_desc_shadow3]" value="<?php echo esc_attr( $dp_options['header_video_desc_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[header_video_desc_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_desc_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_desc_shadow_color'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Button setting', 'tcd-w' ); ?></h4>
			<p><?php _e( 'You can set the button, and check "Display button" to set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" name="dp_options[display_header_video_button]" value="1" data-toggle=".toggle-display_header_video_button" <?php checked( $dp_options['display_header_video_button'], 1 ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_header_video_button"<?php if ( ! $dp_options['display_header_video_button'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label for="dp_options[header_video_button_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></td>
						<td><input type="text" id="dp_options[header_video_button_label]" name="dp_options[header_video_button_label]" value="<?php echo esc_attr( $dp_options['header_video_button_label'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_button_font_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_button_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_button_font_color'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_button_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_button_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_button_bg_color'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_button_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['header_video_button_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_button_font_color_hover'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_button_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['header_video_button_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_button_bg_color_hover'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Overlay', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please check "use overlay", and set detail options.', 'tcd-w' ); ?></p>
			<p><label><input type="checkbox" class="display_header_video_overlay" name="dp_options[display_header_video_overlay]" value="1" data-toggle=".toggle-display_header_video_overlay" <?php checked( $dp_options['display_header_video_overlay'], 1 ); ?>><?php _e( 'Display overlay', 'tcd-w' ); ?></label></p>
			<div class="toggle-display_header_video_overlay"<?php if ( ! $dp_options['display_header_video_overlay'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set color and opacity of overlay.', 'tcd-w' ); ?></p>
				<input class="header_video_overlay_color c-color-picker" name="dp_options[header_video_overlay_color]" type="text" value="<?php echo esc_attr( $dp_options['header_video_overlay_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_overlay_color'] ); ?>">
				<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="header_video_overlay_opacity small-text" name="dp_options[header_video_overlay_opacity]" value="<?php echo esc_attr( $dp_options['header_video_overlay_opacity'] ); ?>" min="0" max="1" step="0.1">
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Click or tap the button and background image to move to the link destination.', 'tcd-w' ); ?></p>
			<input class="large-text" type="text" name="dp_options[header_video_link_url]" value="<?php echo esc_attr( $dp_options['header_video_link_url'] ); ?>">
			<p><label><input name="dp_options[header_video_target]" type="checkbox" value="1" <?php checked( 1, $dp_options['header_video_target'] ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
			<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Overlay contents setting for mobile', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<h4 class="theme_option_headline2"><?php _e( 'Slide content type', 'tcd-w' ); ?></h4>
			<fieldset class="cf select_type2">
				<?php foreach ( $slider_content_type_mobile_options as $option ) : ?>
				<label><input type="radio" name="dp_options[header_video_content_type_mobile]" value="<?php echo esc_attr( $option['value'] ); ?>" data-toggle=".header_video_content_type_mobile-<?php echo esc_attr( $option['value'] ); ?>" data-hide="[class*='header_video_content_type_mobile-']" <?php checked( $dp_options['header_video_content_type_mobile'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
				<?php endforeach; ?>
			</fieldset>
			<div class="header_video_content_type_mobile-default"<?php if ( 'default' != $dp_options['header_video_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
				<div class="header_video_content_type-type1"<?php if ( 'type1' != $dp_options['header_video_content_type'] ) echo ' style="display: none;"'; ?>>
					<div class="slider_logo_preview-wrapper" style="display: none;">
						<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
						<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
						<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_logo_width_mobile'] ); ?>" name="dp_options[header_video_logo_width_mobile]" id="header_video_logo_width_mobile">
						<div class="slider_logo_preview slider_logo_preview-mobile header_video_logo_preview header_video_logo_preview-mobile" data-logo-width-input="#header_video_logo_width_mobile" data-logo-img=".header_video_logo img" data-display-overlay=".display_header_video_overlay" data-overlay-color=".header_video_overlay_color" data-overlay-opacity=".header_video_overlay_opacity"></div>
					</div>
				</div>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase Font size for mobile', 'tcd-w' ); ?></h4>
				<p><?php _e( 'You can set catchphrase font size for mobile.', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[header_video_catch_font_size_mobile]" value="<?php echo esc_attr( $dp_options['header_video_catch_font_size_mobile'] ); ?>" min="1"><span>px</span>
				<h4 class="theme_option_headline2"><?php _e( 'Description Font size for mobile', 'tcd-w' ); ?></h4>
				<p><?php _e( 'You can set description font size for mobile.', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[header_video_desc_font_size_mobile]" value="<?php echo esc_attr( $dp_options['header_video_desc_font_size_mobile'] ); ?>" min="1"><span>px</span>
			</div>
			<div class="header_video_content_type_mobile-type1"<?php if ( 'type1' != $dp_options['header_video_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Logo setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set logo image.', 'tcd-w' ); ?></p>
				<p><?php printf( __( 'Recommend image size. Width:%dpx or more, Height:%dpx or more', 'tcd-w' ), 145, 18 ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js header_video_logo_mobile_type1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_logo_mobile_type1'] ); ?>" name="dp_options[header_video_logo_mobile_type1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['header_video_logo_mobile_type1'] ) { echo wp_get_attachment_image( $dp_options['header_video_logo_mobile_type1'], 'full' /* Require full size for logo preview */ ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['header_video_logo_mobile_type1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
				<div class="slider_logo_preview-wrapper" style="display: none;">
					<h4 class="theme_option_headline2"><?php _e( 'Logo preview', 'tcd-w' ); ?></h4>
					<p><?php _e( 'You can change the logo size by moving the mouse cursor over the logo and dragging the arrow. Double-click on the logo to return to the original size.', 'tcd-w' ); ?></p>
					<input type="hidden" value="<?php echo esc_attr( $dp_options['header_video_logo_width_mobile_type1'] ); ?>" name="dp_options[header_video_logo_width_mobile_type1]" id="header_video_logo_width_mobile_type1">
					<div class="slider_logo_preview slider_logo_preview-mobile header_video_logo_preview header_video_logo_preview-mobile" data-logo-width-input="#header_video_logo_width_mobile_type1" data-logo-img=".header_video_logo_mobile_type1 img" data-display-overlay=".display_header_video_overlay_mobile" data-overlay-color=".header_video_overlay_color_mobile" data-overlay-opacity=".header_video_overlay_opacity_mobile"></div>
				</div>
			</div>
			<div class="header_video_content_type_mobile-type2"<?php if ( 'type2' != $dp_options['header_video_content_type_mobile'] ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase setting', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Please set texts for catchphrase, font size, color and align.', 'tcd-w' ); ?></p>
				<p><?php _e( 'The catchphrase set here will be displayed on all slides.', 'tcd-w' ); ?></p>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<textarea rows="2" class="large-text" name="dp_options[header_video_catch_mobile_type2]"><?php echo esc_textarea( $dp_options['header_video_catch_mobile_type2'] ); ?></textarea>
				<table>
					<tr>
						<td colspan="2"><label><input type="checkbox" name="dp_options[header_video_catch_vertical_mobile_type2]" value="1" <?php checked( $dp_options['header_video_catch_vertical_mobile_type2'], 1 ); ?>><?php _e( 'Display as vertical writing', 'tcd-w' ); ?></label></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_font_size_mobile_type2]" value="<?php echo esc_attr( $dp_options['header_video_catch_font_size_mobile_type2'] ); ?>" min="1"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[header_video_catch_color_mobile_type2]" type="text" value="<?php echo esc_attr( $dp_options['header_video_catch_color_mobile_type2'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_catch_color_mobile_type2'] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font type', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[header_video_catch_align_mobile_type2]">
								<?php foreach ( $font_type_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_video_catch_align_mobile_type2'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label><?php _e( 'Text align', 'tcd-w' ); ?></label></td>
						<td>
							<select name="dp_options[header_video_catch_align_mobile_type2]">
								<?php foreach ( $text_align_options as $option ) : ?>
								<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_video_catch_align_mobile_type2'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow1_mobile_type2]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow1_mobile_type2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow2_mobile_type2]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow2_mobile_type2'] ); ?>"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[header_video_catch_shadow3_mobile_type2]" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow3_mobile_type2'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[header_video_catch_shadow_color_mobile_type2]" type="text" value="<?php echo esc_attr( $dp_options['header_video_catch_shadow_color_mobile_type2'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_catch_shadow_color_mobile_type2'] ); ?>"></td>
					</tr>
				</table>
			</div>
			<div class="header_video_content_type_mobile-type1 header_video_content_type_mobile-type2"<?php if ( ! in_array( $dp_options['header_video_content_type_mobile'], array( 'type1', 'type2' ) ) ) echo ' style="display: none;"'; ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Overlay', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Use overlay, to become easy to read the catchphrase on the image. Please check "use overlay", and set detail options.', 'tcd-w' ); ?></p>
				<p><label><input type="checkbox" class="display_header_video_overlay_mobile" name="dp_options[display_header_video_overlay_mobile]" value="1" data-toggle=".toggle-display_header_video_overlay_mobile" <?php checked( $dp_options['display_header_video_overlay_mobile'], 1 ); ?>><?php _e( 'Display overlay', 'tcd-w' ); ?></label></p>
				<div class="toggle-display_header_video_overlay_mobile"<?php if ( ! $dp_options['display_header_video_overlay_mobile'] ) echo ' style="display: none;"'; ?>>
					<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
					<p><?php _e( 'Please set color and opacity of overlay.', 'tcd-w' ); ?></p>
					<input class="header_video_overlay_color_mobile c-color-picker" name="dp_options[header_video_overlay_color_mobile]" type="text" value="<?php echo esc_attr( $dp_options['header_video_overlay_color_mobile'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_video_overlay_color_mobile'] ); ?>">
					<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
					<input type="number" class="header_video_overlay_opacity_mobile small-text" name="dp_options[header_video_overlay_opacity_mobile]" value="<?php echo esc_attr( $dp_options['header_video_overlay_opacity_mobile'] ); ?>" min="0" max="1" step="0.1">
				</div>
			</div>
			<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ニュースティッカーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'News ticker setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'You can set news ticker below header slider.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_index_newsticker]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_newsticker'] ); ?>> <?php _e( 'Display news ticker', 'tcd-w'); ?></label></p>
	
	<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the number of news and display/non-display of date.', 'tcd-w' ); ?></p>
	<p><label><?php _e( 'Post number', 'tcd-w' ); ?><label> <input type="number" class="small-text" name="dp_options[index_newsticker_num]" value="<?php echo esc_attr( $dp_options['index_newsticker_num'] ); ?>" min="1"></p>
	<p><label><input name="dp_options[show_index_newsticker_date]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_newsticker_date'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can set the button to archive page displayed at right of ticker. If you set blank, button is not displayed.', 'tcd-w' ); ?></p>
	<table>
		<tr>
			<td><label><?php _e( 'Archive link text', 'tcd-w' ); ?></label></td>
			<td><input class="regular-text" type="text" name="dp_options[index_newsticker_archive_link_text]" value="<?php echo esc_attr( $dp_options['index_newsticker_archive_link_text'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_newsticker_archive_link_font_color]" type="text" value="<?php echo esc_attr( $dp_options['index_newsticker_archive_link_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_newsticker_archive_link_font_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_newsticker_archive_link_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['index_newsticker_archive_link_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_newsticker_archive_link_bg_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_newsticker_archive_link_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['index_newsticker_archive_link_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_newsticker_archive_link_font_color_hover'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[index_newsticker_archive_link_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['index_newsticker_archive_link_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['index_newsticker_archive_link_bg_color_hover'] ); ?>"></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'News ticker interval seconds', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set news ticker interval seconds. (3 to 15 seconds)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[index_newsticker_slide_time_seconds]" value="<?php echo esc_attr( $dp_options['index_newsticker_slide_time_seconds'] ); ?>" min="3" max="15"> <?php _e( ' seconds', 'tcd-w' ); ?>
	<input type="submit" class="button-ml ajax_button" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php
// コンテンツビルダー
cb_inputs();
?>
