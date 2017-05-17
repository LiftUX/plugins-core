<?php
/**
 * Field Type Definitions
 *
 * Helper class to compose form fields.
 *
 * @since v0.1.0
 * @package Lift\Core
 * @subpackage Classes
 */

// Work In Progress.
// @codingStandardsIgnoreStart

namespace Lift\Core;

/**
 * @codeCoverageIgnore
 */
class Field_Type_Definition {

	public $type = 'text';

	public $name = '';

	public $class = 'field';

	public $id = '';

	public $value = '';

	public $attributes;

	public $save_callback = '__return_false';

	public function __construct( $args ) {
		$this->apply( $args );
	}

	public function apply( $args ) : Field_Type_Definition {
		foreach ( $args as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
		return $this;
	}

	public function render() {
		$html = '';
		if ( strpos( $this->type, 'input' ) > -1 ) {
			$html = $this->render_input( ...array_slice( explode( ':', $this->type ), 1, 2 ) );
		}

		// Allowed through wp_kses.
		$allowed = array(
			'input' => array_fill_keys( [ 'name', 'type', 'value', 'class', 'id', 'disabled', 'required', 'checked' ], array() ),
			'select' => array_fill_keys( [ 'name', 'value', 'class', 'id', 'disabled', 'required', 'selected' ], array() ),
		);

		echo wp_kses( apply_filters( 'lift_field_type_definition_render', $html, $this ), $allowed );
	}

	public function render_input( $type = 'text' ) {
		return sprintf( '<input type="%1$s" name="%2$s" value="%3$s" class="%4$s" id="%5$s" %6$s />',
			esc_attr( $type ),
			esc_attr( $this->name ),
			esc_attr( $this->value ),
			esc_attr( $this->class ),
			esc_attr( $this->id ),
			$this->stringify_attributes()
		);
	}

	protected function stringify_attributes() : string {
		$attributes = '';
		foreach ( $this->attributes as $att_name => $att_value ) {
			$attributes = $attributes . sprintf( ' %1$s="%2$s"', (string) $att_name, esc_attr( $att_value ) );
		}
		return $attributes;
	}
}

// @codingStandardsIgnoreEnd
