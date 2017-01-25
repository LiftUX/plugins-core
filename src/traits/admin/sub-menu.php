<?php
/**
 * Options Provider
 *
 * @since  v0.1.0
 * @package  AdbutlerUserCampaigns
 * @subpackage Traits
 */

namespace Lift\Core\Utils\Admin;

/**
 * Utility: Submenu
 */
trait Sub_Menu {

	/**
	 * Parent Slug
	 *
	 * @var string
	 */
	protected $submenu_page_parent_slug;

	/**
	 * Page Title
	 *
	 * @var string
	 */
	protected $submenu_page_page_title;

	/**
	 * Menu Title
	 *
	 * @var string
	 */
	protected $submenu_page_menu_title;

	/**
	 * Capability
	 *
	 * @var string
	 */
	protected $submenu_page_capability;

	/**
	 * Menu Slug
	 *
	 * @var string
	 */
	protected $submenu_page_menu_slug;

	/**
	 * Submenu Page Sections
	 *
	 * @var string[]
	 */
	protected $submenu_page_sections = array();

	/**
	 * Callback
	 *
	 * @var callable
	 */
	protected $submenu_page_callback;

	/**
	 * Get Submenu Page Property
	 *
	 * @since  v0.1.0
	 * @param  string $property Property to get.
	 * @return mixed|null       Value of property or null
	 */
	public function get_submenu_page( string $property ) {
		$prefixed = 'submenu_page_' . $property;
		if ( property_exists( $this, $prefixed ) ) {
			return $this->$prefixed;
		}
		return null;
	}

	/**
	 * Set Submenu Page
	 *
	 * @param string $property Property.
	 * @param mixed  $value    Value.
	 * @return mixed Value
	 */
	public function set_submenu_page( string $property, $value ) {
		$prefixed = 'submenu_page_' . $property;
		if ( property_exists( $this, $prefixed ) ) {
			return $this->$prefixed = $value;
		}
		return null;
	}

	/**
	 * Render Submenu Page
	 *
	 * @since  v0.1.0
	 * @return void
	 */
	public function render_submenu_page() {
		// Ensure we can be here and we have a reason to be here.
		if ( ! current_user_can( $this->get_submenu_page( 'capability' ) ) || ! $this->option_name ) {
			return;
		}?>

		<div class="wrap">

			<h1>
				<?php echo esc_html( get_admin_page_title() ); ?>
			</h1>

			<form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>" method="post">
				<?php
					settings_fields( $this->option_name );
					do_settings_sections( $this->hook_suffix );
					submit_button( 'Save Settings' );
				?>
			</form>
		</div>

		<?php
	}

	/**
	 * Add Submenu Section
	 *
	 * @since v0.1.0
	 * @param string   $sid       Section ID.
	 * @param string   $label    Section Label.
	 * @param callable $callback Callable to render after section title.
	 *
	 * @return self
	 */
	public function add_submenu_section( string $sid = 'main', string $label = 'Options', callable $callback = '\__return_false' ) {
		add_settings_section( $sid, $label, $callback, $this->hook_suffix );
		array_push( $this->submenu_page_sections, $sid );
		return $this;
	}

	/**
	 * Add Submenu Field
	 *
	 * @since v0.1.0
	 *
	 * @param string       $option Option name from the database.
	 * @param string|array $type   The form element. Element types expressed as an array.
	 * @param string       $key    The option key.
	 * @param string       $label  The label for the option.
	 * @param array        $opts   Additional options.
	 *
	 * @return  void
	 */
	public function add_submenu_field( string $option, $type, string $key, string $label, array $opts = array() ) {
		$args = func_get_args();
		add_settings_field(
			$key,
			$label,
			( isset( $opts['cb'] ) && is_callable( $opts['cb'] ) )
				? $opts['cb']
				: function() use ( $option, $type, $key ) {
					return $this->render_field( $option, $type, $key );
				},
			isset( $opts['page'] ) ? $opts['page'] : $this->hook_suffix,
			isset( $opts['section'] ) ? $opts['section'] : end( $this->submenu_page_sections ),
			$args
		);
	}

	/**
	 * Render Field
	 *
	 * @since  v0.1.0
	 * @param  string       $option Option name.
	 * @param  string|array $type   The element and type.
	 * @param  string       $key    The option key.
	 * @return void
	 */
	public function render_field( string $option, $type, string $key ) {

		if ( is_array( $type ) ) {
			$node_type = reset( $type );
			$node_el = key( $type );
		} else {
			$node_el = $type;
		}

		switch ( $node_el ) {
			case 'input' :
				$this->render_field_input( $node_type, $option, $key );
				break;
			default:
				break;
		}
	}

	/**
	 * Render Field: Input
	 *
	 * @since  v0.1.0
	 * @param  string $type   The input `type` attribute.
	 * @param  string $option The option name.
	 * @param  string $key    The option key.
	 * @return void
	 */
	public function render_field_input( string $type, string $option, string $key ) {
		$options = get_option( $option );
		$value = isset( $options[ $key ] ) ? $options[ $key ] : '';
		echo sprintf(
			'<input type="%s" name="%s[%s]" value="%s" />',
			esc_attr( $type ),
			esc_attr( $option ),
			esc_attr( $key ),
			esc_attr( $value )
		);
	}
}
