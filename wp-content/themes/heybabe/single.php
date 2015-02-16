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

		} ?>

		</section>

</div>

<div id="archive">
		<?php the_post(); ?>
		<div class="content">
		<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="date"><?php echo date_i18n( 'd F Y', strtotime( $post->post_date ) ); ?></div>

		<?php

		// Volledige breedte
		$is_full = get_field( 'full_image' );

		// Image size
		$size = $is_full ? 'archive-large' : 'archive';
		$class = $is_full ? 'full' : 'aligncenter';

		// Featured Image
		$link = get_permalink();
		$thumbnail = get_the_post_thumbnail( $post->ID, $size, array(
			'title'	=> esc_attr( $post->post_title ),
			'class' => $class,
		));
		echo $thumbnail ? "{$thumbnail}" : '';

		?>
		<div class="entry">
			<?php the_content(); ?>

			<div class="entry-meta">
				<div class="categories">This entry was posted in <?php the_category(', ', 'multiple') ?> | <?php echo date_i18n( 'd/m/Y', strtotime( $post->post_date ) ); ?></div>
					<a class="a2a_dd" href="http://www.addtoany.com/share_save">SHARE</a>
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
			</div>

			<?php if ( comments_open() || get_comments_number() ) {
                comments_template();
            }; ?>

		</div>
	</div><!--.content-->

</div>

<?php get_footer(); ?>