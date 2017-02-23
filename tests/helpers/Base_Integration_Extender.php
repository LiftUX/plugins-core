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

	public function __construct( Hook_Catalog $hook_catalog, array ...$providers ) {
		return parent::__construct( $hook_catalog, $providers );
	}

	public function maybe_do_something() {
		$this->add_hook( 'maybe_we_should', 'do_something', 10, 1 );
	}

	public function must_do_something_else() {
		$this->add_hook( 'we_must', 'do_something_else', 10, 1 );
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
