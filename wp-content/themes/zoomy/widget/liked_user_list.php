<?php
/**
 * Liked User List (tcd ver)
 */
class Liked_User_List_Widget extends WP_Widget {

	/**
	 * Default instance.
	 */
	protected $default_instance = array(
		'title' => '',
		'liked_users_num' => 10,
		'liked_users_order' => 0
	);

	function __construct() {
		$this->default_instance['title'] = __( 'Liked users', 'tcd-w' );

		parent::__construct(
			'liked_user_list_widget', // ID
			__( 'Liked User List (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'liked_user_list_widget',
				'description' => __( "Displays liked user list when displayed single page.", 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options, $post, $wpdb;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		// ブログ・写真詳細のみ
		if ( ! is_singular( array( 'post', $dp_options['photo_slug'] ) ) ) return;

		extract( $args );

		$instance = array_merge( $this->default_instance, $instance );
		$post_author = get_user_by( 'id', $post->post_author );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$liked_users_num = isset( $instance['liked_users_num'] ) ? absint( $instance['liked_users_num'] ) : 10;
		$liked_users_order = isset( $instance['liked_users_order'] ) ? $instance['liked_users_order'] : 'date1';

		$tablename = $wpdb->prefix . 'tcd_membership_actions';

		$sql = "SELECT user_id FROM {$tablename} WHERE type = 'like' AND post_id = %d";

		if ( 'rand' == $liked_users_order ) {
			$sql .= " ORDER BY RAND()";
		} elseif ( 'date2' == $liked_users_order ) {
			$sql .= " ORDER BY id ASC";
		} else {
			$sql .= " ORDER BY id DESC";
		}

		if ( $liked_users_num > 0 ) {
			$sql .= " LIMIT {$liked_users_num}";
		}

		$user_ids = $wpdb->get_col( $wpdb->prepare( $sql, $post->ID ) );

		if ( $user_ids ) {
			echo $before_widget;

			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			echo '<ul class="p-widget-users-list u-clearfix">' . "\n";
			foreach ( $user_ids as $user_id ) {
				$user = get_user_by( 'id', $user_id );
				if ( ! $user ) continue;

				echo "\t" . '<li class="p-widget-users-list__item">';
				echo '<a class="p-widget-users-list__item-thumbnail p-hover-effect--' . esc_attr( $dp_options['hover_type'] ) . get_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ) . '" href="' . esc_attr( get_author_posts_url( $user_id ) ) . '" title="' . esc_attr( $user->display_name ) . '">';
				echo '<span class="p-hover-effect__image js-object-fit-cover">';
				echo get_avatar( $user_id, 96, null, $user->display_name );
				echo '</span></a></li>' . "\n";
			}

			echo '</ul>' . "\n";

			echo $after_widget;
		}
	}

	function form( $instance ) {
		$instance = array_merge( $this->default_instance, $instance );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'liked_users_num' ); ?>"><?php _e( 'Number of post:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'liked_users_num' ); ?>" name="<?php echo $this->get_field_name( 'liked_users_num' ); ?>" type="number" value="<?php echo esc_attr( $instance['liked_users_num'] ); ?>" min="1">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'liked_users_order' ); ?>"><?php _e( 'Post order:', 'tcd-w' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'liked_users_order' ); ?>" name="<?php echo $this->get_field_name( 'liked_users_order' ); ?>">
				<option value="date1" <?php selected( $instance['liked_users_num'], 'date1' ); ?>><?php _e( 'Liked date (DESC)', 'tcd-w' ); ?></option>
				<option value="date2" <?php selected( $instance['liked_users_num'], 'date2' ); ?>><?php _e( 'Liked date (ASC)', 'tcd-w' ); ?></option>
				<option value="rand" <?php selected( $instance['liked_users_num'], 'rand' ); ?>><?php _e( 'Random', 'tcd-w' ); ?></option>
			</select>
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['liked_users_num'] = absint( $new_instance['liked_users_num'] );
		$instance['liked_users_order'] = strip_tags( $new_instance['liked_users_order'] );
		return $instance;
	}
}

function register_Liked_User_List_Widget() {
	register_widget( 'Liked_User_List_Widget' );
}
add_action( 'widgets_init', 'register_Liked_User_List_Widget' );
