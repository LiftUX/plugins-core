<?php

use Lift\Core\Hook_Catalog;

class Base_Integration_Test extends PHPUnit_Framework_Testcase {

	public function setUp() {
		$this->class = new Base_Integration_Extender( new Hook_Catalog );
	}

	public function test_has_hook_catalog() {
		$this->assertTrue( $this->class->hook_catalog instanceof Hook_Catalog );
	}

	public function test_add_hook() {
		\WP_Mock::expectFilterAdded( 'test_add_hook', array( $this->class, 'no_autoload' ), 10, 1 );

		$this->class->add_hook( 'test_add_hook', 'no_autoload', 10, 1 );

		$this->assertEquals( 1, count( $this->class->hook_catalog->get_catalog_entries() ) );
		$this->assertInstanceOf( 'Lift\\Core\\Hook_Definition', $this->class->hook_catalog->get_catalog_entries()[0] );
	}

	public function test_add_all_hooks() {

		$this->class->add_all_hooks();

		$this->assertEquals( 2, count( $this->class->hook_catalog->get_catalog_entries() ) );
		$this->assertInstanceOf( 'Lift\\Core\\Hook_Definition', $this->class->hook_catalog->get_catalog_entries()[0] );
	}

	public function test_get_all_hooks() {
		$this->assertTrue( empty( $this->class->get_all_hooks() ) );

		$this->class->add_all_hooks();

		$this->assertFalse( empty( $this->class->get_all_hooks() ) );
	}

	public function test_remove_hook() {
		\WP_Mock::expectFilterAdded( 'test_add_hook', array( $this->class, 'no_autoload' ), 10, 1 );
		\WP_Mock::userFunction( 'remove_filter', array(
			'return_arg' => 0
		) );

		$this->class->add_hook( 'test_add_hook', 'no_autoload', 10, 1 );

		$this->assertEquals( 1, count( $this->class->hook_catalog->get_catalog_entries() ) );

		$this->class->remove_hook( 'test_add_hook', 'no_autoload', 10, 1 );

		$this->assertTrue( empty( $this->class->get_all_hooks() ) );
	}
}