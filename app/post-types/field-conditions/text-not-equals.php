<?php

namespace Voxel\Post_Types\Field_Conditions;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Text_Not_Equals extends Base_Condition {
	use Traits\Single_Value_Model;

	public function get_type(): string {
		return 'text:not_equals';
	}

	public function get_label(): string {
		return _x( 'Not equals', 'field conditions', 'voxel-backend' );
	}

	public function evaluate( $value ): bool {
		return $value !== $this->props['value'];
	}
}
