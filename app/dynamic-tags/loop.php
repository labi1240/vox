<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Loop {

	public static $loops = [];

	public static function get_index( $loopable ): int {
		return static::$loops[ $loopable ]['index'] ?? 0;
	}

	public static function is_running( $loopable ): bool {
		return isset( static::$loops[ $loopable ] );
	}

	public static function run( $loopable, $cb, $hard_limit = null, $offset = null ) {
		if ( isset( static::$loops[ $loopable ] ) ) {
			return;
		}

		$groups = \Voxel\config('dynamic_tags.groups');
		preg_match( \Voxel\REG_MATCH_TAGS, $loopable, $matches );
		if ( ! isset( $groups[ $matches['group'] ?? null ] ) ) {
			return;
		}

		$group = new $groups[ $matches['group'] ];
		$property = $group->get_property( $matches['property'] ?? null );
		if ( $property === null || empty( $property['loopable'] ) || ! is_callable( $property['loopcount'] ) ) {
			return;
		}

		$count = ($property['loopcount'])();
		if ( is_numeric( $hard_limit ) ) {
			$count = min( $count, $hard_limit );
		}

		if ( ! is_int( $count ) || $count <= 0 ) {
			return;
		}

		static::$loops[ $loopable ] = [
			'index' => is_numeric( $offset ) ? absint( $offset ) : 0,
			'count' => $count,
		];

		while ( static::get_index( $loopable ) < $count ) {
			$cb( static::get_index( $loopable ) );
			static::$loops[ $loopable ]['index']++;
		}

		// dump(static::$loops);

		unset( static::$loops[ $loopable ] );
	}

	public static function _set_loop_item( $loopable, int $index ) {
		if ( ! isset( static::$loops[ $loopable ] ) ) {
			static::$loops[ $loopable ] = [
				'index' => 0,
				'count' => 0,
			];
		}

		static::$loops[ $loopable ]['index'] = $index;
	}

	public static function _unset_loop_item( $loopable ) {
		unset( static::$loops[ $loopable ] );
	}
}
