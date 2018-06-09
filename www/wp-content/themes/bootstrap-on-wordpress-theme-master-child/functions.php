<?php

if( !is_admin() ) { //DO THIS ON FRONTEND ONLY

	//ADD CSS TO CHILD THEME

	//add our bootstrap
	wp_register_style( 'bootstrap', get_stylesheet_directory_uri().'/assets/css/bootstrap.min.css', '', '3.3.7', 'all' );
	wp_enqueue_style( 'bootstrap' );

	wp_register_style( 'myCss', get_stylesheet_directory_uri().'/assets/css/css.bs3.en.css', '', array(), 'all' );
	wp_enqueue_style( 'myCss' );

	//ADD JS TO CHILD THEME
	function my_scripts_method() {
		wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/all.js', array( 'jquery' ));
	}

	add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

	//remove black admin bar frontend
	add_filter('show_admin_bar', '__return_false');

	////remove "edit this entry" in wordpress frontend (when you're logged)
	add_filter( 'edit_post_link', '__return_false' );
	
	function checknull($a) {
		if($a=='') { return true; }
	}
	
	
	
	function showImage($path,$resource,$text,$css,$style) {
	
		$stylesheet='';
		$inlineclass='';
		$alttitle='';
		
		if($css!='') {  $stylesheet=' class="'.$css.'"';}
		if($style!='') {  $inlineclass=' style="'.$style.'"';}
		if($text!='') {  $alttitle=' alt="'.$text.'" title="'.$text.'"';}
		if($resource!='') { $x='<img src="'.$path.$resource.'"'.$alttitle.$stylesheet.$inlineclass.'>'."\r\n"; } else if($resource=='') { $x='<!--<span class="red">no photo!</span>-->';}
		
		return $x;
	}
	

	
	function get_cat_slug($cat_id) {
		$cat_id = (int) $cat_id;
		$category = &get_category($cat_id);
		return $category->slug;
	}
	
	// Remove the REST API lines from the HTML Header
	function remove_json_api () {

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
	   add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

	}
	add_action( 'after_setup_theme', 'remove_json_api' );
	
		
	remove_action ( 'wp_head', 'wp_shortlink_wp_head'); //// remove WP 4.9+ dns-prefetch nonsense
	remove_action( 'wp_head', 'wp_resource_hints', 2 ); // remove dns-prefetch 
	remove_action('wp_head', 'rsd_link');// Windows Live Writer? Ew!
	remove_action('wp_head', 'wlwmanifest_link');// Windows Live Writer? Ew!
	remove_action('wp_head', 'wp_generator');// No need to know my WP version quite that easily
	





} else { //DO THIS ON BACKEND ONLY



}


// ADD FAVICON
function favicon() {
	echo '<link rel="icon" href="'.get_stylesheet_directory_uri().'/assets/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/assets/favicon.ico" type="image/x-icon" />';
}
add_action('wp_head', 'favicon');

// Remove All Yoast HTML Comments
// https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
add_action('wp_head',function() { ob_start(function($o) {
return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi','',$o);
}); },~PHP_INT_MAX);


// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Custom', 'your-theme-domain' ),
            'id' => 'custom-side-bar',
            'description' => __( 'Custom Sidebar', 'your-theme-domain' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );



// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'photographus_add_gutenberg_assets' );

/**
 * Load Gutenberg stylesheet.
 */
function photographus_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'photographus-gutenberg', get_stylesheet_directory_uri() . '/blocks.css', false );
}



//Flamingo - Provide access to Editor
remove_filter( 'map_meta_cap', 'flamingo_map_meta_cap' );
add_filter( 'map_meta_cap', 'mycustom_flamingo_map_meta_cap', 9, 4 );
function mycustom_flamingo_map_meta_cap( $caps, $cap, $user_id, $args ) {
    $meta_caps = array(
       'flamingo_edit_contacts' => 'edit_posts',
       'flamingo_edit_contact' => 'edit_posts',
       'flamingo_delete_contact' => 'edit_posts',
       'flamingo_edit_inbound_messages' => 'publish_posts',
       'flamingo_delete_inbound_message' => 'publish_posts',
       'flamingo_delete_inbound_messages' => 'publish_posts',
       'flamingo_spam_inbound_message' => 'publish_posts',
       'flamingo_unspam_inbound_message' => 'publish_posts'
);

$caps = array_diff( $caps, array_keys( $meta_caps ) );
if ( isset( $meta_caps[$cap] ) )
    $caps[] = $meta_caps[$cap];
    return $caps;
}


//DO NOT LEAVE ANY WHITESPACE AFTER CLOSE TAG PHP // IT WILL HEADER ERROR!
?>