<?php

namespace Myd_Widgets\Includes\Widgets;

use MydPro\Includes\Fdm_products_show;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor widget for MyD Delivery main page.
 *
 * @since 1.0
 */
class Widget_Delivery_Page extends \Elementor\Widget_Base {
	/**
	 * Prefix to prevent name conflics.
	 */
	protected static $prefix = 'myd-delivery-page';

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'myd-delivery-page';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'MyD Delivery Page', 'myd-delivery-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'myd', 'delivery', 'products' ];
	}

	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Filter and search - content
		 */
		$this->start_controls_section(
			self::$prefix . '_filter_search_content_section',
			[
				'label' => esc_html__( 'Filter & Search', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			self::$prefix . '_filter_search_type',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Type', 'myd-delivery-widgets' ),
				'options' => [
					'complete' => esc_html__( 'Complete', 'myd-delivery-widgets' ),
					'hide_filter' => esc_html__( 'Hide filter', 'myd-delivery-widgets' ),
					'hide_search' => esc_html__( 'Hide search', 'myd-delivery-widgets' ),
					'hide' => esc_html__( 'Hide all', 'myd-delivery-widgets' ),
				],
				'default' => 'complete',
			]
		);

		$this->end_controls_section();

		/**
		 * Product grid - content
		 */
		$this->start_controls_section(
			self::$prefix . '_product_grid_content_section',
			[
				'label' => esc_html__( 'Product Grid', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_grid_columns',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Columns', 'myd-delivery-widgets' ),
				'options' => [
					'1' => esc_html__( '1 column', 'myd-delivery-widgets' ),
					'2' => esc_html__( '2 columns', 'myd-delivery-widgets' ),
					'3' => esc_html__( '3 columns', 'myd-delivery-widgets' ),
				],
				'desktop_default' => '2',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'selectors' => [
					'{{WRAPPER}} .myd-product-list' => 'grid-template-columns: repeat({{VALUE}},1fr);',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_grid_gap',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Gap', 'myd-delivery-widgets' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'desktop_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-list' => 'grid-gap: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render template based on model in MyD Delivery Pro
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$args = array(
			'filter_type' => $settings[ self::$prefix . '_filter_search_type' ],
		);

		if( defined( '\MYD_CURRENT_VERSION' ) && version_compare( \MYD_CURRENT_VERSION, '1.9.15', '<' ) ) {
			echo __( 'To use this widget you need MyD Delivery Pro version 1.9.15 or later.', 'myd-delivery-widgets' );
			return;
		}

		if ( class_exists( 'MydPro\Includes\Fdm_products_show' ) ) {
			$delivey_template = new Fdm_products_show();
			echo $delivey_template->fdm_list_products_html( $args );
			return;
		}

		echo __( 'Please, install MyD Delivery Pro to use this widget.', 'myd-delivery-widgets' );
	}
}
