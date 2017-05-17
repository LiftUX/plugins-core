<?php
/**
 * Test Helper:  Base_Integration_Extender
 *
 * @package  Lift\Core\Tests
 */

use Lift\Core\Base_Integration;
use Lift\Core\Hook_Catalog;
use Lift\Core\Interfaces\Provider;

class Base_Integration_Extender extends Base_Integration {

	public function __construct( Hook_Catalog $hook_catalog, Provider ...$providers ) {
		return parent::__construct( $hook_catalog, ...$providers );
	}

	public function maybe_do_something() {
		$this->subscribe( 'maybe_we_should', array( $this, 'do_something' ), 10, 1 );
	}

	public function must_do_something_else() {
		$this->subscribe( 'we_must', array( $this, 'do_something_else' ), 10, 1 );
	}

	public function do_something() {
		return 0;
	}

	public function do_something_else() {
		return 1;
	}

	public function no_autoload() {
		return 2;
	}
}
