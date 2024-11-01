<?php
/*
Plugin Name: WordPress Facebook Messenger
Plugin URI: https://softwhiz.in/
Description: Provide Support to your customers using Facebook Messenger.
Author: Anurag Sharma
Version: 0.0.2
Author URI: https://www.softwhiz.in/
Text Domain: wp-fb-messenger
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'WFM_TEXT_DOMAIN' ) ) {
	define( 'WFM_TEXT_DOMAIN', 'wp-fb-messenger' );
}

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-fb-messenger.php';

function run_wp_fb_messenger() {

	$plugin = new Wp_Fb_Messenger();
	$plugin->run();

}

function wp_fb_messenger_plugin_init(){
	run_wp_fb_messenger();
}
add_action('plugins_loaded', 'wp_fb_messenger_plugin_init');

?>