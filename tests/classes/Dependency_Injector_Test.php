<?php

use Lift\Core\Hook_Catalog;
use Lift\Core\Dependency_Injector;
use PHPUnit\Framework\TestCase;

class Dependency_Injector_Test extends TestCase {

	public function setUp() {
		$this->injection = new Base_Integration_Extender( new Hook_Catalog );
		$this->di = new Dependency_Injector;
	}

	public function test___construct() {
		$this->assertObjectHasAttribute( 'dependencies', $this->di );
		$this->assertObjectHasAttribute( 'required', $this->di );
	}

	public function test_setup() {
		$this->di->setup();

		$this->assertInstanceOf( Hook_Catalog::class, $this->di->inject( 'hook_catalog' ) );
	}

	public function test_inject__when_valid() {
		$this->di->setup();

		$this->assertInstanceOf( Hook_Catalog::class, $this->di->inject( 'hook_catalog' ) );
	}

	public function test_inject__when_invalid() {
		$this->di->setup();

		$this->assertInternalType( 'null', $this->di->inject( 'not_registered' ) );
	}

	public function test_register_dependency() {
		$this->di->register_dependency( 'test_class', $this->injection, false );

		$this->assertInstanceOf( Base_Integration_Extender::class, $this->di->inject( 'test_class' ) );
	}

	public function test_ensure_dependencies__when_valid() {
		$this->di->register_dependency( 'required_class', $this->injection, true );
		$this->di->register_dependency( 'false', false, true );

		$result = $this->di->ensure_dependencies();

		$this->assertTrue( $result );
	}

	public function test_ensure_dependencies__when_invalid() {
		$this->di->register_dependency( 'required_class', $this->injection, true );
		$this->di->register_dependency( 'null', null, true );

		$result = $this->di->ensure_dependencies();

		$this->assertFalse( $result );
	}

	public function test_get_manifest() {
		$di = new Dependency_Injector;
		$di->register_dependency( 'required_class', $this->injection, true );
		$di->register_dependency( 'required_string', 'Hello World', true );

		$expect = array (
			'required_class' => Base_Integration_Extender::class,
			'required_string' => 'string',
		);

		$manifest = $di->get_manifest();

		$this->assertEquals( $expect, $manifest );
	}
}
