<?php

/**
 * Header
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

	<?php wp_body_open(); ?>

	<!-- NAVBAR -->
	<?php

	$nav_class = '';

	if(!class_exists('Essential_Core') || (is_page() && !is_front_page()) || is_home() || is_404() || is_search()) {
		$nav_class = 'navbar-light-static';
	}

	if(!class_exists('Essential_Core')) {
		$nav_class .= ' small';
	}

	?>

	<header>
		<nav class="navbar navbar-expand-md fixed-top <?php echo esc_attr($nav_class); ?>">
			<div class="navbar-brand">
				<?php

				$logo = essential_get_options('essential_logo_image');
				$text_logo = essential_get_options('essential_logo_text', get_bloginfo('name'));

				if(essential_get_options('essential_type_logo') == 'image' && !empty($logo)) { ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="navbar-title">
						<img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($text_logo); ?>" class="image-logo">
					</a>
				<?php }elseif((essential_get_options('essential_type_logo') == 'text' || !class_exists('Essential_Core')) || (essential_get_options('essential_type_logo') == 'image' && empty($logo))) { ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="navbar-title">
						<?php echo esc_html($text_logo); ?>
					</a>
				<?php } ?>
			</div>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-dropdown" aria-controls="navbar-dropdown" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'essential'); ?>">
				<span class="navbar-toggler-icon"></span>
				<span class="navbar-toggler-icon"></span>
				<span class="navbar-toggler-icon"></span>
			</button>

			<?php essential_custom_menu(); ?>
		</nav>
	</header>
