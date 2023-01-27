<?php

/**
 * Declaring widgets
 *
 * @package the-science-lab
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Register Sidebar

if(!function_exists('essential_register_widgets')) {
	function essential_register_widgets() {
		register_sidebar(
			array(
				'id' 					=> 'sidebar',
				'name' 				=> __('Sidebar' , 'essential'),
				'before_widget' 	=> '<div class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h3 class="title-w">',
				'after_title' 		=> '</h3>',
				'description' 		=> __('Drag the widgets for sidebars.', 'essential')
			)
		);
	}
}
