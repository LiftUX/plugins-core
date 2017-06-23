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
 * A class that you can add instances of Asset_Loader to.  Handles searching through multiple Asset_Loaders
 * to resolve an asset dependency's path, uri, or contents.
 *
 * @since v0.1.0
 */
final class Assets extends \SplPriorityQueue {
	/**
	 * Instance
	 *
	 * @var Assets
	 */
	public static $instance = null;

	/**
	 * Factory
	 *
	 * @return Assets
	 */
	public static function factory() : Assets {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Add Loader
	 *
	 * @param Asset_Loader $loader   An instance of Asset_Loader.
	 * @param int|integer  $priority The priority of the Asset_Loader, higher is greater priority.
	 * @return void
	 */
	public static function add_loader( Asset_Loader $loader, int $priority = 10 ) {
		self::factory()->insert( $loader, $priority );
	}

	/**
	 * Get Path
	 *
	 * @param  string $filename The filename of the asset you're looking for.
	 * @return string
	 */
	public static function get_path( string $filename ) : string {
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

	/**
	 * Get URI
	 *
	 * @param  string $filename The filename of the asset you're looking for.
	 * @return string
	 */
	public static function get_uri( string $filename ) : string {
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

	/**
	 * Get Content
	 *
	 * @param  string $filename The filename of the asset you're looking for.
	 * @return string
	 */
	public static function get_contents( string $filename ) : string {
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
