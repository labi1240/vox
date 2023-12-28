<?php

namespace Voxel\Post_Types\Fields\Post_Relation_Field;

if ( ! defined('ABSPATH') ) {
	exit;
}

trait Exports {

	/**
	 * Dynamic tags exported by the post relation field.
	 *
	 * @since 1.0
	 */
	public function exports() {
		// export related post fields
		if (
			in_array( $this->props['relation_type'], [ 'has_one', 'belongs_to_one' ], true )
			&& count( $this->props['post_types'] ) === 1
			&& ( $post_type = \Voxel\Post_Type::get( $this->props['post_types'][0] ?? null ) )
		) {
			if ( ! isset( $GLOBALS['_vx_relation_exports_nesting_level'] ) ) {
				$GLOBALS['_vx_relation_exports_nesting_level'] = 0;
			}

			// limit nesting level
			if ( $GLOBALS['_vx_relation_exports_nesting_level'] < 1 ) {
				$GLOBALS['_vx_relation_exports_nesting_level']++;
				$exports = $this->exports_post_type( $post_type );
				$GLOBALS['_vx_relation_exports_nesting_level']--;

				return $exports;
			}
		}

		return [
			'label' => $this->get_label(),
			'type' => \Voxel\T_OBJECT,
			'loopable' => true,
			'loopcount' => function() {
				return count( $this->get_value() );
			},
			'properties' => [
				'id' => [
					'label' => 'Post ID',
					'type' => \Voxel\T_NUMBER,
					'callback' => function( $index ) {
						if ( isset( $GLOBALS['vx_preview_card_current_ids'] ) ) {
							$ids = \Voxel\prime_relations_cache( $GLOBALS['vx_preview_card_current_ids'], $this );
							_prime_post_caches( $ids );
						}

						$value = (array) $this->get_value();
						return $value[ $index ] ?? null;
					},
				],
			],
		];
	}

	protected function exports_post_type( \Voxel\Post_Type $post_type ) {
		$group = new \Voxel\Dynamic_Tags\Post_Group;
		$group->post_type = $post_type;
		$group->post = \Voxel\Post::dummy( [ 'post_type' => $post_type->get_key() ] );
		$group->before_field_callback = function( $field ) use ( $group ) {
			$field->set_post( $group->get_post() );
			$field->set_custom_path_prefix($this->get_path().'.');
		};

		$properties = $group->get_properties();
		$properties['id'] = [
			'label' => 'Post ID',
			'type' => \Voxel\T_NUMBER,
			'callback' => function( $index ) {
				if ( isset( $GLOBALS['vx_preview_card_current_ids'] ) ) {
					$ids = \Voxel\prime_relations_cache( $GLOBALS['vx_preview_card_current_ids'], $this );
					_prime_post_caches( $ids );
				}

				$value = (array) $this->get_value();
				return $value[ $index ] ?? null;
			},
		];

		return [
			'label' => $this->get_label(),
			'type' => \Voxel\T_OBJECT,
			'properties' => $properties,
			'before_callback' => function() use ( $group ) {
				if ( isset( $GLOBALS['vx_preview_card_current_ids'] ) ) {
					$ids = \Voxel\prime_relations_cache( $GLOBALS['vx_preview_card_current_ids'], $this );
					_prime_post_caches( $ids );
				}

				$value = (array) $this->get_value();
				$group->post = \Voxel\Post::get( $value[0] ?? null );
				if ( ! $group->post || $group->post->get_id() === 0 ) {
					return false;
				}
			},
		];
	}
}
