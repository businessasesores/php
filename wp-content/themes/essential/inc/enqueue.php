<?php

/**
 * Enqueue scripts and styles
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

add_action('widgets_init', 'essential_register_widgets');
add_action('wp_enqueue_scripts', 'essential_enqueue_scripts');
add_action('tgmpa_register', 'essential_include_required_plugins');
add_action('wp_ajax_essential_dynamic_css', 'essential_dynamic_css');
add_action('wp_ajax_nopriv_essential_dynamic_css', 'essential_dynamic_css');

// Load Fonts

if(!function_exists('essential_fonts_url')) {
	function essential_fonts_url() {

		$font_url = '';

		$font_families = array('Open Sans:wght@300;400;500;600;700;800');
		$query_args = array(
			'family'  => implode('&family=', $font_families),
			'display' => 'swap',
		);

		$font_url = add_query_arg($query_args, "//fonts.googleapis.com/css2");

		return $font_url;

	}
}

// Load Theme's JavaScript and CSS sources

if(!function_exists('essential_enqueue_scripts')) {
	function essential_enqueue_scripts() {

		// Theme Options
		$essential = wp_get_theme();

		// Include CSS
		wp_enqueue_style('animate', ESSENTIAL_URI . '/assets/css/animate.min.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('owl.carousel', ESSENTIAL_URI . '/assets/css/owl.carousel.min.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('owl.theme', ESSENTIAL_URI . '/assets/css/owl.theme.default.min.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('supersized', ESSENTIAL_URI . '/assets/css/supersized.min.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('ionicons', 'https://unpkg.com/ionicons@4.5.8/dist/css/ionicons.min.css', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('essential-fonts', essential_fonts_url(), array(), apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('essential-style', ESSENTIAL_URI . '/assets/css/style.min.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_style('essential-core',  ESSENTIAL_URI . '/style.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		if(file_exists(ESSENTIAL_PATH . '/assets/css/custom-styles.css')) {
			wp_enqueue_style('custom-styles',  ESSENTIAL_URI . '/assets/css/custom-styles.css', '', apply_filters('essential_version_filter', $essential->get('Version')));
		}

		wp_enqueue_style('essential-dynamic-css', admin_url('admin-ajax.php') . '?action=essential_dynamic_css', '', apply_filters('essential_version_filter', $essential->get('Version')));

		// Include Scripts
		wp_enqueue_script('isotope', ESSENTIAL_URI . '/assets/js/isotope.pkgd.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('jquery.easing', ESSENTIAL_URI . '/assets/js/jquery.easing.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('jquery.countTo', ESSENTIAL_URI . '/assets/js/jquery.countTo.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('jquery.localScroll', ESSENTIAL_URI . '/assets/js/jquery.localScroll.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('magnific-popup', ESSENTIAL_URI . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('jquery.scrollTo', ESSENTIAL_URI . '/assets/js/jquery.scrollTo.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('owl.carousel', ESSENTIAL_URI . '/assets/js/owl.carousel.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('parallax', ESSENTIAL_URI . '/assets/js/parallax.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('supersized', ESSENTIAL_URI . '/assets/js/supersized.3.2.7.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')));
		wp_enqueue_script('wow', ESSENTIAL_URI . '/assets/js/wow.min.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);
		wp_enqueue_script('essential-script', ESSENTIAL_URI . '/assets/js/script.js', array('jquery'), apply_filters('essential_version_filter', $essential->get('Version')), true);

		if(is_singular()) {
			wp_enqueue_script('comment-reply');
		}

	}
}

// Include plugins

if(!function_exists('essential_include_required_plugins')) {
	function essential_include_required_plugins() {

		$plugins = array(

			array(
				'name'     					=> 'Essential Core', // The plugin name
				'slug'     					=> 'essential-core', // The plugin slug (typically the folder name)
				'source'   					=> ESSENTIAL_PATH . '/plugins/essential-core.zip', // The plugin source
				'required' 					=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '1.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     					=> 'WPBakery Page Builder', // The plugin name
				'slug'     					=> 'js_composer', // The plugin slug (typically the folder name)
				'source'   					=> ESSENTIAL_PATH . '/plugins/js_composer.zip', // The plugin source
				'required' 					=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     					=> 'Advanced Custom Fields PRO', // The plugin name
				'slug'     					=> 'advanced-custom-fields-pro', // The plugin slug (typically the folder name)
				'source'   					=> ESSENTIAL_PATH . '/plugins/advanced-custom-fields-pro.zip', // The plugin source
				'required' 					=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     					=> 'Contact Form 7', // The plugin name
				'slug'     					=> 'contact-form-7', // The plugin slug (typically the folder name)
				'required' 					=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     					=> 'MailChimp for WordPress', // The plugin name
				'slug'     					=> 'mailchimp-for-wp', // The plugin slug (typically the folder name)
				'required' 					=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name' 						=> 'Envato Market', // The plugin name
				'slug' 						=> 'envato-market', // The plugin slug (typically the folder name)
				'source' 					=> ESSENTIAL_PATH . '/plugins/envato-market.zip',
				'required' 					=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name' 						=> 'One Click Demo Import', // The plugin name
				'slug' 						=> 'one-click-demo-import', // The plugin slug (typically the folder name)
				'required' 					=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 					=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

		);

		// Change this to your theme text domain, used for internationalising strings

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       		=> 'essential',         			// Text domain - likely want to be the same as your theme.
			'defaulESSENTIAL_PATH' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'menu'         		=> 'tgmpa-install-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> esc_html__('Install Required Plugins', 'essential'),
				'menu_title'                       			=> esc_html__('Install Plugins', 'essential'),
				'installing'                       			=> esc_html__('Installing Plugin: %s', 'essential'), // %1$s = plugin name
				'oops'                             			=> esc_html__('Something went wrong with the plugin API.', 'essential'),
				'notice_can_install_required'     			=> _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'essential'), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'essential'), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'essential'), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'essential'), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'essential'), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'essential'), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'essential'), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'essential'), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop('Begin installing plugin', 'Begin installing plugins', 'essential'),
				'activate_link' 				  			=> _n_noop('Activate installed plugin', 'Activate installed plugins', 'essential'),
				'return'                           			=> esc_html__('Return to Required Plugins Installer', 'essential'),
				'plugin_activated'                 			=> esc_html__('Plugin activated successfully.', 'essential'),
				'complete' 									=> esc_html__('All plugins installed and activated successfully. %s', 'essential'), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa( $plugins, $config);
	}
}
