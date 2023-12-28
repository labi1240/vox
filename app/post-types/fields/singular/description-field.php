<?php

namespace Voxel\Post_Types\Fields\Singular;

use \Voxel\Form_Models;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Description_Field extends \Voxel\Post_Types\Fields\Texteditor_Field {

	protected $supported_conditions = ['text'];

	public function before_props_assigned(): void {
		$this->props['label'] = 'Description';
		$this->props['type'] = 'description';
		$this->props['key'] = 'description';
		$this->props['editor-type'] = 'wp-editor-basic';
		$this->props['singular'] = true;
	}

	public function sanitize( $value ) {
		if ( $this->props['editor-type'] === 'plain-text' ) {
			return sanitize_textarea_field( trim( $value ) );
		}

		$content = wp_kses_post( trim( $value ) );
		$content = preg_replace( '/(<(.*)>)?<!-- [\/]?wp:(.*) --\>(<\/(.*)>)?[\\n]?/', '', $content );
		return $content;
	}

	public function update( $value ): void {
		global $wpdb;
		$wpdb->update( $wpdb->posts, [
			'post_content' => $value,
		], $where = [ 'ID' => $this->post->get_id() ] );
	}

	public function get_value() {
		return $this->post->get_content();
	}

	protected function editing_value() {
		if ( ! $this->post ) {
			return null;
		} elseif ( $this->props['editor-type'] === 'plain-text' ) {
			return $this->get_value();
		} else {
			$content = $this->get_value();
			$content = preg_replace( '/(<(.*)>)?<!-- [\/]?wp:(.*) --\>(<\/(.*)>)?[\\n]?/', '', $content );
			return $content;
		}
	}
}
