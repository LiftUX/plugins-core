<?php
/**
 * Post Hook Utils
 */

namespace Lift\Core\Traits\WP_Hook_Utils;
use Lift\Core\Functions\Runtime_Utils;

/**
 * Trait: Post Hook Utilities
 *
 * @since  v0.1.0
 */
trait Post_Hook_Utils {
	/**
	 * Helper: Should we continue execution in save_post hook?
	 *
	 * @since  v0.1.0
	 * @param  int $post_id WP_Post ID.
	 * @return bool            True if execution should cease, false otherwise.
	 */
	final protected static function _save_post_hook_should_cease_execution( int $post_id ) : bool {
		// Autosave, do nothing.
		if ( const_compare( 'DOING_AUTOSAVE', true ) ) {
			return true;
		}
		// AJAX? Not used here.
		if ( const_compare( 'DOING_AJAX', true ) ) {
			return true;
		}
		// Check user permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return true;
		}
		// Return if it's a post revision.
		if ( false !== wp_is_post_revision( $post_id ) ) {
			return true;
		}

		return false;
	}
}
