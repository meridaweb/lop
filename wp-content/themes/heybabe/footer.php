		</div><!--content-->
		<footer>

			<nav id="social-nav" role="navigation">
			<?php
				wp_nav_menu( array(
					'depth'             => 1,
					'level'             => 0,
					'classes'           => '',
					'theme_location'    => 'social-footer',
					'container'         => false,
					'items_wrap'        => '<ul>%3$s</ul>',
				));
			?>
			</nav>

			<section id="newsletter">
				<h3>Volg LandofPlenty_</h3>
				Ontvang de <a href="<?php the_field('newsletter_link', 'options'); ?>">nieuwsbrief</a>
			</section>

			<section id="copyright">
				<a href="<?php echo home_url(); ?>">&copy; LANDOFPLENTY_</a> All rights reserved, unless stated otherwise
			</section>

			<section id="search">
				<?php get_search_form(); ?>
			</section>

			<nav id="footer-nav" role="navigation">
			<?php
				wp_nav_menu( array(
					'depth'             => 2,
					'level'             => 0,
					'classes'           => '',
					'theme_location'    => 'main',
					'container'         => false,
					'items_wrap'        => '<ul>%3$s</ul>',
				));
			?>
			</nav>
		</footer>
	</div><!--wrapper-->

	<?php wp_footer() ?>

	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-45462447-1', 'landofplenty.nl');
	ga('send', 'pageview');
	</script>

</body>
</html>