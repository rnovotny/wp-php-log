<?php
/*
Plugin Name: WordPress PHP Logger
Plugin URI: https://ryanmnovotny.com/wp-php-log
Description: Quickly and easily log PHP variables to help debug plugins and themes
Text Domain: wp-php-log
Domain Path: /languages
Author: Ryan Novotny
Author URI: https://ryanmnovotny.com
License: GPLv2
Version: 1.0.0
*/

$my_variable = "Hello World";
wp_php_log ( $my_variable, "my variable" );

$post_meta = get_post_meta (1806);

wp_php_log ( $post_meta, "post meta" );

$variable = "If you don't specify a variable name string...";
wp_php_log ( $variable);

global $woocommerce;
wp_php_log ( $woocommerce, 'woocommerce object' );

// BASIC SECURITY
defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );

// DEFINE SOME USEFUL CONSTANTS
define( 'RN_WPPHP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RN_WPPHP_PLUGINS_URL', plugins_url( '', __FILE__ ) );

function wp_php_log ( $var, $name = '' ) {
	empty ( $name ) ? $name = date("r") : '';
	$log = get_option ( 'rn_wpphp_log' );
	$log[] = array (
		'var' => $var,
		'name' => $name,
	);
	update_option ( 'rn_wpphp_log', $log );
	
}

function rn_wpphp_register_menu_page(){
    add_menu_page( 
        __( 'PHP Logs', 'wp-php-log' ),
		__( 'PHP Logs', 'wp-php-log' ),
		'manage_options',
		'rn_wpphp_main_page',
		'rn_wpphp_main_page',
		'dashicons-editor-code',
        '67.301237577123000471' 
    ); 
}
add_action( 'admin_menu', 'rn_wpphp_register_menu_page' );
 
function rn_wpphp_main_page(){
	wp_enqueue_style( 'rn_wpphp_main_page_css', RN_WPPHP_PLUGINS_URL . '/includes/admin.css' );
	wp_enqueue_script( 'rn_wpphp_main_page_js', RN_WPPHP_PLUGINS_URL . '/includes/admin.js' );
	$data = array(
		'confirm_text' => __( 'Are you sure you want to clear the log?', 'wp-php-log'),
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		
	);
	wp_localize_script( 'rn_wpphp_main_page_js', 'wpphp', $data  );
		
	echo "<div id='rn_wpphp_main_page'>";
		
		$log = get_option ( 'rn_wpphp_log' );
		empty ( $log ) ? $log = array() : '';
			
		echo "<h2>" . __('WordPress PHP Log Plugin', 'wp-php-log') . '</h2>';
		
		echo "<pre class='rn_php_pre'>" . __('<strong>Usage:</strong> wp_php_log( int|string|array $var, string $name = time() (Optional) )', 'wp-php-log') . '</pre>';
		echo "<pre class='rn_php_pre'>" . __('<strong>Example:</strong> wp_php_log( $my_variable, "my variable") ', 'wp-php-log') . '</pre>';	
		
		echo '<div id="rn_wpphp_controls">';
			echo '<p><strong>' . __('Controls', 'wp-php-log') . '</strong></p>';
			echo '<p>' . __('Array mode', 'wp-php-log') . '</p>';
			echo '<label class="rn_wpphp_show_var_dump"><input type="radio" name="rn_wpphp_array_setting" value="rn_wpphp_show_var_dump">' . __('var_dump', 'wp-php-log') . '</label><br>';
			echo '<label class="rn_wpphp_show_print_r"><input type="radio" name="rn_wpphp_array_setting" value="rn_wpphp_show_print_r">' . __('print_r', 'wp-php-log') . '</label><br><br>';
			echo "<button type='button' class='button button-secondary' id='rn_wpphp_delete_button'>" . __('Clear Log', 'wp-php-log' ) . "</button>";
		echo '</div>';

		echo "<h3>" . __('Log:', 'wp-php-log') . '</h3>';
				
		forEach ( $log as $item ) {
			echo '<div class="rn_wpphp_item"><h4>' . $item['name'] . '</h4>';
			if ( is_array ( $item['var'] ) OR is_object ( $item['var'] ) ) {
				echo '<pre class="rn_wpphp_var_dump rn_php_pre">';
				var_dump ( $item['var'] );
				echo '</pre>';
				echo '<pre class="rn_wpphp_print_r rn_php_pre">';
				print_r ( $item['var'] );
				echo '</pre>';			
				
			} else {
				echo '<pre class="rn_php_pre">' . $item['var']. '</pre>';
			}
			echo '</div>';
		}
		
		wp_nonce_field( 'rn_wpphp_delete_action', 'rn_wpphp_delete_action_nonce' );

	echo "</div>";
}

function rn_wpphp_clear_log() {
	// if nonce is verified 
	
	$verified = wp_verify_nonce( $_REQUEST['rn_wpphp_nonce'], 'rn_wpphp_delete_action' );
	
	if ( $verified == 1 ) {
		update_option ( 'rn_wpphp_log', array() );
		echo 'success';
	} else {
		echo 'failed';
	}
		
	wp_die();

}

//AJAX Reset button
add_action( 'wp_ajax_rn_wpphp_delete_action', 'rn_wpphp_clear_log' );
add_action( 'wp_ajax_nopriv_rn_wpphp_delete_action', 'rn_wpphp_clear_log' );



