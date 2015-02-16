<?php get_header(); ?>

<div id="side-right">

<?php if ( is_front_page() ) : ?>
	<div class="cp-tweets" data-usernames="Antoin_LoP" data-count="3"></div>
<?php endif; ?>

	<?php dynamic_sidebar('project'); ?>

</div>

<div id="posts">

<?php

// override and set arguments
$arguments = wp_parse_args( array(
	'post_type'			=> 'project',
	'orderby'           => 'date',
	'order'             => 'DESC',
	'paged'             => get_query_var('page') ? get_query_var('page') : 1,
	'pagename'          => '', // reset page template to behave like archive,
	'numberposts'		=> -1
), $wp_query->query);

// get posts
query_posts( $arguments );

get_template_part( 'inc', 'archive-posts' );

?>

</div><!--posts-->

<?php get_footer(); ?>