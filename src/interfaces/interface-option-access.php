<?php
/**
 * Option_Access
 *
 * @since  v0.1.0
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;

/**
 * Interface: Option_Access
 *
 * @since  v0.1.0
 */
interface Option_Access {

	/**
	 * Constructor
	 *
	 * @param string $opt_group The parent option key.  If it doesn't exist, will be created.
	 */
	public function __construct( string $opt_group );

	/**
	 * Factory
	 *
	 * @param string $opt_group The parent option key.
	 * @return Option_Access    Option_Access implementor with loaded parent option key.
	 */
	public static function factory( string $opt_group ) : Option_Access;

	/**
	 * Set Options
	 *
	 * @param  array $options Array of options.
	 * @return void
	 */
	public function set_options( array $options );

	/**
	 * Get Options
	 *
	 * @return array             Array of key value options.
	 */
	public function get_options();

	/**
	 * Set Option
	 *
	 * @param  string $key        The key of the specific option.
	 * @param  mixed  $value      The value of the option.
	 * @return mixed              The value of the option.
	 */
	public function set_option( string $key, $value );

	/**
	 * Get Option
	 *
	 * @param  string $key       The key of the specific option.
	 * @return mixed             The value of the option.
	 */
	public function get_option( string $key );

	/**
	 * Remove Option
	 *
	 * @param  string $key       The key of the specific option.
	 * @return void
	 */
	public function remove_option( string $key );

	/**
	 * Clear Options
	 *
	 * @return void
	 */
	public function clear_options();

	/**
	 * Defer
	 *
	 * @param  boolean $defer Whether saving options to a database should be deferred to specified time, or be done on the fly.
	 * @return void
	 */
	public function defer( bool $defer );

}
