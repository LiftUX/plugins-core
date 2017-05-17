<?php
/**
 * Subscriber Interface
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;
use Lift\Core\Hook_Catalog;

/**
 * Interface: Subscriber
 */
interface Subscriber {
	/**
	 * Subscribe
	 *
	 * @since v0.1.0
	 *
	 * @param string      $tag      Event tag.
	 * @param callable    $method   Callback.
	 * @param int|integer $priority Priority.
	 * @param int|integer $args     Number of arguments.
	 *
	 * @return  mixed
	 */
	public function subscribe( string $tag, callable $method, int $priority = 10, int $args = 1 );

	/**
	 * Unsubscribe
	 *
	 * @since v0.1.0
	 *
	 * @param string   $tag      Event tag.
	 * @param callable $method   Callback.
	 *
	 * @return  mixed
	 */
	public function unsubscribe( string $tag, callable $method );
}
