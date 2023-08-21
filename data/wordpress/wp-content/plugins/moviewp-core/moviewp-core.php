<?php
/*
Plugin Name: Moviewp Core
Plugin URI: https://fr0zen.mysellix.io/product/617ad1a1357ba
Description: Required plugin for the Moviewp theme to work.
Version: 3.0
Author: fr0zen
Author URI: https://fr0zen.mysellix.io/
*/
      

remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'rel_canonical');

remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
      
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
      
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Remove shortlink

function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'example_theme_support' );
/* Disable Widgets Block Editor */
add_filter( 'use_widgets_block_editor', '__return_false' );
/*
* Remove JSON API links in header html
*/
function remove_json_api () {

    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

   // Remove all embeds rewrite rules.
   //add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

}
add_action( 'after_setup_theme', 'remove_json_api' );


/*
 * function remove unnecessary dashboard
*/

add_action( 'wp_dashboard_setup', function()
{
    //remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    //remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    //remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    //remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
} );

/*
 * function register taxonomy
*/

function taxonomy_init() {
register_taxonomy('director', 'post', array(
'hierarchical' => false,  'label' => 'Directors',
'query_var' => true, 'rewrite' => true));
register_taxonomy('actors', 'post', array(
'hierarchical' => false,  'label' => 'Actors',
'query_var' => true, 'rewrite' => true));
register_taxonomy('networks', 'post', array(
'hierarchical' => false,  'label' => 'Networks',
'query_var' => true, 'rewrite' => true));
register_taxonomy('creator', 'post', array(
'hierarchical' => false,  'label' => 'Creators',
'query_var' => true, 'rewrite' => true));
register_taxonomy('country', 'post', array(
'hierarchical' => false,  'label' => 'Countries',
'query_var' => true, 'rewrite' => true));
register_taxonomy('years', 'post', array(
'hierarchical' => false,  'label' => 'Year',
'query_var' => true, 'rewrite' => true));
register_taxonomy('quality', 'post', array(
'hierarchical' => false,  'label' => 'Quality',
'query_var' => true, 'rewrite' => true));
register_taxonomy('collection', 'post', array(
'hierarchical' => false,  'label' => 'Collections',
'query_var' => true, 'rewrite' => true));
}    
add_action( 'init', 'taxonomy_init', 0 );

/*====================================*\
	function make jQuery load from Google
\*====================================*/

add_action( 'wp_enqueue_scripts', function(){
    if (is_admin()) return; // don't dequeue on the backend
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js', array(), '3.5.1', false );
    wp_enqueue_script( 'jquery');
});

add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
  } 
);

function theme_scripts() {
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'theme_scripts');

/*====================================*\
	function fetch js
\*====================================*/

add_action('admin_enqueue_scripts', 'api_search_scripts', 10, 1);
function api_search_scripts($hook) {
  if($hook === 'edit.php' || $hook === 'post.php' || $hook === 'post-new.php') {
    wp_enqueue_style ( 'api-search', get_template_directory_uri() . '/assets/api/css/api-search.css' );
    wp_enqueue_style ( 'api-search-pagination', get_template_directory_uri() . '/assets/api/css/api-search-pagination.css' );
    wp_enqueue_style ( 'api-search-font-awesome', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css' );
    
	wp_enqueue_script( 'api-search', get_template_directory_uri() . '/assets/api/js/api-search.js' );
	wp_enqueue_script( 'api-search-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js' );
	wp_enqueue_script( 'api-search-pagination', get_template_directory_uri() . '/assets/api/js/api-search-pagination.js' );
  }
}

function wpdocs_remove_nav_menus_panel( $components ) {
    $i = array_search( 'nav_menus', $components );
    if ( false !== $i ) {
        unset( $components[ $i ] );
    }
    return $components;
}
add_filter( 'customize_loaded_components', 'wpdocs_remove_nav_menus_panel' );

/*====================================*\
	function admin bar
\*====================================*/

function cc_wpse_278096_disable_admin_bar() {
   if (current_user_can('administrator') || current_user_can('contributor') ) {
     // user can view admin bar
     //show_admin_bar(true); // this line isn't essentially needed by default...
   } else {
     // hide admin bar
     show_admin_bar(false);
   }
}
add_action('after_setup_theme', 'cc_wpse_278096_disable_admin_bar');




	
if ( ! function_exists('custom_post_type') ) {

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Articles', 'Post Type General Name', 'moviewp' ),
		'singular_name'         => _x( 'Article', 'Post Type Singular Name', 'moviewp' ),
		'menu_name'             => __( 'Articles', 'moviewp' ),
		'name_admin_bar'        => __( 'Articles', 'moviewp' ),
		'archives'              => __( 'Articles archives', 'moviewp' ),
		'attributes'            => __( 'Article Attributes', 'moviewp' ),
		'parent_item_colon'     => __( 'Parent Article:', 'moviewp' ),
		'all_items'             => __( 'All Articles', 'moviewp' ),
		'add_new_item'          => __( 'Add New Article', 'moviewp' ),
		'add_new'               => __( 'Add New', 'moviewp' ),
		'new_item'              => __( 'New Article', 'moviewp' ),
		'edit_item'             => __( 'Edit Article', 'moviewp' ),
		'update_item'           => __( 'Update Article', 'moviewp' ),
		'view_item'             => __( 'View Article', 'moviewp' ),
		'view_items'            => __( 'View Articles', 'moviewp' ),
		'search_items'          => __( 'Search Article', 'moviewp' ),
		'not_found'             => __( 'Not found', 'moviewp' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'moviewp' ),
		'featured_image'        => __( 'Featured Image', 'moviewp' ),
		'set_featured_image'    => __( 'Set featured image', 'moviewp' ),
		'remove_featured_image' => __( 'Remove featured image', 'moviewp' ),
		'use_featured_image'    => __( 'Use as featured image', 'moviewp' ),
		'insert_into_item'      => __( 'Insert into Article', 'moviewp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Article', 'moviewp' ),
		'items_list'            => __( 'Articles list', 'moviewp' ),
		'items_list_navigation' => __( 'Articles list navigation', 'moviewp' ),
		'filter_items_list'     => __( 'Filter Articles list', 'moviewp' ),
	);
	$rewrite = array(
		'slug'                  => 'blog',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Article', 'moviewp' ),
		'description'           => __( 'Articles', 'moviewp' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'trackbacks', 'revisions' ),
		//'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-clipboard',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'blog',
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'article', $args );

}
add_action( 'init', 'custom_post_type', 0 );

}