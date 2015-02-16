<?php /** Template Name: About */ ?>

<?php get_header(); ?>

<div id="side-right">

	<div class="cp-tweets" data-usernames="akkiebosje" data-count="3"></div>
	<?php dynamic_sidebar('blog'); ?>

	<section class="gewoonleuk">

		<h3>Gewoon leuk</h3>

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

		}

		wp_reset_query();

		?>

		</section>

</div>

<div id="archive">

	<div class="content">
		<h2 class="title"><?php the_title(); ?></h2>
		<div class="entry lead">
			<?php the_content(); ?>
		</div>
	</div>

	<?php if ( get_field('extras') ) : while ( has_sub_field('extras') ) : ?>

		<div class="content extras">
			<?php $image = get_sub_field('extras_foto');
			if( !empty($image) ): ?>
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
			<?php endif; ?>
			<?php if( !empty(get_sub_field('extras_video')) ): ?>
				<div class="embeddedvideo">
				<?php echo html_entity_decode(get_sub_field('extras_video')); ?>
				</div>
			<?php endif; ?>
			<h2 class="title"><?php echo get_sub_field('extras_title'); ?></h2>
			<div class="date"><?php echo get_sub_field('extras_label'); ?></div>
			<div class="entry">
				<?php echo get_sub_field('extras_text'); ?>
			</div>
		</div>

	<?php endwhile; endif; ?>

</div><!-- /archive -->

<?php get_footer(); ?>