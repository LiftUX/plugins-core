<?php
/**
 * Abstact Integration
 *
 * @package  AdbutlerUserCampaigns
 * @subpackage  Integrations
 */

namespace Lift\Core;

use Lift\Core\Decorators\Integration_Decorator;
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
	use Integration_Decorator;

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
}
