<div id="side-left">
	<div class="project-content">

		<div class="submenu">
			<a href="javascript:;" class="all">alle photo's</a>

			<?php
			$illustrations = get_posts( array(
				'post_type' 	=> 'project',
				'numberposts' 	=> -1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'thema',
						'field' 	=> 'slug',
						'terms' 	=> 'photo'
						)
					)
			));
			if ( $illustrations ) : ?>
			<div class="subitems">
				<?php foreach ( $illustrations as $p ) : ?>
					<a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo apply_filters( 'the_title', $p->post_title ); ?></a><br/>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<h1><?php the_title(); ?></h1>

	<?php if ( $term = codepress_get_single_thema_term( $post->ID ) ) : ?>
		<div class="meta">
			<a href="<?php get_term_link( $term ); ?>" ><?php echo $term->name; ?></a>
		</div>
	<?php endif; ?>

		<span class="divider"></span>

		<?php the_content(); ?>
		<?php if ( $bron = get_field('bron') ) : ?>
			<div class="bron">
				<?php echo $bron; ?>
			</div>
		<?php endif; ?>

		<div class="next-prev">
			<?php next_post_link('%link >', 'next'); ?><br/>
			<?php previous_post_link('%link >', 'previous'); ?>
		</div>

	</div>
</div>

<div id="project" class="photo">
	<div class="content">
		<?php
		$slides = array();
	 	if ( $images = get_field( 'images') ) {
	 		foreach ( $images as $image ) {
	 			$slides[] = wp_get_attachment_image( $image['image'], 'full' );
	 		}
	 	}
	 	?>

	 	<div class="flexslider">
			<ul class="slides">
				<li>
					<?php echo implode( '</li><li>', $slides ); ?>
				</li>
			</ul>
		</div>

	</div><!--.content-->
</div>