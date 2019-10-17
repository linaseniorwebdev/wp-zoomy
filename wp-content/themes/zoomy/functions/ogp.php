<?php
function og_image( $n ) {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	$myArray = array();
	if ( is_singular() ) {
		if ( $post->_main_image ) {
			$myArray[0] = $post->_main_image['url'];
			$myArray[1] = $post->_main_image['width'];
			$myArray[2] = $post->_main_image['height'];
			echo esc_attr( $myArray[$n] );
		} elseif ( $post->main_image ) {
			$myArray[0] = $post->main_image;
			$myArray[1] = '';
			$myArray[2] = '';

			$main_image = str_replace( array( 'https://', 'http://' ), '//' , $post->main_image );
			$site_url = str_replace( array( 'https://', 'http://' ), '//' , site_url( '/' ) );
			$realpath = str_replace( $site_url, ABSPATH, $main_image );
			if ( file_exists( $realpath ) && $imagesize = getimagesize( $realpath ) ) {
				$myArray[1] = $imagesize[0];
				$myArray[2] = $imagesize[1];
			}
			echo esc_attr( $myArray[$n] );
		} elseif ( has_post_thumbnail() && $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) ) {
			list( $myArray[0], $myArray[1], $myArray[2] ) = $image;
			echo esc_attr( $myArray[$n] );
		}
	} else {
		if ( $dp_options['ogp_image'] ) {
			$image = wp_get_attachment_image_src( $dp_options['ogp_image'], 'full' );
			list( $myArray[0], $myArray[1], $myArray[2] ) = $image;
			echo esc_attr( $myArray[$n] );
		} else {
			$myArray[0] = get_bloginfo( 'template_url' ) . '/img/no-image-300x300.gif';
			$myArray[1] = 300;
			$myArray[2] = 300;
			echo esc_attr( $myArray[$n] );
		}
	}
}
function twitter_image() {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	if ( is_singular() ) {
		if ( ! empty( $post->_main_image['thumbnails']['300x300'] ) ) {
			echo esc_attr( $post->_main_image['thumbnails']['300x300'] );
		} elseif ( $post->main_image ) {
			echo esc_attr( $post->main_image );
		} elseif ( has_post_thumbnail() && $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'size1' ) ) {
			echo esc_attr( $image[0] );
		}
	} else {
		if ( $dp_options['ogp_image'] && $image = wp_get_attachment_image_src( $dp_options['ogp_image'], 'size1' ) ) {
			;
			echo esc_attr( $image[0] );
		} else {
			echo get_bloginfo( 'template_url' ) . '/img/no-image-300x300.gif';
		}
	}
}
?>
<?php
function ogp() {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php if ( is_singular() ) { ?>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>">
<?php if ( is_front_page() ) { ?>
<meta property="og:title" content="<?php echo get_bloginfo( 'name' ); ?>" />
<?php } else { ?>
<meta property="og:title" content="<?php the_title(); ?>" />
<?php } ?>
<meta property="og:description" content="<?php seo_description(); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>" />
<meta property="og:image" content="<?php og_image( 0 ); ?>">
<meta property="og:image:secure_url" content="<?php og_image( 0 ); ?>" />
<meta property="og:image:width" content="<?php og_image( 1 ); ?>" />
<meta property="og:image:height" content="<?php og_image( 2 ); ?>" />
<?php if ( $dp_options['fb_app_id'] ) { ?>
<meta property="fb:app_id" content="<?php echo esc_attr( $dp_options['fb_app_id'] ); ?>">
<?php } ?>
<?php if ( $dp_options['use_twitter_card'] ) { ?>
<meta name="twitter:card" content="summary" />
<?php if ( $dp_options['twitter_account_name'] ) { ?>
<meta name="twitter:site" content="@<?php echo $dp_options['twitter_account_name']; ?>" />
<?php } ?>
<?php if ( $dp_options['twitter_account_name'] ) { ?>
<meta name="twitter:creator" content="@<?php echo $dp_options['twitter_account_name']; ?>" />
<?php } ?>
<meta name="twitter:title" content="<?php the_title(); ?>" />
<meta name="twitter:description" content="<?php seo_description(); ?>" />
<meta name="twitter:image:src" content="<?php twitter_image(); ?>" />
<?php } ?>
<?php } else { ?>
<meta property="og:type" content="blog" />
<meta property="og:url" content="<?php echo ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>">
<?php if ( is_front_page() ) { ?>
<meta property="og:title" content="<?php echo get_bloginfo( 'name' ); ?>" />
<?php } else { ?>
<meta property="og:title" content="<?php echo esc_attr( get_the_archive_title() ); ?>" />
<?php } ?>
<meta property="og:description" content="<?php echo get_bloginfo( 'description' ); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>" />
<meta property="og:image" content='<?php og_image( 0 ); ?>'>
<meta property="og:image:secure_url" content="<?php og_image( 0 ); ?>" />
<meta property="og:image:width" content="<?php og_image( 1 ); ?>" />
<meta property="og:image:height" content="<?php og_image( 2 ); ?>" />
<?php if ( $dp_options['fb_app_id'] ) { ?>
<meta property="fb:app_id" content="<?php echo esc_attr( $dp_options['fb_app_id'] ); ?>">
<?php } ?>
<?php if ( $dp_options['use_twitter_card'] ) { ?>
<meta name="twitter:card" content="summary" />
<?php if ( $dp_options['twitter_account_name'] ) { ?>
<meta name="twitter:site" content="@<?php echo $dp_options['twitter_account_name']; ?>" />
<?php } ?>
<?php if ( $dp_options['twitter_account_name'] ) { ?>
<meta name="twitter:creator" content="@<?php echo $dp_options['twitter_account_name']; ?>" />
<?php } ?>
<meta name="twitter:title" content="<?php echo get_bloginfo( 'name' ); ?>" />
<meta name="twitter:description" content="<?php echo get_bloginfo( 'description' ); ?>" />
<?php } ?>
<?php } ?>
<?php } ?>
