<?php

use Lift\Core\Functions\Runtime_Utils as lib;

class Runtime_Utils_Test extends PHPUnit_Framework_Testcase {

	public function test_const_compare() {
		define( 'TEST_CONST_COMPARE', true );

		$this->assertTrue( lib\const_compare( 'TEST_CONST_COMPARE', true ) );
		$this->assertFalse( lib\const_compare( 'TEST_CONST_COMPARE', 42 ) );
	}
}
