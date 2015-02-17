<?php get_header(); ?>

<div id="archive">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div class="content">
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="date"><?php echo date_i18n( 'd F Y', strtotime( $post->post_date ) ); ?></div>

			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'archive' );  ?>
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo $image[0]; ?>" alt="" />
			</a>
			<div class="entry">
				<?php the_excerpt(); ?>
				<div class="entry-meta">
					<div class="categories">Posted in <?php the_category(', ', 'multiple') ?> | <?php echo date_i18n( 'd/m/Y', strtotime( $post->post_date ) ); ?></div>
					<a class="a2a_dd" href="http://www.addtoany.com/share_save">SHARE</a>
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
				</div>
			</div>
		</div><!--.content-->

	<?php endwhile; endif; ?>
	<?php if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>

</div>

<?php get_footer(); ?>