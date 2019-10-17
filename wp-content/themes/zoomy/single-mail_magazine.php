<?php
/**
 * Mail Magazine single template for preview
 */

global $post;
the_post();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php the_title(); ?></title>
	</head>
	<body>
<?php
if ( 'html' === $post->mail_format ) :
?>
		<?php the_content(); ?>
<?php
else :
	echo '<pre>' . strip_tags( $post->post_content ) . '</pre>';
endif;
?>
	</body>
</html>
