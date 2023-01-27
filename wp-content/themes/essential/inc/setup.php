<?php

/**
 * Theme basic setup
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

defined('ESSENTIAL_URI') or define('ESSENTIAL_URI', get_template_directory_uri());
defined('ESSENTIAL_PATH') or define('ESSENTIAL_PATH', get_theme_file_path());

// Admin CSS

if(!function_exists('essential_admin_css')) {
   function essential_admin_css() {
      wp_enqueue_style('admin-styles', ESSENTIAL_URI . '/assets/css/admin.css');
   }
}

add_action('login_head', 'essential_admin_css');
add_action('admin_enqueue_scripts', 'essential_admin_css');

if(!isset($content_width)) {
	$content_width = 1200;
}

// Sets up Theme defaults and registers support for various WordPress features

add_action('after_setup_theme', 'essential_setup');
if(!function_exists('essential_setup')) {
	function essential_setup() {
		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');

		// Document title tag managed by WordPress
		add_theme_support('title-tag');

		// Navbar registration
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'essential'),
		));

		// Thumbnail basic support
		add_theme_support('post-thumbnails');

		// Support for Posts Formats
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		));

		// Support for responsive embedded content
		add_theme_support('responsive-embeds');

		// Support for wide alignment
		add_theme_support('align-wide');
	}
}

// Get Options Theme

if(!function_exists('essential_get_options')) :
    function essential_get_options( $setting = false, $default = array()) {

        $options = get_option('essential_themes_options' );

        $options = (array) $options;

        if(empty($options)) return $default;

        if(!$setting) return $options;

        if(!empty( $options[ $setting ] )) {
            return $options[$setting];
        } else {
            return $default;
        }

        return array();
    }
endif;

add_action("customize_register", "essential_customize_register");

add_theme_support('align-wide');

add_theme_support('align-full');

add_theme_support('editor-styles');

add_editor_style('assets/css/style-editor.css');

add_editor_style(essential_fonts_url());

// Import Demo

add_filter('pt-ocdi/import_files', 'essential_ocdi_import_files');
function essential_ocdi_import_files() {
   return array(
   	array(
	      'import_file_name'             => 'Demo Import',
	      'local_import_file'            => trailingslashit(ESSENTIAL_PATH) . '/inc/demo/content.xml',
	      'local_import_widget_file'     => trailingslashit(ESSENTIAL_PATH) . '/inc/demo/widgets.wie',
	      'local_import_customizer_file' => trailingslashit(ESSENTIAL_PATH) . '/inc/demo/customizer.dat',
	      'import_preview_image_url'     => ESSENTIAL_PATH . '/screenshot.png',
	      'preview_url'                  => 'https://essential.riccardoborchi.it/'
   	)
	);
}

add_action('pt-ocdi/after_import', 'essential_ocdi_after_import_setup');
function essential_ocdi_after_import_setup() {
	// Assign menus to their locations
	$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');

	$locations = get_theme_mod('nav_menu_locations');
	$locations['primary-menu'] = $main_menu->term_id;
	set_theme_mod('nav_menu_locations', $locations);

	// Assign front page and posts page (blog page)
	$front_page_id = get_page_by_title('Home');
	$blog_page_id  = get_page_by_title('Blog');

	update_option('show_on_front', 'page');
	update_option('page_on_front', $front_page_id->ID);
	update_option('page_for_posts', $blog_page_id->ID);
}

add_filter('pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false');

add_filter('pt-ocdi/disable_pt_branding', '__return_true');

// Excerpt end

add_filter('excerpt_more', 'essential_excerpt_more');
if(!function_exists('essential_excerpt_more')) {
	function essential_excerpt_more($more) {
		return ' &hellip;';
	}
}

// Max title length

add_filter('the_title', 'essential_max_title_length');
function essential_max_title_length($title) {
	$max = 50;
	if(strlen($title) > $max && !is_single()) {
		return substr($title, 0, $max) . " &hellip;";
	}else{
		return $title;
	}
}

// Excerpt length

add_filter('excerpt_length', 'essential_excerpt_length');
if(!function_exists('essential_excerpt_length')) {
	function essential_excerpt_length($length) {
		return 25;
	}
}
