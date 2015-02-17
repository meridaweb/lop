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
		echo $thumbnail ? "<a href='{$link}'>{$thumbnail}</a>" : '';

		?>
		<div class="entry">
			<?php the_excerpt(); ?>
			<div class="entry-meta">
				<div class="categories">Posted in <?php the_category(', ', 'multiple') ?> | <?php echo date_i18n( 'd/m/Y', strtotime( $post->post_date ) ); ?></div>
				<a class="a2a_dd" href="http://www.addtoany.com/share_save">SHARE</a>
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
			</div>

		</div>
	</div><!--.content-->
