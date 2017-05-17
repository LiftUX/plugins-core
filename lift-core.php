<?php
/**
 * Plugin Name:     Lift Core
 *
 * Plugin URI:      https://liftux.com
 * Description:     A PHP library for composing WordPress themes and applications.
 * Author:          Christian Chung
 * Author URI:      https://liftux.com
 * Text Domain:     lift-core
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Lift\Core
 */

namespace Lift\Core;

// This is a library, all we do is autoload the library classes.
if ( ! class_exists( 'Lift\Core\Hook_Catalog' ) ) {
	require_once( 'vendor/autoload.php' );
}

/**
 * Ready
 *
 * Alerts WordPress that the library is loaded and ready.
 *
 * @return void
 */
function ready() {
	do_action( 'lift_init' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\ready' );
