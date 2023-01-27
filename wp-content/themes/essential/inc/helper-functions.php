<?php

/**
 * Helper Functions
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Comments

if(!function_exists('essential_comment')) {
	function essential_comment($comment, $args, $depth) {

	   $GLOBALS['comment'] = $comment;

	   $reply_class = ($comment->comment_parent) ? 'indented' : '';

	   switch($comment->comment_type):
	      case 'pingback':
	      case 'trackback':
	        ?>
	          <div class="pingback">
	            <?php esc_html_e( 'Pingback:', 'essential' ); ?> <?php comment_author_link(); ?>
	            <?php edit_comment_link( esc_html__( '(Edit)', 'essential' ), '<span class="edit-link">', '</span>' ); ?>
	          </div>
	        <?php
	      break;
	      default:
	        // Generate comments
	        ?>
	          <li id="comment-<?php comment_ID(); ?>" <?php comment_class('ct-part'); ?>>
	            <div class="comment-wrapper">
	              <div class="comment-image">
	                <?php echo get_avatar($comment, 160, '', esc_attr(get_the_author())); ?>
	              </div>
	              <div class="content">
	                <div class="author">
	                  <p class="author pretitle"><?php comment_author(); ?></p>
	                </div>
	                <span class="date"><?php comment_date(); ?> (<?php comment_time(); ?>)</span>
	                <?php comment_text(); ?>
	              </div>
	            </div>
	            <div class="reply-wrapper">
	              <?php
	                comment_reply_link(
	                  array_merge( $args,
	                    array(
	                      'reply_text' => esc_html__( 'Rispondi', 'essential' ),
	                      'after' => '',
	                      'depth' => $depth,
	                      'max_depth' => $args['max_depth']
	                    )
	                  )
	                );
	              ?>
	            </div>
	          </li>
	        <?php
	      break;
	   endswitch;

	}
}

// Pagination

if(!function_exists('essential_wp_link_pages')) {
  	function essential_wp_link_pages() {
   	get_post_format();
  	}
}

// Categories

if(!function_exists('essential_categories')) {
   function essential_categories() {

	   $args = array(
	      'type'     => 'post',
	      'taxonomy' => 'category'
	   );

	   $categories = get_categories($args);
	   $list = array();

	   foreach($categories as $category) {
	   	$list[$category->name] = $category->slug;
	   }

	   return $list;

   }
}

// Custom row styles for one page mode

add_action('wp_ajax_nopriv_essential_dynamic_css', 'essential_dynamic_css');
add_action('wp_ajax_essential_dynamic_css', 'essential_dynamic_css');
if(!function_exists('essential_dynamic_css')) {
   function essential_dynamic_css() {
		require_once ESSENTIAL_PATH . '/assets/css/custom.css.php';
		wp_die();
   }
}
