<?php
global $post, $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

$signage = $catchphrase = $desc = $overlay = $overlay_opacity = null;

if ( is_404() ) :
	$signage = wp_get_attachment_url( $dp_options['image_404'] );
	$catchphrase = esc_html( trim( $dp_options['catchphrase_404'] ) );
	$desc = trim( $dp_options['desc_404'] );
	$catchphrase_font_size = $dp_options['catchphrase_font_size_404'] ? $dp_options['catchphrase_font_size_404'] : 32;
	$catchphrase_font_size_mobile = $dp_options['catchphrase_font_size_404_mobile'] ? $dp_options['catchphrase_font_size_404_mobile'] : 26;
	$catchphrase_font_type = $dp_options['catchphrase_font_type_404'] ? $dp_options['catchphrase_font_type_404'] : 'type2';
	$desc_font_size = $dp_options['desc_font_size_404'] ? $dp_options['desc_font_size_404'] : 16;
	$desc_font_size_mobile = $dp_options['desc_font_size_404_mobile'] ? $dp_options['desc_font_size_404_mobile'] : 14;
	$color = $dp_options['color_404'] ? $dp_options['color_404'] : '#000000';
	$shadow1 = $dp_options['shadow1_404'] ? $dp_options['shadow1_404'] : 0;
	$shadow2 = $dp_options['shadow2_404'] ? $dp_options['shadow2_404'] : 0;
	$shadow3 = $dp_options['shadow3_404'] ? $dp_options['shadow3_404'] : 0;
	$shadow4 = $dp_options['shadow_color_404'] ? $dp_options['shadow_color_404'] : '#999999';
	$overlay = $dp_options['overlay_404'] ? $dp_options['overlay_404'] : '#000000';
	$overlay_opacity = isset( $dp_options['overlay_opacity_404'] ) ? floatval( $dp_options['overlay_opacity_404'] ) : 0.5;

elseif ( is_page() ) :
	$signage = wp_get_attachment_url( $post->page_header_image );
	if ( $post->page_headline ) :
		$catchphrase = esc_html( trim( $post->page_headline ) );
	elseif ( 'hide' != $post->display_title ) :
		$catchphrase = trim( $post->post_title );
	endif;
	$catchphrase_font_size = $post->page_headline_font_size ? $post->page_headline_font_size : 32;
	$catchphrase_font_size_mobile = $post->page_headline_font_size_mobile ? $post->page_headline_font_size_mobile : 26;
	$catchphrase_font_type = $post->page_headline_font_type ? $post->page_headline_font_type : 'type2';
	$desc = trim( $post->page_desc );
	$desc_font_size = $post->page_desc_font_size ? $post->page_desc_font_size : 16;
	$desc_font_size_mobile = $post->page_desc_font_size_mobile ? $post->page_desc_font_size_mobile : 14;
	$color = $post->page_headline_color ? $post->page_headline_color : '#000000';
	$shadow1 = $post->page_headline_shadow1 ? $post->page_headline_shadow1 : 0;
	$shadow2 = $post->page_headline_shadow2 ? $post->page_headline_shadow2 : 0;
	$shadow3 = $post->page_headline_shadow3 ? $post->page_headline_shadow3 : 0;
	$shadow4 = $post->page_headline_shadow4 ? $post->page_headline_shadow4 : '#999999';
	$overlay = $post->page_overlay ? $post->page_overlay : '#000000';
	$overlay_opacity = '' !== $post->page_overlay_opacity ? floatval( $post->page_overlay_opacity ) : 0.5;

elseif ( is_post_type_archive( $dp_options['information_slug'] ) || is_singular( $dp_options['information_slug'] ) ) :
	$catchphrase = esc_html( $dp_options['information_header_headline'] ? $dp_options['information_header_headline'] : $dp_options['information_label'] );
	$desc = $dp_options['information_header_desc'];

elseif ( is_post_type_archive( $dp_options['photo_slug'] ) ) :
	$catchphrase = esc_html( $dp_options['photo_header_headline'] ? $dp_options['photo_header_headline'] : $dp_options['photo_label'] );
	$desc = $dp_options['photo_header_desc'];

elseif ( is_category() || is_tag() || is_tax() ) :
	$queried_object = get_queried_object();
	$catchphrase = esc_html( $queried_object->name );
	$desc = $queried_object->description;

elseif ( is_date() ) :
	$catchphrase = sprintf( __( 'Archive for %s', 'tcd-w' ), zoomy_archive_title( null ) );

elseif ( is_search() ) :
	$catchphrase = sprintf( __( 'Search result for "%s"', 'tcd-w' ), esc_html( get_query_var( 's' ) ) );

else :
	$catchphrase = esc_html( $dp_options['blog_header_headline'] ? $dp_options['blog_header_headline'] : $dp_options['blog_label'] );
	$desc = $dp_options['blog_header_desc'];
endif;

if ( $signage ) :
?>
	<header class="p-page-header__image" style="background-image: url(<?php echo esc_attr( $signage ); ?>);">
		<div class="p-page-header__overlay" style="background-color: rgba(<?php echo esc_attr( implode( ', ', hex2rgb( $overlay ) ) ); ?>, <?php echo esc_attr( $overlay_opacity ); ?>);">
			<div class="p-page-header__inner l-inner" style="text-shadow: <?php echo esc_attr( $shadow1 ); ?>px <?php echo esc_attr( $shadow2 ); ?>px <?php echo esc_attr( $shadow3 ); ?>px <?php echo esc_attr( $shadow4 ); ?>;">
<?php
	if ( $catchphrase ) :
?>
				<h1 class="p-page-header__image-title c-font_type--<?php echo esc_attr( $catchphrase_font_type ); ?>"><?php echo $catchphrase; ?></h1>
<?php
	endif;
	if ( $desc ) :
?>
				<p class="p-page-header__image-desc"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $desc ) ); ?></p>
<?php
	endif;
?>
			</div>
		</div>
<?php
	if ( $catchphrase || $desc ) :
?>
		<style scoped>
<?php
		if ( $catchphrase ) :
?>
			.p-page-header__title { color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $catchphrase_font_size ); ?>px; }
<?php
		endif;
		if ( $desc ) :
?>
			.p-page-header__desc { color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $desc_font_size ); ?>px; }
<?php
		endif;
?>
			@media only screen and (max-width: 991px) {
<?php
		if ( $catchphrase ) :
?>
				.p-page-header__title { font-size: <?php echo esc_attr( $catchphrase_font_size_mobile ); ?>px; }
<?php
		endif;
		if ( $desc ) :
?>
				.p-page-header__desc { font-size: <?php echo esc_attr( $desc_font_size_mobile ); ?>px; }
<?php
		endif;
?>
			}
		</style>
<?php
		endif;
?>
	</header>
<?php
elseif ( $catchphrase || $desc ) :
?>
	<header class="p-page-header">
		<div class="p-page-header__inner l-inner">
<?php
	if ( $catchphrase ) :
?>
			<h1 class="p-page-header__title"><?php echo esc_html( $catchphrase ); ?></h1>
<?php
	endif;
	if ( $desc ) :
?>
			<p class="p-page-header__desc"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $desc ) ); ?></p>
<?php
	endif;
?>
		</div>
	</header>
<?php
endif;
