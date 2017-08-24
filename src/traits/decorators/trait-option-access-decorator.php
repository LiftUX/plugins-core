<?php
/**
 * Option Access Decorator Trait
 *
 * Decorates a class with the Option_Access Interface.
 *
 * @see Lift\Core\Interfaces\Option_Access
 * @since v0.1.0
 * @package Lift\Core
 * @subpackage Decorators
 */

namespace Lift\Core\Decorators;
use Lift\Core\Interfaces\Option_Access;

trait Option_Access_Decorator {
	/**
	 * Option Group Identifier
	 *
	 * @var string Option group slug.
	 */
	protected $opt_group;

	/**
	 * Options
	 *
	 * @var array Keyed array of options.
	 */
	protected $options;

	/**
	 * Defer
	 *
	 * @var boolean Flag to defer saving options to database on wp_shutdown.  Default is true.
	 */
	protected $defer;

	/**
	 * Dirty
	 *
	 * @var boolean Flag whether the option group is dirty ( the values have changed since instantiation );
	 */
	protected $dirty;

	/**
	 * Constructor
	 *
	 * @param string $opt_group The parent option key.  If it doesn't exist, will be created.
	 */
	public function __construct( string $opt_group ) {
		$this->decorate_option_access( $opt_group );
	}

	/**
	 * Decorate Option Access
	 *
	 * Default decorator for implementing Option_Access.
	 *
	 * @param  string $opt_group The parent option key.  If it doesn't exist, will be created.
	 * @return Option_Access     A class implementing Option_Access.
	 */
	public function decorate_option_access( string $opt_group ) : Option_Access {
		$this->opt_group = $opt_group;
		$this->options = get_option( $this->opt_group );

		if ( false === $this->options ) {
			$this->options = array();
			add_option( $this->opt_group, $this->options );
		}

		add_filter( 'pre_update_option_' . $this->opt_group, array( $this, 'handle_external_updates' ), 10, 2 );

		$this->dirty = false;
		$this->defer( true );

		return $this;
	}

	/**
	 * Factory
	 *
	 * @param string $opt_group The parent option key.
	 * @return Option_Access    Option_Access implementor with loaded parent option key.
	 */
	public static function factory( string $opt_group ) : Option_Access {
		return new self( $opt_group );
	}

	/**
	 * Get Options
	 *
	 * @return array Array of key value options.
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Set Options
	 *
	 * @param  array $options Array of options.
	 * @return array          The option array.
	 */
	public function set_options( array $options ) {
		$this->options = wp_parse_args( $options, $this->options );
		$this->dirty = true;
		return ( ! $this->defer ) ? $this->save() : $this->options;
	}

	/**
	 * Get Option
	 *
	 * @param  string $key       The key of the specific option.
	 * @return mixed             The value of the option.
	 */
	public function get_option( string $key ) {
		return ( isset( $this->options[ $key ] ) ) ? $this->options[ $key ] : null;
	}

	/**
	 * Set Option
	 *
	 * @param  string $key        The key of the specific option.
	 * @param  mixed  $value      The value of the option.
	 * @return mixed              The value of the option.
	 */
	public function set_option( string $key, $value ) {
		$this->options[ $key ] = $value;
		$this->dirty = true;
		if ( ! $this->defer ) {
			$this->save();
		}
		return $value;
	}

	/**
	 * Remove Option
	 *
	 * @param  string $key       The key of the specific option.
	 * @return void
	 */
	public function remove_option( string $key ) {
		unset( $this->options[ $key ] );
		$this->dirty = true;
		if ( ! $this->defer ) {
			$this->save();
		}
	}

	/**
	 * Clear Options
	 *
	 * @return void
	 */
	public function clear_options() {
		$this->options = array();
		if ( ! $this->defer ) {
			$this->save();
		}
	}

	/**
	 * Defer
	 *
	 * @param  boolean $defer Whether saving options to a database should be deferred to specified time, or be done on the fly.
	 * @return void
	 */
	public function defer( bool $defer ) {
		$this->defer = $defer;
		if ( $this->defer ) {
			add_action( 'shutdown', array( $this, 'save' ) );
		} else {
			remove_action( 'shutdown', array( $this, 'save' ) );
		}
	}

	/**
	 * Save
	 *
	 * @return array The options array.
	 */
	public function save() {
		if ( $this->dirty ) {
			update_option( $this->opt_group, $this->options );
		}
		return $this->options;
	}

	/**
	 * Handle External Updates
	 *
	 * @filter
	 * @param mixed $new_value The new value for the option.
	 * @param mixed $old_value The old value for the option.
	 * @return mixed
	 */
	public function handle_external_updates( $new_value, $old_value ) {
		if ( ! $this->dirty ) {
			return $new_value;
		}

		if ( is_array( $new_value ) ) {
			$this->options = array_merge( $this->options, $new_value );
			return $this->options;
		}
	}

	/**
	 * Magic Getter
	 *
	 * @param  string $prop Property name used as array key accessor.
	 * @return mixed
	 */
	public function __get( $prop ) {
		return $this->get_option( $prop );
	}

	/**
	 * Magic Setter
	 *
	 * @param  string $prop  Property name used as array key accessor.
	 * @param  mixed  $value Value to set at the array key.
	 * @return mixed         Returns back the value.
	 */
	public function __set( $prop, $value ) {
		return $this->set_option( $prop, $value );
	}

	/**
	 * Magic Isset
	 *
	 * @param  string $prop Property name used as array key accessor.
	 * @return boolean
	 */
	public function __isset( $prop ) : bool {
		return ! is_null( $this->get_option( $prop ) );
	}

	/**
	 * Magic Unset
	 *
	 * @param  string $prop Property name used as array key accessor.
	 * @return void
	 */
	public function __unset( $prop ) {
		$this->remove_option( $prop );
	}
}
