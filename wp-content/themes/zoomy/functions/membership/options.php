<?php

// ゲストアクセス許可選択肢
global $guest_permission_options, $guest_permission_options2;
$guest_permission_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Guest can not browse %s archive and %s single page, require login.', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Guest can browse %s archive page, %s single page require login.', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Guest can browse %s archive and %s single page.', 'tcd-w' )
	)
);
$guest_permission_options2 = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Guest can not browse %s archive, require login.', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Guest can browse %s archive page.', 'tcd-w' )
	)
);

// 通知間隔選択肢
global $notify_schedule_type_options;
$notify_schedule_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Everyday', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Days interval', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Day of the week', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Select days', 'tcd-w' )
	)
);

// 通知間隔選択肢
global $notify_schedule_type_options;
$notify_schedule_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Everyday', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Days interval', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Day of the week', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Select days', 'tcd-w' )
	)
);

// ログイン中フッターの固定メニュー 表示タイプ
global $loggedin_footer_bar_display_options;
$loggedin_footer_bar_display_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Display normal footer bar', 'tcd-w' ) )
);

/**
 * オプション初期値
 */
global $dp_default_options;
$dp_default_options['membership'] = array(

	// basic
	'use_follow' => 1,
	'use_mail_magazine' => 1,
	'disable_wp_login_php' => 1,
	'users_can_register' => get_option( 'users_can_register' ) ? 1 : 0,

	// forbidden_words
	'forbidden_words' => '',

	// intormation
	'guest_permission_information' => 'type1',

	// profile
	'guest_permission_profile' => 'type1',

	// report
	'report_label' => __( 'Report to administrator', 'tcd-w' ),
	'report_desc' => __( 'Would you report inappropriate article, photo usage or violation?', 'tcd-w' ),
	'report_button_label' => __( 'Report to administrator', 'tcd-w' ),
	'report_complete_headline' => __( 'Report completed', 'tcd-w' ),
	'report_complete_desc' => __( 'Report completed.', 'tcd-w' ),

	// logged-in footer bar
	'loggedin_footer_bar_display' => 'type2',
	'loggedin_footer_bar_tp' => 0.8,
	'loggedin_footer_bar_bg' => '#000000',
	'loggedin_footer_bar_border' => '#666666',
	'loggedin_footer_bar_color' => '#ffffff',

	// blog
	'use_front_edit_blog' => 1,
	'use_front_edit_blog_pending' => 0,
	'pending_label' => __( 'Pending', 'tcd-w' ),
	'use_like_blog' => 1,
	'guest_permission_blog' => 'type1',
	'add_blog_note' => '',
	'edit_blog_note' => '',
	'edit_blog_complete_publish_headline' => sprintf( __( '%s was published.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_publish_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_private_headline' => sprintf( __( '%s saved as private.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_private_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_pending_headline' => sprintf( __( '%s saved as pending.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_pending_desc' => __( 'It will be publish after review by administrator.', 'tcd-w' ),
	'edit_blog_complete_draft_headline' => sprintf( __( '%s saved as draft.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_draft_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_update_headline' => sprintf( __( '%s updated.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),
	'edit_blog_complete_update_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Blog', 'tcd-w' ) ),

	// photo
	'use_front_edit_photo' => 1,
	'use_front_edit_photo_pending' => 0,
	'use_like_photo' => 1,
	'guest_permission_photo' => 'type1',
	'add_photo_note' => '',
	'edit_photo_note' => '',
	'edit_photo_complete_publish_headline' => sprintf( __( '%s was published.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_publish_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_private_headline' => sprintf( __( '%s saved as private.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_private_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_pending_headline' => sprintf( __( '%s saved as pending.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_pending_desc' => __( 'It will be publish after review by administrator.', 'tcd-w' ),
	'edit_photo_complete_draft_headline' => sprintf( __( '%s saved as draft.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_draft_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_update_headline' => sprintf( __( '%s updated.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),
	'edit_photo_complete_update_desc' => sprintf( __( 'You can edit / delete %s from the profile page.', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ),

	// user_form
	'login_form_desc' => '',
	'registration_headline' => __( 'Registration', 'tcd-w' ),
	'registration_desc' => __( 'When account created, You agreed to the term of service.', 'tcd-w' ),
	'registration_complete_headline' => __( 'Registration complete', 'tcd-w' ),
	'registration_complete_desc' => __( "Sent email to [user_email].\nPlease read email and registration account.", 'tcd-w' ),
	'registration_account_headline' => __( 'Registration Account', 'tcd-w' ),
	'registration_account_desc' => '',
	'registration_account_complete_headline' => '',
	'registration_account_complete_desc' => '',
	'login_registration_desc' => __( 'If you are not a member please register as a member.', 'tcd-w' ),
	'login_registration_button_label' => __( 'Registration here.', 'tcd-w' ),
	'show_account_area' => 1,
	'show_account_gender' => 1,
	'show_account_birthday' => 1,
	'show_profile_area' => 1,
	'show_profile_desc' => 1,
	'show_profile_job' => 1,
	'show_profile_website' => 1,
	'show_profile_twitter' => 1,
	'show_profile_instagram' => 1,
	'show_profile_facebook' => 1,
	'area_label' => __( 'Residence area', 'tcd-w' ),
	'area' => tcd_membership_options_area_default(),

	// mypage
	'memberpage_page_id' => 0,
	'mypage_headline_news' => __( 'News', 'tcd-w' ),
	'mypage_headline_add_photo' => __( 'Add photo', 'tcd-w' ),
	'mypage_headline_add_blog' => __( 'Add blog', 'tcd-w' ),
	'mypage_headline_profile' => __( 'Profile', 'tcd-w' ),
	'mypage_headline_account' => __( 'Account', 'tcd-w' ),
	'mypage_news_num' => 10,
	'mypage_ad_code1' => '',
	'mypage_ad_image1' => false,
	'mypage_ad_url1' => '',
	'mypage_ad_code2' => '',
	'mypage_ad_image2' => false,
	'mypage_ad_url2' => '',
	'mypage_ad_code3' => '',
	'mypage_ad_image3' => false,
	'mypage_ad_url3' => '',
	'mypage_ad_code4' => '',
	'mypage_ad_image4' => false,
	'mypage_ad_url4' => '',
	'mypage_ad_mobile_code1' => '',
	'mypage_ad_mobile_image1' => false,
	'mypage_ad_mobile_url1' => '',
	'mypage_ad_mobile_code2' => '',
	'mypage_ad_mobile_image2' => false,
	'mypage_ad_mobile_url2' => '',

	// notify
	'use_member_news_notify' => 1,
	'member_news_notify_label' => __( 'Member news notify', 'tcd-w' ),
	'member_news_notify_schedule_type' => 'type1',
	'member_news_notify_schedule_type2' => 2,
	'member_news_notify_schedule_type3' => 0,
	'member_news_notify_schedule_type4' => array( 1, 15 ),
	'member_news_notify_hour' => '12',
	'member_news_notify_minute' => '00',
	'use_social_notify' => 1,
	'social_notify_label' => __( 'Follow/Like/Comment notify', 'tcd-w' ),
	'social_notify_schedule_type' => 'type1',
	'social_notify_schedule_type2' => 2,
	'social_notify_schedule_type3' => 0,
	'social_notify_schedule_type4' => array( 1, 15 ),
	'social_notify_hour' => '12',
	'social_notify_minute' => '00',

	// mail
	'mail_from_email' => get_bloginfo( 'admin_email' ),
	'mail_from_name' => get_bloginfo( 'name' ),
	'mail_registration_subject' => __( 'Provisional registration is completed / [blog_name]', 'tcd-w' ),
	'mail_registration_body' => tcd_membership_options_mail_body_default( 'registration' ),
	'mail_registration_account_subject' => __( 'Registration is completed / [blog_name]', 'tcd-w' ),
	'mail_registration_account_body' => tcd_membership_options_mail_body_default( 'registration_account' ),
	'mail_registration_account_admin_to' => get_bloginfo( 'admin_email' ),
	'mail_registration_account_admin_subject' => __( 'New registration / [blog_name]', 'tcd-w' ),
	'mail_registration_account_admin_body' => tcd_membership_options_mail_body_default( 'registration_account_admin' ),
	'mail_reset_password_subject' => __( 'Password reissue / [blog_name]', 'tcd-w' ),
	'mail_reset_password_body' => tcd_membership_options_mail_body_default( 'reset_password' ),
	'mail_withdraw_subject' => __( 'Withdrawal is completed / [blog_name]', 'tcd-w' ),
	'mail_withdraw_body' => tcd_membership_options_mail_body_default( 'withdraw' ),
	'mail_withdraw_admin_to' => get_bloginfo( 'admin_email' ),
	'mail_withdraw_admin_subject' => __( 'Withdrawal / [blog_name]', 'tcd-w' ),
	'mail_withdraw_admin_body' => tcd_membership_options_mail_body_default( 'withdraw_admin' ),
	'mail_report_to' => get_bloginfo( 'admin_email' ),
	'mail_report_subject' => __( 'Report / [blog_name]', 'tcd-w' ),
	'mail_report_body' => tcd_membership_options_mail_body_default( 'report' ),
	'mail_member_news_notify_subject' => __( 'New information / [blog_name]', 'tcd-w' ),
	'mail_member_news_notify_body' => tcd_membership_options_mail_body_default( 'member_news_notify' ),
	'mail_social_notify_subject' => __( 'Notification / [blog_name]', 'tcd-w' ),
	'mail_social_notify_body' => tcd_membership_options_mail_body_default( 'social_notify' )
);

/**
 * 住まいのデフォルト値を返す
 */
function tcd_membership_options_area_default() {
	if ( in_array( strtolower( get_locale() ), array( 'ja', 'ja_jp' ) ) ) {
		return <<< EOM
北海道
青森県
岩手県
宮城県
秋田県
山形県
福島県
茨城県
栃木県
群馬県
埼玉県
千葉県
東京都
神奈川県
新潟県
富山県
石川県
福井県
山梨県
長野県
岐阜県
静岡県
愛知県
三重県
滋賀県
京都府
大阪府
兵庫県
奈良県
和歌山県
鳥取県
島根県
岡山県
広島県
山口県
徳島県
香川県
愛媛県
高知県
福岡県
佐賀県
長崎県
熊本県
大分県
宮崎県
鹿児島県
沖縄県
EOM;
	} else {
		return <<< EOM
Afghanistan
Albania
Algeria
Andorra
Angola
Antigua and Barbuda
Argentina
Armenia
Australia
Austria
Azerbaijan
Bahamas
Bahrain
Bangladesh
Barbados
Belarus
Belgium
Belize
Benin
Bhutan
Bolivia
Bosnia and Herzegovina
Botswana
Brazil
Brunei Darussalam
Bulgaria
Burkina Faso
Burundi
Cabo Verde
Cambodia
Cameroon
Canada
Central African Republic
Chad
Chile
China
Colombia
Comoros
Congo
Costa Rica
Côte D'Ivoire
Croatia
Cuba
Cyprus
Czech Republic
Democratic People's Republic of Korea
Democratic Republic of the Congo
Denmark
Djibouti
Dominica
Dominican Republic
Ecuador
Egypt
El Salvador
Equatorial Guinea
Eritrea
Estonia
Eswatini
Ethiopia
Fiji
Finland
France
Gabon
Gambia
Georgia
Germany
Ghana
Greece
Grenada
Guatemala
Guinea
Guinea Bissau
Guyana
Haiti
Honduras
Hungary
Iceland
India
Indonesia
Iran
Iraq
Ireland
Israel
Italy
Jamaica
Japan
Jordan
Kazakhstan
Kenya
Kiribati
Kuwait
Kyrgyzstan
Lao People's Democratic Republic
Latvia
Lebanon
Lesotho
Liberia
Libya
Liechtenstein
Lithuania
Luxembourg
Madagascar
Malawi
Malaysia
Maldives
Mali
Malta
Marshall Islands
Mauritania
Mauritius
Mexico
Micronesia
Monaco
Mongolia
Montenegro
Morocco
Mozambique
Myanmar
Namibia
Nauru
Nepal
Netherlands
New Zealand
Nicaragua
Niger
Nigeria
Norway
Oman
Pakistan
Palau
Panama
Papua New Guinea
Paraguay
Peru
Philippines
Poland
Portugal
Qatar
Republic of Korea
Republic of Moldova
Romania
Russian Federation
Rwanda
Saint Kitts and Nevis
Saint Lucia
Saint Vincent and the Grenadines
Samoa
San Marino
Sao Tome and Principe
Saudi Arabia
Senegal
Serbia
Seychelles
Sierra Leone
Singapore
Slovakia
Slovenia
Solomon Islands
Somalia
South Africa
South Sudan
Spain
Sri Lanka
Sudan
Suriname
Sweden
Switzerland
Syrian Arab Republic
Tajikistan
Thailand
The former Yugoslav Republic of Macedonia
Timor-Leste
Togo
Tonga
Trinidad and Tobago
Tunisia
Turkey
Turkmenistan
Tuvalu
Uganda
Ukraine
United Arab Emirates
United Kingdom of Great Britain and Northern Ireland
United Republic of Tanzania
United States of America
Uruguay
Uzbekistan
Vanuatu
Venezuela, Bolivarian Republic of
Viet Nam
Yemen
Zambia
Zimbabwe
EOM;
	}
}
/**
 * メー本文のデフォルト値を返す
 */
function tcd_membership_options_mail_body_default( $type ) {
	switch ( $type ) {
		case 'registration' :
			return __( 'Dear [user_email],

This mail is delivered to those who were newly registered in [blog_name].

Your provisional registration is complete.

Please access the following URL and proceed with registration within 24hours.
[registration_account_url]', 'tcd-w' );
			break;

		case 'registration_account' :
			return __( 'Dear [user_display_name],

Thank you for registering for [blog_name].

Your registration is complete.

E-Mail address: [user_email]
Password: ******** (Do not display for personal information)
Login URL: [login_url]

If you forgot your password, you can reissue it at the URL below.
[reset_password_url]

We are looling forward to you enjoying [blog_name].', 'tcd-w' );
			break;

		case 'registration_account_admin' :
			return __( 'You can find the new registration below.

-----
User name: [user_display_name]
E-Mail address: [user_email]
Profile page URL: [author_url]', 'tcd-w' );
			break;

		case 'reset_password' :
			return __( 'Dear [user_display_name],

Thank you very much for using [blog_name].

You can reissue your password to access the URL below within 24hours.
[reset_password_url]

Sincerely, [blog_name]', 'tcd-w' );
			break;

		case 'withdraw' :
			return __( 'Dear [user_display_name],

We notify you of the completion of withdrawal from [blog_name].
Thank you for using [blog_name].
We hope to see you again.

Sincerely, [blog_name]', 'tcd-w' );
			break;

		case 'withdraw_admin' :
			return __( 'We notify you of a withdrawal from [blog_name].

-----
User name: [user_display_name]
E-Mail address: [user_email]', 'tcd-w' );
			break;

		case 'report' :
			return __( 'We will notify you of a new report.

-----
URL: [post_url]
User: [user_display_name]
Comment: [report_comment]', 'tcd-w' );
			break;

		case 'member_news_notify' :
			return __( 'Dear [user_display_name],

Thank you for using [blog_name].

We will notify you of new information.
Please check the URL below.
[mypage_news_url]

Sincerely, [blog_name]', 'tcd-w' );
			break;

		case 'social_notify' :
			return __( 'Dear [user_display_name],

Thank you for using [blog_name].

We will notify you below.
[has_likes_count]New Likes: [likes_count]
[/has_likes_count][has_comments_count]New Comments: [comments_count]
[/has_comments_count][has_follows_count]
New followers: [follows_count]
[/has_follows_count]

Please check the URL below.
[mypage_news_url]

Sincerely, [blog_name]', 'tcd-w' );
			break;

		default:
			return '';
			break;
	}
}

/**
 * TCD Membership設定フォーム
 */
function tcd_membership_options_do_page() {
	global $dp_options;

	$tabs = array(
		// 基本設定
		array(
			'label' => __( 'Basic', 'tcd-w' ),
			'template_part' => 'functions/membership/inc/basic'
		),
		// Blog
		array(
			'label' => $dp_options['blog_label'],
			'template_part' => 'functions/membership/inc/blog'
		),
		// Photo
		array(
			'label' => $dp_options['photo_label'],
			'template_part' => 'functions/membership/inc/photo'
		),
		// 会員フォーム設定
		array(
			'label' => __( 'User form', 'tcd-w' ),
			'template_part' => 'functions/membership/inc/user_form'
		),
		// マイページ設定
		array(
			'label' => __( 'Mypage', 'tcd-w' ),
			'template_part' => 'functions/membership/inc/mypage'
		),
		// 通知設定
		array(
			'label' => __( 'Notify', 'tcd-w' ),
			'template_part' => 'functions/membership/inc/notify'
		),
		// メール設定
		array(
			'label' => __( 'Mail', 'tcd-w' ),
			'template_part' => 'functions/membership/inc/mail'
		)
	);

?>
<div class="wrap">
	<h2><?php _e( 'TCD Membership Options', 'tcd-w' ); ?></h2>
<?php
	// 更新時のメッセージ
	if ( ! empty( $_REQUEST['settings-updated'] ) ) :
?>
	<div class="updated fade">
		<p><strong><?php _e( 'Updated', 'tcd-w' ); ?></strong></p>
	</div>
<?php
	endif;
?>
	<div id="tcd_membership_option" class="tcd_theme_option cf">
		<div id="tcd_theme_left">
			<ul id="theme_tab" class="cf">
<?php
	foreach ( $tabs as $key => $tab ):
?>
				<li><a href="#tab-content<?php echo esc_attr( $key + 1 ); ?>"><?php echo esc_html( $tab['label'] ); ?></a></li>
<?php
	endforeach;
?>
			</ul>
		</div>
		<div id="tcd_theme_right">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<input type="hidden" name="tcd_membership_options" value="1" >
<?php
	settings_fields( 'design_plus_options' );
?>
				<div id="tab-panel">
<?php
	foreach ( $tabs as $key => $tab ):
?>
					<div id="#tab-content<?php echo esc_attr( $key + 1 ); ?>">
<?php
		if ( !empty( $tab['template_part'] ) ) :
			get_template_part( $tab['template_part'] );
		endif;
?>
					</div>
<?php
	endforeach;
?>
				</div><!-- END #tab-panel -->
			</form>
			<div id="saved_data"></div>
			<div id="saving_data" style="display:none;"><p><?php _e( 'Now saving...', 'tcd-w' ); ?></p></div>
		</div><!-- END #tcd_theme_right -->
	</div><!-- END #tcd_theme_option -->
</div><!-- END #wrap -->
<?php
}

/**
 * TCD Membership設定フォーム バリデート theme_options_validate()内から呼び出されるので注意
 */
function tcd_membership_options_validate( $input ) {
	global $dp_default_options, $guest_permission_options, $guest_permission_options2, $gender_options, $receive_options, $notify_options, $notify_schedule_type_options, $loggedin_footer_bar_display_options;

	// basic
	$input['membership']['use_follow'] = ! empty( $input['membership']['use_follow'] ) ? 1 : 0;
	$input['membership']['use_mail_magazine'] = ! empty( $input['membership']['use_mail_magazine'] ) ? 1 : 0;
	$input['membership']['disable_wp_login_php'] = ! empty( $input['membership']['disable_wp_login_php'] ) ? 1 : 0;
	$input['membership']['users_can_register'] = ! empty( $input['membership']['users_can_register'] ) ? 1 : 0;

	// forbidden_words
	$input['membership']['forbidden_words'] = $input['membership']['forbidden_words'];

	// intormation
	if ( ! isset( $input['membership']['guest_permission_information'] ) || ! array_key_exists( $input['membership']['guest_permission_information'], $guest_permission_options2 ) )
		$input['membership']['guest_permission_information'] = $dp_default_options['membership']['guest_permission_information'];

	// profile
	if ( ! isset( $input['membership']['guest_permission_profile'] ) || ! array_key_exists( $input['membership']['guest_permission_profile'], $guest_permission_options ) )
		$input['membership']['guest_permission_profile'] = $dp_default_options['membership']['guest_permission_profile'];

	// report
	$input['membership']['report_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['report_label'] ) );
	$input['membership']['report_desc'] = $input['membership']['report_desc'];
	$input['membership']['report_button_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['report_button_label'] ) );
	$input['membership']['report_complete_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['report_complete_headline'] ) );
	$input['membership']['report_complete_desc'] = $input['membership']['report_complete_desc'];

	// logged-in footer bar
	if ( ! isset( $input['membership']['loggedin_footer_bar_display'] ) || ! array_key_exists( $input['membership']['loggedin_footer_bar_display'], $loggedin_footer_bar_display_options ) )
		$input['membership']['loggedin_footer_bar_display'] = 'type3';
	$input['membership']['loggedin_footer_bar_bg'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['loggedin_footer_bar_bg'] ) );
	$input['membership']['loggedin_footer_bar_border'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['loggedin_footer_bar_border'] ) );
	$input['membership']['loggedin_footer_bar_color'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['loggedin_footer_bar_color'] ) );
	$input['membership']['loggedin_footer_bar_tp'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['loggedin_footer_bar_tp'] ) );

	// blog
	$input['membership']['use_front_edit_blog'] = ! empty( $input['membership']['use_front_edit_blog'] ) ? 1 : 0;
	$input['membership']['use_front_edit_blog_pending'] = ! empty( $input['membership']['use_front_edit_blog_pending'] ) ? 1 : 0;
	$input['membership']['pending_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['pending_label'] ) );
	$input['membership']['use_like_blog'] = ! empty( $input['membership']['use_like_blog'] ) ? 1 : 0;
	if ( ! isset( $input['membership']['guest_permission_blog'] ) || ! array_key_exists( $input['membership']['guest_permission_blog'], $guest_permission_options ) )
		$input['membership']['guest_permission_blog'] = $dp_default_options['membership']['guest_permission_profile'];
	$input['membership']['add_blog_note'] = $input['membership']['add_blog_note'];
	$input['membership']['edit_blog_note'] = $input['membership']['edit_blog_note'];
	$input['membership']['edit_blog_complete_publish_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_blog_complete_publish_headline'] ) );
	$input['membership']['edit_blog_complete_publish_desc'] = $input['membership']['edit_blog_complete_publish_desc'];
	$input['membership']['edit_blog_complete_private_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_blog_complete_private_headline'] ) );
	$input['membership']['edit_blog_complete_private_desc'] = $input['membership']['edit_blog_complete_private_desc'];
	$input['membership']['edit_blog_complete_pending_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_blog_complete_pending_headline'] ) );
	$input['membership']['edit_blog_complete_pending_desc'] = $input['membership']['edit_blog_complete_pending_desc'];
	$input['membership']['edit_blog_complete_draft_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_blog_complete_draft_headline'] ) );
	$input['membership']['edit_blog_complete_draft_desc'] = $input['membership']['edit_blog_complete_draft_desc'];
	$input['membership']['edit_blog_complete_update_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_blog_complete_update_headline'] ) );
	$input['membership']['edit_blog_complete_update_desc'] = $input['membership']['edit_blog_complete_update_desc'];

	// photo
	$input['membership']['use_front_edit_photo'] = ! empty( $input['membership']['use_front_edit_photo'] ) ? 1 : 0;
	$input['membership']['use_front_edit_photo_pending'] = ! empty( $input['membership']['use_front_edit_photo_pending'] ) ? 1 : 0;
	$input['membership']['use_like_photo'] = ! empty( $input['membership']['use_like_photo'] ) ? 1 : 0;
	if ( ! isset( $input['membership']['guest_permission_photo'] ) || ! array_key_exists( $input['membership']['guest_permission_photo'], $guest_permission_options ) )
		$input['membership']['guest_permission_photo'] = $dp_default_options['membership']['guest_permission_profile'];
	$input['membership']['add_photo_note'] = $input['membership']['add_photo_note'];
	$input['membership']['edit_photo_note'] = $input['membership']['edit_photo_note'];
	$input['membership']['edit_photo_complete_publish_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_photo_complete_publish_headline'] ) );
	$input['membership']['edit_photo_complete_publish_desc'] = $input['membership']['edit_photo_complete_publish_desc'];
	$input['membership']['edit_photo_complete_private_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_photo_complete_private_headline'] ) );
	$input['membership']['edit_photo_complete_private_desc'] = $input['membership']['edit_photo_complete_private_desc'];
	$input['membership']['edit_photo_complete_pending_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_photo_complete_pending_headline'] ) );
	$input['membership']['edit_photo_complete_pending_desc'] = $input['membership']['edit_photo_complete_pending_desc'];
	$input['membership']['edit_photo_complete_draft_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_photo_complete_draft_headline'] ) );
	$input['membership']['edit_photo_complete_draft_desc'] = $input['membership']['edit_photo_complete_draft_desc'];
	$input['membership']['edit_photo_complete_update_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['edit_photo_complete_update_headline'] ) );
	$input['membership']['edit_photo_complete_update_desc'] = $input['membership']['edit_photo_complete_update_desc'];

	// user_form
	$input['membership']['login_form_desc'] = $input['membership']['login_form_desc'];
	$input['membership']['registration_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['registration_headline'] ) );
	$input['membership']['registration_desc'] = $input['membership']['registration_desc'];
	$input['membership']['registration_complete_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['registration_complete_headline'] ) );
	$input['membership']['registration_complete_desc'] = $input['membership']['registration_complete_desc'];
	$input['membership']['registration_account_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['registration_account_headline'] ) );
	$input['membership']['registration_account_desc'] = $input['membership']['registration_account_desc'];
	$input['membership']['registration_account_complete_headline'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['registration_account_complete_headline'] ) );
	$input['membership']['registration_account_complete_desc'] = $input['membership']['registration_account_complete_desc'];
	$input['membership']['login_registration_desc'] = $input['membership']['login_registration_desc'];
	$input['membership']['login_registration_button_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['login_registration_button_label'] ) );
	$input['membership']['show_account_area'] = ! empty( $input['membership']['show_account_area'] ) ? 1 : 0;
	$input['membership']['show_account_gender'] = ! empty( $input['membership']['show_account_gender'] ) ? 1 : 0;
	$input['membership']['show_account_birthday'] = ! empty( $input['membership']['show_account_birthday'] ) ? 1 : 0;
	$input['membership']['show_profile_area'] = ! empty( $input['membership']['show_profile_area'] ) ? 1 : 0;
	$input['membership']['show_profile_job'] = ! empty( $input['membership']['show_profile_job'] ) ? 1 : 0;
	$input['membership']['show_profile_desc'] = ! empty( $input['membership']['show_profile_desc'] ) ? 1 : 0;
	$input['membership']['show_profile_website'] = ! empty( $input['membership']['show_profile_website'] ) ? 1 : 0;
	$input['membership']['show_profile_twitter'] = ! empty( $input['membership']['show_profile_twitter'] ) ? 1 : 0;
	$input['membership']['show_profile_instagram'] = ! empty( $input['membership']['show_profile_instagram'] ) ? 1 : 0;
	$input['membership']['show_profile_facebook'] = ! empty( $input['membership']['show_profile_facebook'] ) ? 1 : 0;

	// area
	$input['membership']['area'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['area'] ) );
	$areas = explode( "\n", $input['membership']['area'] );
	$areas = array_map( 'trim', $areas );
	$areas = array_filter( $areas, 'strlen' );
	$input['membership']['area'] = implode( "\n", $areas );

	// mypage
	$input['membership']['memberpage_page_id'] = absint( $input['membership']['memberpage_page_id'] );
	$input['membership']['mypage_headline_news'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_headline_news'] ) );
	$input['membership']['mypage_headline_add_photo'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_headline_add_photo'] ) );
	$input['membership']['mypage_headline_add_blog'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_headline_add_blog'] ) );
	$input['membership']['mypage_headline_profile'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_headline_profile'] ) );
	$input['membership']['mypage_headline_account'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_headline_account'] ) );
	$input['membership']['mypage_news_num'] = absint( $input['membership']['mypage_news_num'] );
	for ( $i = 1; $i <= 4; $i++ ) {
		$input['membership']['mypage_ad_code' . $i] = $input['membership']['mypage_ad_code' . $i];
		$input['membership']['mypage_ad_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_ad_image' . $i] ) );
		$input['membership']['mypage_ad_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_ad_url' . $i] ) );
	}
	for ( $i = 1; $i <= 2; $i++ ) {
		$input['membership']['mypage_ad_mobile_code' . $i] = $input['membership']['mypage_ad_mobile_code' . $i];
		$input['membership']['mypage_ad_mobile_image' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_ad_mobile_image' . $i] ) );
		$input['membership']['mypage_ad_mobile_url' . $i] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['mypage_ad_mobile_url' . $i] ) );
	}

	// member news notify
	$input['membership']['use_member_news_notify'] = ! empty( $input['membership']['use_member_news_notify'] ) ? 1 : 0;
	$input['membership']['member_news_notify_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['member_news_notify_label'] ) );
	if ( ! isset( $input['membership']['member_news_notify_schedule_type'] ) || ! array_key_exists( $input['membership']['member_news_notify_schedule_type'], $notify_schedule_type_options ) )
		$input['membership']['member_news_notify_schedule_type'] = $dp_default_options['membership']['member_news_notify_schedule_type'];
	$input['membership']['member_news_notify_schedule_type2'] = absint( $input['membership']['member_news_notify_schedule_type2'] );
	if ( ! $input['membership']['member_news_notify_schedule_type2'] )
		$input['membership']['member_news_notify_schedule_type2'] = $dp_default_options['membership']['member_news_notify_schedule_type2'];
	$input['membership']['member_news_notify_schedule_type3'] = absint( $input['membership']['member_news_notify_schedule_type3'] );
	if ( 6 < $input['membership']['member_news_notify_schedule_type3'] )
		$input['membership']['member_news_notify_schedule_type3'] = $dp_default_options['membership']['member_news_notify_schedule_type3'];
	if ( ! empty( $input['membership']['member_news_notify_schedule_type4'] ) && is_array( $input['membership']['member_news_notify_schedule_type4'] ) ) {
		$member_news_notify_schedule_type4 = array();
		foreach( $input['membership']['member_news_notify_schedule_type4'] as $key => $value ) {
			$value = absint( $value );
			if ( 1 <= $value && 31 >= $value ) {
				$member_news_notify_schedule_type4[] = $value;
			}
		}
		$input['membership']['member_news_notify_schedule_type4'] = $member_news_notify_schedule_type4;
	}
	if ( empty( $input['membership']['member_news_notify_schedule_type4'] ) )
		$input['membership']['member_news_notify_schedule_type4'] = $dp_default_options['membership']['member_news_notify_schedule_type4'];

	$input['membership']['member_news_notify_hour'] = absint( $input['membership']['member_news_notify_hour'] );
	if ( 23 < $input['membership']['member_news_notify_hour'] )
		$input['membership']['member_news_notify_hour'] = 23;
	$input['membership']['member_news_notify_hour'] = sprintf( '%02d', $input['membership']['member_news_notify_hour'] );
	$input['membership']['member_news_notify_minute'] = absint( $input['membership']['member_news_notify_minute'] );
	if ( 59 < $input['membership']['member_news_notify_minute'] )
		$input['membership']['member_news_notify_minute'] = 59;
	$input['membership']['member_news_notify_minute'] = sprintf( '%02d', $input['membership']['member_news_notify_minute'] );

	// like notify
	$input['membership']['use_social_notify'] = ! empty( $input['membership']['use_social_notify'] ) ? 1 : 0;
	$input['membership']['social_notify_label'] = wp_unslash( wp_filter_nohtml_kses( $input['membership']['social_notify_label'] ) );
	if ( ! isset( $input['membership']['social_notify_schedule_type'] ) || ! array_key_exists( $input['membership']['social_notify_schedule_type'], $notify_schedule_type_options ) )
		$input['membership']['social_notify_schedule_type'] = $dp_default_options['membership']['social_notify_schedule_type'];
	$input['membership']['social_notify_schedule_type2'] = absint( $input['membership']['social_notify_schedule_type2'] );
	if ( ! $input['membership']['social_notify_schedule_type2'] )
		$input['membership']['social_notify_schedule_type2'] = $dp_default_options['membership']['social_notify_schedule_type2'];
	$input['membership']['social_notify_schedule_type3'] = absint( $input['membership']['social_notify_schedule_type3'] );
	if ( 6 < $input['membership']['social_notify_schedule_type3'] )
		$input['membership']['social_notify_schedule_type3'] = $dp_default_options['membership']['social_notify_schedule_type3'];
	if ( ! empty( $input['membership']['social_notify_schedule_type4'] ) && is_array( $input['membership']['social_notify_schedule_type4'] ) ) {
		$social_notify_schedule_type4 = array();
		foreach( $input['membership']['social_notify_schedule_type4'] as $key => $value ) {
			$value = absint( $value );
			if ( 1 <= $value && 31 >= $value ) {
				$social_notify_schedule_type4[] = $value;
			}
		}
		$input['membership']['social_notify_schedule_type4'] = $social_notify_schedule_type4;
	}
	if ( empty( $input['membership']['social_notify_schedule_type4'] ) )
		$input['membership']['social_notify_schedule_type4'] = $dp_default_options['membership']['social_notify_schedule_type4'];

	$input['membership']['social_notify_hour'] = absint( $input['membership']['social_notify_hour'] );
	if ( 23 < $input['membership']['social_notify_hour'] )
		$input['membership']['social_notify_hour'] = 23;
	$input['membership']['social_notify_hour'] = sprintf( '%02d', $input['membership']['social_notify_hour'] );
	$input['membership']['social_notify_minute'] = absint( $input['membership']['social_notify_minute'] );
	if ( 59 < $input['membership']['social_notify_minute'] )
		$input['membership']['social_notify_minute'] = 59;
	$input['membership']['social_notify_minute'] = sprintf( '%02d', $input['membership']['social_notify_minute'] );

	// mail
	$input['membership']['mail_from_name'] = trim( wp_filter_nohtml_kses( $input['membership']['mail_from_name'] ) );
	$input['membership']['mail_from_email'] = trim( wp_filter_nohtml_kses( $input['membership']['mail_from_email'] ) );
	if ( ! $input['membership']['mail_from_email'] || ! is_email( $input['membership']['mail_from_email'] ) ) {
		unset( $input['membership']['mail_from_email'] );
	}
	// othor mail inputs are no varidate

	// update wp option
	if ( ! is_multisite() && get_option( 'users_can_register' ) != $input['membership']['users_can_register'] ) {
		update_option( 'users_can_register', $input['membership']['users_can_register'] );
	}

	// 通知スケジュールイベント
	set_tcd_membership_notify_schedule_event( $input, $GLOBALS['dp_options'] );

	return $input;
}
