<?php

namespace Myd_Widgets\Includes;

use Myd_Widgets\Includes\Register_Elementor_Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin main class
 *
 * @since 1.0
 */
final class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.0
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Disable class cloning and throw an error on object clone.
	 *
	 * @since 1.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'myd-delivery-widgets' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 1.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'myd-delivery-widgets' ), '1.0' );
	}

	/**
	 * Construct class
	 *
	 * @since 1.0
	 * @return void
	 */
	private function __construct() {
		\add_action( 'myddelivery_after_init', array( $this, 'init' ) );
		\add_action( 'plugins_loaded', [ $this, 'check_requirements' ] );
	}

	/**
	 * Check requirements
	 *
	 * @return void
	 */
	public function check_requirements() {
		if ( ! \did_action( 'myddelivery_loaded' ) ) {
			\add_action( 'admin_notices', array( $this, 'admin_notice_require_myd' ) );
			return;
		}
	}

	/**
	 * Init plugin
	 *
	 * @since 1.0
	 * @return void
	 */
	public function init() {
		if ( ! \did_action( 'elementor/loaded' ) ) {
			\add_action( 'admin_notices', array( $this, 'admin_notice_require_elementor' ) );
			return;
		}

		include_once MYDW_PLUGIN_PATH . 'includes/class-register-widgets.php';
		$register_elementor_widget = new Register_Elementor_Widgets();
		$register_elementor_widget->init();
	}

	/**
	 * Admin notice required Elementor
	 *
	 * @since 1.0
	 * @return void
	 */
	function admin_notice_require_elementor() {
		$message = sprintf(
			esc_html__( '%1$s requires Elementor installed and activated.', 'myd-delivery-widgets' ),
			'<strong>MyD Delivery Widgets</strong>'
		);

		$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );

		echo wp_kses_post( $html_message );
	}

	/**
	 * Admin notice required MyD Delivery Pro
	 *
	 * @since 1.0
	 * @return void
	 */
	function admin_notice_require_myd() {
		$message = sprintf(
			/* translators: plugin name won't be translated */
			esc_html__( '%1$s requires %2$s free version installed and activated.', 'myd-delivery-widgets' ),
			'<strong>MyD Delivery Widgets</strong>',
			'<strong>Myd Delivery</strong>',
			esc_html__( 'Click here to install', 'myd-delivery-widgets' )
		);

		$html_message = sprintf( '<div class="notice notice-error mydd-notice"><p>%1$s <a href="/wp-admin/plugin-install.php?tab=plugin-information&plugin=myd-delivery&TB_iframe=true&width=772&height=1174">%2$s</a></p></div>',
			$message,
			esc_html__( 'Click here to install', 'myd-delivery-widgets' )
		);

		echo wp_kses_post( $html_message );
	}
}
