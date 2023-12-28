<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Relation_Request_Group extends Base_Group {

	public $key = 'request';
	public $label = 'Request';

	public $relation_ids;

	protected function properties(): array {
		return [
			'title' => [
				'label' => 'Post title',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					$post = \Voxel\Post::get( $this->relation_ids[0] ?? null );
					return $post ? $post->get_display_name() : _x( '(deleted)', 'deleted item', 'voxel' );
				},
				'list' => function() {
					$relation_ids = $this->relation_ids;
					if ( count( $relation_ids ) > 10 ) {
						$relation_ids = array_slice( $relation_ids, 0, 10 );
					}

					_prime_post_caches( $relation_ids );
					return array_map( function( $post_id ) {
						$post = \Voxel\Post::get( $post_id );
						return $post ? $post->get_display_name() : _x( '(deleted)', 'deleted item', 'voxel' );
					}, $relation_ids );
				},
			],
			'count' => [
				'label' => 'Relation count',
				'type' => \Voxel\T_NUMBER,
				'callback' => function() {
					return count( $this->relation_ids );
				},
			],
		];
	}
}
