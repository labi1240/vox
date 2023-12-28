<?php

namespace Voxel\Controllers\Templates;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Templates_Controller extends \Voxel\Controllers\Base_Controller {

	protected function hooks() {
		$this->on( 'admin_menu', '@add_menu_page' );
		$this->filter( 'display_post_states', '@display_template_labels', 100, 2 );

		$this->on( 'voxel_ajax_backend.create_template', '@create_template' );
		$this->on( 'voxel_ajax_backend.create_custom_template', '@create_custom_template' );
		$this->on( 'voxel_ajax_backend.update_template_id', '@update_template_id' );
		$this->on( 'voxel_ajax_backend.update_custom_template', '@update_custom_template' );
		$this->on( 'voxel_ajax_backend.update_custom_template_order', '@update_custom_template_order' );
		$this->on( 'voxel_ajax_backend.delete_template', '@delete_template' );
		$this->on( 'voxel_ajax_backend.delete_custom_template', '@delete_custom_template' );
		$this->on( 'voxel_ajax_backend.update_page_id', '@update_page_id' );
	}

	protected function add_menu_page() {
		add_menu_page(
			__( 'Design', 'voxel-backend' ),
			__( 'Design', 'voxel-backend' ),
			'manage_options',
			'voxel-templates',
			function() {
				$config = [
					'tab' => $_GET['tab'] ?? 'membership',
					'templates' => \Voxel\get_base_templates(),
					'editLink' => admin_url( 'post.php?post={id}&action=elementor' ),
					'previewLink' => home_url( '/?p={id}' ),
				];

				wp_enqueue_script('vx:template-manager.js');
				require locate_template( 'templates/backend/templates/general.php' );
			},
			sprintf( 'data:image/svg+xml;base64,%s', base64_encode( \Voxel\paint_svg(
				file_get_contents( locate_template( 'assets/images/svgs/brush-alt.svg' ) ),
				'#a7aaad'
			) ) ),
			'0.278'
		);

		add_submenu_page(
			'voxel-templates',
			__( 'Header & Footer', 'voxel-backend' ),
			__( 'Header & Footer', 'voxel-backend' ),
			'manage_options',
			'vx-templates-header-footer',
			function() {
				$this->create_required_templates();

				$config = [
					'tab' => $_GET['tab'] ?? 'header',
					'custom_templates' => \Voxel\get_custom_templates(),
					'templates' => \Voxel\get_base_templates(),
					'editLink' => admin_url( 'post.php?post={id}&action=elementor' ),
					'previewLink' => home_url( '/?p={id}' ),
				];

				wp_enqueue_script('vx:template-manager.js');
				require locate_template( 'templates/backend/templates/header-footer.php' );
			},
			1
		);

		add_submenu_page(
			'voxel-templates',
			__( 'Taxonomies', 'voxel-backend' ),
			__( 'Taxonomies', 'voxel-backend' ),
			'manage_options',
			'vx-templates-taxonomies',
			function() {
				$this->create_required_templates();

				$config = [
					'tab' => $_GET['tab'] ?? 'term_single',
					'custom_templates' => \Voxel\get_custom_templates(),
					'templates' => \Voxel\get_base_templates(),
					'editLink' => admin_url( 'post.php?post={id}&action=elementor' ),
					'previewLink' => home_url( '/?p={id}' ),
				];

				wp_enqueue_script('vx:template-manager.js');
				require locate_template( 'templates/backend/templates/taxonomies.php' );
			},
			2
		);

		foreach ( \Voxel\Post_Type::get_voxel_types() as $post_type ) {
			add_submenu_page(
				'voxel-templates',
				'&mdash; '.$post_type->get_label(),
				'&mdash; '.$post_type->get_label(),
				'manage_options',
				'vx-templates-post-type-'.$post_type->get_key(),
				function() {},
				100
			);
		}
	}

	protected function create_required_templates() {
		$templates = \Voxel\get( 'templates' );

		if ( ! \Voxel\template_exists( $templates['header'] ?? '' ) ) {
			$template_id = \Voxel\create_template( 'site template: header' );
			if ( ! is_wp_error( $template_id ) ) {
				$templates['header'] = $template_id;
			}
		}

		if ( ! \Voxel\template_exists( $templates['footer'] ?? '' ) ) {
			$template_id = \Voxel\create_template( 'site template: footer' );
			if ( ! is_wp_error( $template_id ) ) {
				$templates['footer'] = $template_id;
			}
		}

		\Voxel\set( 'templates', $templates );
	}

	protected function display_template_labels( $states, $post ) {
		if ( $post->post_type !== 'page' ) {
			return $states;
		}

		$labels = [
			'auth' => _x( 'Auth Page', 'templates', 'voxel-backend' ),
			'pricing' => _x( 'Pricing Plans Page', 'templates', 'voxel-backend' ),
			'current_plan' => _x( 'Current Plan Page', 'templates', 'voxel-backend' ),
			'configure_plan' => _x( 'Configure Plan Page', 'templates', 'voxel-backend' ),
			'orders' => _x( 'Orders Page', 'templates', 'voxel-backend' ),
			'reservations' => _x( 'Reservations Page', 'templates', 'voxel-backend' ),
			'qr_tags' => _x( 'Order tags: QR code handler', 'templates', 'voxel-backend' ),
			'terms' => _x( 'Terms & Conditions', 'templates', 'voxel-backend' ),
			'stripe_account' => _x( 'Seller Dashboard', 'templates', 'voxel-backend' ),
		];

		$templates = \Voxel\get( 'templates', [] );
		$template = array_search( absint( $post->ID ), $templates, true );
		if ( $template && isset( $labels[ $template ] ) ) {
			$states[ 'vx:'.$template ] = $labels[ $template ];
		}

		foreach ( \Voxel\Post_Type::get_voxel_types() as $post_type ) {
			if ( $post_type->get_templates()['form'] === $post->ID ) {
				$states[ 'vx:create_post' ] = sprintf( '%s: Submit page', $post_type->get_label() );
			}
		}

		return $states;
	}

	protected function create_custom_template() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$label = sanitize_text_field( $_GET['label'] ?? '' );
			$group = sanitize_text_field( $_GET['group'] ?? '' );
			if ( ! in_array( $group, [ 'header', 'footer', 'term_single', 'term_card' ], true ) ) {
				throw new \Exception( __( 'Could not create template', 'voxel-backend' ) );
			}

			if ( ! $label ) {
				throw new \Exception( __( 'Template label is required.', 'voxel-backend' ) );
			}

			$template_id = \Voxel\create_template(
				sprintf( 'template: %s (%s)', $group, $label )
			);

			if ( is_wp_error( $template_id ) ) {
				throw new \Exception( __( 'Could not create template', 'voxel-backend' ) );
			}

			$templates = \Voxel\get( 'custom_templates' );

			$template_config = [
				'label' => $label,
				'id' => absint( $template_id ),
			];

			if ( ! in_array( $group, [ 'term_card' ], true ) ) {
				$template_config['visibility_rules'] = [];
			}

			$templates[ $group ][] = $template_config;

			// make sure templates are stored as indexed arrays
			$templates = array_map( 'array_values', $templates );
			\Voxel\set( 'custom_templates', $templates );

			return wp_send_json( [
				'success' => true,
				'templates'	=> $templates,
			] );

		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function create_template() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$templates = \Voxel\get_base_templates();
			$template_key = $_GET['template_key'] ?? null;
			$template_type = $_GET['template_type'] ?? null;

			if ( empty( $template_key ) || empty( $template_type ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$filtered = array_filter( $templates, function( $tpl ) use ( $template_key ) {
				return $tpl['key'] === $template_key;
			} );
			$template = array_shift( $filtered );

			// error if this template type does not exist, or has already been created
			if ( ! $template || ! empty( $template['id'] ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			if ( $template['type'] === 'page' ) {
				$template_id = \Voxel\create_page( $template['label'], sanitize_title( $template['label'] ) );

				if ( is_wp_error( $template_id ) ) {
					throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
				}

				\Voxel\set( $template['key'], $template_id );
			} elseif ( $template['type'] == 'template' ) {
				$template_id = \Voxel\create_template( $template['label'] );

				if ( is_wp_error( $template_id ) ) {
					throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
				}

				\Voxel\set( $template['key'], $template_id );
			}

			foreach ( $templates as $index => $data ) {
				if ( $data['key'] === $template['key'] ) {
					$data['id'] = $template_id;
					$templates[ $index ] = $data;
				}
			}

			return wp_send_json( [
				'success' => true,
				'templates'=> $templates,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function update_template_id() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$templates = \Voxel\get_base_templates();
			$template_key = $_GET['template_key'] ?? null;
			$new_template_id = $_GET['new_template_id'] ?? null;

			if ( empty( $template_key ) || ! is_numeric( $new_template_id ) || $new_template_id < 1 ) {
				throw new \Exception( __( 'Enter the ID of the new template.', 'voxel-backend' ) );
			}

			$new_template_id = absint( $new_template_id );
			$filtered = array_filter( $templates, function( $tpl ) use ( $template_key ) {
				return $tpl['key'] === $template_key;
			} );
			$template = array_shift( $filtered );

			if ( ! $template ) {
				throw new \Exception( __( 'Could not find requested template.', 'voxel-backend' ) );
			}

			if ( str_starts_with( $template['key'], 'templates.' ) ) {
				if ( $template['type'] === 'page' && ! \Voxel\page_exists( $new_template_id ) ) {
					throw new \Exception( __( 'Provided page template does not exist.', 'voxel-backend' ) );
				} elseif ( $template['type'] === 'template' && ! \Voxel\template_exists( $new_template_id ) ) {
					throw new \Exception( __( 'Provided template does not exist.', 'voxel-backend' ), 110 );
				}

				\Voxel\set( $template['key'], $new_template_id );
			}

			if ( str_starts_with( $template['key'], 'post_types:' ) ) {
				$post_type = \Voxel\Post_Type::get( $template['post_type'] );
				if ( ! $post_type ) {
					throw new \Exception( __( 'Post type not found.', 'voxel-backend' ) );
				}

				if ( $template['type'] === 'page' && ! \Voxel\page_exists( $new_template_id ) ) {
					throw new \Exception( __( 'Provided page template does not exist.', 'voxel-backend' ) );
				} elseif ( $template['type'] === 'template' && ! \Voxel\template_exists( $new_template_id ) ) {
					throw new \Exception( __( 'Provided template does not exist.', 'voxel-backend' ), 112 );
				}

				$post_type_templates = $post_type->get_templates();
				if ( str_ends_with( $template['key'], '.single' ) ) {
					$post_type_templates['single'] = $new_template_id;
				} elseif ( str_ends_with( $template['key'], '.card' ) ) {
					$post_type_templates['card'] = $new_template_id;
				} elseif ( str_ends_with( $template['key'], '.archive' ) ) {
					$post_type_templates['archive'] = $new_template_id;
				} elseif ( str_ends_with( $template['key'], '.form' ) ) {
					$post_type_templates['form'] = $new_template_id;
				}

				$post_type->repository->set_config( [
					'templates' => $post_type_templates,
				] );
			}

			return wp_send_json( [
				'success' => true,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function update_custom_template() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$templates = \Voxel\get_custom_templates();
			$template_id = $_GET['template_id'] ?? null;
			$new_template_id = $_GET['new_template_id'] ?? null;
			$label = sanitize_text_field( $_GET['template_label'] ?? '' );
			$group = sanitize_text_field( $_GET['group'] ?? '' );
			$visibility_rules = $_GET['visibility_rules'] ?? [];

			if ( ! is_numeric( $new_template_id ) || $new_template_id < 1 ) {
				throw new \Exception( __( 'Enter the ID of the new template.', 'voxel-backend' ) );
			}

			if ( ! isset( $templates[ $group ] ) ) {
				throw new \Exception( __( 'Could not update template.', 'voxel-backend' ) );
			}

			$template_id = absint( $template_id );
			$filtered = array_filter( $templates[ $group ], function( $tpl ) use ( $template_id ) {
				return $tpl['id'] === $template_id;
			} );
			$template = array_shift( $filtered );

			if ( ! $template ) {
				throw new \Exception( __( 'Could not find requested template.', 'voxel-backend' ) );
			}

			$new_template_id = absint( $new_template_id );
			if ( ! in_array( $group, [ 'header', 'footer', 'term_single', 'term_card' ], true ) ) {
				throw new \Exception( __( 'Could not update template', 'voxel-backend' ) );
			}
			
			// if ( ! \Voxel\template_exists( $new_template_id ) ) {
			// 	throw new \Exception( __( 'Provided template does not exist.', 'voxel-backend' ), 114 );
			// }

			foreach ( $templates[ $group ] as $index => $data ) {
				if ( $data['id'] === $template_id ) {
					$template_config = [
						'label' => $label ? $label : $data['label'],
						'id' => absint( $new_template_id ),
					];

					if ( ! in_array( $group, [ 'term_card' ], true ) ) {
						$template_config['visibility_rules'] = $visibility_rules ?: [];
					}

					$templates[ $group ][ $index ] = $template_config;
				}
			}

			// make sure templates are stored as indexed arrays
			$templates = array_map( 'array_values', $templates );
			\Voxel\set( 'custom_templates', $templates );

			return wp_send_json( [
				'success' => true,
				'templates'=> $templates,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function update_custom_template_order() {
		try {
			if ( ! current_user_can('manage_options') ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$custom_templates = json_decode( stripslashes( $_REQUEST['custom_templates'] ), true );

			if ( ! is_array( $custom_templates ) || empty( $custom_templates ) ) {
				throw new \Exception( 'Invalid request.' );
			}

			// make sure templates are stored as indexed arrays
			$custom_templates = array_map( 'array_values', $custom_templates );
			\Voxel\set( 'custom_templates', $custom_templates );

			return wp_send_json( [
				'success' => true,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function delete_custom_template() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$templates = \Voxel\get_custom_templates();
			$template_id = $_GET['id'] ?? null;
			$group = sanitize_text_field( $_GET['group'] ?? '' );

			if ( ! in_array( $group, [ 'header', 'footer', 'term_single', 'term_card' ], true ) ) {
				throw new \Exception( __( 'Could not delete template', 'voxel-backend' ) );
			}

			if ( ! isset( $templates[ $group ] ) ) {
				throw new \Exception( __( 'Could not delete template.', 'voxel-backend' ) );
			}

			if ( ! is_numeric( $template_id ) || $template_id < 1 ) {
				throw new \Exception( __( 'Enter the ID of the new template.', 'voxel-backend' ) );
			}

			$template_id = absint( $template_id );
			$filtered = array_filter( $templates[ $group ], function( $tpl ) use ( $template_id ) {
				return $tpl['id'] === $template_id;
			} );
			$template = array_shift( $filtered );
			
			if ( ! $template ) {
				throw new \Exception( __( 'Could not find requested template.', 'voxel-backend' ) );
			}

			foreach ( $templates[ $group ] as $index => $data ) {
				if ( $data['id'] === $template_id ) {
					wp_delete_post( $template_id );
					unset( $templates[ $group ][ $index ] );
				}
			}

			// make sure templates are stored as indexed arrays
			$templates = array_map( 'array_values', $templates );
			\Voxel\set( 'custom_templates', $templates );

			return wp_send_json( [
				'success' => true,
				'templates'=> $templates,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function delete_template() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$templates = \Voxel\get_base_templates();
			$template_key = $_GET['template_key'] ?? null;
			$template_id = $_GET['id'] ?? null;

			if ( empty( $template_key ) || ! is_numeric( $template_id ) || $template_id < 1 ) {
				throw new \Exception( __( 'Enter the ID of the new template.', 'voxel-backend' ) );
			}

			$template_id = absint( $template_id );
			$filtered = array_filter( $templates, function( $tpl ) use ( $template_key ) {
				return $tpl['key'] === $template_key;
			} );
			$template = array_shift( $filtered );

			if ( ! $template ) {
				throw new \Exception( __( 'Could not find requested template.', 'voxel-backend' ) );
			}

			if ( str_starts_with( $template['key'], 'templates.' ) ) {
				wp_delete_post( $template_id );
				\Voxel\set( $template['key'], null );
			}

			foreach ( $templates as $index => $data ) {
				if ( $data['key'] === $template['key'] ) {
					$data['id'] = null;
					$templates[ $index ] = $data;
				}
			}

			return wp_send_json( [
				'success' => true,
				'templates'=> $templates,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function update_page_id() {
		try {
			if ( ! current_user_can( 'manage_options' ) ) {
				throw new \Exception( __( 'Invalid request.', 'voxel-backend' ) );
			}

			$post_type = \Voxel\Post_Type::get( $_GET['post_type'] ?? null );
			$template_key = $_GET['template_key'] ?? null;
			$new_template_id = absint( $_GET['new_template_id'] ?? null );
			$template_type = $_GET['template_type'] ?? null;
			$field_key = sanitize_title( $_GET['field_key'] ?? '' );

			if ( ! $post_type ) {
				throw new \Exception( __( 'Post type not found.', 'voxel-backend' ) );
			}

			if ( empty( $template_key ) || ! is_numeric( $new_template_id ) || $new_template_id < 1 ) {
				throw new \Exception( __( 'Enter the ID of the new template.', 'voxel-backend' ) );
			}

			if ( $template_type === 'page' && ! \Voxel\page_exists( $new_template_id ) ) {
				throw new \Exception( __( 'Provided page template does not exist.', 'voxel-backend' ) );
			} elseif ( $template_type === 'template' && ! \Voxel\template_exists( $new_template_id ) ) {
				throw new \Exception( __( 'Provided template does not exist.', 'voxel-backend' ), 119 );
			}

			$post_type_templates = $post_type->get_templates();
			if ( str_ends_with( $template_key, '.single' ) ) {
				$post_type_templates['single'] = $new_template_id;
			} elseif ( str_ends_with( $template_key, '.card' ) ) {
				$post_type_templates['card'] = $new_template_id;
			} elseif ( str_ends_with( $template_key, '.archive' ) ) {
				$post_type_templates['archive'] = $new_template_id;
			} elseif ( str_ends_with( $template_key, '.form' ) ) {
				$post_type_templates['form'] = $new_template_id;
			}

			$post_type->repository->set_config( [
				'templates' => $post_type_templates,
			] );
			
			return wp_send_json( [
				'success' => true,
				'templates' => $post_type_templates,
			] );
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}
}
