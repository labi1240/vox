<?php

namespace Voxel\Controllers\Frontend\Statistics;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Statistics_Controller extends \Voxel\Controllers\Base_Controller {

	protected function hooks() {
		$this->filter( 'page_template', '@render_statistics_template' );
		$this->filter( '_voxel/editor/get_post_for_preview', '@set_post_in_preview', 10, 2 );
	}

	protected function render_statistics_template( $template ) {
		if ( (int) get_queried_object_id() === (int) \Voxel\get( 'templates.post_stats' ) ) {
			return locate_template( 'templates/frontend/statistics.php' );
		}

		return $template;
	}

	protected function set_post_in_preview( $post, $template_id ) {
		if ( (int) $template_id === (int) \Voxel\get( 'templates.post_stats' ) ) {
			$page_settings = (array) get_post_meta( $template_id, '_elementor_page_settings', true );
			$post_id = $page_settings['voxel_preview_post'] ?? null;
			if ( is_numeric( $post_id ) && ( $_post = \Voxel\Post::get( $post_id ) ) ) {
				$post = $_post;
			} else {
				$_post = \Voxel\Post::find( [
					'post_type' => array_merge( ['__none__'], (array) \Voxel\get( 'settings.stats.enabled_post_types' ) ),
					'post_status' => 'publish',
				] );

				if ( $_post ) {
					$post = $_post;
				}
			}
		}

		return $post;
	}
}
