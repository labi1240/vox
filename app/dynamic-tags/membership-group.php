<?php

namespace Voxel\Dynamic_Tags;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Membership_Group extends Base_Group {

	public $key = 'membership';
	public $label = 'Membership';

	public $membership;

	protected function properties(): array {
		return [
			'plan' => [
				'label' => 'Plan',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'key' => [
						'label' => 'Key',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							return $this->membership->plan->get_key();
						},
					],
					'label' => [
						'label' => 'Label',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							return $this->membership->plan->get_label();
						},
					],
					'description' => [
						'label' => 'Description',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							return $this->membership->plan->get_description();
						},
					],
				],
			],
			'pricing' => [
				'label' => 'Pricing',
				'type' => \Voxel\T_OBJECT,
				'properties' => [
					'amount' => [
						'label' => 'Amount',
						'type' => \Voxel\T_NUMBER,
						'default_mods' => '.currency_format(,true)',
						'callback' => function() {
							if ( $this->membership->get_type() === 'subscription' || $this->membership->get_type() === 'payment' ) {
								return $this->membership->get_amount();
							} else {
								return 0;
							}
						},
					],
					'period' => [
						'label' => 'Period',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							if ( $this->membership->get_type() === 'subscription' ) {
								return \Voxel\interval_format( $this->membership->get_interval(), $this->membership->get_interval_count() );
							} elseif ( $this->membership->get_type() === 'payment' ) {
								return _x( 'one time', 'price interval', 'voxel' );
							} else {
								return '';
							}
						},
					],
					'currency' => [
						'label' => 'Currency',
						'type' => \Voxel\T_STRING,
						'callback' => function() {
							if ( $this->membership->get_type() === 'subscription' || $this->membership->get_type() === 'payment' ) {
								return $this->membership->get_currency();
							} else {
								return '';
							}
						},
					],
				],
			],
		];
	}
}
