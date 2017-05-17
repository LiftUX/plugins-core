<?php
/**
 * Plugin Integration
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;

use Lift\Core\Hook_Catalog;

/**
 * Interface: Integration
 */
interface Integration extends Subscriber {

	/**
	 * Constructor
	 *
	 * @param Hook_Catalog     $hook_catalog Hook Catalog instance.
	 * @param array|Provider[] ...$providers Variadic of Providers.
	 */
	public function __construct( Hook_Catalog $hook_catalog, Provider ...$providers );

	/**
	 * Subscribe All
	 *
	 * @since  v0.1.0
	 */
	public function add_subscriptions() : Subscriber;

	/**
	 * Get Subscriptions
	 *
	 * @since  v0.1.0
	 * @return mixed
	 */
	public function get_subscriptions();

	/**
	 * Extract Provider
	 *
	 * @param  string     $class     The fully qualified class name of the Provider to extract.
	 * @param  Provider[] $providers An array of Providers.
	 * @return mixed                 The Provider instance.
	 */
	public function extract_provider( string $class, array $providers );
}
