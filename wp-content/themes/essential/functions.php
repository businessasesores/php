<?php

/**
 * Functions and Definitions
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

$essential_includes = array(
	'/inc/enqueue.php',                       // Enqueue scripts and styles
	'/inc/navbar.php',    							// Load custom WordPress navbar
	'/inc/setup.php',            					// Theme setup and custom Theme supports
	'/inc/helper-functions.php',              // Helper functions
	'/inc/widgets.php',                       // Register widget area
	'/inc/customizer.php',                    // Customizer
	'/inc/custom-header.php',                 // Custom Header
	'/inc/class-tgm-plugin-activation.php',   // TGM Plugin Activation
	'/inc/acf/acf-config.php'                 // ACF configuration
);

foreach($essential_includes as $file) {
   require_once get_template_directory() . $file;
}
