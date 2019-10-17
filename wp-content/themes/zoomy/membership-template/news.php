<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<main class="l-main has-bg--pc">
	<div class="p-member-page-header">
		<div class="l-inner">
			<h1 class="p-member-page-header__title"><?php echo esc_html( get_tcd_membership_memberpage_title( 'news' ) ); ?></h1>
		</div>
	</div>
	<div class="l-inner">
		<div class="p-member-page p-member-news">
<?php
if ( is_mobile() ) :
	if ( $dp_options['membership']['mypage_ad_mobile_code1'] || $dp_options['membership']['mypage_ad_mobile_image1'] ) :
		echo "\t\t\t" . '<div class="p-member-news__ad p-member-news__ad-top p-ad">';
		if ( $dp_options['membership']['mypage_ad_mobile_code1'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_mobile_code1'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_mobile_image1'] ) :
			$mypage_ad_mobile_image1 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_mobile_image1'], 'full' );
			if ( $mypage_ad_mobile_image1 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_mobile_url1'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_mobile_image1[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		echo '</div>' . "\n";
	endif;
else :
	if ( $dp_options['membership']['mypage_ad_code1'] || $dp_options['membership']['mypage_ad_image1'] || $dp_options['membership']['mypage_ad_code2'] || $dp_options['membership']['mypage_ad_image2'] ) :
		echo "\t\t\t" . '<div class="p-member-news__ad p-member-news__ad-top p-ad">';
		if ( $dp_options['membership']['mypage_ad_code1'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_code1'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_image1'] ) :
			$mypage_ad_image1 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_image1'], 'full' );
			if ( $mypage_ad_image1 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_url1'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_image1[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		if ( $dp_options['membership']['mypage_ad_code2'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_code2'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_image2'] ) :
			$mypage_ad_image2 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_image2'], 'full' );
			if ( $mypage_ad_image2 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_url2'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_image2[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		echo '</div>' . "\n";
	endif;
endif;

$all_news = get_tcd_membership_news();
if ( $all_news ) :
	$news_per_page = $dp_options['membership']['mypage_news_num'];
	if ( 1 > $news_per_page ) :
		$news_per_page = 10;
	endif;
	$news_current_page = max( 1, get_query_var( 'page' ), get_query_var( 'paged' ), isset( $_GET['paged'] ) ? $_GET['paged'] : 1 );
	$news_max_page = ceil( count( $all_news ) / $news_per_page );
	if ( $news_current_page > $news_max_page ) :
		$news_current_page = $news_max_page;
	endif;
	$newses = array_slice($all_news, ( $news_current_page - 1 ) * $news_per_page,$news_per_page);

	$current_ts = current_time( 'timestamp', false );
	$current_ts_gmt = current_time( 'timestamp', true );
	$current_ts_offset = $current_ts - $current_ts_gmt;
?>
			<ul class="p-member-news__list">
<?php
	$news_content = '';
	foreach ( $newses as $news ) :
		$user = get_user_by( 'id', $news->user_id );
		$comment_author = null;

		// 未読か
		if ( ! is_tcd_membership_news_read( $news->id ) ) :
			$is_unread = true;
		else :
			$is_unread = false;
		endif;

		if ( 'member_news' === $news->type ) :
			$member_news = get_post( $news->post_id );
			if ( $member_news && 'member_news' === $member_news->post_type ) :
				$news_content = wpautop( $member_news->post_content );
			else :
				continue;
			endif;

		elseif ( 'follow' === $news->type ) :
			$news_content = __( 'You was followed.', 'tcd-w' );
			if ( ! is_following( $news->user_id ) ) :
				$news_content .= __( 'Would you follow?', 'tcd-w' );
			endif;

		elseif ( 'like' === $news->type ) :
			$post_title = strip_tags( get_the_title( $news->post_id ) );
			$post_url = get_permalink( $news->post_id );
			$news_content = sprintf( __( 'Liked to <a href="%s">%s</a>.', 'tcd-w' ), $post_url, mb_strimwidth( $post_title, 0, 80, '...') );

		elseif ( 'comment' === $news->type ) :
			$post_title = strip_tags( get_the_title( $news->post_id ) );
			$post_url = get_permalink( $news->post_id );
			$news_content = sprintf( __( 'Commented to <a href="%s">%s</a>.', 'tcd-w' ), $post_url, mb_strimwidth( $post_title, 0, 80, '...') );
			if ( ! $user ) :
				$comment_id = get_tcd_membership_action_meta( $news->id, 'comment_id' );
				if ( $comment_id ) :
					$comment_author = get_comment_author( $comment_id );
				endif;
			endif;

		else :
			$news_content = $news->type;
		endif;

		$news_ts_gmt = strtotime( $news->created_gmt );
		$news_ts = $news_ts_gmt + $current_ts_offset;
		if ( date( 'Ymd', $news_ts ) === date( 'Ymd', $current_ts ) ) :
			$news_date = human_time_diff( $news_ts, $current_ts ) . __( ' ago', 'tcd-w' );
		else :
			$news_date = date( 'Y.m.d', $news_ts );
		endif;
?>
				<li class="p-member-news__item<?php if ( $is_unread ) echo ' is-unread'; ?>">
<?php
		if ( ! empty( $user->ID ) ) :
?>
					<a class="p-member-news__item-author p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( get_author_posts_url( $user->ID ) ); ?>">
						<span class="p-member-news__item-author_thumbnail p-hover-effect__image"><?php echo get_avatar( $user->ID, 96 ); ?></span>
						<span class="p-member-news__item-author_name"><?php echo esc_html( $user->display_name ); ?></span>
					</a>
<?php
		else :
?>
					<div class="p-member-news__item-author p-article__author">
						<span class="p-member-news__item-author_thumbnail p-article__author-thumbnail"><?php echo get_avatar( 0, 96, array( 'default' => 'mystery', 'force_default' => 1 ) ); ?></span>
						<span class="p-member-news__item-author_name p-article__author-name"><?php echo esc_html( $comment_author ? $comment_author : __( 'Guest' , 'tcd-w' ) ); ?></span>
					</div>
<?php
		endif;
?>
					<div class="p-member-news__item-content p-body"><?php echo $news_content; ?></div>
					<time class="p-member-news__item-date"><?php echo esc_html( $news_date ); ?></time>
				</li>
<?php
		// 既読にする
		if ( $is_unread ) :
			tcd_membership_news_read( $news->id );
		endif;
	endforeach;
?>
			</ul>
<?php
	$paginate_links = paginate_links( array(
		'current' => $news_current_page,
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $news_max_page,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-member-news__pager p-pager">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
else :
?>
			<ul class="p-member-news__list">
				<li class="p-member-news__item"><?php _e( 'There is no registered news.', 'tcd-w' ); ?></li>
			</ul>
<?php
endif;

if ( is_mobile() ) :
	if ( $dp_options['membership']['mypage_ad_mobile_code2'] || $dp_options['membership']['mypage_ad_mobile_image2'] ) :
		echo "\t\t\t" . '<div class="p-member-news__ad p-member-news__ad-bottom p-ad">';
		if ( $dp_options['membership']['mypage_ad_mobile_code2'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_mobile_code2'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_mobile_image2'] ) :
			$mypage_ad_mobile_image2 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_mobile_image2'], 'full' );
			if ( $mypage_ad_mobile_image2 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_mobile_url2'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_mobile_image2[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		echo '</div>' . "\n";
	endif;
else :
	if ( $dp_options['membership']['mypage_ad_code3'] || $dp_options['membership']['mypage_ad_image3'] || $dp_options['membership']['mypage_ad_code4'] || $dp_options['membership']['mypage_ad_image4'] ) :
		echo "\t\t\t" . '<div class="p-member-news__ad p-member-news__ad-bottom p-ad">';
		if ( $dp_options['membership']['mypage_ad_code3'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_code3'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_image3'] ) :
			$mypage_ad_image3 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_image3'], 'full' );
			if ( $mypage_ad_image3 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_url3'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_image3[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		if ( $dp_options['membership']['mypage_ad_code4'] ) :
			echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-code">' . $dp_options['membership']['mypage_ad_code4'] . '</div>';
		elseif ( $dp_options['membership']['mypage_ad_image4'] ) :
			$mypage_ad_image4 = wp_get_attachment_image_src( $dp_options['membership']['mypage_ad_image4'], 'full' );
			if ( $mypage_ad_image4 ) :
				echo '<div class="p-member-news__ad-item p-ad__item p-ad__item-image"><a href="' . esc_url( $dp_options['membership']['mypage_ad_url4'] ) . '" target="_blank"><img src="' . esc_attr( $mypage_ad_image4[0] ) . '" alt=""></a></div>';
			endif;
		endif;
		echo '</div>' . "\n";
	endif;
endif;
?>
		</div>
	</div>
</main>
<?php
get_footer();
