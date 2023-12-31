<?php

namespace Voxel\Post_Types\Fields;

use \Voxel\Form_Models;

if ( ! defined('ABSPATH') ) {
	exit;
}

class File_Field extends Base_Post_Field {
	use \Voxel\Object_Fields\File_Field_Trait;

	protected $supported_conditions = ['file'];

	protected $sortable = true;

	protected $props = [
		'type' => 'file',
		'label' => 'File',
		'max-count' => 1,
		'max-size' => 2000,
		'allowed-types' => [],
	];

	public function sanitize( $value ) {
		if ( $this->repeater ) {
			$upload_key = sprintf( '%s::row-%d', $this->get_id(), $this->repeater_index );
		} else {
			$upload_key = $this->get_id();
		}

		$files = [];
		$uploads = \Voxel\Utils\File_Uploader::prepare( $upload_key, $_FILES['files'] ?? [] );
		$upload_index = 0;

		foreach ( (array) $value as $file ) {
			if ( $file === 'uploaded_file' ) {
				$files[] = [
					'source' => 'new_upload',
					'data' => $uploads[ $upload_index ],
				];

				$upload_index++;
			} elseif ( is_numeric( $file ) ) {
				$files[] = [
					'source' => 'existing',
					'file_id' => absint( $file ),
				];
			}
		}

		return $files;
	}

	public function update( $value ): void {
		$file_ids = $this->_prepare_ids_from_sanitized_input( $value, [
			'post_parent' => $this->post->get_id(),
		] );

		if ( empty( $file_ids ) ) {
			delete_post_meta( $this->post->get_id(), $this->get_key() );
		} else {
			update_post_meta( $this->post->get_id(), $this->get_key(), join( ',', $file_ids ) );
		}
	}

	public function update_value_in_repeater( $value ) {
		$file_ids = $this->_prepare_ids_from_sanitized_input( $value, [
			'post_parent' => $this->post->get_id(),
		] );

		return ! empty( $file_ids ) ? $file_ids : null;
	}

	public function get_value_from_post() {
		$meta_value = get_post_meta( $this->post->get_id(), $this->get_key(), true );
		$ids = explode( ',', $meta_value );
		$ids = array_filter( array_map( 'absint', $ids ) );
		return $ids;
	}

	protected function editing_value() {
		if ( ! $this->post ) {
			return [];
		}

		$ids = $this->get_value();
		if ( $ids === null ) {
			return [];
		}

		$config = [];

		foreach ( $ids as $attachment_id ) {
			if ( $attachment = get_post( $attachment_id ) ) {
				$config[] = [
					'source' => 'existing',
					'id' => $attachment->ID,
					'name' => wp_basename( get_attached_file( $attachment->ID ) ),
					'type' => $attachment->post_mime_type,
					'preview' => wp_get_attachment_image_url( $attachment->ID, 'medium' ),
				];
			}
		}

		return $config;
	}

	public function get_default() {
		if ( ! isset( $this->props['default'] ) || ! is_numeric( $this->props['default'] ) ) {
			return null;
		}

		return absint( $this->props['default'] );
	}

	public function exports() {
		$is_loopable = absint( $this->props['max-count'] ) >= 2;
		$properties = [
			'id' => [
				'label' => 'File ID',
				'type' => \Voxel\T_NUMBER,
				'callback' => function( $index ) {
					$value = (array) $this->get_value();
					return $value[ $index ] ?? $this->get_default();
				},
			],
			'url' => [
				'label' => 'File URL',
				'type' => \Voxel\T_URL,
				'callback' => function( $index ) {
					$value = (array) $this->get_value();
					return wp_get_attachment_url( $value[ $index ] ?? $this->get_default() ) ?: null;
				},
			],
			'name' => [
				'label' => 'File Name',
				'type' => \Voxel\T_STRING,
				'callback' => function( $index ) {
					$value = (array) $this->get_value();
					$attachment = get_post( $value[ $index ] ?? $this->get_default() );
					return $attachment ? wp_basename( get_attached_file( $attachment->ID ) ) : null;
				},
			],
		];

		if ( $is_loopable ) {
			$properties['ids'] = [
				'label' => 'All ids',
				'type' => \Voxel\T_STRING,
				'callback' => function() {
					$value = (array) $this->get_value();
					if ( empty( $value ) ) {
						return $this->get_default();
					}

					return join( ',', $value );
				},
			];
		}

		return [
			'label' => $this->get_label(),
			'type' => \Voxel\T_OBJECT,
			'loopable' => $is_loopable,
			'loopcount' => function() {
				$count = count( $this->get_value() );
				if ( $count >= 1 ) {
					return $count;
				}

				return $this->get_default() !== null ? 1 : 0;
			},
			'properties' => $properties,
		];
	}
}
