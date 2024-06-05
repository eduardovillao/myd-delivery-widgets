<?php

namespace Myd_Widgets\Includes\Widgets;

use MydPro\Includes\Fdm_products_show;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
	protected static $prefix = 'myd_delivery_page';

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
	 * Style depends
	 *
	 * @return void
	 */
	public function get_style_depends() {
		return [ 'myd-delivery-frontend' ];
	}

	/**
	 * Get product categories to use on select option
	 *
	 * @return array
	 */
	public function get_product_categories_options() {
		if( defined( '\MYD_CURRENT_VERSION' ) && version_compare( \MYD_CURRENT_VERSION, '1.9.41', '<' ) ) {
			return array(
				'all' => esc_html__( 'All Categories', 'myd-delivery-widgets' ),
			);
		}

		$product_categories = get_option( 'fdm-list-menu-categories' );
		if ( empty( $product_categories ) ) {
			return array();
		}

		$product_categories = explode( ",", $product_categories );
		$product_categories = array_map( 'trim', $product_categories );
		$product_categories_options = array(
			'all' => esc_html__( 'All Categories', 'myd-delivery-widgets' ),
		);
		foreach ( $product_categories as $category ) {
			$product_categories_options[ $category ] = $category;
		}

		return $product_categories_options;
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

		$this->add_control(
			self::$prefix . '_filter_search_product_category',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Product Category', 'myd-delivery-widgets' ),
				'options' => $this->get_product_categories_options(),
				'default' => 'all',
				'description' => esc_html__( 'This control requires MyD Delivery Pro version 1.9.41 or greater to work and show the options.', 'myd-delivery-widgets' ),
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

		/**
		 * Product card - content
		 */
		$this->start_controls_section(
			self::$prefix . '_product_card_content_section',
			[
				'label' => esc_html__( 'Product card', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			self::$prefix . '_product_card_img_align',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Image alignment', 'myd-delivery-widgets' ),
				'options' => [
					'row' => esc_html__( 'Right', 'myd-delivery-widgets' ),
					'row-reverse' => esc_html__( 'Left', 'myd-delivery-widgets' ),
				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'flex-direction: {{VALEU}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_card_items_gap',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Itemns gap', 'myd-delivery-widgets' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'gap: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Filter and search - style
		 */
		$this->start_controls_section(
			self::$prefix . '_filter_search_style_section',
			[
				'label' => esc_html__( 'Filter & Search container', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name' => self::$prefix . '_filter_search_type',
							'operator' => '!==',
							'value' => 'hide',
						],
					],
				],
			]
		);

		$this->add_control(
			self::$prefix . '_filter_search_container_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_filter_search_container_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '12',
					'right' => '12',
					'bottom' => '12',
					'left' => '12',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_filter_search_container_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-content-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_filter_search_container_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-content-filter',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_filter_search_container_border',
				'label' => esc_html__( 'Border', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-content-filter',
			]
		);

		$this->end_controls_section();

		/**
		 * Product card - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_card_style_section',
			[
				'label' => esc_html__( 'Product card', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_card__background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_card_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .myd-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_product_card_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-product-item',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_product_card_border',
				'label' => esc_html__( 'Border', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-product-item',
			]
		);

		$this->end_controls_section();

		/**
		 * Product title - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_title_style_section',
			[
				'label' => esc_html__( 'Product title', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_title_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'myd-delivery-widgets' ),
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_title_font',
				'selector' => '{{WRAPPER}} .myd-product-item__title',
			]
		);

		$this->end_controls_section();

		/**
		 * Product description - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_description_style_section',
			[
				'label' => esc_html__( 'Product description', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_description_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'myd-delivery-widgets' ),
				'default' => '#717171',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_description_font',
				'selector' => '{{WRAPPER}} .myd-product-item__desc',
			]
		);

		$this->end_controls_section();

		/**
		 * Product price - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_price_style_section',
			[
				'label' => esc_html__( 'Product price', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_price_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'myd-delivery-widgets' ),
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .myd-product-item__price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_product_price_font',
				'selector' => '{{WRAPPER}} .myd-product-item__price',
			]
		);

		$this->end_controls_section();

		/**
		 * Product popup - style
		 */
		$this->start_controls_section(
			self::$prefix . '_product_popup_style_section',
			[
				'label' => esc_html__( 'Product popup', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_product_popup_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'background: {{VALUE}};',
					'{{WRAPPER}} .fdm-popup-product-action' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_product_popup_button_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Button color', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .fdm-add-to-cart-popup' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_popup_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_product_popup_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Border radius', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .fdm-popup-product-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_product_popup_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .fdm-popup-product-content',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_product_popup_border',
				'label' => esc_html__( 'Border', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .fdm-popup-product-content',
			]
		);

		$this->end_controls_section();

		/**
		 * Cart float button - style
		 */
		$this->start_controls_section(
			self::$prefix . '_cart_float_button_style_section',
			[
				'label' => esc_html__( 'Cart float button', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_cart_float_button_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_cart_float_button_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_font',
				'selector' => '{{WRAPPER}} .myd-float__title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-float',
			]
		);

		$this->add_responsive_control(
			self::$prefix . '_cart_float_button_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Border radius', 'myd-delivery-widgets' ),
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .myd-float' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => self::$prefix . '_cart_float_button_border',
				'label' => esc_html__( 'Border', 'myd-delivery-widgets' ),
				'selector' => '{{WRAPPER}} .myd-float',
			]
		);

		$this->end_controls_section();

		/**
		 * Side cart navigation - style
		 */
		$this->start_controls_section(
			self::$prefix . '_side_cart_navigation_style_section',
			[
				'label' => esc_html__( 'Side cart navigation', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_navigation_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__nav' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_navigation_buttons_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Buttons color', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__nav-back' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__nav-close' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__nav--active svg' => 'fill: {{VALUE}} !important;',
					'{{WRAPPER}} .myd-cart__nav--active .myd-cart__nav-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Side cart content - style
		 */
		$this->start_controls_section(
			self::$prefix . '_side_cart_content_style_section',
			[
				'label' => esc_html__( 'Side cart content', 'myd-delivery-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_content_background',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Background', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__content' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			self::$prefix . '_side_cart_content_buttons_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Buttons color', 'myd-delivery-widgets' ),
				'selectors' => [
					'{{WRAPPER}} .myd-cart__button' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__checkout-option--active' => 'background: {{VALUE}};',
					'{{WRAPPER}} .myd-cart__finished-track-order' => 'background: {{VALUE}};',
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
			'product_category' => $settings[ self::$prefix . '_filter_search_product_category' ],
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
