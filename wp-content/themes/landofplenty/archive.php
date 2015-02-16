<?php get_header(); ?>

<div id="side-right">

	<div class="cp-tweets" data-usernames="akkiebosje" data-count="3"></div>

	<?php dynamic_sidebar('blog'); ?>
</div>

<div id="archive">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'post' ); ?>
	<?php endwhile; endif; ?>
	<?php if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>
</div>

<?php get_footer(); ?>