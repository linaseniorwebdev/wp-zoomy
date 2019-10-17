<?php
function tcd_head() {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	$primary_color_hex = esc_html( implode( ', ', hex2rgb( $dp_options['primary_color'] ) ) );
	$load_color1_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color1'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
	$load_color2_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color2'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
?>
<?php if ( $dp_options['favicon'] && $url = wp_get_attachment_url( $dp_options['favicon'] ) ) : ?>
<link rel="shortcut icon" href="<?php echo esc_attr( $url ); ?>">
<?php endif; ?>
<style>
<?php /* Primary color */ ?>
.p-headline, .p-breadcrumb__item a:hover, .p-button-follow, .p-has-icon::before, .p-social-nav a:hover, .p-archive-information__item-date, .p-index-newsticker__item-date, .p-member-page-header__title, .p-member-page-headline--color, .p-widget__title, .p-widget-categories .toggle-children:hover { color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-button, .p-header-member-menu__item.has-bg a, .p-category-item, .p-page-links > span, .p-author .p-social-nav__item--url a, .p-author__list-tab_badge, .slick-dots li.slick-active button, .slick-dots li:hover button { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-button-follow { border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
a.p-button-follow:hover, a.p-button-following:hover, .p-pager__item .current, .p-page-links a:hover, .p-pager__item a:hover, .slick-dots li.slick-active button { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-author__list-tab, .p-member-news__item.is-unread, .p-widget-categories li a:hover { background-color: rgba(<?php echo $primary_color_hex; ?>, 0.15); }
.p-blog-archive__sort-item.is-active, .p-blog-archive__sort-item:hover { background: <?php echo esc_html( $dp_options['primary_color'] ); ?>; border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?> !important; }
<?php /* Secondary color */ ?>
a:hover, .p-body a:hover, a:hover .p-article__title, .p-article__author:hover .p-article__author-name, a.p-has-icon:hover::before, .p-user-list__search-submit:hover, .p-widget .searchform #searchsubmit:hover, .p-widget-search .p-widget-search__submit:hover, .c-entry-nav__item a:hover, .p-modal__close:hover { color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-button:hover, .p-header-member-menu__item.has-bg a:hover, .p-category-item:hover, .p-author .p-social-nav__item--url a:hover, .p-author__list-tab:hover, .p-article__edit-button:hover, .p-article__delete-button:hover, .p-membership-form__overlay-button:hover, .c-comment__form-submit:hover, c-comment__password-protected, .c-pw__btn--register, .c-pw__btn { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-membership-form__image-upload-tiny__label:hover, .c-comment__tab-item.is-active a, .c-comment__tab-item a:hover, .c-comment__tab-item.is-active p { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; border-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.c-comment__tab-item.is-active a:after, .c-comment__tab-item.is-active p:after { border-top-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
<?php /* Link color of post contents */ ?>
.p-body a { color: <?php echo esc_html( $dp_options['content_link_color'] ); ?>; }
<?php /* font type */ ?>
<?php if ( 'type2' == $dp_options['font_type'] ) : ?>
body, input, textarea { font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif; }
<?php elseif ( 'type3' == $dp_options['font_type'] ) : ?>
body, input, textarea { font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif; }
<?php else : ?>
body, input, textarea { font-family: Verdana, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "メイリオ", Meiryo, sans-serif; }
<?php endif; ?>
<?php /* headline font type */ ?>
.p-logo, .p-entry__title, .p-entry-photo__title, .p-headline, .p-headline-photo, .p-page-header__title, .p-cb__item-headline, .p-widget__title, .p-sidemenu-categories-title {
<?php if ( 'type2' == $dp_options['headline_font_type'] ) : ?>
font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
<?php elseif ( 'type3' == $dp_options['headline_font_type'] ) : ?>
font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif;
font-weight: 500;
<?php else : ?>
font-family: Segoe UI, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "メイリオ", Meiryo, sans-serif;
<?php endif; ?>
}
<?php /* load */ ?>
<?php if ( 'type1' == $dp_options['load_icon'] ) : ?>
.c-load--type1 { border: 3px solid rgba(<?php echo esc_html( $load_color2_hex ); ?>, 0.2); border-top-color: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php elseif ( 'type2' == $dp_options['load_icon'] ) : ?>
@-webkit-keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
@keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
.c-load--type2:before { box-shadow: 16px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 0); }
.c-load--type2:after { background-color: rgba(<?php echo $load_color1_hex; ?>, 1); }
<?php elseif ( 'type3' == $dp_options['load_icon'] ) : ?>
.c-load--type3 i { background: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php endif; ?>
<?php /* hover effect */ ?>
<?php if ( $dp_options['hover1_rotate'] ) : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); -moz-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); -ms-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); }
<?php else : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); -moz-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); -ms-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); }
<?php endif; ?>
<?php if ( 'type1' == $dp_options['hover2_direct'] ) : ?>
.p-hover-effect--type2 img { margin-left: -8px; }
.p-hover-effect--type2:hover img { margin-left: 8px; }
<?php else : ?>
.p-hover-effect--type2 img { margin-left: 8px; }
.p-hover-effect--type2:hover img { margin-left: -8px; }
<?php endif; ?>
<?php if ( 1 > $dp_options['hover1_opacity'] ) : ?>
.p-hover-effect--type1:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover1_bgcolor'] ); ?>; }
.p-hover-effect--type1:hover img { opacity: <?php echo esc_html( $dp_options['hover1_opacity'] ); ?>; }
<?php endif; ?>
.p-hover-effect--type2:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover2_bgcolor'] ); ?>; }
.p-hover-effect--type2:hover img { opacity: <?php echo esc_html( $dp_options['hover2_opacity'] ); ?> }
.p-hover-effect--type3:hover .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover3_bgcolor'] ); ?>; }
.p-hover-effect--type3:hover img { opacity: <?php echo esc_html( $dp_options['hover3_opacity'] ); ?>; }
<?php /* Entry */ ?>
.p-entry__title { font-size: <?php echo esc_html( $dp_options['title_font_size'] ); ?>px; }
.p-entry__title, .p-article-post__title, .p-article__title { color: <?php echo esc_html( $dp_options['title_color'] ); ?>; }
.p-entry__body { color: <?php echo esc_html( $dp_options['content_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['content_font_size'] ); ?>px; }
<?php if ( is_page() && $post->content_font_size ) { ?>
.p-entry-page__body { font-size: <?php echo esc_html( $post->content_font_size ); ?>px; }
<?php } ?>
<?php /* Photo */ ?>
.p-entry-photo__title { font-size: <?php echo esc_html( $dp_options['photo_title_font_size'] ); ?>px; }
.p-entry-photo__title, .p-article-photo__title { color: <?php echo esc_html( $dp_options['photo_title_color'] ); ?>; }
.p-entry-photo__body { color: <?php echo esc_html( $dp_options['photo_content_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['photo_content_font_size'] ); ?>px; }
.p-headline-photo__author { background-color: <?php echo esc_html( $dp_options['photo_author_headline_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['photo_author_headline_font_color'] ); ?>; }
.p-headline-photo__comment { background-color: <?php echo esc_html( $dp_options['photo_comment_headline_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['photo_comment_headline_font_color'] ); ?>; }
<?php /* Information */ ?>
.p-entry-information__body { color: <?php echo esc_html( $dp_options['information_content_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['information_content_font_size'] ); ?>px; }
<?php /* Header */ ?>
.l-header__bar { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
body.l-header__fix .is-header-fixed .l-header__bar { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity_fixed'] ); ?>); }
.l-header__bar a { color: <?php echo esc_html( $dp_options['header_font_color'] ); ?>; }
.l-header__bar a:hover, .p-header-member-menu__item a:hover { color: <?php echo esc_html( $dp_options['header_font_color_hover'] ); ?>; }
<?php /* logo */ ?>
.p-header__logo--text { font-size: <?php echo esc_html( $dp_options['header_logo_font_size'] ); ?>px; }
.p-siteinfo__title { font-size: <?php echo esc_html( $dp_options['footer_logo_font_size'] ); ?>px; }
<?php /* membermenu */ ?>
.p-member-menu { background-color: <?php echo esc_html( $dp_options['membermenu_bg_color'] ); ?> !important; }
.p-member-menu__item a { color: <?php echo esc_html( $dp_options['membermenu_font_color'] ); ?>; }
.p-member-menu__item a:hover, .p-member-menu__item.is-active a { color: <?php echo esc_html( $dp_options['membermenu_font_color_hover'] ); ?>; }
.p-member-menu__item-badge { background-color: <?php echo esc_html( $dp_options['membermenu_badge_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['membermenu_badge_font_color'] ); ?>; }
<?php /* sidemenu */ ?>
.p-sidemnu { background-color: <?php echo esc_html( $dp_options['sidemenu_bg_color'] ); ?>; }
.p-sidemnu, .p-sidemnu a, .p-sidemnu .p-widget__title { color: <?php echo esc_html( $dp_options['sidemenu_font_color'] ); ?>; }
.p-sidemnu a:hover, .p-sidemnu .current-cat a { color: <?php echo esc_html( $dp_options['sidemenu_font_color_hover'] ); ?>; }
.p-sidemenu-categories-title, .p-sidemnu .p-widget__title { background-color: <?php echo esc_html( $dp_options['sidemenu_title_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['sidemenu_title_font_color'] ); ?>; }
<?php /* Footer */ ?>
.p-copyright { background-color: <?php echo esc_html( $dp_options['copyright_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['copyright_font_color'] ); ?>; }
<?php if ( ( is_front_page() && $dp_options['show_footer_blog_top'] ) || ( ! is_front_page() && $dp_options['show_footer_blog'] ) ) : ?>
.p-footer-blog, .p-footer-blog .slick-slider::before, .p-footer-blog .slick-slider::after { background-color: <?php echo esc_html( $dp_options['footer_blog_bg_color'] ); ?>; }
<?php endif; ?>
<?php /* Footer bar */ ?>
<?php if ( is_mobile() ) : ?>
<?php if ( current_user_can( 'read' ) && in_array( $dp_options['membership']['loggedin_footer_bar_display'], array( 'type1', 'type2' ) ) && current_user_can( 'edit_posts' ) && ( $dp_options['membership']['use_front_edit_blog'] || $dp_options['membership']['use_front_edit_photo'] ) ) : ?>
.c-footer-bar { background: rgba(<?php echo implode( ',', hex2rgb( $dp_options['membership']['loggedin_footer_bar_bg'] ) ) . ', ' . esc_html( $dp_options['membership']['loggedin_footer_bar_tp'] ); ?>); color:<?php echo esc_html( $dp_options['membership']['loggedin_footer_bar_color'] ); ?>; }
.c-footer-bar a { color: <?php echo esc_html( $dp_options['membership']['loggedin_footer_bar_color'] ); ?>; }
.c-footer-bar__item + .c-footer-bar__item { border-left: 1px solid <?php echo esc_html( $dp_options['membership']['loggedin_footer_bar_border'] ); ?>; }
<?php elseif ( in_array( $dp_options['footer_bar_display'], array( 'type1', 'type2' ) ) ) : ?>
.c-footer-bar { background: rgba(<?php echo implode( ',', hex2rgb( $dp_options['footer_bar_bg'] ) ) . ', ' . esc_html( $dp_options['footer_bar_tp'] ); ?>); border-top: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; color:<?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar a { color: <?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar__item + .c-footer-bar__item { border-left: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; }
<?php endif; ?>
<?php endif; ?>
<?php /* Responsive */ ?>
@media (min-width: 992px) {
	.l-header__bar { background-color: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
	.p-pagetop a:hover { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
}
@media only screen and (max-width: 991px) {
	.p-header__logo--text { font-size: <?php echo esc_html( $dp_options['header_logo_font_size_mobile'] ); ?>px; }
	.p-pagetop a { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
	.p-pagetop a:hover { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
	.p-siteinfo__title { font-size: <?php echo esc_html( $dp_options['footer_logo_font_size_mobile'] ); ?>px; }
	.p-entry__title { font-size: <?php echo esc_html( $dp_options['title_font_size_mobile'] ); ?>px; }
	.p-entry__body { font-size: <?php echo esc_html( $dp_options['content_font_size_mobile'] ); ?>px; }
	.p-entry-photo__title { font-size: <?php echo esc_html( $dp_options['photo_title_font_size_mobile'] ); ?>px; }
	.p-entry-photo__body { font-size: <?php echo esc_html( $dp_options['photo_content_font_size_mobile'] ); ?>px; }
	.p-entry-information__title { font-size: <?php echo esc_html( $dp_options['information_title_font_size_mobile'] ); ?>px; }
	.p-entry-information__body { font-size: <?php echo esc_html( $dp_options['information_content_font_size_mobile'] ); ?>px; }
<?php	if ( is_page() && $post->content_font_size_mobile ) { ?>
	.p-entry-page__body { font-size: <?php echo esc_html( $post->content_font_size_mobile ); ?>px; }
<?php	} ?>
}
<?php if ( 'type2' == $dp_options['load_icon'] ) : ?>
@media only screen and (max-width: 767px) {
	@-webkit-keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	@keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	.c-load--type2:before { box-shadow: 10px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
<?php endif; ?>
<?php
if ( is_front_page() ) {
	$css = array();
	$css_mobile = array();
	$css_sp = array();

	// 動画, Youtube
	if ( in_array( $dp_options['header_content_type'], array( 'type2', 'type3' ) ) ) {
		if ( 'type2' === $dp_options['header_video_content_type'] && $dp_options['header_video_catch'] ) {
			if ( $dp_options['header_video_catch_vertical'] ) {
				$css[] = '.p-header-content__catch { color: ' . esc_attr( $dp_options['header_video_catch_color'] ) . '; font-size: ' . esc_attr( $dp_options['header_video_catch_font_size'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['header_video_catch_shadow2'] * -1 ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow1'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow3'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow_color'] ) . '; }';
			} else {
				$css[] = '.p-header-content__catch { color: ' . esc_attr( $dp_options['header_video_catch_color'] ) . '; font-size: ' . esc_attr( $dp_options['header_video_catch_font_size'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['header_video_catch_shadow1'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow3'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow_color'] ) . '; }';
			}

			if ( ! in_array( $dp_options['header_video_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
				$css_sp[] = '.p-header-content__catch { font-size: ' . esc_attr( $dp_options['header_video_catch_font_size_mobile'] ) . 'px; }';
			}
		}

		if ( $dp_options['display_header_video_desc'] && $dp_options['header_video_desc'] ) {
			$css[] = '.p-header-content__desc { color: ' . esc_attr( $dp_options['header_video_desc_color'] ) . '; font-size: ' . esc_attr( $dp_options['header_video_desc_font_size'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['header_video_desc_shadow1'] ) . 'px ' . esc_attr( $dp_options['header_video_desc_shadow2'] ) . 'px ' . esc_attr( $dp_options['header_video_desc_shadow3'] ) . 'px ' . esc_attr( $dp_options['header_video_desc_shadow_color'] ) . '; }';

			if ( ! in_array( $dp_options['header_video_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
				$css_sp[] = '.p-header-content__desc { font-size: ' . esc_attr( $dp_options['header_video_desc_font_size_mobile'] ) . 'px; }';
			}
		}

		if ( $dp_options['display_header_video_button'] && $dp_options['header_video_button_label'] ) {
			$css[] = '.p-header-content__button .p-button { background-color: ' . esc_attr( $dp_options['header_video_button_bg_color'] ) . '; color: ' . esc_attr( $dp_options['header_video_button_font_color'] ) . ' !important; }';
			$css[] = '.p-header-content__button a.p-button:hover { background-color: ' . esc_attr( $dp_options['header_video_button_bg_color_hover'] ) . '; color: ' . esc_attr( $dp_options['header_video_button_font_color_hover'] ) . ' !important; }';
		}

		if ( $dp_options['display_header_video_overlay'] && 0 < $dp_options['header_video_overlay_opacity'] ) {
			$css[] = '.p-header-content__overlay { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['header_video_overlay_color'] ) ) . ', ' . $dp_options['header_video_overlay_opacity'] ) . '); }';
		}

		if ( ! in_array( $dp_options['header_video_content_type_mobile'], array( 'type1', 'type2' ) ) && $dp_options['header_video_logo_width_mobile'] ) {
			$css_sp[] = '.p-header-content__logo img { width: ' . esc_attr( $dp_options['header_video_logo_width_mobile'] ) . 'px; }';
		}

		if ( 'type2' === $dp_options['header_video_content_type_mobile'] && $dp_options['header_video_catch_mobile_type2'] ) {
			if ( $dp_options['header_video_catch_vertical_mobile_type2'] ) {
				$css_sp[] = '.p-header-content--mobile .p-header-content__catch { color: ' . esc_attr( $dp_options['header_video_catch_color_mobile_type2'] ) . '; font-size: ' . esc_attr( $dp_options['header_video_catch_font_size_mobile_type2'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['header_video_catch_shadow2_mobile_type2'] * -1 ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow1_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow3_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow_color_mobile_type2'] ) . '; }';
			} else {
				$css_sp[] = '.p-header-content--mobile .p-header-content__catch { color: ' . esc_attr( $dp_options['header_video_catch_color_mobile_type2'] ) . '; font-size: ' . esc_attr( $dp_options['header_video_catch_font_size_mobile_type2'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['header_video_catch_shadow1_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow2_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow3_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['header_video_catch_shadow_color_mobile_type2'] ) . '; }';
			}
		}

		if ( in_array( $dp_options['header_video_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
			$css_sp[] = '.p-header-content__overlay { background-color: transparent; }';
			if ( $dp_options['display_header_video_overlay_mobile'] && 0 < $dp_options['header_video_overlay_opacity_mobile'] ) {
				$css_sp[] = '.p-header-content--mobile { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['header_video_overlay_color_mobile'] ) ) . ', ' . $dp_options['header_video_overlay_opacity_mobile'] ) . '); }';
			}
		}

	// 画像スライダー
	} else {
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( is_mobile() && $dp_options['slider_image_sp' . $i] ) :
				$slider_image = wp_get_attachment_image_src( $dp_options['slider_image_sp' . $i], 'full' );
			else :
				$slider_image = wp_get_attachment_image_src( $dp_options['slider_image' . $i], 'full' );
			endif;
			if ( empty( $slider_image[0] ) ) continue;

			if ( 'type2' === $dp_options['slider_content_type' . $i] && $dp_options['slider_catch' . $i] ) {
				if ( $dp_options['slider_catch_vertical' . $i] ) {
					$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__catch { color: ' . esc_attr( $dp_options['slider_catch_color' . $i] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size' . $i] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow2'] * -1 ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow1'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow3'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow_color'] ) . '; }';
				} else {
					$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__catch { color: ' . esc_attr( $dp_options['slider_catch_color' . $i] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size' . $i] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow1'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow2'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow3'] ) . 'px ' . esc_attr( $dp_options['slider_catch' . $i . '_shadow_color'] ) . '; }';
				}

				if ( ! in_array( $dp_options['slider_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
					$css_sp[] = '.p-index-slider__item--' . $i . ' .p-header-content__catch { font-size: ' . esc_attr( $dp_options['slider_catch_font_size_mobile' . $i] ) . 'px; }';
				}
			}

			if ( $dp_options['display_slider_desc' . $i] && $dp_options['slider_desc' . $i] ) {
				$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__desc { color: ' . esc_attr( $dp_options['slider_desc_color' . $i] ) . '; font-size: ' . esc_attr( $dp_options['slider_desc_font_size' . $i] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_desc' . $i . '_shadow1'] ) . 'px ' . esc_attr( $dp_options['slider_desc' . $i . '_shadow2'] ) . 'px ' . esc_attr( $dp_options['slider_desc' . $i . '_shadow3'] ) . 'px ' . esc_attr( $dp_options['slider_desc' . $i . '_shadow_color'] ) . '; }';

				if ( ! in_array( $dp_options['slider_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
					$css_sp[] = '.p-index-slider__item--' . $i . ' .p-header-content__desc { font-size: ' . esc_attr( $dp_options['slider_desc_font_size_mobile' . $i] ) . 'px; }';
				}
			}

			if ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] ) {
				$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__button .p-button { background-color: ' . esc_attr( $dp_options['slider_button_bg_color' . $i] ) . '; color: ' . esc_attr( $dp_options['slider_button_font_color' . $i] ) . ' !important; }';
				$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__button a.p-button:hover { background-color: ' . esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ) . '; color: ' . esc_attr( $dp_options['slider_button_font_color_hover' . $i] ) . ' !important; }';
			}

			if ( $dp_options['display_slider_overlay' . $i] && 0 < $dp_options['slider_overlay_opacity' . $i] ) {
				$css[] = '.p-index-slider__item--' . $i . ' .p-header-content__overlay { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['slider_overlay_color' . $i] ) ) . ', ' . $dp_options['slider_overlay_opacity' . $i] ) . '); }';
			}

			if ( in_array( $dp_options['slider_content_type_mobile'], array( 'type1', 'type2' ) ) ) {
				if ( $dp_options['display_slider_overlay_mobile' . $i] && 0 < $dp_options['slider_overlay_opacity_mobile' . $i] ) {
					$css_sp[] = '.p-index-slider__item--' . $i . ' .p-header-content__overlay { background-color: rgba(' . esc_attr( implode( ', ', hex2rgb( $dp_options['slider_overlay_color_mobile' . $i] ) ) . ', ' . $dp_options['slider_overlay_opacity_mobile' . $i] ) . '); }';
				} else {
					$css_sp[] = '.p-index-slider__item--' . $i . ' .p-header-content__overlay { background-color: transparent; }';
				}
			} elseif ( $dp_options['slider_logo_width_mobile' . $i] ) {
				$css_sp[] = '.p-index-slider__item--' . $i . ' .p-header-content__logo img { width: ' . esc_attr( $dp_options['slider_logo_width_mobile' . $i] ) . 'px; }';
			}
		}

		if ( 'type2' === $dp_options['slider_content_type_mobile'] && $dp_options['slider_catch_mobile_type2'] ) {
			if ( $dp_options['slider_catch_vertical_mobile_type2'] ) {
				$css_sp[] = '.p-header-content--mobile .p-header-content__catch { color: ' . esc_attr( $dp_options['slider_catch_color_mobile_type2'] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size_mobile_type2'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_catch_shadow2_mobile_type2'] * -1 ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow1_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow3_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow_color_mobile_type2'] ) . '; }';
			} else {
				$css_sp[] = '.p-header-content--mobile .p-header-content__catch { color: ' . esc_attr( $dp_options['slider_catch_color_mobile_type2'] ) . '; font-size: ' . esc_attr( $dp_options['slider_catch_font_size_mobile_type2'] ) . 'px; text-shadow: ' . esc_attr( $dp_options['slider_catch_shadow1_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow2_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow3_mobile_type2'] ) . 'px ' . esc_attr( $dp_options['slider_catch_shadow_color_mobile_type2'] ) . '; }';
			}
		}
	}

	// ニュースティッカー
	if ( $dp_options['show_index_newsticker'] && $dp_options['index_newsticker_archive_link_text'] ) {
		$css[] = '.p-index-newsticker__archive-link__button { background-color: ' . esc_attr( $dp_options['index_newsticker_archive_link_bg_color'] ) . '; color: ' . esc_attr( $dp_options['index_newsticker_archive_link_font_color'] ) . '; }';
		$css[] = '.p-index-newsticker__archive-link__button:hover { background-color: ' . esc_attr( $dp_options['index_newsticker_archive_link_bg_color_hover'] ) . '; color: ' . esc_attr( $dp_options['index_newsticker_archive_link_font_color_hover'] ) . '; }';
	}

	// コンテンツビルダー
	if ( ! empty( $dp_options['contents_builder'] ) ) {
		foreach ( $dp_options['contents_builder'] as $key => $cb_content ) {
			$cb_index = 'cb_' . ( $key + 1 );
			if ( empty( $cb_content['cb_content_select'] ) || empty( $cb_content['cb_display'] ) ) continue;

			if ( ! empty( $cb_content['cb_headline'] ) ) {
				$css[] = '#' . $cb_index . ' .p-cb__item-headline { color: ' . esc_attr( $cb_content['cb_headline_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_headline_font_size'] ) . 'px; }';
				$css_mobile[] = '#' . $cb_index . ' .p-cb__item-headline { font-size: ' . esc_attr( $cb_content['cb_headline_font_size_mobile'] ) . 'px; }';
			}

			if ( ! empty( $cb_content['cb_desc'] ) ) {
				$css[] = '#' . $cb_index . ' .p-cb__item-desc { color: ' . esc_attr( $cb_content['cb_desc_color'] ) . '; font-size: ' . esc_attr( $cb_content['cb_desc_font_size'] ) . 'px; }';
				$css_mobile[] = '#' . $cb_index . ' .p-cb__item-desc { font-size: ' . esc_attr( $cb_content['cb_desc_font_size_mobile'] ) . 'px; }';
			}

			if ( ! empty( $cb_content['cb_desc2'] ) ) {
				$css[] = '#' . $cb_index . ' .p-cb__item-desc2 { color: ' . esc_attr( $cb_content['cb_desc_color2'] ) . '; font-size: ' . esc_attr( $cb_content['cb_desc_font_size2'] ) . 'px; }';
				$css_mobile[] = '#' . $cb_index . ' .p-cb__item-desc2 { font-size: ' . esc_attr( $cb_content['cb_desc_font_size_mobile2'] ) . 'px; }';
			}

			if ( ! empty( $cb_content['cb_show_archive_link'] ) && ! empty( $cb_content['cb_archive_link_text'] ) ) {
				$css[] = '#' . $cb_index . ' .p-cb__item-button { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color'] ) . ' !important; }';
				$css[] = '#' . $cb_index . ' .p-cb__item-button:hover { background-color: ' . esc_attr( $cb_content['cb_archive_link_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_archive_link_font_color_hover'] ) . ' !important; }';
			}

			if ( ! empty( $cb_content['cb_button_label'] ) && ! empty( $cb_content['cb_button_label'] ) ) {
				$css[] = '#' . $cb_index . ' .p-cb__item-button { background-color: ' . esc_attr( $cb_content['cb_button_bg_color'] ) . '; color: ' . esc_attr( $cb_content['cb_button_font_color'] ) . ' !important; }';
				$css[] = '#' . $cb_index . ' .p-cb__item-button:hover { background-color: ' . esc_attr( $cb_content['cb_button_bg_color_hover'] ) . '; color: ' . esc_attr( $cb_content['cb_button_font_color_hover'] ) . ' !important; }';
			}
		}
	}

	if ( $css ) {
		echo implode( "\n", $css ) . "\n";
	}
	if ( $css_mobile ) {
		echo "@media only screen and (max-width: 991px) {\n";
		echo "\t" . implode( "\n\t", $css_mobile ) . "\n";
		echo "}\n";
	}
	if ( $css_sp ) {
		echo "@media only screen and (max-width: 767px) {\n";
		echo "\t" . implode( "\n\t", $css_sp ) . "\n";
		echo "}\n";
	}
}

$css = array();
$css_mobile = array();

/* footer widget */
if ( is_active_sidebar( is_mobile() ? 'footer_widget_mobile' : 'footer_widget' ) ) {
	$css[] = '.p-footer-widget-area { background-color: ' . esc_html( $dp_options['footer_widget_bg_color'] ) . '; color: ' . esc_html( $dp_options['footer_widget_font_color'] ) . '; }';
	$css[] = '.p-footer-widget-area .p-widget__title { color: ' . esc_html( $dp_options['footer_widget_title_color'] ) . '; }';
	$css[] = '.p-footer-widget-area a { color: ' . esc_html( $dp_options['footer_widget_font_color'] ) . '; }';
	$css[] = '.p-footer-widget-area a:hover { color: ' . esc_html( $dp_options['footer_widget_font_color_hover'] ) . '; }';
}

/* Site info widget */
foreach( get_option( 'widget_site_info_widget', array() ) as $key => $value ) {
	if ( is_int( $key ) && ! empty( $value['title'] ) && ! empty( $value['title_font_size'] ) ) {
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__title { font-size: ' . esc_html( $value['title_font_size'] ) . 'px; }';
		if ( ! empty( $value['title_font_size_mobile'] ) ) {
			$css_mobile[] = '#site_info_widget-' . $key . ' .p-siteinfo__title { font-size: ' . esc_html( $value['title_font_size_mobile'] ) . 'px; }';
		}
	}
	if ( is_int( $key ) && ! empty( $value['button'] ) ) {
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__button { background: ' . esc_html( $value['button_bg_color'] ) . '; color: ' . esc_html( $value['button_font_color'] ) . '; }';
		$css[] = '#site_info_widget-' . $key . ' .p-siteinfo__button:hover { background: ' . esc_html( $value['button_bg_color_hover'] ) . '; color: ' . esc_html( $value['button_font_color_hover'] ) . '; }';
	}
}
if ( $css ) {
	echo implode( "\n", $css ) . "\n";
}
if ( $css_mobile ) {
	echo "@media only screen and (max-width: 991px) {\n";
	echo "\t" . implode( "\n\t", $css_mobile ) . "\n";
	echo "}\n";
}

/* Custom CSS */
if ( $dp_options['css_code'] ) {
	echo $dp_options['css_code'] . "\n";
}
?>
</style>
<?php
}
add_action( 'wp_head', 'tcd_head' );

// Custom head/script
function tcd_custom_head() {
	global $dp_options;

	if ( $dp_options['custom_head'] ) {
		echo $dp_options['custom_head'] . "\n";
	}
}
add_action( 'wp_head', 'tcd_custom_head', 9999 );
