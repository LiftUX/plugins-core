<?php
/**
 * Class SampleTest
 *
 * @package Lift_Core
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

	function test_post_create() {
		$post = $this->factory->post->create([
			'post_title' => 'Test Post',
			'post_content' => 'Test content.'
			]);

		$query = new \WP_Query([
			's' => 'Test Post'
			]);

		$posts = $query->posts;

		$this->assertEquals( 'Test Post', $posts[0]->post_title );
	}
}
