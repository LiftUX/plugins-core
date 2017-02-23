<?php
/**
 * Runtime Functions
 *
 * A collection of functions that help execution at runtime.
 *
 * @package Lift\Core
 * @subpackage  Functions
 */

namespace Lift\Core\Functions\Runtime_Utils;

/**
 * Constant Compare
 *
 * @since  v0.1.0
 * @param  string $constant Constant Name.
 * @param  mixed  $compare  The value of the constant to compare against.
 * @return bool             True if the value of the constant is equal to the comparator, false otherwise.
 */
function const_compare( string $constant, $compare ) : bool {
	if ( defined( $constant ) && constant( $constant ) === $compare ) {
		return true;
	}
	return false;
}
