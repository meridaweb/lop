<?php get_header(); ?>
<?php the_post(); ?>

<div id="page">
	<h2><?php the_title(); ?></h2>
	<?php the_content(); ?>
</div>

<?php get_footer(); ?>