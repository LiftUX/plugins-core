<?php
/**
 * Class: Assets
 *
 * @package Lift\Core
 * @subpackage Classes
 * @since v0.1.0
 */

namespace Lift\Core;

/**
 * Class: Assets
 *
 * @since v0.1.0
 */
final class Assets extends \SplPriorityQueue {
	public static $instance = null;

	public static function factory() : Assets {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function add_loader( Asset_Loader $loader, int $priority = 10 ) {
		self::factory()->insert( $loader, $priority );
	}

	public static function get_path( $filename ) {
		while ( self::factory()->valid() ) {
			try {
				$path = self::factory()->current()->get_path( $filename );
			} catch ( \Exception $exception ) {
				self::factory()->next();
				continue;
			}
			if ( '' == $path ) {
				self::factory()->next();
				continue;
			}
			return $path;
		}
		return '';
	}

	public static function get_uri( $filename ) {
		while ( self::factory()->valid() ) {
			try {
				$path = self::factory()->current()->get_uri( $filename );
			} catch ( \Exception $exception ) {
				self::factory()->next();
				continue;
			}
			if ( '' == $path ) {
				self::factory()->next();
				continue;
			}
			return $path;
		}
		return '';
	}

	public static function get_contents( $filename ) {
		while ( self::factory()->valid() ) {
			try {
				$path = self::factory()->current()->get_contents( $filename );
			} catch ( \Exception $exception ) {
				self::factory()->next();
				continue;
			}
			if ( '' == $path ) {
				self::factory()->next();
				continue;
			}
			return $path;
		}
		return '';
	}
}
