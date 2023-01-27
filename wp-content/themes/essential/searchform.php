<?php

/**
 * Search form
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

if('html5' == $format) { ?>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url('/')); ?>">
		<label>
			<span class="screen-reader-text"><?php esc_html_x('Search for:', 'label','essential') ?></span>
			<input type="search" placeholder="<?php echo esc_attr_x('Search&hellip;', 'placeholder','essential'); ?>" value="<?php get_search_query(); ?>" name="s" />
		</label>
		<input type="submit" class="btn" value="<?php _e('Search', 'essential'); ?>" />
	</form>
<?php }else{ ?>
	<form role="search" method="get" id="searchform" class="searchform" action="<?php esc_url( home_url('/')); ?>">
		<div>
			<label class="screen-reader-text" for="s"><?php esc_html_x('Search for:', 'label','essential'); ?></label>
			<input type="text" placeholder="<?php echo esc_attr_x('Search&hellip;', 'placeholder','essential'); ?>" value="<?php get_search_query(); ?>" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="<?php _e('Search', 'essential'); ?>" class="btn"  />
		</div>
	</form>
<?php } ?>
