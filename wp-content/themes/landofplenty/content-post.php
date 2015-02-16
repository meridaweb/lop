	<div class="content">
		<h2 class="title"><?php the_title(); ?></h2>
		<div class="date"><?php echo date_i18n( 'd F Y', strtotime( $post->post_date ) ); ?></div>

		<?php

		// Volledige breedte
		$is_full = get_field( 'full_image' );

		// Image size
		$size = $is_full ? 'archive-full' : 'archive';
		$class = $is_full ? 'full' : 'aligncenter';

		// Featured Image
		$link = get_permalink();
		$thumbnail = get_the_post_thumbnail( $post->ID, $size, array(
			'title'	=> esc_attr( $post->post_title ),
			'class' => $class,
		));
		echo $thumbnail ? "<a href='{$link}'>{$thumbnail}</a>" : '';

		?>
		<div class="entry">
			<?php the_excerpt(); ?>

			<div class="entry-meta">
				<a href="javascript:;" class="">Leave a comment</a>

				<?php
				// categories
				$cats = '';
				$postcats = get_the_category( $post );
				if ( $postcats ) {
					$arr_cats = array();
					foreach ( $postcats as $cat) {
						$arr_cats[] = '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>';
					}
					$cats = implode(", ", $arr_cats);
				}

				?>
				<div class="categories">Posted in <?php echo $cats; ?> | <?php echo date_i18n( 'd/m/Y', strtotime( $post->post_date ) ); ?></div>
			</div>

		</div>
	</div><!--.content-->
