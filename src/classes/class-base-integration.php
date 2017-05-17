<?php
/**
 * Abstact Integration
 *
 * @package  AdbutlerUserCampaigns
 * @subpackage  Integrations
 */

namespace Lift\Core;
use Lift\Core\Interfaces\Integration;
use Lift\Core\Interfaces\Provider;
use Lift\Core\Interfaces\Subscriber;

/**
 * Abstract Class: Base_Integration
 *
 * @since  v0.1.0
 * @see  Lift\Core\Interfaces\Integration
 */
abstract class Base_Integration implements Integration {

	/**
	 * Hook Catalog
	 *
	 * @var Hook_Catalog
	 */
	public $hook_catalog;

	/**
	 * Constructor
	 *
	 * @param Hook_Catalog     $hook_catalog Hook Catalog.
	 * @param array|Provider[] ...$providers Array of Providers.
	 *
	 * @return  Integration Instance of self
	 */
	public function __construct( Hook_Catalog $hook_catalog, Provider ...$providers ) {
		$this->hook_catalog = $hook_catalog;
		return $this;
	}

	/**
	 * Add All Integrations
	 *
	 * Adds all integrations defined as methods within the called class.  Those methods
	 * prefixed with `maybe_` will have a corresponding call to `apply_filters` that an
	 * end user can hook into and return false from, thus removing that integration.
	 * Those methods prefixed with `must_` will not have any call to `apply_filters`, and
	 * are required.
	 *
	 * @since v2.0.0
	 * @return  Base_Integration Instance of self
	 */
	public function add_subscriptions() : Subscriber {
		$integrations = array_filter( get_class_methods( $this ), function( $method ) {
			return ( strpos( $method, 'maybe_' ) === 0 || strpos( $method, 'must_' ) === 0 );
		});

		$added_integrations = array();

		foreach ( $integrations as $integration ) {
			array_push( $added_integrations, $this->$integration() ? $this->$integration() : false );
		}

		return $this;
	}

	/**
	 * Get All Integrations
	 *
	 * @since  v2.0.0
	 * @return array An array of integrations added by class within the HookCatalog
	 */
	public function get_subscriptions() : array {
		return array_filter( $this->hook_catalog->entries, function( $entry ) {
			return ( $entry->callable[0] instanceof $this );
		});
	}

	/**
	 * Add Integration
	 *
	 * @since v2.0.0
	 * @param string      $tag      String reference to the hook to apply function to.
	 * @param callable    $method   Method to hook to $tag.
	 * @param int|integer $priority Priority in which it should run, default 10.
	 * @param int|integer $args     Number of arguments to pass to the method, default 1.
	 *
	 * @return  bool True if the Hook_Definition describing integration was added to HookCatalog
	 */
	public function subscribe( string $tag, callable $method, int $priority = 10, int $args = 1 ) : bool {
		$definition = new Hook_Definition( $tag, $method, $priority, $args );
		$this->hook_catalog->add_entry( $definition );
		return true;
	}

	/**
	 * Remove Integration
	 *
	 * @since v2.0.0
	 * @param string      $tag      String reference to the hook to apply function to.
	 * @param callable    $method   Method to hook to $tag.
	 * @param int|integer $priority Priority in which it should run, default 10.
	 * @param int|integer $args     Number of arguments to pass to the method, default 1.
	 *
	 * @return  bool True if the Hook_Definition describing integration was remove to HookCatalog
	 */
	public function unsubscribe( string $tag, callable $method, int $priority = 10, int $args = 1 ) : bool {
		$this->hook_catalog->remove_entry( $tag, $method );
		return true;
	}

	/**
	 * Extract Provider
	 *
	 * @since  v2.0.0
	 * @param  string $class     The name of the class to extract.
	 * @param  array  $providers An array of providers to extract the the class from.
	 * @return mixed|null        The request provider, null if provider is not in the array of providers.
	 */
	public function extract_provider( string $class, array $providers ) {
		return array_reduce( $providers, function( $carry, $item ) use ( $class ) {
			if ( ( ! $carry instanceof $class ) && ( $item instanceof $class ) ) {
				return $item;
			}
			return null;
		}, null );
	}
}
