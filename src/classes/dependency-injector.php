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
	 * @param  string $ref  String to reference the dependency by.
	 * @param  mixed  $dep  The thing to register.
	 * @param  bool   $req  Whether the dependency should be required.
	 * @return Dependency_Injector Instance of self
	 */
	public function register_dependency( string $ref, $dep, bool $req = true ) : Dependency_Injector {
		$this->dependency[ $ref ] = $dep;

		if( $req ) {
			array_push( $this->required, $ref );
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
		foreach ( $this->required as $req_dep ) {
			if ( ! isset( $this->dependencies[ $req_dep ] ) || is_null( $this->dependencies[ $req_dep ] ) ) {
				return false;
			}
		}
		return true;
	}
}
