<?php

use Lift\Core\Functions\Runtime_Utils as lib;
use PHPUnit\Framework\TestCase;

class Runtime_Utils_Test extends TestCase {

	public function test_const_compare() {
		define( 'TEST_CONST_COMPARE', true );

		$this->assertTrue( lib\const_compare( 'TEST_CONST_COMPARE', true ) );
		$this->assertFalse( lib\const_compare( 'TEST_CONST_COMPARE', 42 ) );
	}
}
