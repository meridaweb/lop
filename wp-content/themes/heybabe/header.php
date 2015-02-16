<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php if (is_home()) { echo get_bloginfo('name') . ' ' .get_bloginfo('description') ; } else { wp_title('&laquo;', true, 'right'); echo ' '.get_bloginfo('description'); } ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon">
</head>
<?php

// add term class for photo template
$body_class = is_single() && codepress_post_has_term( 'photo', $post->ID ) ? 'term-photo' : '';

?>

<body <?php body_class( $body_class ); ?>>

	<div id="wrapper">

		<header id="branding" role="banner">

			<section>

				<a id="logo" href="<?php echo home_url(); ?>"><span class="title"><?php bloginfo( 'name' ); ?></span><span class="description"><?php bloginfo( 'description' ); ?></span></a>

				<nav id="about-nav" role="navigation">
					<?php
						wp_nav_menu( array(
							'depth'             => 1,
							'level'             => 0,
							'classes'           => '',
							'theme_location'    => 'about',
							'container'         => false,
							'items_wrap'        => '<ul>%3$s</ul>',
						));
					?>
				</nav>

			</section>

			<nav id="main-nav" role="navigation">
			<?php
				wp_nav_menu( array(
					'depth'             => 1,
					'level'             => 0,
					'classes'           => '',
					'theme_location'    => 'main',
					'container'         => false,
					'items_wrap'        => '<ul>%3$s</ul>',
				));
			?>
			</nav>

		</header>
		<div id="content">

