<?php
/**
 * Plugin Name: MyD Delivery Widgets
 * Plugin URI: https://myddelivery.com/
 * Description: MyD Delivery Widgets create Elementor widgets to delivery plugin MyD Delivery.
 * Author: EduardoVillao.me
 * Author URI: https://eduardovillao.me/
 * Version: 1.3
 * Requires PHP: 7.0
 * Requires at least: 5.4
 * Text Domain: myd-delivery-widgets
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Myd_Delivery_Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'MYDW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MYDW_PLUGN_URL', plugin_dir_url( __FILE__ ) );
define( 'MYDW_PLUGIN_MAIN_FILE', __FILE__ );
define( 'MYDW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'MYDW_PLUGIN_DIRNAME', plugin_basename( __DIR__ ) );
define( 'MYDW_CURRENT_VERSION', '1.3' );
define( 'MYDW_MINIMUM_PHP_VERSION', '7.0' );
define( 'MYDW_MINIMUM_WP_VERSION', '5.4' );
define( 'MYDW_PLUGIN_NAME', 'MyD Delivery Widgets' );

/**
 * Check PHP and WP version before include plugin main class
 *
 * @since 1.0
 */
if ( ! version_compare( PHP_VERSION, MYDW_MINIMUM_PHP_VERSION, '>=' ) ) {

	add_action( 'admin_notices', 'mydp_admin_notice_php_version_fail' );
	return;
}

if ( ! version_compare( get_bloginfo( 'version' ), MYDW_MINIMUM_WP_VERSION, '>=' ) ) {

	add_action( 'admin_notices', 'mydp_admin_notice_wp_version_fail' );
	return;
}

include_once MYDW_PLUGIN_PATH . 'includes/class-plugin.php';
Myd_Widgets\Includes\Plugin::instance();

/**
 * Admin notice PHP version fail
 *
 * @since 1.0
 * @return void
 */
function mydw_admin_notice_php_version_fail() {

	$message = sprintf(
		esc_html__( '%1$s requires PHP version %2$s or greater.', 'myd-delivery-widgets' ),
		'<strong>MyD Delivery Widgets</strong>',
		MYDW_MINIMUM_PHP_VERSION
	);

	$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );

	echo wp_kses_post( $html_message );
}

/**
 * Admin notice WP version fail
 *
 * @since 1.0
 * @return void
 */
function mydw_admin_notice_wp_version_fail() {

	$message = sprintf(
		esc_html__( '%1$s requires WordPress version %2$s or greater.', 'myd-delivery-widgets' ),
		'<strong>MyD Delivery Widgets</strong>',
		MYDW_MINIMUM_WP_VERSION
	);

	$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );

	echo wp_kses_post( $html_message );
}
