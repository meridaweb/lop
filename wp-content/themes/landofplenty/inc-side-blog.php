	<div class="widget widget-text">
		<strong>welcome</strong>
		<p>enjoy wandering by our
		collection of playful
		and poetic finds</p>
	</div>

	<div class="widget side-quote">
		<p>not all those who wander are lost</p>
	</div>

	<div class="widget widget-list">
		<strong>categories</strong>
		<ul>
			<li><a href="<?php echo get_category_link( 1 ); ?>">all posts</a></li>
		<?php if ( $allcats = get_categories( array( 'child_of' => 1 ) ) ) : foreach ( $allcats as $cat ) : ?>
			<li><a href="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo $cat->name; ?></a></li>
		<?php endforeach; endif; ?>
		</ul>
	</div>

	<div class="widget widget-list">
		<strong>recent posts</strong>
		<ul>
		<?php if ( $rposts = get_posts( array( 'numberposts' => 5 ) ) ) : foreach ( $rposts as $p ) : ?>
			<li><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo apply_filters( 'the_title', $p->post_title ); ?></a></li>
		<?php endforeach; endif; ?>
		</ul>
	</div>

	<div class="widget widget-text">
		<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/_placeholder8.png" alt="" />
	</div>