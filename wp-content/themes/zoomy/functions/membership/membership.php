<?php

// 定数
define( 'TCD_MEMBERSHIP_VERSION', '1.0' );
define( 'TCD_MEMBERSHIP_DATABASE_VERSION', '1.0' );

// TCD Membership database
get_template_part( 'functions/membership/database' );

// TCD Membership options
get_template_part( 'functions/membership/options' );

// TCD Membership backend
get_template_part( 'functions/membership/backend' );

// TCD Membership member news
get_template_part( 'functions/membership/member_news' );

// TCD Membership mail magazine
get_template_part( 'functions/membership/mail_magazine' );

// TCD Membership frontend
get_template_part( 'functions/membership/frontend' );

// TCD Membership memberpage
get_template_part( 'functions/membership/memberpage' );

// TCD Membership user
get_template_part( 'functions/membership/user' );

// TCD Membership user form
get_template_part( 'functions/membership/user_form' );

// TCD Membership user profile
get_template_part( 'functions/membership/user_profile' );

// TCD Membership add/edit/delete blog
get_template_part( 'functions/membership/blog' );

// TCD Membership add/edit/delete photo
get_template_part( 'functions/membership/photo' );

// TCD Membership comment
get_template_part( 'functions/membership/comment' );

// TCD Membership follow
get_template_part( 'functions/membership/follow' );

// TCD Membership like
get_template_part( 'functions/membership/like' );

// TCD Membership news
get_template_part( 'functions/membership/news' );

// TCD Membership main image
get_template_part( 'functions/membership/main_image' );

// TCD Membership notify
get_template_part( 'functions/membership/notify' );

// load options
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
