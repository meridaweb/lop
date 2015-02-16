<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();

	// column counter
	static $i = 1;

	$title 		= apply_filters( 'the_title', $post->post_title );
	$excerpt 	= get_the_excerpt();
	$link 		= get_permalink();

	// thumbnail
	$thumbnail	= get_the_post_thumbnail( $post->ID, 'archive', array(
		'title'	=> esc_attr( $post->post_title )
	));
	$thumbnail  = $thumbnail ? "<a href='{$link}'>{$thumbnail}</a>" : '';

	// categories
	$cat = '';
	if ( $term = codepress_get_single_thema_term( $post->ID ) )
		$cat = '<a href="'.get_term_link( $term ).'">'.$term->name.'</a>';


	$article = "
		<div class='block'>
			<div class='thumb'>
				{$thumbnail}
			</div>
			<div class='entry'>
				<h2><a href='{$link}'>{$title}</a></h2>
				<div class='meta'>{$cat}</div>
				<span class='divider'></span>
				<div class='text'>
					{$excerpt}
				</div>
				<a href='{$link}' class='lees-meer'>Lees meer ></a>
			</div>
		</div>
	";

	// split content over two columns
	if ( 0 === $i++ % 2 ) {
		$articles['right'][] = $article;
	}
	else {
		$articles['left'][] = $article;
	}
endwhile; endif;
?>
	<div class='col-left'>
		<?php echo !empty($articles['left']) ? implode( '', $articles['left'] ) : ''; ?>
	</div>
	<div class='col-right'>
		<?php echo !empty($articles['right']) ? implode( '', $articles['right'] ) : ''; ?>
	</div>

	<?php if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>