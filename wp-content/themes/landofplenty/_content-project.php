	<div class="content">
		<h2 class="title"><?php the_title(); ?></h2>
		<div class="date"><?php echo date_i18n( 'd F Y', strtotime( $post->post_date ) ); ?></div>

		<?php
		$link = get_permalink();
		$thumbnail = get_the_post_thumbnail( $post->ID, 'full', array(
			'title'	=> esc_attr( $post->post_title ),
			'class' => 'aligncenter',
		));
		echo $thumbnail ? "<a href='{$link}'>{$thumbnail}</a>" : '';
		?>
		<div class="entry">
			<?php the_excerpt(); ?>
		</div>
	</div><!--.content-->
