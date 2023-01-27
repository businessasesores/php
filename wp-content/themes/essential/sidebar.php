<?php

/**
 * Sidebar
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

if(is_active_sidebar('sidebar')) : ?>
	<aside id="secondary" class="sidebar widget_area col-lg-3 col-12" role="complementary">
		<?php dynamic_sidebar('sidebar'); ?>
	</aside>
<?php endif; ?>
