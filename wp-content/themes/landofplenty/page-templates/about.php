<?php /** Template Name: About */ ?>

<?php get_header(); ?>

<div id="side-right">
	<div class="entry">
		<?php the_field('sidebar'); ?>
	</div>
</div>

<div id="about">
	<div class="row intro">
		<div class='col-left'>
			<?php
			echo get_the_post_thumbnail( $post->ID, 'about', array(
				'title'	=> esc_attr( $post->post_title ),
				'class'	=> 'indent'
			));
			?>
		</div>
		<div class='col-right'>
			<div class="entry large-text">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

	<?php if ( get_field('faqs') ) : while ( has_sub_field('faqs') ) : ?>

	<div class="faq-question">
		<div class='col-left entry'>
			<h2>Vraag</h2>
			<div class="meta"><?php echo get_sub_field('faq_label'); ?></div>
			-----<br/>
			<?php echo get_sub_field('faq_question'); ?>
			<span class="alignright">></span>
		</div>
	</div>

	<div class="faq-answer">
		<div class='col-right entry'>
			<h2>Antwoord</h2>
			<div class="meta"><?php echo get_sub_field('faq_label'); ?></div>
			-----<br/>
			<?php echo get_sub_field('faq_answer'); ?>
		</div>
	</div>

	<?php endwhile; endif; ?>

</div><!--about-->

<?php get_footer(); ?>