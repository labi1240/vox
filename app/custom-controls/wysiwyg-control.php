<?php

namespace Voxel\Custom_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wysiwyg_Control extends \Elementor\Control_Wysiwyg {

	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );
		if ( strpos( $value, '@tags()' ) !== false && ! \Voxel\is_importing_elementor_template() ) {
			$value = \Voxel\Dynamic_Tags\Dynamic_Tags::parse( $value );
		}

		return $value;
	}
}
