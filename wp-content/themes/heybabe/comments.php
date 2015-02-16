<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h3 class="comments-title">
		Reacties
	</h3>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      	=> 'div',
				'short_ping' 	=> true,
				'callback' 		=> 'codepress_comment'
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments">Reageren niet meer mogelijk.</p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php

	$comments_args = array(
        'label_submit'=>'Reactie plaatsen',
        'title_reply'=>'Geef een reactie'
	);

	comment_form($comments_args);

	 ?>

</div><!-- #comments -->
