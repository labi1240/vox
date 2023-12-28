<?php

namespace Voxel\Custom_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Number_Control extends \Elementor\Control_Number {

	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );
		if ( is_string( $value ) && strncmp( $value, '@tags()', 7 ) === 0 && ! \Voxel\is_importing_elementor_template() ) {
			$value = \Voxel\render( $value );
		}

		return $value;
	}
}
