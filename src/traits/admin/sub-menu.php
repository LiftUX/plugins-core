<?php
/**
 * Options Provider
 *
 * @since  v0.1.0
 * @package  AdbutlerUserCampaigns
 * @subpackage Traits
 */

namespace Lift\Core\Utils\Admin;

/**
 * Utility: Submenu
 */
trait Sub_Menu {

	/**
	 * Parent Slug
	 *
	 * @var string
	 */
	protected $submenu_page_parent_slug;

	/**
	 * Page Title
	 *
	 * @var string
	 */
	protected $submenu_page_page_title;

	/**
	 * Menu Title
	 *
	 * @var string
	 */
	protected $submenu_page_menu_title;

	/**
	 * Capability
	 *
	 * @var string
	 */
	protected $submenu_page_capability;

	/**
	 * Menu Slug
	 *
	 * @var string
	 */
	protected $submenu_page_menu_slug;

	/**
	 * Callback
	 *
	 * @var callable
	 */
	protected $submenu_page_callback;

	/**
	 * Get Submenu Page Property
	 *
	 * @since  v0.1.0
	 * @param  string $property Property to get.
	 * @return mixed|null       Value of property or null
	 */
	public function get_submenu_page( string $property ) {
		$prefixed = 'submenu_page_' . $property;
		if ( property_exists( $this, $prefixed ) ) {
			return $this->$prefixed;
		}
		return null;
	}

	/**
	 * Set Submenu Page
	 *
	 * @param string $property Property.
	 * @param mixed  $value    Value.
	 * @return mixed Value
	 */
	public function set_submenu_page( string $property, $value ) {
		$prefixed = 'submenu_page_' . $property;
		if ( property_exists( $this, $prefixed ) ) {
			return $this->$prefixed = $value;
		}
		return null;
	}
}
