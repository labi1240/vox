<?php

namespace Voxel\Controllers\Frontend\Search;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Search_Controller extends \Voxel\Controllers\Base_Controller {

	protected function hooks() {
		$this->on( 'voxel_ajax_search_posts', '@search_posts' );
		$this->on( 'voxel_ajax_nopriv_search_posts', '@search_posts' );

		$this->on( 'voxel_ajax_get_preview_card', '@get_preview_card' );
		$this->on( 'voxel_ajax_nopriv_get_preview_card', '@get_preview_card' );

		$this->on( 'pre_get_posts', '@maybe_disable_native_archive_query' );
	}

	protected function search_posts() {
		$limit = absint( $_GET['limit'] ?? 10 );
		$page = absint( $_GET['pg'] ?? 1 );
		$offset = absint( $_GET['__offset'] ?? 0 );
		$exclude = array_filter( array_map( 'absint', explode( ',', (string) ( $_GET['__exclude'] ?? '' ) ) ) );
		$results = \Voxel\get_search_results( wp_unslash( $_GET ), [
			'limit' => $limit,
			'offset' => $offset,
			'template_id' => is_numeric( $_GET['__template_id'] ?? null ) ? (int) $_GET['__template_id'] : null,
			'get_total_count' => ! empty( $_GET['__get_total_count'] ),
			'exclude' => array_slice( $exclude, 0, 25 ),
		] );

		echo $results['styles'];
		echo $results['render'];
		echo $results['scripts'];

		$total_count = $results['total_count'] ?? 0;

		printf(
			'<script
				class="info"
				data-has-prev="%s"
				data-has-next="%s"
				data-has-results="%s"
				data-total-count="%d"
				data-display-count="%s"
				data-display-count-alt="%s"
			></script>',
			$results['has_prev'] ? 'true' : 'false',
			$results['has_next'] ? 'true' : 'false',
			! empty( $results['ids'] ) ? 'true' : 'false',
			$total_count,
			\Voxel\count_format( count( $results['ids'] ), $total_count ),
			\Voxel\count_format( ( ( $page - 1 ) * $limit ) + count( $results['ids'] ), $total_count )
		);
	}

	protected function get_preview_card() {
		try {
			$post = \Voxel\Post::get( $_GET['post_id'] ?? null );
			if ( ! ( $post && $post->post_type && $post->post_type->is_managed_by_voxel() && $post->is_viewable_by_current_user() ) ) {
				throw new \Exception( 'Invalid request.', 101 );
			}

			$template_id = absint( $_GET['template_id'] ?? null );
			$templates = $post->post_type->get_templates();
			$custom_card_templates = array_column( $post->post_type->templates->get_custom_templates()['card'], 'id' );
			if ( ! ( $template_id === $templates['card'] || in_array( $template_id, $custom_card_templates ) ) ) {
				throw new \Exception( 'Invalid request.', 102 );
			}

			\Voxel\set_current_post( $post );

			add_filter( 'elementor/frontend/builder_content/before_print_css', '__return_false' );

			ob_start();
			\Voxel\print_template( $template_id );
			foreach ( wp_scripts()->queue as $handle ) {
				wp_scripts()->do_item( $handle );
			}
			$markup = ob_get_clean();

			// print styles first
			foreach ( wp_styles()->queue as $handle ) {
				wp_styles()->do_item( $handle );
			}

			echo $markup;
			exit;
		} catch ( \Exception $e ) {
			return wp_send_json( [
				'success' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
			] );
		}
	}

	protected function maybe_disable_native_archive_query( $query ) {
		// disable main query in post type archive
		if ( ! is_admin() && $query->is_main_query() && is_post_type_archive() ) {
			$post_type = \Voxel\Post_Type::get( $query->get( 'post_type' ) );
			if (
				$post_type
				&& $post_type->is_managed_by_voxel()
				&& ( $post_type->get_setting('options.default_archive_query', 'disabled') !== 'enabled' )
			) {
				$query->set( 'post__in', [0] );
				$query->set( 'posts_per_page', 1 );
			}
		}

		// disable main query in single term
		if ( ! is_admin() && $query->is_main_query() && ( is_tax() || is_category() || is_tag() ) ) {
			$term = \Voxel\Term::get( get_queried_object() );
			if (
				$term
				&& $term->taxonomy
				&& $term->taxonomy->is_managed_by_voxel()
				&& ( $term->taxonomy->config('settings.default_archive_query', 'disabled') !== 'enabled' )
			) {
				$query->set( 'post__in', [0] );
				$query->set( 'posts_per_page', 1 );
			}
		}
	}
}
