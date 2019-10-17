<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php if ( $dp_options['use_ogp'] ) { echo 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"'; } ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="description" content="<?php seo_description(); ?>">
<meta name="viewport" content="width=device-width">
<?php if ( $dp_options['use_ogp'] ) { ogp(); } ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if ( $dp_options['use_load_icon'] ) :
?>
<div id="site_loader_overlay">
	<div id="site_loader_animation" class="c-load--<?php echo esc_attr( $dp_options['load_icon'] ); ?>">
<?php
	if ( 'type3' === $dp_options['load_icon'] ) :
?>
		<i></i><i></i><i></i><i></i>
<?php
	endif;
?>
	</div>
</div>
<?php
endif;

if (
	( is_singular( $dp_options['photo_slug'] ) && ( 'type4' != $dp_options['header_bar_photo'] || 'type4' != $dp_options['header_bar_photo_mobile'] ) ) ||
	( ! is_singular( $dp_options['photo_slug'] ) && ( 'type4' != $dp_options['header_bar'] || 'type4' != $dp_options['header_bar_mobile'] ) )
) :
?>
<header id="js-header" class="l-header<?php if ( is_tcd_membership_static_member_menu() ) echo ' is-member-menu--static'; ?>">
	<div class="l-header__bar l-header__bar--mobile p-header__bar">
<?php
	$logotag = is_front_page() ? 'h1' : 'div';
	if ( 'yes' == $dp_options['use_header_logo_image'] && $image = wp_get_attachment_image_src( $dp_options['header_logo_image'], 'full' ) ) :
?>
		<<?php echo $logotag; ?> class="p-logo p-header__logo<?php if ( $dp_options['header_logo_image_retina'] ) { echo ' p-header__logo--retina'; } ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php if ( $dp_options['header_logo_image_retina'] ) echo ' width="' . floor( $image[1] / 2 ) . '"'; ?>></a>
		</<?php echo $logotag; ?>>
<?php
	else :
?>
		<<?php echo $logotag; ?> class="p-logo p-header__logo p-header__logo--text">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</<?php echo $logotag; ?>>
<?php
	endif;

	if ( 'yes' == $dp_options['use_header_logo_image_mobile'] && $image = wp_get_attachment_image_src( $dp_options['header_logo_image_mobile'], 'full' ) ) :
?>
		<div class="p-logo p-header__logo--mobile<?php if ( $dp_options['header_logo_image_mobile_retina'] ) echo ' p-header__logo--retina'; ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php if ( $dp_options['header_logo_image_mobile_retina'] ) echo ' width="' . floor( $image[1] / 2 ) . '"'; ?>></a>
		</div>
<?php
	else :
?>
		<div class="p-logo p-header__logo--mobile p-header__logo--text">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</div>
<?php
	endif;

	the_tcd_membership_header_member_menu();
?>
		<a href="#" id="js-menu-button" class="p-menu-button c-menu-button"></a>
	</div>
<?php
	the_tcd_membership_member_menu();
?>
	<div class="p-sidemnu">
		<a href="#" id="js-sidemenu-close" class="p-close-button"></a>
		<div class="p-sidemnu__inner">
<?php
	if ( $dp_options['sidemenu_photo_category_show_first'] ) :
		$tax_orders = array( 'photo_category', 'category' );
	else :
		$tax_orders = array( 'category', 'photo_category' );
	endif;

	foreach ( $tax_orders as $tax ) :
		if ( 'category' == $tax && $dp_options['show_sidemenu_category'] ) :
			$categories = wp_list_categories( array(
				'depth' => 1,
				'echo' => 0,
				'exclude' => trim( $dp_options['sidemenu_category_exclude'], ' ,' ),
				'show_count' => 0,
				'title_li' => '',
				'use_desc_for_title' => 0
			) );
			if ( $categories ) :
?>
			<h2 class="p-sidemenu-categories-title"><i class="p-sidemenu-categories-title__icon"></i><?php echo esc_html( $dp_options['sidemenu_category_label'] ); ?></h2>
			<ul class="p-sidemenu-categories">
<?php
	echo $categories;
?>
			</ul>
<?php
			endif;
		endif;

		if ( 'photo_category' == $tax && $dp_options['show_sidemenu_photo_category'] && 'category' !== $dp_options['photo_category_slug'] ) :
			$categories = wp_list_categories( array(
				'depth' => 1,
				'echo' => 0,
				'exclude' => trim( $dp_options['sidemenu_photo_category_exclude'], ' ,' ),
				'show_count' => 0,
				'title_li' => '',
				'taxonomy' => $dp_options['photo_category_slug'],
				'use_desc_for_title' => 0
			) );
			if ( $categories ) :
?>
			<h2 class="p-sidemenu-categories-title p-sidemenu-photo-categories-title"><i class="p-sidemenu-categories-title__icon"></i><?php echo esc_html( $dp_options['sidemenu_photo_category_label'] ); ?></h2>
			<ul class="p-sidemenu-categories">
<?php
	echo $categories;
?>
			</ul>
<?php
			endif;
		endif;
	endforeach;

	if ( is_mobile() ) :
		$sidemenu_widget = 'sidemenu_widget_mobile';
	else :
		$sidemenu_widget = 'sidemenu_widget';
	endif;

	if ( $dp_options['show_sidemenu_globalmenu'] && has_nav_menu( 'global' ) ) :
		$locations = get_nav_menu_locations();
		if ( ! empty( $locations[ 'global' ] ) ) :
			the_widget(
				'WP_Nav_Menu_Widget',
				array(
					'title' => '',
					'nav_menu' => $locations[ 'global' ]
				),
				array(
					'id' => $sidemenu_widget,
					'before_widget' => '<div class="p-widget p-widget-sidemenu p-global-nav WP_Nav_Menu_Widget">' . "\n",
					'after_widget' => "</div>\n",
					'before_title' => '<h2 class="p-widget__title">',
					'after_title' => '</h2>' . "\n"
				)
			);
		endif;
	endif;

	if ( $dp_options['show_sidemenu_search'] ) :
		the_widget(
			'WP_Widget_Search',
			array(
				'title' => ''
			),
			array(
				'id' => $sidemenu_widget,
				'before_widget' => '<div class="p-widget p-widget-sidemenu WP_Widget_Search">' . "\n",
				'after_widget' => "</div>\n",
				'before_title' => '<h2 class="p-widget__title">',
				'after_title' => '</h2>' . "\n"
			)
		);
	endif;

	if ( $dp_options['show_sidemenu_widget'] && is_active_sidebar( $sidemenu_widget ) ) :
		dynamic_sidebar( $sidemenu_widget );
	endif;
?>
		</div>
	</div>
</header>
<?php
endif;
?>
