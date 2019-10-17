<?php
$dp_options = get_design_plus_option();
$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main has-bg--pc">
<?php
get_template_part( 'template-parts/page-header' );
if ( $dp_options['show_breadcrumb_archive_information'] ) :
	get_template_part( 'template-parts/breadcrumb' );
endif;

if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
		<div class="l-primary">
<?php
else :
?>
	<div class="l-inner">
<?php
endif;

if ( have_posts() ) :
?>
			<div class="p-archive-information">
<?php
	while ( have_posts() ) :
		the_post();
?>
				<article class="p-archive-information__item">
					<div class="p-entry__body p-entry-information__body p-body">
<?php
		if ( $dp_options['show_date_information'] ) :
?>
						<p class="p-archive-information__item-date"><time datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
		endif;

		$post_content = $post->post_content;
		if ( false !== strpos( $post_content, '<!--nextpage-->' ) ) :
			$post_content = str_replace( array( "\n<!--nextpage-->\n", "\n<!--nextpage-->", "<!--nextpage-->\n", '<!--nextpage-->' ), '', $post_content );
		endif;
		echo apply_filters( 'the_content', $post_content );
?>
					</div>
				</article>
<?php
	endwhile;
?>
			</div>
<?php
	$paginate_links = paginate_links( array(
		'current' => max( 1, get_query_var( 'paged' ) ),
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager p-pager-information">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item<?php if ( strpos( $paginate_link, 'current' ) ) echo ' p-pager__item--current'; ?>"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
endif;

if ( $active_sidebar ) :
?>
		</div>
<?php
	get_sidebar();
?>
	</div>
<?php
else :
?>
	</div>
<?php
endif;
?>
</main>
<?php
get_footer();
