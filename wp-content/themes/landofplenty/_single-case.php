<?php get_header(); ?>
<?php the_post(); ?>

<div id="side-right">
	<?php
	$projects = get_posts( array(
		'post_type' 	=> 'case',
		'numberposts' 	=> -1,
		'post__not_in'	=> array( $post->ID )
	));
	if ( $projects ) : foreach ( $projects as $p ) :
		if ( $thumb = get_the_post_thumbnail( $p->ID, 'side', array( 'title' => esc_attr( $p->post_title ), 'class' => 'thumb' ) ) )
			echo "<div class='border'><a href='" . get_permalink( $p->ID ) . "'>{$thumb}</a></div>";
	endforeach; endif;
	?>
</div>

<div id="side-left">
	<div class="project-content">

		<h1><?php the_title(); ?></h1>
		<?php
		// categories
		$cats = '';

		if ( $postcats = wp_get_post_terms( $post->ID, 'thema_case' ) ) :

			?>
		<div class="meta">
			<?php
			$arr_cats = array();
			foreach ( $postcats as $cat) {
				$arr_cats[] = '<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>';
			}
			echo implode(", ", $arr_cats); ?>
		</div>
		<?php endif; ?>
		------
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

<div id="project">
	<div class="content">
		<?php
	 	if ( $images = get_field( 'images') ) {
	 		foreach ( $images as $image ) {
	 			echo wp_get_attachment_image( $image['image'], 'full' );
	 		}
	 	}
	?>
	</div><!--.content-->
</div>

<?php get_footer(); ?>