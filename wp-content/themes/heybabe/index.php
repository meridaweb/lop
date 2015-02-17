<?php get_header(); ?>

<div id="side-right">

	<div class="cp-tweets" data-usernames="akkiebosje" data-count="3"></div>
	<?php dynamic_sidebar('blog'); ?>

	<section class="gewoonleuk">

		<?php
		$args = array(
			'post_type'         => 'gewoonleuk',
			'order_by' 			=> 'order',
		    'order' 			=> 'ASC',
			'posts_per_page'    => 5
		);

		$leuk_posts = new WP_Query($args);

		if ( $leuk_posts->have_posts() ) {

			while( $leuk_posts->have_posts() ) {

				$leuk_posts->the_post(); ?>

						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('gewoonleuk'); ?>
							<?php the_content(); ?>
						</a>

			<?php }

		} ?>

	</section>

</div>

<div id="archive">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'post' ); ?>
	<?php endwhile; endif; ?>
	<?php if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>

</div>

<?php get_footer(); ?>