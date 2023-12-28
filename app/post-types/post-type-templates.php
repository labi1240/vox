<?php

namespace Voxel\Post_Types;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Post_Type_Templates {

	private $post_type, $repository;

	public function __construct( \Voxel\Post_Type $post_type ) {
		$this->post_type = $post_type;
		$this->repository = $post_type->repository;
	}

	/**
	 * Retrieve and validate post type templates.
	 *
	 * @since 1.0
	 */
	public function get_templates( $create_if_not_exists = false ) {
		$templates = [
			'single' => null,
			'card' => null,
			'archive' => null,
			'form' => null,
		];

		foreach ( (array) ( $this->repository->config['templates'] ?? [] ) as $location => $template_id ) {
			if ( array_key_exists( $location, $templates ) && is_numeric( $template_id )  ) {
				$templates[ $location ] = absint( $template_id );
			}
		}

		if ( $create_if_not_exists ) {
			foreach ( $templates as $location => $template_id ) {
				// allow passing an array as parameter to only create certain templates
				if ( is_array( $create_if_not_exists ) && ! in_array( $location, $create_if_not_exists, true ) ) {
					continue;
				}

				if ( $location === 'form' ) {
					if ( \Voxel\page_exists( absint( $template_id ) ) ) {
						continue;
					}

					$title = sprintf( 'Create %s', $this->post_type->get_singular_name() );
					$new_template_id = \Voxel\create_page(
						$title,
						sprintf( 'create-%s', $this->post_type->get_key() )
					);

					if ( ! is_wp_error( $new_template_id ) ) {
						$templates[ $location ] = absint( $new_template_id );
					}
				} else {
					if ( \Voxel\template_exists( absint( $template_id ) ) ) {
						continue;
					}

					$title = sprintf( 'post type: %s | template: %s', $this->post_type->get_key(), $location );
					$new_template_id = \Voxel\create_template( $title );
					if ( ! is_wp_error( $new_template_id ) ) {
						$templates[ $location ] = absint( $new_template_id );
					}
				}
			}

			$this->repository->set_config( [
				'templates' => $templates,
			] );
		}

		return $templates;
	}

	public function get_custom_templates() {
		$groups = [
			'card' => [],
			'single' => [],
			'single_post' => [],
		];

		foreach ( (array) ( $this->repository->config['custom_templates'] ?? [] ) as $group => $templates ) {
			foreach ( (array) $templates as $template ) {
				if ( isset( $template['id'], $template['label'] ) && is_numeric( $template['id'] ) ) {
					if ( $group == 'single_post' ) {
						$groups[ $group ][] = [
							'label' => $template['label'],
							'id' => absint( $template['id'] ),
							'visibility_rules'	=> $template['visibility_rules'] ?? [],
						];
					} else {
						$groups[ $group ][] = [
							'label' => $template['label'],
							'id' => absint( $template['id'] ),
						];
					}
				}
			}
		}

		return $groups;
	}

}
