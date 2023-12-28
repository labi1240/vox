<?php

namespace Voxel\Controllers\Taxonomies;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Taxonomy_Controller extends \Voxel\Controllers\Base_Controller {

	protected function hooks() {
		$this->on( 'init', '@register_taxonomies', 0 );
		$this->filter( 'register_taxonomy_args', '@manage_existing_taxonomies', 50, 2 );
		$this->on( 'admin_menu', '@add_menu_page' );
		$this->on( 'voxel/backend/screen:manage-taxonomies', '@render_manage_taxonomies_screen' );
		$this->on( 'voxel/backend/screen:create-taxonomy', '@render_create_taxonomy_screen' );
		$this->on( 'admin_post_voxel_create_taxonomy', '@create_taxonomy' );
		$this->on( 'edited_term', '@update_taxonomy_version', 100, 3 );
		$this->on( 'created_term', '@update_taxonomy_version', 100, 3 );
		$this->on( 'delete_term', '@update_taxonomy_version', 100, 3 );

		$this->on( 'voxel/backend/screen:edit-taxonomy', '@render_edit_screen', 30 );
		$this->on( 'admin_post_voxel_save_taxonomy_settings', '@save_taxonomy_settings' );

		$this->filter( 'admin_footer', '@add_edit_taxonomy_link', 140 );
	}

	protected function register_taxonomies() {
		$taxonomies = \Voxel\get('taxonomies');
		foreach ( $taxonomies as $config ) {
			if ( ! taxonomy_exists( $config['settings']['key'] ) ) {
				$args = [
					'labels' => [
						'name' => $config['settings']['plural'],
						'singular_name' => $config['settings']['singular'],
					],
					'public'              => true,
					'show_ui'             => true,
					'publicly_queryable'  => true,
					'hierarchical'        => true,
					'query_var'           => true,
					'show_in_nav_menus'   => true,
					'_is_created_by_voxel' => true,
				];

				if ( $config['settings']['permalinks']['custom'] ?? false ) {
					$args['rewrite'] = [
						'slug' => $config['settings']['permalinks']['slug'] ?? $config['settings']['key'],
						'hierarchical' => $config['settings']['permalinks']['hierarchical'] ?? false,
						'with_front' => $config['settings']['permalinks']['with_front'] ?? true,
					];
				}

				if ( ( $config['settings']['show_admin_column'] ?? null ) === 'yes' ) {
					$args['show_admin_column'] = true;
				} elseif ( ( $config['settings']['show_admin_column'] ?? null ) === 'no' ) {
					$args['show_admin_column'] = false;
				}

				if ( ( $config['settings']['show_in_quick_edit'] ?? null ) === 'yes' ) {
					$args['show_in_quick_edit'] = true;
				} elseif ( ( $config['settings']['show_in_quick_edit'] ?? null ) === 'no' ) {
					$args['show_in_quick_edit'] = false;
				}

				if ( ( $config['settings']['publicly_queryable'] ?? null ) === 'yes' ) {
					$args['publicly_queryable'] = true;
				} elseif ( ( $config['settings']['publicly_queryable'] ?? null ) === 'no' ) {
					$args['publicly_queryable'] = false;
				}

				if ( ( $config['settings']['hierarchical'] ?? null ) === 'yes' ) {
					$args['hierarchical'] = true;
				} elseif ( ( $config['settings']['hierarchical'] ?? null ) === 'no' ) {
					$args['hierarchical'] = false;
				}

				register_taxonomy( $config['settings']['key'], $config['settings']['post_type'], $args );
			}
		}
	}

	protected function manage_existing_taxonomies( $args, $taxonomy_key ) {
		$config = \Voxel\get( 'taxonomies.'.$taxonomy_key );
		if ( ! empty( $args['_is_created_by_voxel'] ) || empty( $config ) ) {
			return $args;
		}

		if ( ! empty( $config['settings']['plural'] ?? null ) ) {
			$args['labels']['name'] = $config['settings']['plural'];
		}

		if ( ! empty( $config['settings']['singular'] ?? null ) ) {
			$args['labels']['singular_name'] = $config['settings']['singular'];
		}

		if ( $config['settings']['permalinks']['custom'] ?? false ) {
			$args['rewrite'] = [
				'slug' => $config['settings']['permalinks']['slug'] ?? $config['settings']['key'],
				'hierarchical' => $config['settings']['permalinks']['hierarchical'] ?? false,
				'with_front' => $config['settings']['permalinks']['with_front'] ?? true,
			];
		}

		if ( ( $config['settings']['show_admin_column'] ?? null ) === 'yes' ) {
			$args['show_admin_column'] = true;
		} elseif ( ( $config['settings']['show_admin_column'] ?? null ) === 'no' ) {
			$args['show_admin_column'] = false;
		}

		if ( ( $config['settings']['show_in_quick_edit'] ?? null ) === 'yes' ) {
			$args['show_in_quick_edit'] = true;
		} elseif ( ( $config['settings']['show_in_quick_edit'] ?? null ) === 'no' ) {
			$args['show_in_quick_edit'] = false;
		}

		if ( ( $config['settings']['publicly_queryable'] ?? null ) === 'yes' ) {
			$args['publicly_queryable'] = true;
		} elseif ( ( $config['settings']['publicly_queryable'] ?? null ) === 'no' ) {
			$args['publicly_queryable'] = false;
		}

		if ( ( $config['settings']['hierarchical'] ?? null ) === 'yes' ) {
			$args['hierarchical'] = true;
		} elseif ( ( $config['settings']['hierarchical'] ?? null ) === 'no' ) {
			$args['hierarchical'] = false;
		}

		return $args;
	}

	protected function create_taxonomy() {
		check_admin_referer( 'voxel_manage_taxonomies' );
		if ( ! current_user_can( 'manage_options' ) ) {
			die;
		}

		if ( empty( $_POST['taxonomy'] ) || ! is_array( $_POST['taxonomy'] ) ) {
			die;
		}

		$taxonomies = \Voxel\get('taxonomies');

		$config = wp_unslash( $_POST['taxonomy'] );
		$key = sanitize_key( $config['key'] ?? '' );
		$singular_name = sanitize_text_field( $config['singular_name'] ?? '' );
		$plural_name = sanitize_text_field( $config['plural_name'] ?? '' );
		$post_types = array_filter( $config['post_type'] ?? [], function( $post_type_key ) {
			return post_type_exists( $post_type_key );
		} );

		if ( $key && $singular_name && $plural_name ) {
			$taxonomies[ $key ] = [
				'settings' => [
					'key' => $key,
					'singular' => $singular_name,
					'plural' => $plural_name,
					'post_type' => $post_types,
				],
			];
		}

		\Voxel\set( 'taxonomies', $taxonomies );

		flush_rewrite_rules();

		wp_safe_redirect( admin_url( 'admin.php?page=voxel-taxonomies&action=edit-taxonomy&taxonomy='.$key ) );
		exit;
	}

	protected function add_menu_page() {
		add_submenu_page(
			'voxel-post-types',
			__( 'Taxonomies', 'voxel-backend' ),
			__( 'Taxonomies', 'voxel-backend' ),
			'manage_options',
			'voxel-taxonomies',
			function() {
				$action_key = $_GET['action'] ?? 'manage-taxonomies';
				$allowed_actions = ['manage-taxonomies', 'create-taxonomy', 'edit-taxonomy', 'reorder-terms'];
				$action = in_array( $action_key, $allowed_actions, true ) ? $action_key : 'manage-taxonomies';
				do_action( 'voxel/backend/screen:'.$action );
			},
			5
		);
	}

	protected function render_manage_taxonomies_screen() {
		$add_taxonomy_url = admin_url('admin.php?page=voxel-taxonomies&action=create-taxonomy');
		$taxonomies = \Voxel\Taxonomy::get_voxel_taxonomies();

		$default_taxonomies = [
			'category',
			'post_tag',
		];

		foreach ( $default_taxonomies as $taxonomy_key ) {
			if ( ! isset( $taxonomies[ $taxonomy_key ] ) && ( $taxonomy = \Voxel\Taxonomy::get( $taxonomy_key ) ) ) {
				$taxonomies[ $taxonomy_key ] = $taxonomy;
			}
		}

		$config = [
			'tab' => $_GET['tab'] ?? 'manage-taxonomies',
			'post_types' => array_filter( array_map( function( $post_type ) {
				$taxonomies = get_object_taxonomies( $post_type->get_key() );
				if ( ! empty( $taxonomies ) ) {
					return [
						'label'	=> $post_type->get_label(),
						'slug' => $post_type->get_key(),
					];
				}
			}, \Voxel\Post_Type::get_voxel_types() ) ),
			'taxonomies' => array_map( function( $taxonomy ) {
				return [
					'label' => $taxonomy->get_label(),
					'slug' => $taxonomy->get_key(),
					'post_types' => array_values( $taxonomy->get_post_types() ),
					'reorder_terms'	=> admin_url( sprintf(
						'admin.php?page=voxel-taxonomies&action=reorder-terms&taxonomy=%s',
						$taxonomy->get_key()
					) ),
					'edit_taxonomy'	=> admin_url( sprintf(
						'admin.php?page=voxel-taxonomies&action=edit-taxonomy&taxonomy=%s',
						$taxonomy->get_key()
					) ),
				];
			}, $taxonomies ),
		];

		wp_enqueue_script('vx:taxonomies-editor.js');
		require locate_template( 'templates/backend/taxonomies/view-taxonomies.php' );
	}

	protected function render_create_taxonomy_screen() {
		require locate_template( 'templates/backend/taxonomies/add-taxonomy.php' );
	}

	protected function update_taxonomy_version( $term_id, $tt_id, $taxonomy_key ) {
		if ( $taxonomy = \Voxel\Taxonomy::get( $taxonomy_key ) ) {
			$taxonomy->update_version();
		}
	}

	protected function render_edit_screen() {
		$key = $_GET['taxonomy'] ?? null;
		$taxonomy = \Voxel\Taxonomy::get( $key );
		if ( ! ( $key && $taxonomy ) ) {
			return;
		}

		if ( ! $taxonomy->is_managed_by_voxel() ) {
			$taxonomy->update( [
				'settings' => [
					'key' => $taxonomy->get_key(),
					'singular' => $taxonomy->get_singular_name(),
					'plural' => $taxonomy->get_plural_name(),
					'post_type' => $taxonomy->get_post_types(),
				],
			] );
		}

		$config = [
			'taxonomy' => $taxonomy->get_editor_config(),
			'permalink_front' => \Voxel\get_permalink_front(),
		];

		// load required assets
		wp_enqueue_script('vue');
		wp_enqueue_script('vx:taxonomy-editor.js');

		require locate_template( 'templates/backend/taxonomies/edit-taxonomy.php' );
	}

	protected function save_taxonomy_settings() {
		check_admin_referer( 'voxel_save_taxonomy_settings' );
		if ( ! current_user_can( 'manage_options' ) ) {
			die;
		}

		if ( empty( $_POST['taxonomy_config'] ) ) {
			die;
		}

		$config = json_decode( wp_unslash( $_POST['taxonomy_config'] ), true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			die;
		}

		$taxonomy = \Voxel\Taxonomy::get( $config['settings']['key'] ?? null );
		if ( ! ( $taxonomy && ( $config['settings']['key'] ?? null ) && ( $config['settings']['post_type'] ?? null ) ) ) {
			wp_die( 'Taxonomy must be assigned to at least one post type.', '', [ 'back_link' => true ] );
			exit;
		}

		// delete taxonomy
		if ( ! empty( $_POST['remove_taxonomy'] ) && $_POST['remove_taxonomy'] === 'yes' ) {
			$taxonomy->delete();
			wp_safe_redirect( admin_url( 'admin.php?page=voxel-taxonomies' ) );
			die;
		}

		$config['settings']['post_type'] = array_filter( (array) $config['settings']['post_type'], function( $post_type_key ) {
			return post_type_exists( $post_type_key );
		} );

		// edit post type
		$taxonomy->update( [
			'settings' => $config['settings'],
		] );

		wp_safe_redirect( admin_url( 'admin.php?page=voxel-taxonomies&action=edit-taxonomy&taxonomy='.$taxonomy->get_key() ) );
		exit;
	}

	protected function add_edit_taxonomy_link() {
		if ( get_current_screen()->base !== 'edit-tags' ) {
			return;
		}

		$taxonomy = \Voxel\Taxonomy::get( get_current_screen()->taxonomy ?? null );
		if ( ! $taxonomy ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery('.tablenav.top .bulkactions').append(
				jQuery('<a></a>')
					.addClass('button')
					.attr('href', <?= wp_json_encode( $taxonomy->get_edit_link() ) ?>)
					.css( { margin: '0 3px' } )
					.text('Edit taxonomy')
			);
		</script>
		<?php
	}
}
