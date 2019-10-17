<?php
global $post, $dp_options, $tcd_membership_post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
$breadcrumb_position = 1;
?>
	<div class="p-breadcrumb c-breadcrumb">
		<ul class="p-breadcrumb__inner c-breadcrumb__inner l-inner" itemscope itemtype="http://schema.org/BreadcrumbList">
			<li class="p-breadcrumb__item c-breadcrumb__item p-breadcrumb__item--home c-breadcrumb__item--home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item"><span itemprop="name">HOME</span></a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
if ( is_tcd_membership_preview_photo() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( $dp_options['photo_slug'] ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['photo_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	$category = get_term_by( 'id', $tcd_membership_post->category, $dp_options['photo_category_slug'] );
	if ( $category && ! is_wp_error( $category ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">

				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( strip_tags( $tcd_membership_post->post_title ) ); ?></span>
			</li>
<?php
elseif ( is_tcd_membership_preview_blog() ) :
	if ( $dp_options['blog_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;

	$category = get_term_by( 'id', $tcd_membership_post->category, 'category' );
	if ( $category && ! is_wp_error( $category ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">

				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( strip_tags( $tcd_membership_post->post_title ) ); ?></span>
			</li>
<?php
elseif ( is_post_type_archive( $dp_options['information_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( $dp_options['information_label'] ); ?></span>
			</li>
<?php
elseif ( is_singular( $dp_options['information_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( $dp_options['information_slug'] ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['information_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_singular( $dp_options['photo_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( $dp_options['photo_slug'] ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['photo_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	$categories = get_the_terms( $post->ID, $dp_options['photo_category_slug'] );
	if ( $categories && ! is_wp_error( $categories ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<?php
		foreach ( $categories as $key => $category ) :
			if ( 0 !== $key ) :
				echo ', ';
			endif;
?>
				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
<?php
		endforeach;
?>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_post_type_archive( $dp_options['photo_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( $dp_options['photo_label'] ); ?></span>
			</li>
<?php
elseif ( is_tax( $dp_options['photo_category_slug'] ) ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( $dp_options['photo_slug'] ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['photo_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	$queried_object = get_queried_object();
	if ( ! empty( $queried_object->term_id ) ) :
		$ancestors = get_ancestors( $queried_object->term_id, $dp_options['photo_category_slug'], 'taxonomy' );
		if ( $ancestors ) :
			foreach( array_reverse( $ancestors ) as $term_id ) :
				$term = get_term_by( 'id', $term_id, $dp_options['photo_category_slug'] );
				if ( empty( $term->name ) ) continue;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $term->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
			endforeach;
		endif;
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_author() ) :
	if ( $dp_options['photo_author_headline'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( $dp_options['photo_author_headline'] ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ); ?></span>
			</li>
<?php
elseif ( is_category() ) :
	if ( $dp_options['blog_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;

	$ancestors = get_ancestors( get_query_var( 'cat' ), 'category' );
	if ( $ancestors ) :
		foreach( array_reverse( $ancestors ) as $category_id ) :
			$category = get_term_by( 'id', $category_id, 'category' );
			if ( empty( $category->name ) ) continue;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
		endforeach;
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_tag() ) :
	if ( $dp_options['blog_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( single_tag_title( '', false ) ); ?></span>
			</li>
<?php
elseif ( is_search() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php _e( 'Search result', 'tcd-w' ); ?></span>
			</li>
<?php
elseif ( is_year() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_month() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F, Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_day() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F jS, Y', 'tcd-w' ), $post ) ); ?></span>
			</li>
<?php
elseif ( is_home() ) :
	if ( $dp_options['blog_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo esc_html( $dp_options['blog_label'] ); ?></span>
			</li>
<?php
	endif;
elseif ( is_page() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_singular( 'post' ) ) :
	if ( $dp_options['blog_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;

	$categories = get_the_category();
	if ( $categories ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<?php
		foreach ( $categories as $key => $category ) :
			if ( 0 !== $key ) :
				echo ', ';
			endif;
?>
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" itemscope itemtype="http://schema.org/Thing" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
<?php
		endforeach;
?>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>">
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
			</li>
<?php
elseif ( is_404() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php _e( "Sorry, but you are looking for something that isn't here.", 'tcd-w' ); ?></span>
			</li>
<?php
else :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item">
				<span itemprop="name"><?php echo strip_tags( single_post_title() ); ?></span>
			</li>
<?php
endif;
?>
		</ul>
	</div>
