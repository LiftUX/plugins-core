<?php
/**
 * Service
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;

/**
 * Interface: Service
 *
 * @since  v0.1.0
 */
interface Service {

	/**
	 * Call
	 *
	 * @since  v.0.1.0
	 * @param  string $type    The type of call to make.
	 * @param  array  ...$args Arguments to configure the call.
	 * @return mixed           Response from call.
	 */
	public function call( $type, ...$args );

}
