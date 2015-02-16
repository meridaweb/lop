<?php get_header(); ?>
<?php the_post(); ?>

<div id="side-right">
	<?php get_template_part( 'inc', 'side-blog' ); ?>
</div>

<div id="archive">
	<?php get_template_part( 'content', 'post' ); ?>
</div>

<?php get_footer(); ?>