<?php

namespace Voxel\Post_Types\Fields\Taxonomy_Field;

if ( ! defined('ABSPATH') ) {
	exit;
}

trait Exports {

	public function exports() {
		return [
			'label' => $this->get_label(),
			'type' => \Voxel\T_OBJECT,
			'loopable' => true,
			'loopcount' => function() {
				return count( $this->get_value() );
			},
			'properties' => [
				'id' => [
					'label' => 'Term ID',
					'type' => \Voxel\T_NUMBER,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_id() : null;
					},
					'list' => function() {
						$value = (array) $this->get_value();
						return array_map( function( $term ) {
							return $term->get_id();
						}, $value );
					},
				],
				'name' => [
					'label' => 'Term name',
					'type' => \Voxel\T_STRING,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_label() : null;
					},
					'list' => function() {
						$value = (array) $this->get_value();
						return array_map( function( $term ) {
							return $term->get_label();
						}, $value );
					},
				],
				'slug' => [
					'label' => 'Term slug',
					'type' => \Voxel\T_STRING,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_slug() : null;
					},
					'list' => function() {
						$value = (array) $this->get_value();
						return array_map( function( $term ) {
							return $term->get_slug();
						}, $value );
					},
				],
				'description' => [
					'label' => 'Term description',
					'type' => \Voxel\T_STRING,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_description() : null;
					},
				],
				'link' => [
					'label' => 'Term link',
					'type' => \Voxel\T_URL,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_link() : null;
					},
				],
				'icon' => [
					'label' => 'Term icon',
					'type' => \Voxel\T_STRING,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_icon() : null;
					},
				],
				'image' => [
					'label' => 'Term image',
					'type' => \Voxel\T_NUMBER,
					'callback' => function( $index ) {
						$value = (array) $this->get_value();
						$term = $value[ $index ] ?? null;
						return $term ? $term->get_image_id() : null;
					},
				],
			],
		];
	}

}
