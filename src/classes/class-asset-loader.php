<?php
/**
 * Asset Loader
 *
 * @package  Lift\Core
 * @subpackage  Classes
 */

namespace Lift\Core;
use Lift\Core\Interfaces\File_Loader;
use Lift\Core\Exceptions\File_Loader_Exception;
use Lift\Core\Functions\Runtime_Utils as lib;

/**
 * Class: Asset Loader
 *
 * @uses Lift\Core\Interfaces\File_Loader
 * @since  v0.1.0
 */
class Asset_Loader implements File_Loader {
	/**
	 * Base Path
	 *
	 * @var string
	 */
	public $base_path;

	/**
	 * Base URI
	 *
	 * @var string
	 */
	public $base_uri;

	/**
	 * Constructor
	 *
	 * @param string $path The base path to the directory.
	 * @param string $uri  The base uri to the directory.
	 */
	public function __construct( string $path, string $uri ) {
		$this->base_path = $this->validate_path( $path ) ? $path : null;
		$this->base_uri = $this->base_path ? $uri : null;
	}

	/**
	 * Static Factory
	 *
	 * @param string $path The base path to the directory.
	 * @param string $uri  The base uri to the directory.
	 * @return Asset_Loader
	 */
	public static function factory( string $path = '', string $uri = '' ) : Asset_Loader {
		return new self( $path, $uri );
	}

	/**
	 * Validate Path
	 *
	 * @param  string $path The directory path or file path to validate.
	 * @return bool         True on existence, false otherwise.
	 */
	public function validate_path( string $path ) : bool {
		return file_exists( $path );
	}

	/**
	 * Validate URI
	 *
	 * @param  string $uri The URI to path or file to validate.
	 * @return bool        True on existence, false otherwise.
	 */
	public function validate_uri( string $uri ) : bool {
		return $this->validate_path( $uri );
	}

	/**
	 * Get Path
	 *
	 * @param  string $filename The directory or filename with path to retrieve.
	 * @return string           The full path to the file.
	 */
	public function get_path( string $filename ) : string {
		$path = $this->concat( $this->base_path, $filename );
		return $this->validate_path( $path ) ? $path : $this->handle_failure( $filename );
	}

	/**
	 * Get URI
	 *
	 * @param  string $filename The filename or directory to retrieve.
	 * @return string           The full uri to the file or directory.
	 */
	public function get_uri( string $filename ) : string {
		$uri = $this->concat( $this->base_uri, $filename );
		return $this->validate_uri( $this->get_path( $filename ) ) ? $uri : $this->handle_failure( $filename );
	}

	/**
	 * Get Contents
	 *
	 * @param  string $filename The filename to read contents from.
	 * @return string           The contents of the file.
	 */
	public function get_contents( string $filename ) : string {
		$target = false;
		$path = $this->concat( $this->base_path, $filename );
		if ( $this->validate_path( $path ) ) {
			$target = $path;
		} elseif ( filter_var( $filename, FILTER_VALIDATE_URL ) ) {
			$target = $filename;
		}

		if ( apply_filters( 'asset_loader_get_contents_target', $target ) ) {
			return call_user_func( apply_filters( 'lift_get_contents_fn', 'file_get_contents' ), $target );
		}
		return $this->handle_failure( strlen( $filename ) ? $filename : 'empty' );
	}

	/**
	 * Concat
	 *
	 * @since  v0.1.0
	 * @param  string $base     Base path or uri.
	 * @param  string $filename Requested path or uri, relative to base.
	 * @return string           Concatenated path or uri.
	 */
	public function concat( string $base, string $filename ) : string {
		return trailingslashit( $base ) . ltrim( $filename, '/' );
	}

	/**
	 * Failure handler
	 *
	 * @uses Lift\Core\Functions\Runtime_Utils::const_compare()
	 * @throws  File_Loader_Exception Thrown if debug mode and file doesn't exist.
	 * @param string $filename The name of the file that couldn't be loaded.
	 *
	 * @return mixed
	 */
	public function handle_failure( string $filename ) {
		if ( lib\const_compare( 'WP_DEBUG', true ) ) {
			throw new File_Loader_Exception( "{$filename} does not exist in {$this->base_path}" );
		}
		return '';
	}

	/**
	 * [Deprecated] Resolve URI
	 *
	 * @param  Asset_Loader $loader   The Asset_Loader instance.
	 * @param  string       $filename The Filename.
	 * @return string                 The URI to the file.
	 */
	public static function resolve_uri( Asset_Loader $loader, string $filename ) : string {
		return $loader->get_uri( $filename );
	}

	/**
	 * [Deprecated] Resolve Path
	 *
	 * @param  Asset_Loader $loader   The Asset_Loader instance.
	 * @param  string       $filename The Filename.
	 * @return string                 The path to the file.
	 */
	public static function resolve_path( Asset_Loader $loader, string $filename ) : string {
		return $loader->get_path( $filename );
	}

	/**
	 * [Deprecated] Resolve Contents
	 *
	 * @param  Asset_Loader $loader   The Asset_Loader instance.
	 * @param  string       $filename The Filename.
	 * @return string                 The contents of the file.
	 */
	public static function resolve_contents( Asset_Loader $loader, string $filename ) : string {
		return $loader->get_contents( $filename );
	}
}
