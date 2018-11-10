<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
// show_admin_bar(false);
// Set up theme support
function elementor_hello_theme_setup() {

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'custom-logo', array(
		'height' => 70,
		'width' => 350,
		'flex-height' => true,
		'flex-width' => true,
	) );

	add_theme_support( 'woocommerce' );

	load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'elementor_hello_theme_setup' );

// Theme Scripts & Styles
function elementor_hello_theme_scripts_styles() {
	wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'elementor_hello_theme_scripts_styles' );

// Register Elementor Locations
function elementor_hello_theme_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
};
add_action( 'elementor/theme/register_locations', 'elementor_hello_theme_register_elementor_locations' );

// Remove WP Embed
function elementor_hello_theme_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'elementor_hello_theme_deregister_scripts' );

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );






// -------Quitar menús principales de admin de WordPress -------------
//

function remove_menus(){

 $current_user = wp_get_current_user();
    if ( 1 != $current_user->ID ) {

  remove_menu_page( 'link-manager.php' );
  remove_menu_page( 'elementor' );
  remove_menu_page( 'edit.php?post_type=elementor_library' );
  remove_menu_page( 'edit-comments.php' );          //Comentarios
  remove_menu_page( 'themes.php' );                 //Apariencia
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Usuarios
  remove_menu_page( 'tools.php' );                  //Herramientas
  remove_menu_page( 'options-general.php' );        //Ajustes
remove_menu_page( 'profile.php' );        //Ajustes
remove_menu_page( 'loco' );
remove_submenu_page( 'index.php', 'update-core.php' );
}
}
add_action( 'admin_menu', 'remove_menus', 99, 0 );


// cambiar Footer name
function change_footer_admin() {
    echo '&copy;2018 Copyright. Todos los derechos reservados';
}
add_filter('admin_footer_text', 'change_footer_admin');




// // Eliminar opciones de la barra del administrador
  function change_toolbar($wp_toolbar) {
      global $current_user;


      $wp_toolbar->remove_node('new-content');
      $wp_toolbar->remove_node('updates');


  }
  add_action('admin_bar_menu', 'change_toolbar', 999);
