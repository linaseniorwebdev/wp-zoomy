<?php
global $dp_options, $dp_default_options, $header_bar_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーバーの表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header bar setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the display position of the header bar.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_bar_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_bar]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['header_bar'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
</div>
<?php // ヘッダーバーの表示設定（スマホ）?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header bar setting for mobile device', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the display position of the header bar for mobile.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_bar_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_bar_mobile]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['header_bar_mobile'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 投稿画像のヘッダーバーの表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header bar in photo page setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the display position of the header bar in photo page.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_bar_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_bar_photo]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['header_bar_photo'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
</div>
<?php // 投稿画像のヘッダーバーの表示設定（スマホ）?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header bar in photo page setting for mobile device', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the display position of the header bar in photo page for mobile.', 'tcd-w' ); ?></p>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_bar_options as $option ) : ?>
		<label><input type="radio" name="dp_options[header_bar_photo_mobile]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['header_bar_photo_mobile'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーバーの色の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Color of header', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Background color setting', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the background color of header bar.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_bg]" type="text" value="<?php echo esc_attr( $dp_options['header_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_bg'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Opacity of background', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 1.0)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[header_opacity]" value="<?php echo esc_attr( $dp_options['header_opacity'] ); ?>" min="0" max="1" step="0.1">
	<h4 class="theme_option_headline2"><?php _e( 'Opacity of background for sticky header bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[header_opacity_fixed]" value="<?php echo esc_attr( $dp_options['header_opacity_fixed'] ); ?>" min="0" max="1" step="0.1">
	<h4 class="theme_option_headline2"><?php _e( 'Text color setting', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the font color of header bar.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_font_color]" type="text" value="<?php echo esc_attr( $dp_options['header_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Link hover color setting', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set the hover font color of header bar link.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[header_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['header_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['header_font_color_hover'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ドロップダウンメンバーメニュー設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mypage menu setting', 'tcd-w' ); ?></h3>
    <h4 class="theme_option_headline2"><?php _e( 'Mypage menu font color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set font color of mypage menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[membermenu_font_color]" type="text" value="<?php echo esc_attr( $dp_options['membermenu_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membermenu_font_color'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Mypage menu font color on hover', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set hover font color of mypage menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[membermenu_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['membermenu_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membermenu_font_color_hover'] ); ?>">

	<h4 class="theme_option_headline2"><?php _e( 'Unread news number font color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set font color of unread news number.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[membermenu_badge_font_color]" type="text" value="<?php echo esc_attr( $dp_options['membermenu_badge_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membermenu_badge_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Unread news number background color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set background color of unread news number.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[membermenu_badge_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['membermenu_badge_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membermenu_badge_bg_color'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Mypage menu background color', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Please set background color of mypage menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[membermenu_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['membermenu_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['membermenu_bg_color'] ); ?>">
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // サイドメニュー設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Side menu setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Side menu font color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set font color of side menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[sidemenu_font_color]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['sidemenu_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Side menu font color on hover', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set hover font color of side menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[sidemenu_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['sidemenu_font_color_hover'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Side menu title font color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set font color of side menu title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[sidemenu_title_font_color]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_title_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['sidemenu_title_font_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Side menu title background color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set background color of side menu title.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[sidemenu_title_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_title_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['sidemenu_title_bg_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Side menu background color', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please set background color of side menu.', 'tcd-w' ); ?></p>
	<input class="c-color-picker" name="dp_options[sidemenu_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['sidemenu_bg_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please check items to display.', 'tcd-w' ); ?></p>
	<ul>
		<li>
			<label><input name="dp_options[show_sidemenu_category]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_sidemenu_category'] ); ?>> <?php _e( 'Display category', 'tcd-w' ); ?></label>
			<div style="margin-left: 26px">
				<label><?php _e( 'Category label:', 'tcd-w' ); ?></label>
				<input class="regular-text" name="dp_options[sidemenu_category_label]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_category_label'] ); ?>">
				<br>
				<label><?php _e( 'Categories To Exclude:', 'tcd-w' ); ?></label>
				<input class="regular-text" name="dp_options[sidemenu_category_exclude]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_category_exclude'] ); ?>">
				<br>
				<small class="description"><?php _e( 'Enter a comma-seperated list of category ID numbers, example 2,4,10', 'tcd-w' ); ?></small>
			</div>
		</li>
		<li>
			<label><input name="dp_options[show_sidemenu_photo_category]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_sidemenu_photo_category'] ); ?>> <?php _e( 'Display photo category', 'tcd-w' ); ?></label>
			<div style="margin-left: 26px">
				<label><?php _e( 'Photo category label:', 'tcd-w' ); ?></label>
				<input class="regular-text" name="dp_options[sidemenu_photo_category_label]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_photo_category_label'] ); ?>">
				<br>
				<label><?php _e( 'Categories To Exclude:', 'tcd-w' ); ?></label>
				<input class="regular-text" name="dp_options[sidemenu_photo_category_exclude]" type="text" value="<?php echo esc_attr( $dp_options['sidemenu_photo_category_exclude'] ); ?>">
				<br>
				<small class="description"><?php _e( 'Enter a comma-seperated list of category ID numbers, example 2,4,10', 'tcd-w' ); ?></small>
				<br>
				<label><input name="dp_options[sidemenu_photo_category_show_first]" type="checkbox" value="1" <?php checked( '1', $dp_options['sidemenu_photo_category_show_first'] ); ?>> <?php _e( 'Display photo category before category', 'tcd-w' ); ?></label>
			</div>
		</li>
		<li><label><input name="dp_options[show_sidemenu_globalmenu]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_sidemenu_globalmenu'] ); ?>> <?php _e( 'Display global menu', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sidemenu_search]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_sidemenu_search'] ); ?>> <?php _e( 'Display search form', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sidemenu_widget]" type="checkbox" value="1" <?php checked( '1', $dp_options['show_sidemenu_widget'] ); ?>> <?php _e( 'Display side menu widget', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml ajax_button" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
