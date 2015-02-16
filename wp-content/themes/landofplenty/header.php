<!DOCTYPE html>
<!--
Copyright (c) CodePress 2013 All rights reserved
Developed by : http://codepress.nl | info@codepress.nl
-->
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() . '/assets/images/favicon.ico'; ?>" type="image/x-icon">
</head>
<?php

// add term class for photo template
$body_class = is_single() && codepress_post_has_term( 'photo', $post->ID ) ? 'term-photo' : '';

?>

<body <?php body_class( $body_class ); ?>>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-45462447-1', 'landofplenty.nl');
	ga('send', 'pageview');
	</script>
    <div id="wrapper">
    	<header id="branding" role="banner">
    		<a id="logo" href="<?php echo home_url(); ?>"></a>
	        <nav id="main-nav" role="navigation">
	        <?php
	            wp_nav_menu( array(
	                'depth'             => 3,
	                'level'             => 0,
	                'classes'           => '',
	                'theme_location'    => 'main',
	                'container'         => false,
	                'items_wrap'        => '<ul>%3$s</ul>',
	            ));
	        ?>
	        </nav>
	        <div class="contact">
	        	+31 (0)72 581 6009 <a href="mailto:info@landofplenty.nl">e-mail</a>
	        </div>
		</header>
		<div id="content">

