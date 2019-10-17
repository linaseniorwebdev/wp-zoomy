<?php
global $dp_options, $notify_schedule_type_options, $wp_locale;
?>
<div class="theme_option_message" style="margin-top: 0;">
    <p><?php _e( 'When using this function, recommend Cron setting to access wp-cron.php on the server. If you do not set Cron, time may be lost or processing may not be executed.)', 'tcd-w' ); ?></p>
    <p><?php _e( 'Cron is runs programs periodically. Please check the setting manual / support etc of your server setting.', 'tcd-w' ); ?></p>
    <p><?php _e( 'Depending on the server and plan, it may not be available', 'tcd-w' ); ?></p>
</div>
<?php // 会員お知らせ通知 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Member news nofity settings', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Notify the member news added after the last notification.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[membership][use_member_news_notify]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_member_news_notify'] ); ?>><?php _e( 'Use "Member News Notify"', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Member news nofity label', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][member_news_notify_label]" value="<?php echo esc_attr( $dp_options['membership']['member_news_notify_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Nofity schedule', 'tcd-w' ); ?></h4>
	<fieldset>
		<p>
			<label><input type="radio" name="dp_options[membership][member_news_notify_schedule_type]" value="type1" data-toggle-reverse=".member_news_notify_schedule_type4" <?php checked( 'type1', $dp_options['membership']['member_news_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type1']['label'] ); ?></label>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][member_news_notify_schedule_type]" value="type2" data-toggle-reverse=".member_news_notify_schedule_type4" <?php checked( 'type2', $dp_options['membership']['member_news_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type2']['label'] ); ?></label>
			<input class="small-text" type="number" name="dp_options[membership][member_news_notify_schedule_type2]" value="<?php echo esc_attr( $dp_options['membership']['member_news_notify_schedule_type2'] ); ?>"> <?php _e( 'days interval', 'tcd-w' ); ?>
			<small class="description"><?php _e( 'When set 1 days, same as everyday.', 'tcd-w' ); ?></small>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][member_news_notify_schedule_type]" value="type3" data-toggle-reverse=".member_news_notify_schedule_type4" <?php checked( 'type3', $dp_options['membership']['member_news_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type3']['label'] ); ?></label>
			<select name="dp_options[membership][member_news_notify_schedule_type3]">
<?php
	for ( $i = 0; $i <= 6; $i++ ) :
		echo '<option value="' . esc_attr( $i ) . '" ' . selected( $i, $dp_options['membership']['member_news_notify_schedule_type3'], false ) . '>' . $wp_locale->get_weekday( $i ) . '</option>';
	endfor;
?>
			</select>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][member_news_notify_schedule_type]" value="type4" <?php checked( 'type4', $dp_options['membership']['member_news_notify_schedule_type'] ); ?> data-toggle=".member_news_notify_schedule_type4"><?php echo esc_html( $notify_schedule_type_options['type4']['label'] ); ?></label>
		</p>
		<div class="member_news_notify_schedule_type4 p-select-days">
<?php
	for ( $i = 1; $i <= 31; $i++ ) :
		echo '<label><input type="checkbox" name="dp_options[membership][member_news_notify_schedule_type4][]" value="' . esc_attr( $i ) . '"' . ( in_array( $i, $dp_options['membership']['member_news_notify_schedule_type4'] ) ? ' checked="checked"' : '' ) . '><br>' . esc_html( $i ) . '</label>';
	endfor;
?>
		</div>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Nofity time', 'tcd-w' ); ?></h4>
	<p>
		<select name="dp_options[membership][member_news_notify_hour]">
<?php
	for ( $i = 0; $i <= 23; $i++ ) :
		$j = sprintf( '%02d' , $i );
		echo '<option value="' . esc_attr( $j ) . '" ' . selected( $j, $dp_options['membership']['member_news_notify_hour'], false ) . '>' . $j . '</option>';
	endfor;
?>
		</select> : 
		<select name="dp_options[membership][member_news_notify_minute]">
<?php
	for ( $i = 0; $i <= 59; $i++ ) :
		$j = sprintf( '%02d' , $i );
		echo '<option value="' . esc_attr( $j ) . '" ' . selected( $j, $dp_options['membership']['member_news_notify_minute'], false ) . '>' . $j . '</option>';
	endfor;
?>
		</select>
	</p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // いいねお知らせ通知 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Follow/Like/Comment nofity settings', 'tcd-w' ); ?></h3>
    <p><?php _e( 'Notify the Follow/Like/Comment added after the last notification.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[membership][use_social_notify]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_social_notify'] ); ?>><?php _e( 'Use "Follow/Like/Comment Notify"', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Follow/Like/Comment nofity label', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[membership][social_notify_label]" value="<?php echo esc_attr( $dp_options['membership']['social_notify_label'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Nofity schedule', 'tcd-w' ); ?></h4>
	<fieldset>
		<p>
			<label><input type="radio" name="dp_options[membership][social_notify_schedule_type]" value="type1" data-toggle-reverse=".social_notify_schedule_type4" <?php checked( 'type1', $dp_options['membership']['social_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type1']['label'] ); ?></label>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][social_notify_schedule_type]" value="type2" data-toggle-reverse=".social_notify_schedule_type4" <?php checked( 'type2', $dp_options['membership']['social_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type2']['label'] ); ?></label>
			<input class="small-text" type="number" name="dp_options[membership][social_notify_schedule_type2]" value="<?php echo esc_attr( $dp_options['membership']['social_notify_schedule_type2'] ); ?>"> <?php _e( 'days interval', 'tcd-w' ); ?>
			<small class="description"><?php _e( 'When set 1 days, same as everyday.', 'tcd-w' ); ?></small>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][social_notify_schedule_type]" value="type3" data-toggle-reverse=".social_notify_schedule_type4" <?php checked( 'type3', $dp_options['membership']['social_notify_schedule_type'] ); ?>><?php echo esc_html( $notify_schedule_type_options['type3']['label'] ); ?></label>
			<select name="dp_options[membership][social_notify_schedule_type3]">
<?php
	for ( $i = 0; $i <= 6; $i++ ) :
		echo '<option value="' . esc_attr( $i ) . '" ' . selected( $i, $dp_options['membership']['social_notify_schedule_type3'], false ) . '>' . $wp_locale->get_weekday( $i ) . '</option>';
	endfor;
?>
			</select>
		</p>
		<p>
			<label><input type="radio" name="dp_options[membership][social_notify_schedule_type]" value="type4" <?php checked( 'type4', $dp_options['membership']['social_notify_schedule_type'] ); ?> data-toggle=".social_notify_schedule_type4"><?php echo esc_html( $notify_schedule_type_options['type4']['label'] ); ?></label>
		</p>
		<div class="social_notify_schedule_type4 p-select-days">
<?php
	for ( $i = 1; $i <= 31; $i++ ) :
		echo '<label><input type="checkbox" name="dp_options[membership][social_notify_schedule_type4][]" value="' . esc_attr( $i ) . '"' . ( in_array( $i, $dp_options['membership']['social_notify_schedule_type4'] ) ? ' checked="checked"' : '' ) . '><br>' . esc_html( $i ) . '</label>';
	endfor;
?>
		</div>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Nofity time', 'tcd-w' ); ?></h4>
	<p>
		<select name="dp_options[membership][social_notify_hour]">
<?php
	for ( $i = 0; $i <= 23; $i++ ) :
		$j = sprintf( '%02d' , $i );
		echo '<option value="' . esc_attr( $j ) . '" ' . selected( $j, $dp_options['membership']['social_notify_hour'], false ) . '>' . $j . '</option>';
	endfor;
?>
		</select> : 
		<select name="dp_options[membership][social_notify_minute]">
<?php
	for ( $i = 0; $i <= 59; $i++ ) :
		$j = sprintf( '%02d' , $i );
		echo '<option value="' . esc_attr( $j ) . '" ' . selected( $j, $dp_options['membership']['social_notify_minute'], false ) . '>' . $j . '</option>';
	endfor;
?>
		</select>
	</p>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
