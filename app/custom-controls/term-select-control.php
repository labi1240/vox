<?php

namespace Voxel\Custom_Controls;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Term_Select_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'voxel-term-select';
	}

	protected function get_default_settings() {
		return [
			'label' => '',
			'label_block' => true,
			'taxonomy' => [],
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>

		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title">
					{{{ data.label }}}
				</label>
			<# } #>
			<div class="elementor-control-input-wrapper">
				<div class="value-wrap" style="display: none;">
					<a href="#" class="current-value"></a>
					<a href="#" class="clear-value"><?= __( 'Clear', 'voxel-backend' ) ?></a>
				</div>
				<input type="text" placeholder="<?= esc_attr( __( 'Search terms', 'voxel-backend' ) ) ?>">
				<div class="search-results"></div>
			</div>
		</div>

		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );
		if ( is_string( $value ) && strncmp( $value, '@tags()', 7 ) === 0 && ! \Voxel\is_importing_elementor_template() ) {
			$value = \Voxel\render( $value );
		}

		// cache ids to bulk retrieve post titles for display in the editor
		if ( is_admin() && ! empty( $value ) ) {
			if ( ! isset( $GLOBALS['_vx_term_select_values'] ) ) {
				$GLOBALS['_vx_term_select_values'] = [];
			}

			$GLOBALS['_vx_term_select_values'][] = $value;
		}

		return $value;
	}
}
