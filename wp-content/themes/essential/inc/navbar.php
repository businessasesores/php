<?php

/**
 * WordPress Navbar
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Сustom essential menu

if(! function_exists('essential_custom_menu' )) {
    function essential_custom_menu() {
        if(has_nav_menu('primary' )) {
            wp_nav_menu(
                array(
                  'theme_location'    	=> 'primary',
                  'container_class'   	=> 'collapse navbar-collapse',
                  'container_id'    	=> 'navbar-dropdown',
						'menu_class'      	=> 'navbar-nav ml-auto',
						'fallback_cb'     	=> '',
						'menu_id'         	=> 'main-menu',
						'walker'          	=> new WordPress_Navbar(),
                )
            );
        } elseif(current_user_can('administrator'))  {
            print '<span class="no-menu">' . esc_html__('Please register Top Navigation from', 'essential' ) . '<a href="' . esc_url( admin_url('nav-menus.php' )) . '" target="_blank">' . esc_html__('Appearance &gt; Menus', 'essential' ) . '</a></span>';
        }
    }
}

if(! class_exists('WordPress_Navbar' )) {
    class WordPress_Navbar extends Walker_Nav_Menu {
        // change view of top navigation menu items
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'nav-item nav-item-' . esc_attr( $item->ID );
            $classes[] = 'page-scroll';

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ));
            $class_names = ' class="' . esc_attr( $class_names ) . '"';

            $id = apply_filters('nav_menu_item_id', 'nav-item-'. $item->ID, $item, $args );
            $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li ' . $id . $value . $class_names .'>';

            $cur_post = get_post($item->object_id);
            $slug = "#" . $cur_post->post_name;

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

            if(substr_count($class_names, 'nav-item-has-children')) {
                $attributes .= ' data-toggle="dropdown"';
            }

            $page_list = apply_filters('essential_custom_page_list', essential_get_options('essential_sortable_pages'));

            if(get_option('show_on_front') == 'page' && essential_get_options('enable_onepage')) {
                $pages = get_all_page_ids();
                $blog_page = get_option('page_for_posts' );

                if($blog_page && ( $key = array_search( $blog_page, $pages )) !== false ) {
                    unset($pages[$key]);
                }

                if(!empty( $page_list ) && in_array( $item->object_id, $page_list )) { // Custom page list in onepage
                    if( is_page() && in_array( get_the_ID(), $page_list )) {
                        $attributes .= ! empty( $item->object_id )  ? ' class="nav-link anchor-scroll" href="' . esc_url( $slug ) . '"' : '';
                    } else {
                        $attributes .= ! empty( $item->object_id )  ? ' class="nav-link" href="' . esc_url( home_url('/' )) . '#' . $cur_post->post_name . '"' : '';
                    }
                } else {
                    $attributes .= ! empty( $item->url ) ? ' class="nav-link" href="' . esc_url( $item->url ) . '"' : '';
                }
            } else {
                $attributes .= ! empty( $item->url ) ? ' class="nav-link" href="' . esc_url( $item->url ) . '"' : '';
            }

            $item_output = $args->before;
            $item_output .= '<a '. $attributes .'>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}
