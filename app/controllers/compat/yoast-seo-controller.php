<?php

namespace Voxel\Controllers\Compat;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Yoast_Seo_Controller extends \Voxel\Controllers\Base_Controller {

	protected function authorize() {
		return defined( 'WPSEO_VERSION' );
	}

	protected function hooks() {
		$this->filter( 'wpseo_replacements', '@render_replacements', 100, 2 );
	}

	/**
	 * Render dynamic tags added in the format `vx(<dtag>)`, e.g.
	 * `vx(@post(:title)) %%sep%% %%sitename%%`
	 *
	 * @since 1.2.8
	 */
	protected function render_replacements( $replacements, $args ) {
		foreach ( debug_backtrace(0, 8) as $frame ) {
			if ( ( $frame['class'] ?? '' ) === 'WPSEO_Replace_Vars' && ( $frame['function'] ?? '' ) === 'replace' ) {
				preg_match_all( \Voxel\REG_MATCH_TAGS, (string) ( $frame['args'][0] ?? '' ), $matches );
				foreach ( ( $matches[0] ?? [] ) as $tag ) {
					$replacements[ 'vx('.$tag.')' ] = \Voxel\render( $tag );
				}

				break;
			}
		}

		return $replacements;
	}
}
