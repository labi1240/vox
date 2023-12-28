<?php

namespace Voxel\Dynamic_Tags\Modifiers;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Truncate extends \Voxel\Dynamic_Tags\Base_Modifier {

	public function get_label(): string {
		return _x( 'Truncate text', 'modifiers', 'voxel-backend' );
	}

	public function get_key(): string {
		return 'truncate';
	}

	public function get_arguments(): array {
		return [
			'length' => [
				'type' => \Voxel\Form_Models\Text_Model::class,
				'label' => _x( 'Max length', 'modifiers', 'voxel-backend' ),
				'classes' => 'x-col-12',
			],
		];
	}

	public function apply( $value, $args, $group ) {
		return \Voxel\truncate_text( (string) $value, absint( is_numeric( $args[0] ?? null ) ? $args[0] : 128 ) );
	}
}
