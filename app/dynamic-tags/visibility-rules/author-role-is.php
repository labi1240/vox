<?php

namespace Voxel\Dynamic_Tags\Visibility_Rules;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Author_Role_Is extends Base_Visibility_Rule {

	public function get_type(): string {
		return 'author:role';
	}

	public function get_label(): string {
		return _x( 'Author role is', 'visibility rules', 'voxel-backend' );
	}

	public function props(): array {
		return [
			'value' => null,
		];
	}

	public function get_models(): array {
		return [
			'value' => [
				'type' => \Voxel\Form_Models\Select_Model::class,
				'label' => _x( 'Value', 'visibility rules', 'voxel-backend' ),
				'classes' => 'x-col-3 x-grow',
				'choices' => array_map( function( $role ) {
					return $role['name'];
				}, wp_roles()->roles ),
			],
		];
	}

	public function evaluate(): bool {
		$author = \Voxel\get_current_author();
		if ( ! $author ) {
			return false;
		}

		return $author->has_role( $this->props['value'] );
	}
}
