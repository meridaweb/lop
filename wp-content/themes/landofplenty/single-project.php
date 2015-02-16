<?php get_header(); ?>
<?php the_post(); ?>

<?php

// Is this a illustration project or case?
if ( codepress_post_has_term( 'illustration', $post->ID ) )
	get_template_part( 'content', 'project-illustration' );

// Is this a photo project or case?
elseif ( codepress_post_has_term( 'photo', $post->ID ) )
	get_template_part( 'content', 'project-photo' );

else
	get_template_part( 'content', 'project' );

?>

<?php get_footer(); ?>