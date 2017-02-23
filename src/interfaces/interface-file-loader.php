<?php
/**
 * File Loader Interface
 *
 * @package  Lift\Core
 * @subpackage  Interfaces
 */

namespace Lift\Core\Interfaces;

/**
 * Interface: File loader
 *
 * @since  v0.1.0
 */
interface File_Loader {

	/**
	 * Constructor
	 *
	 * @param string $path The base path to the directory.
	 * @param string $uri  The base uri to the directory.
	 */
	public function __construct( string $path, string $uri );

	/**
	 * Validate Path
	 *
	 * @param  string $path The directory path or file path to validate.
	 * @return bool         True on existence, false otherwise.
	 */
	public function validate_path( string $path ) : bool;

	/**
	 * Validate URI
	 *
	 * @param  string $uri The URI to path or file to validate.
	 * @return bool        True on existence, false otherwise.
	 */
	public function validate_uri( string $uri ) : bool;

	/**
	 * Get Path
	 * @param  string $filename The directory or filename with path to retrieve.
	 * @return string           The full path to the file.
	 */
	public function get_path( string $filename ) : string;

	/**
	 * Get URI
	 *
	 * @param  string $filename The filename or directory to retrieve.
	 * @return string           The full uri to the file or directory.
	 */
	public function get_uri( string $filename ) : string;

	/**
	 * Get Contents
	 *
	 * @param  string $filename The filename to read contents from.
	 * @return string           The contents of the file.
	 */
	public function get_contents( string $filename ) : string;

	/**
	 * Failure handler
	 *
	 * @return mixed
	 */
	public function handle_failure();
}
