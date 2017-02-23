<?php
/**
 * Provider
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;

/**
 * Interface: Provider
 *
 * @since  v0.1.0
 */
interface Provider {

	/**
	 * Provide
	 *
	 * @since  v0.1.0
	 * @param  array|mixed[] ...$args Arguments.
	 * @return mixed
	 */
	public function provide( ...$args );
}
