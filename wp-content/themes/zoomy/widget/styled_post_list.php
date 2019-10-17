<?php
/**
 * Styled post list (tcd ver)
 */
class Styled_Post_List_widget extends WP_Widget {

	/**
	 * post types.
	 */
	protected $post_types = array();

	/**
	 * List types.
	 */
	protected $list_types = array();

	/**
	 * Default instance.
	 */
	protected $default_instance = array();

	function __construct() {
		global $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		$this->post_types = array(
			'post' => $dp_options['blog_label'] ? $dp_options['blog_label'] : __( 'Blog', 'tcd-w' ),
			'photo' => $dp_options['photo_label'] ? $dp_options['photo_label'] : __( 'Photo', 'tcd-w' )
		);

		$this->list_types = array(
			'all' => __( 'All posts', 'tcd-w' ),
			'recommend_post' => __( 'Recommend post', 'tcd-w' ),
			'recommend_post2' => __( 'Recommend post2', 'tcd-w' ),
			'pickup_post' => __( 'Pickup post', 'tcd-w' ),
			'category' => __( 'Category', 'tcd-w'),
			'photo_category' => $dp_options['photo_category_label'] ? $dp_options['photo_category_label'] : __( 'Photo category', 'tcd-w' )
		);

		$this->default_instance = array(
			'title' => __( 'Recent post', 'tcd-w' ),
			'post_type' => 'post',
			'list_type' => 'all',
			'category' => 0,
			'photo_category' => 0,
			'post_num' => 4,
			'post_order' => 'date1',
			'show_date' => 1,
			'show_category' => 1,
			'show_comments_number' => 1,
			'show_views_number' => 1,
			'show_likes_number' => 1,
			'button' => '',
			'button_font_color' => '#ffffff',
			'button_bg_color' => $dp_options['primary_color'],
			'button_font_color_hover' => '#ffffff',
			'button_bg_color_hover' => $dp_options['secondary_color'],
			'button_url' => '',
			'button_target_blank' => 0,
			'is_singular_change_to_author_recent_post' => 0,
			'title2' => __( "[author_display_name]'s recent post", 'tcd-w' )
		);

		parent::__construct(
			'styled_post_list_widget', // ID
			__( 'Styled post list (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'styled_post_list_widget',
				'description' => __( 'Displays styled post list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options, $post;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		extract( $args );

		$instance = array_merge( $this->default_instance, $instance );
		if ( ! empty( $instance['is_singular_change_to_author_recent_post'] ) && is_singular( array( 'post', $dp_options['photo_slug'] ) ) && $instance['title2'] ) {
			$author = get_user_by( 'id', $post->post_author );
			$title = apply_filters( 'widget_title', str_replace('[author_display_name]', $author->display_name, $instance['title2'] ) );
		} else {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$post_type = isset( $instance['post_type'] ) ? $instance['post_type'] : 'post';
		$list_type = isset( $instance['list_type'] ) ? $instance['list_type'] : 'all';
		$category = isset( $instance['category'] ) ? $instance['category'] : 0;
		$photo_category = isset( $instance['photo_category'] ) ? $instance['photo_category'] : 0;
		$post_num = isset( $instance['post_num'] ) ? absint( $instance['post_num'] ) : 5;
		$post_order = isset( $instance['post_order'] ) ? $instance['post_order'] : 'date1';
		$show_date = ! empty( $instance['show_date'] );
		$show_category = ! empty( $instance['show_category'] );
		$show_comments_number = ! empty( $instance['show_comments_number'] );
		$show_views_number = ! empty( $instance['show_views_number'] );
		$show_likes_number = ! empty( $instance['show_likes_number'] );

		if ( 'photo' == $post_type ) {
			$use_like = $dp_options['membership']['use_like_photo'];
			$post_type = $dp_options['photo_slug'];
		} else {
			$use_like = $dp_options['membership']['use_like_blog'];
		}

		if ( ( $show_comments_number && get_comments_number() ) || $show_views_number || ( $use_like && $show_likes_number ) ) {
			$show_counts = true;
		} else {
			$show_counts = false;
		}

		if ( 'date2' == $post_order ) {
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}
		if ( $post_order == 'date1' || $post_order == 'date2' ) {
			$post_order = 'date';
		}

		$list_args = array();

		if ( in_array( $list_type, array( 'recommend_post', 'recommend_post2', 'pickup_post' ) ) ) {
			$list_args = array(
				'post_type' => $post_type,
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order,
				'meta_key' => $list_type,
				'meta_value' => 'on'
			);
		} elseif ( 'category' == $list_type && $category ) {
			$list_args = array(
				'post_type' => $post_type,
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order,
				'cat' => $category
			);
		} elseif ( 'photo_category' == $list_type && $photo_category ) {
			$list_args = array(
				'post_type' => $post_type,
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order,
				'tax_query' => array(
					array(
						'taxonomy' => $dp_options['photo_category_slug'],
						'field' => 'term_id',
						'terms' => $photo_category
					),
				)
			);
		} elseif ( 'all' == $list_type ) {
			$list_args = array(
				'post_type' => $post_type,
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order
			);
		}

		if ( ! empty( $instance['is_singular_change_to_author_recent_post'] ) && is_singular( array( 'post', $dp_options['photo_slug'] ) ) ) {
			$list_args['author'] = $post->post_author;
		}

		if ( $post_order == 'views' ) {
			$list_args['orderby'] = 'meta_value_num';
			$list_args['meta_key'] = '_views';
		} elseif ( $post_order == 'likes' ) {
			$list_args['orderby'] = 'meta_value_num';
			$list_args['meta_key'] = '_likes';
		}

		// フッター上ウィジェット
		if ( isset( $args['id'] ) && false !== strpos( $args['id'], 'above_footer_widget' ) ) :
			$items_tag = 'div';
			$items_class = 'p-blog-archive';
			$item_tag = 'article';
			$item_class = 'p-blog-archive__item';
		else :
			$items_tag = 'ul';
			$items_class = 'p-widget-list';
			$item_tag = 'li';
			$item_class = 'p-widget-list__item';
		endif;

		$widget_query = new WP_Query( $list_args );

		if ( $widget_query->have_posts() ) :
			echo $before_widget;

			if ( $title ) :
				echo $before_title . $title . $after_title;
			endif;
?>
<<?php echo $items_tag; ?> class="<?php echo $items_class; ?>">
<?php
			while ( $widget_query->have_posts() ) :
				$widget_query->the_post();

				$author = get_user_by( 'id', $post->post_author );

				$catlist_float = array();
				if ( $show_category ) :
					if ( get_post_type() == $dp_options['photo_slug'] ) :
						$categories = get_the_terms( $post->ID, $dp_options['photo_category_slug'] );
					else :
						$categories = get_the_category();
					endif;
					if ( $categories && ! is_wp_error( $categories ) ) :
						foreach( $categories as $category ) :
							$catlist_float[] = '<span class="p-category-item' . get_tcd_membership_guest_require_login_class( $post->post_type, 'archive', ' ' ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
							break;
						endforeach;
					endif;
				endif;
?>
	<<?php echo $item_tag; ?> class="<?php echo $item_class; if ( $show_counts ) echo ' has-counts'; ?>">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( $post_type, 'single', ' ' ); ?> u-clearfix" href="<?php the_permalink(); ?>">
			<div class="<?php echo $item_class; ?>-thumbnail p-hover-effect__image js-object-fit-cover">
				<div class="<?php echo $item_class; ?>-thumbnail__inner">
<?php
				echo "\t\t\t\t\t";
				if ( has_main_image() ) :
					the_main_image( 'size2' );
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'size2' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-600x600.gif" alt="">';
				endif;
				echo "\n";

				if ( $show_date ) :
					echo "\t\t\t\t\t";
					echo '<div class="' . $item_class . '-thumbnail_meta p-article__meta">';
					echo '<time class="p-article__date" datetime="' . get_the_time( 'c' ) . '">' . zoomy_get_human_time_diff() . '</time>';
					echo '</div>' . "\n";
				endif;

				if ( $catlist_float ) :
					echo "\t\t\t\t\t";
					echo '<div class="p-float-category">' . implode( '', $catlist_float ) . '</div>' . "\n";
				endif;
?>
				</div>
			</div>
			<h3 class="<?php echo $item_class; ?>-title p-article-<?php echo esc_attr( $post->post_type ); ?>__title p-article__title js-multiline-ellipsis"><?php echo mb_strimwidth( strip_tags( get_the_title() ), 0, 80, '...' ); ?></h3>
			<div class="<?php echo $item_class; ?>-author p-article__author<?php the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" data-url="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
				<span class="<?php echo $item_class; ?>-author_thumbnail p-article__author-thumbnail"><?php echo get_avatar( $author->ID, 96 ); ?></span>
				<span class="<?php echo $item_class; ?>-author_name p-article__author-name"><?php echo esc_html( $author->display_name ); ?></span>
			</div>
		</a>
<?php
				if ( $show_counts ) :
?>
		<ul class="<?php echo $item_class; ?>-counts">
<?php
					if ( $show_comments_number && get_comments_number() ) :
?>
			<li class="p-has-icon p-icon-comment"><?php echo get_comments_number(); ?></li>
<?php
					endif;
					if ( $show_views_number ) :
?>
			<li class="p-has-icon p-icon-views"><?php the_post_views(); ?></li>
<?php
					endif;
					if ( $use_like && $show_likes_number ) :
?>
			<li class="p-has-icon p-icon-like<?php if ( is_liked() ) echo 'd'; ?> js-toggle-like" data-post-id="<?php echo get_the_ID(); ?>"><?php echo get_likes_number(); ?></li>
<?php
					endif;
?>
		</ul>
<?php
				endif;
?>
	</<?php echo $item_tag; ?>>
<?php
			endwhile;
			wp_reset_postdata();
?>
</<?php echo $items_tag; ?>>
<?php
			if ( ! empty( $instance['is_singular_change_to_author_recent_post'] ) && ! empty( $list_args['author'] ) ) :
				$instance['button_url'] = get_author_posts_url( $list_args['author'] );
			endif;
			if ( $instance['button'] && $instance['button_url'] ) :
?>
<div class="p-widget-list__button">
	<a class="p-button" href="<?php echo esc_attr( $instance['button_url'] ); ?>"<?php if ( $instance['button_target_blank'] ) echo ' target="_blank"'; ?>><?php echo esc_html( $instance['button'] )?></a>
</div>
<?php
			endif;

			echo $after_widget;
		endif;
	}

	function form( $instance ) {
		global $dp_options;

		$instance = array_merge( $this->default_instance, $instance );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', 'tcd-w' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
<?php
	foreach ( $this->post_types as $key => $value ) :
		echo '<option value="' . esc_attr( $key ) . '" ' . selected( $instance['post_type'], $key, false ) . '>' . esc_html( $value ) . '</option>';
	endforeach;
?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'list_type' ); ?>"><?php _e( 'List type:', 'tcd-w' ); ?></label>
			<select class="widefat js-styled_post_list-list_type" id="<?php echo $this->get_field_id( 'list_type' ); ?>" name="<?php echo $this->get_field_name( 'list_type' ); ?>">
<?php
	foreach ( $this->list_types as $key => $value ) :
		echo '<option value="' . esc_attr( $key ) . '" ' . selected( $instance['list_type'], $key, false ) . '>' . esc_html( $value ) . '</option>';
	endforeach;
?>
			</select>
		</p>
		<p class="styled_post_list-list_type-category<?php echo 'category' == $instance['list_type'] ? '' : ' hidden'; ?>">
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'tcd-w' ); ?></label>
<?php
	wp_dropdown_categories( array(
		'class' => 'widefat',
		'echo' => 1,
		'hide_empty' => 0,
		'hierarchical' => 1,
		'id' => $this->get_field_id( 'category' ),
		'name' => $this->get_field_name( 'category' ),
		'selected' => $instance['category'],
		'show_count' => 0,
		'value_field' => 'term_id'
	) );
?>
		</p>
		<p class="styled_post_list-list_type-photo_category<?php echo 'photo_category' == $instance['list_type'] ? '' : ' hidden'; ?>">
			<label for="<?php echo $this->get_field_id( 'photo_category' ); ?>"><?php echo esc_html( $dp_options['photo_category_label'] ? $dp_options['photo_category_label'] : __( 'Photo category', 'tcd-w' ) ); ?></label>
<?php
	wp_dropdown_categories( array(
		'class' => 'widefat',
		'echo' => 1,
		'hide_empty' => 0,
		'hierarchical' => 1,
		'id' => $this->get_field_id( 'photo_category' ),
		'name' => $this->get_field_name( 'photo_category' ),
		'selected' => $instance['photo_category'],
		'show_count' => 0,
		'taxonomy' => $dp_options['photo_category_slug'],
		'value_field' => 'term_id',
	) );
?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of post:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" type="number" value="<?php echo esc_attr( $instance['post_num'] ); ?>" min="1">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_order' ); ?>"><?php _e( 'Post order:', 'tcd-w' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_order' ); ?>" name="<?php echo $this->get_field_name( 'post_order' ); ?>">
				<option value="date1" <?php selected( $instance['post_order'], 'date1' ); ?>><?php _e( 'Date (DESC)', 'tcd-w' ); ?></option>
				<option value="date2" <?php selected( $instance['post_order'], 'date2' ); ?>><?php _e( 'Date (ASC)', 'tcd-w' ); ?></option>
				<option value="views" <?php selected( $instance['post_order'], 'views' ); ?>><?php _e( 'Views (DESC)', 'tcd-w' ); ?></option>
				<option value="likes" <?php selected( $instance['post_order'], 'likes' ); ?>><?php _e( 'Likes (DESC)', 'tcd-w' ); ?></option>
				<option value="rand" <?php selected( $instance['post_order'], 'rand' ); ?>><?php _e( 'Random', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_date'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display date', 'tcd-w' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_category'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Display category', 'tcd-w' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_comments_number' ); ?>" name="<?php echo $this->get_field_name( 'show_comments_number' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_comments_number'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_comments_number' ); ?>"><?php _e( 'Display comments number', 'tcd-w' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_views_number' ); ?>" name="<?php echo $this->get_field_name( 'show_views_number' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_views_number'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_views_number' ); ?>"><?php _e( 'Display views number', 'tcd-w' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_likes_number' ); ?>" name="<?php echo $this->get_field_name( 'show_likes_number' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_likes_number'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_likes_number' ); ?>"><?php _e( 'Display likes number', 'tcd-w' ); ?></label>
		</p>
		<div style="margin:1em 0;">
			<label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Button label', 'tcd-w' ); ?>:</label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" value="<?php echo esc_attr( $instance['button'] ); ?>">
			<label for="<?php echo $this->get_field_id( 'button_font_color' ); ?>"><?php _e( 'Font color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_font_color' ); ?>" name="<?php echo $this->get_field_name( 'button_font_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_font_color'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_bg_color' ); ?>"><?php _e( 'Background color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'button_bg_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_bg_color'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_font_color_hover' ); ?>"><?php _e( 'Font hover color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_font_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'button_font_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_font_color_hover'] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'button_bg_color_hover' ); ?>"><?php _e( 'Background hover color', 'tcd-w' ); ?>:</label>
			<div><input class="c-color-picker-widget" id="<?php echo $this->get_field_id( 'button_bg_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'button_bg_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $this->default_instance['button_bg_color_hover'] ); ?>"></div>
		</div>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php _e( 'Button link URL', 'tcd-w' ); ?>:</label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_url'] ); ?>">
			<label for="<?php echo $this->get_field_id( 'button_target_blank' ); ?>">
				<input id="<?php echo $this->get_field_id( 'button_target_blank' ); ?>" name="<?php echo $this->get_field_name( 'button_target_blank' ); ?>" type="checkbox" value="1" <?php checked( $instance['button_target_blank'], '1' ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?>
			</label>
		</p>
		<p>
			<input class="is_singular_change_to_author_recent_post" id="<?php echo $this->get_field_id( 'is_singular_change_to_author_recent_post' ); ?>" name="<?php echo $this->get_field_name( 'is_singular_change_to_author_recent_post' ); ?>" type="checkbox" value="1" <?php checked( $instance['is_singular_change_to_author_recent_post'], 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'is_singular_change_to_author_recent_post' ); ?>"><?php _e( 'If displayed singular page, Display Author\'s articles', 'tcd-w' ); ?></label>
		</p>
		<div class="widget-is_singular_change_to_author_recent_post-fields<?php if ( empty( $instance['is_singular_change_to_author_recent_post'] ) ) echo ' hidden'; ?>">
			<p>
				<label for="<?php echo $this->get_field_id( 'title2' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
				<input class="large-text" id="<?php echo $this->get_field_id( 'title2' ); ?>" name="<?php echo $this->get_field_name( 'title2' ); ?>" type="text" value="<?php echo esc_attr( $instance['title2'] ); ?>">
			</p>
		</div>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_type'] = isset( $new_instance['post_type'] ) ? strip_tags( $new_instance['post_type'] ) : 'post';
		$instance['list_type'] = isset( $new_instance['list_type'] ) ? strip_tags( $new_instance['list_type'] ) : 'all';
		$instance['category'] = isset( $new_instance['category'] ) ? absint( $new_instance['category'] ) : 0;
		$instance['photo_category'] = isset( $new_instance['photo_category'] ) ? absint( $new_instance['photo_category'] ) : 0;
		$instance['post_num'] = isset( $new_instance['post_num'] ) ? absint( $new_instance['post_num'] ) : 5;
		$instance['post_order'] = isset( $new_instance['post_order'] ) ? strip_tags( $new_instance['post_order'] ) : 'date1';
		$instance['show_date'] = ! empty( $new_instance['show_date'] ) ? 1 : 0;
		$instance['show_category'] = ! empty( $new_instance['show_category'] ) ? 1 : 0;
		$instance['show_comments_number'] = ! empty( $new_instance['show_comments_number'] ) ? 1 : 0;
		$instance['show_views_number'] = ! empty( $new_instance['show_views_number'] ) ? 1 : 0;
		$instance['show_likes_number'] = ! empty( $new_instance['show_likes_number'] ) ? 1 : 0;
		$instance['button'] = strip_tags( $new_instance['button'] );
		$instance['button_font_color'] = strip_tags( $new_instance['button_font_color'] );
		$instance['button_bg_color'] = strip_tags( $new_instance['button_bg_color'] );
		$instance['button_font_color_hover'] = strip_tags( $new_instance['button_font_color_hover'] );
		$instance['button_bg_color_hover'] = strip_tags( $new_instance['button_bg_color_hover'] );
		$instance['button_url'] = strip_tags( $new_instance['button_url'] );
		$instance['button_target_blank'] = ! empty( $new_instance['button_target_blank'] ) ? 1 : 0;
		$instance['is_singular_change_to_author_recent_post'] = ! empty( $new_instance['is_singular_change_to_author_recent_post'] ) ? 1 : 0;
		$instance['title2'] = isset( $new_instance['title2'] ) ? strip_tags( $new_instance['title2'] ) : '';
		return $instance;
	}
}

function register_styled_post_list_widget() {
	register_widget( 'Styled_Post_List_widget' );
}
add_action( 'widgets_init', 'register_styled_post_list_widget' );
