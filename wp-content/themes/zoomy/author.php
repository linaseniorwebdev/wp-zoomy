<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

get_header();
?>
<main class="l-main">
	<div class="p-author">
<?php
$author = get_queried_object();

if ( $author->header_image ) :
?>
		<div class="p-author__header_image" style="background-image: url(<?php echo esc_url( $author->header_image ); ?>);"></div>
<?php
endif;
?>
		<div class="l-inner">
			<div class="p-author__thumbnail js-object-fit-cover"><?php echo get_avatar( $author->ID, 300 ); ?></div>
			<h1 class="p-author__name"><?php echo esc_html( $author->display_name ); ?></h1>
<?php
if ( ( $dp_options['membership']['show_account_area'] || $dp_options['membership']['show_profile_area'] ) && $author->area ) :
?>
			<p class="p-author__area"><?php echo esc_html( $author->area ); ?></p>
<?php
endif;
if ( $dp_options['membership']['show_profile_job'] && $author->job ) :
?>
			<p class="p-author__job"><?php echo esc_html( $author->job ); ?></p>
<?php
endif;

if ( $dp_options['membership']['use_follow'] ) :
?>
			<div class="p-author__follow">
<?php
	if ( is_following( $author->ID ) ) :
?>
				<a class="p-button-following js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Following', 'tcd-w' ); ?></a>
<?php
	else :
?>
				<a class="p-button-follow js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Follow', 'tcd-w' ); ?></a>
<?php
	endif;
?>
			</div>
<?php
endif;

if ( $dp_options['membership']['show_profile_desc'] && $author->description ) :
?>
			<div class="p-entry__body p-author__body p-body">
<?php
	// URL自動リンク
	$desc = zoomy_url_auto_link( $author->description );
	echo wpautop( trim( $desc ) );
?>
			</div>
<?php
endif;

$sns_html = '';
if ( $dp_options['membership']['show_profile_website'] && $author->user_url ) :
	$sns_html .= '<li class="p-social-nav__item p-social-nav__item--url"><a href="' . esc_attr( $author->user_url ) . '" target="_blank"></a></li>';
endif;
if ( $dp_options['membership']['show_profile_facebook'] && $author->facebook_url ) :
	$sns_html .= '<li class="p-social-nav__item p-social-nav__item--facebook"><a href="' . esc_attr( $author->facebook_url ) . '" target="_blank"></a></li>';
endif;
if ( $dp_options['membership']['show_profile_twitter'] && $author->twitter_url ) :
	$sns_html .= '<li class="p-social-nav__item p-social-nav__item--twitter"><a href="' . esc_attr( $author->twitter_url ) . '" target="_blank"></a></li>';
endif;
if ( $dp_options['membership']['show_profile_instagram'] && $author->instagram_url ) :
	$sns_html .= '<li class="p-social-nav__item p-social-nav__item--instagram"><a href="' . esc_attr( $author->instagram_url ) . '" target="_blank"></a></li>';
endif;

if ( $sns_html ) :
?>
			<ul class="p-social-nav p-social-nav--author"><?php echo $sns_html; ?></ul>
<?php
endif;
?>
		</div>
	</div>
<?php
if ( $dp_options['membership']['use_front_edit_photo'] || $dp_options['membership']['use_front_edit_photo'] || $dp_options['membership']['use_follow'] ) :
?>
	<div class="p-author__lists">
		<div id="js-author__list-tabs" class="p-author__list-tabs">
			<ul class="p-author__list-tabs__inner l-inner">
<?php
	$list_totals = get_author_list_totals( $author->ID );
	$is_active = ' is-active';

	if ( $dp_options['membership']['use_front_edit_photo'] || $list_totals['photo']['total'] ) :
?>
				<li class="p-author__list-tab<?php echo $is_active; ?>" data-list-type="photo" data-max-page="<?php echo absint( $list_totals['photo']['max_num_pages'] ); ?>"><h2 class="p-author__list-tab_title"><?php echo esc_html( $dp_options['photo_label'] ); ?></h2><span class="p-author__list-tab_badge"><?php printf( __( '%d posts', 'tcd-w' ), $list_totals['photo']['total'] ); ?></span></li>
<?php
		$is_active = null;
	endif;
	if ( $dp_options['membership']['use_front_edit_blog'] || $list_totals['post']['total'] ) :
?>
				<li class="p-author__list-tab<?php echo $is_active; ?>" data-list-type="post" data-max-page="<?php echo absint( $list_totals['post']['max_num_pages'] ); ?>"><h2 class="p-author__list-tab_title"><?php echo esc_html( $dp_options['blog_label'] ); ?></h2><span class="p-author__list-tab_badge"><?php printf( __( '%d posts', 'tcd-w' ), $list_totals['post']['total'] ); ?></span></li>
<?php
		$is_active = null;
	endif;
	if ( $dp_options['membership']['use_follow'] ) :
?>
				<li class="p-author__list-tab<?php echo $is_active; ?>" data-list-type="follower" data-max-page="<?php echo absint( $list_totals['follower']['max_num_pages'] ); ?>"><h2 class="p-author__list-tab_title"><?php _e( 'Follower', 'tcd-w' ) ?></h2><span class="p-author__list-tab_badge"><?php printf( __( '%d users', 'tcd-w' ), $list_totals['follower']['total'] ); ?></span></li>
				<li class="p-author__list-tab" data-list-type="following" data-max-page="<?php echo absint( $list_totals['following']['max_num_pages'] ); ?>"><h2 class="p-author__list-tab_title"><?php _e( 'Following', 'tcd-w' ) ?></h2><span class="p-author__list-tab_badge"><?php printf( __( '%d users', 'tcd-w' ), $list_totals['following']['total'] ); ?></span></li>
<?php
		$is_active = null;
	endif;
?>
			</ul>
		</div>
		<div class="p-author__lists__inner">
			<div id="js-author__list" class="p-author__list l-inner" data-user-id="<?php echo esc_attr( $author->ID ); ?>"></div>
		</div>
	</div>
<?php
endif;
?>
</main>
<?php
get_footer();
