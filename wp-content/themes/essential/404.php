<?php

/**
 * 404 Page
 *
 * @package essential
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

get_header();

?>

<main class="site-main" id="main">

   <section class="page404">

   	<div class="page404-wrapper">

   		<div class="page404-content container">

            <h1><?php esc_html_e('Looks like page do not exist', 'essential'); ?></h1>

   			<a href="<?php echo esc_url(home_url()); ?>" class="btn mt-5"><?php esc_html_e('Go Home', 'essential'); ?></a>

   		</div>

   	</div>

   </section>

</main>

<?php get_footer();
