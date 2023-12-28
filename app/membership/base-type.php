<?php

namespace Voxel\Membership;

if ( ! defined('ABSPATH') ) {
	exit;
}

abstract class Base_Type {

	public $plan;

	protected $type;

	public function __construct( array $config ) {
		$this->plan = \Voxel\Plan::get( $config['plan'] ?? null );
		if ( ! $this->plan ) {
			$this->plan = \Voxel\Plan::get( 'default' );
		}

		$this->init( $config );
	}

	protected function init( array $config ) {
		//
	}

	public function get_type() {
		return $this->type;
	}

	public function is_active() {
		return true;
	}

	public function get_created_at() {
		return null;
	}

	public function get_additional_limits() {
		return [];
	}

	public function get_details_for_app_event(): array {
		if ( $this->get_type() === 'subscription' && $this->is_active() ) {
			return [
				'type' => 'subscription',
				'plan' => $this->plan->get_key(),
				'amount' => $this->get_amount(),
				'currency' => $this->get_currency(),
				'interval' => $this->get_interval(),
				'interval_count' => $this->get_interval_count(),
			];
		} elseif ( $this->get_type() === 'payment' && $this->is_active() ) {
			return [
				'type' => 'payment',
				'plan' => $this->plan->get_key(),
				'amount' => $this->get_amount(),
				'currency' => $this->get_currency(),
			];
		} else {
			return [
				'type' => 'default',
				'plan' => $this->plan->get_key(),
			];
		}
	}

	public static function create_from_details_for_app_event( $details ) {
		$type = $details['type'] ?? 'default';

		if ( $type === 'subscription' ) {
			return new \Voxel\Membership\Type_Subscription( [
				'type' => $type,
				'plan' => $details['plan'] ?? null,
				'status' => 'active',
				'amount' => $details['amount'] ?? null,
				'currency' => $details['currency'] ?? null,
				'interval' => $details['interval'] ?? null,
				'interval_count' => $details['interval_count'] ?? null,
			] );
		} elseif ( $type === 'payment' ) {
			return new \Voxel\Membership\Type_Payment( [
				'type' => $type,
				'plan' => $details['plan'] ?? null,
				'amount' => $details['amount'] ?? null,
				'currency' => $details['currency'] ?? null,
			] );
		} else {
			return new \Voxel\Membership\Type_Default( [
				'type' => $type,
				'plan' => $details['plan'] ?? null,
			] );
		}
	}
}
