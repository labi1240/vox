<?php

namespace Voxel\Dynamic_Tags\Modifiers;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Time_Diff extends \Voxel\Dynamic_Tags\Base_Modifier {

	public function get_key(): string {
		return 'time_diff';
	}

	public function get_label(): string {
		return _x( 'Time diff', 'modifiers', 'voxel-backend' );
	}

	public function accepts(): string {
		return \Voxel\T_DATE;
	}

	public function get_arguments(): array {
		return [
			'timezone' => [
				'type' => \Voxel\Form_Models\Text_Model::class,
				'label' => _x( 'Timezone to compare against', 'modifiers', 'voxel-backend' ),
				'classes' => 'x-col-12',
				'description' => _x( <<<TEXT
					Enter the timezone identifier e.g. "Europe/London", or an offset e.g. "+02:00".
					Leave empty to use the timezone set in site options.
					TEXT, 'modifiers', 'voxel-backend' ),
			],
		];
	}

	public function apply( $value, $args, $group ) {
		$timestamp = strtotime( $value ?? '' );
		if ( ! $timestamp ) {
			return $value;
		}

		try {
			$timezone = new \DateTimeZone( $args[0] ?? null );
		} catch ( \Exception $e ) {
			$timezone = wp_timezone();
		}

		return human_time_diff( $timestamp, time() + $timezone->getOffset( \Voxel\utc() ) );
	}

}
