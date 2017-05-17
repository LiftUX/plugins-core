<?php
/**
 * Dependency Injector
 *
 * @package  Lift\Core\Common
 * @subpackage  Classes
 */

namespace Lift\Core;

/**
 * Class: Dependency Injector
 *
 * @since  v0.1.0
 */
class Dependency_Injector {
	/**
	 * Required Dependencies
	 *
	 * @var string[]
	 */
	protected $required;

	/**
	 * Dependencies Registered to the Injector
	 *
	 * @var mixed[]
	 */
	protected $dependencies;

	/**
	 * Constructor
	 *
	 * @return  Dependency_Injector Instance of self
	 */
	public function __construct() {
		$this->dependencies = array();
		$this->required = array();

		return $this;
	}

	/**
	 * Setup
	 *
	 * On class extension, can be overridden to register the dependencies from within
	 * the context of class.  By default, registers an instance of Hook_Catalog as a
	 * dependency.  Virtually all classes that get dependencies injected to them should
	 * also include an instance of Hook_Catalog, so it is perfectly acceptable to override
	 * this method and then call parent::setup() to include a Hook_Catalog instance.
	 *
	 * @since  v0.1.0
	 * @return Dependency_Injector Instance of self
	 */
	public function setup() : Dependency_Injector {
		$this->register_dependency( 'hook_catalog', new Hook_Catalog, true );
		return $this;
	}

	/**
	 * Inject
	 *
	 * @since  v0.1.0
	 * @param  string $reference  Dependency Reference.
	 * @return mixed|null             The dependency
	 */
	public function inject( string $reference ) {
		if ( array_key_exists( $reference, $this->dependencies ) ) {
			return $this->dependencies[ $reference ];
		}
		return null;
	}

	/**
	 * Register Dependency
	 *
	 * @since  v0.1.0
	 * @param  string       $reference  String to reference the dependency by.
	 * @param  mixed        $dependency The class to register.
	 * @param  bool|boolean $require    Whether the dependency should be required.
	 * @return Dependency_Injector      Instance of self
	 */
	public function register_dependency( string $reference, $dependency, bool $require ) : Dependency_Injector {
		$this->dependencies[ $reference ] = $dependency;

		if ( true === $require ) {
			array_push( $this->required, $reference );
		}

		return $this;
	}

	/**
	 * Ensure Dependency
	 *
	 * @since  v0.1.0
	 * @return bool True if all required dependencies can be resolved, false otherwise.
	 */
	public function ensure_dependencies() : bool {
		foreach ( $this->required as $required_dependency ) {
			if ( ! $this->ensure_dependency( $required_dependency ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Ensure Dependency
	 *
	 * @since  v0.1.0
	 * @param  string $reference Reference to the dependency.
	 * @return bool              Whether the dependency is mapped
	 */
	public function ensure_dependency( string $reference ) : bool {
		if ( ! isset( $this->dependencies[ $reference ] ) || is_null( $this->dependencies[ $reference ] ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Get Manifest
	 *
	 * @return array An associative array of dependency types keyed by their reference.
	 */
	public function get_manifest() {
		$manifest = array();
		foreach ( $this->dependencies as $reference => $dependency ) {
			$manifest[ $reference ] = is_object( $dependency ) ? get_class( $dependency ) : gettype( $dependency );
		}
		return $manifest;
	}
}
