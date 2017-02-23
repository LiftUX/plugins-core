<?php

class Post_Hook_Utils_Test extends PHPUnit_Framework_Testcase {
	use Lift\Core\Traits\WP_Hook_Utils\Post_Hook_Utils;

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function test__save_post_should_cease_execution__on_autosave() {
		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AUTOSAVE', true ],
			'times' => 1,
			'return' => true
			]);

		$this->assertTrue( $this->_save_post_hook_should_cease_execution( 1 ) );
	}

	public function test__save_post_should_cease_execution__on_ajax() {
		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AUTOSAVE', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AJAX', true ],
			'times' => 1,
			'return' => true
			]);

		$this->assertTrue( $this->_save_post_hook_should_cease_execution( 1 ) );
	}

	public function test__save_post_should_cease_execution__on_cap() {
		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AUTOSAVE', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AJAX', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'current_user_can',[
			'args' => [ 'edit_post', 1 ],
			'times' => 1,
			'return' => false
			]);

		$this->assertTrue( $this->_save_post_hook_should_cease_execution( 1 ) );
	}

	public function test__save_post_should_cease_execution__on_post_revision() {
		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AUTOSAVE', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AJAX', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'current_user_can',[
			'args' => [ 'edit_post', 1 ],
			'times' => 1,
			'return' => true
			]);

		\WP_Mock::userFunction( 'wp_is_post_revision', [
			'args' => [1],
			'times' => 1,
			'return' => true
			]);

		$this->assertTrue( $this->_save_post_hook_should_cease_execution( 1 ) );
	}

	public function test__save_post_should_cease_execution__when_it_should_not() {
		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AUTOSAVE', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'const_compare', [
			'args' => [ 'DOING_AJAX', true ],
			'times' => 1,
			'return' => false
			]);

		\WP_Mock::userFunction( 'current_user_can',[
			'args' => [ 'edit_post', 1 ],
			'times' => 1,
			'return' => true
			]);

		\WP_Mock::userFunction( 'wp_is_post_revision', [
			'args' => [1],
			'times' => 1,
			'return' => false
			]);

		$this->assertFalse( $this->_save_post_hook_should_cease_execution( 1 ) );
	}
}
