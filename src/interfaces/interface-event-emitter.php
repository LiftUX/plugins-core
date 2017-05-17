<?php
/**
 * Event Emitter Interface
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;
use Lift\Core\Hook_Catalog;

/**
 * Interface: Event_Emitter
 */
interface Event_Emitter {
	/**
	 * Emit
	 *
	 * @param string  $action  The name of the event.
	 * @param mixed   $target  The target of the action.
	 * @param mixed[] ...$args The arguments to pass to a callback subscribed to the event.
	 */
	public function emit( string $action, $target, ...$args );
}
