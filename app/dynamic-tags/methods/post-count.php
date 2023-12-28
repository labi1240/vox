<?php

namespace Voxel\Dynamic_Tags\Methods;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Post_Count extends Base_Method {

	public function get_key(): string {
		return 'post_count';
	}

	public function get_label(): string {
		return _x( 'Post count', 'modifiers', 'voxel-backend' );
	}

	public function run( $args, $group ) {
		if ( empty( $args[0] ) ) {
			$counts = $group->term->post_counts->get_counts();
			return array_sum( $counts );
		}

		return $group->term->post_counts->get_count_for_post_type( $args[0] ?? '' );
	}

	public function get_arguments(): array {
		return [
			'post_type' => [
				'type' => \Voxel\Form_Models\Select_Model::class,
				'label' => _x( 'Post type', 'modifiers', 'voxel-backend' ),
				'classes' => 'x-col-12',
				'choices' => [ '' => 'All' ] + array_map( function( $post_type ) {
					return $post_type->get_label();
				}, \Voxel\Post_Type::get_voxel_types() ) ,
			],
		];
	}
}
