<?php

namespace Myd_Widgets\Includes;

use Myd_Widgets\Includes\Widgets\Widget_Delivery_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class to register Elementor Widgets.
 *
 * @since 1.0
 */
final class Register_Elementor_Widgets {
	/**
	 * Init and register the widgets.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	/**
	 * Include required widget fileds.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function include_widget_files() {
		include_once MYDW_PLUGIN_PATH . 'includes/widgets/class-widget-delivery-page.php';
	}

	/**
	 * Register widgets
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 * @since 1.0
	 */
	public function register_widgets( $widgets_manager ) {
		$this->include_widget_files();
		$widgets_manager->register( new Widget_Delivery_Page() );
	}
}
