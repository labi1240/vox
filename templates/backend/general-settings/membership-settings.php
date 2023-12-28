<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Registration</h3>
	</div>

	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.membership.require_verification',
			'label' => 'Require email verification',
			'classes' => 'x-col-12',
		] ) ?>
	</div>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Membership</h3>
	</div>

	<div class="x-row">
		<?php \Voxel\Form_Models\Select_Model::render( [
			'v-model' => 'config.membership.update.proration_behavior',
			'label' => 'Proration behavior when switching between subscription plans',
			'classes' => 'x-col-12',
			'choices' => [
				'create_prorations' => 'Create prorations',
				'always_invoice' => 'Create prorations and invoice immediately',
				'none' => 'Disable prorations',
			],
		] ) ?>

		<?php \Voxel\Form_Models\Select_Model::render( [
			'v-model' => 'config.membership.cancel.behavior',
			'label' => 'When a cancel request is submitted, cancel the subscription:',
			'classes' => 'x-col-12',
			'choices' => [
				'at_period_end' => 'At the end of current billing period',
				'immediately' => 'Immediately',
			],
		] ) ?>

		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.membership.trial.enabled',
			'label' => 'Enable free trial',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Number_Model::render( [
			'v-if' => 'config.membership.trial.enabled',
			'v-model' => 'config.membership.trial.period_days',
			'label' => 'Trial period days',
			'classes' => 'x-col-12',
		] ) ?>
	</div>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Tax collection</h3>
	</div>

	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.membership.checkout.tax.tax_id_collection',
			'label' => 'Enable customer tax ID collection',
			'classes' => 'x-col-12',
		] ) ?>

		<div class="ts-form-group x-col-12">
			<p >See list of supported countries <a href="https://stripe.com/docs/tax/checkout/tax-ids#supported-types" target="_blank">here</a></p>
		</div>

		<?php \Voxel\Form_Models\Select_Model::render( [
			'v-model' => 'config.membership.checkout.tax.mode',
			'label' => 'Tax collection mode',
			'classes' => 'x-col-12',
			'choices' => [
				'auto' => 'Automatic (Stripe Tax)',
				'manual' => 'Manual',
				'none' => 'None',
			],
		] ) ?>
	</div>


</div>
<div class="ts-group" v-if="config.membership.checkout.tax.mode === 'manual'">
	<template v-if="config.membership.checkout.tax.mode === 'manual'">
		<div class="ts-group-head">
			<h3>
				Collect taxes manually using Tax Rates
			</h3>
		</div>

		<div class="x-row">
			<div class="ts-form-group x-col-12">
				<div class="basic-ul">
					<a href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/tax-rates' ) ) ?>" target="_blank" class="ts-button ts-faded">
						<i class="las la-external-link-alt icon-sm"></i>
						Setup tax rates
					</a>
				</div>
			</div>
			<div class="ts-form-group x-col-12">
				<h4>Live mode</h4>
				<rate-list
					v-model="config.membership.checkout.tax.manual.tax_rates"
					mode="live"
					source="backend.list_tax_rates"
				></rate-list>
			</div>

			<div class="ts-form-group x-col-12">
				<h4>Test mode</h4>
				<rate-list
					v-model="config.membership.checkout.tax.manual.test_tax_rates"
					mode="test"
					source="backend.list_tax_rates"
				></rate-list>
			</div>
		</div>


	</template>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Promotion codes</h3>
	</div>
	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.membership.checkout.promotion_codes.enabled',
			'label' => 'Allow promotion codes in checkout',
			'classes' => 'x-col-12',
		] ) ?>

		<div class="ts-form-group x-col-12">
			<div class="basic-ul">
				<li><a href="<?= esc_url( \Voxel\Stripe::dashboard_url( '/coupons' ) ) ?>" target="_blank" class="ts-button ts-faded">
					<i class="las la-external-link-alt icon-sm"></i>
					Manage promotion codes
				</a></li>
			</div>
		</div>
	</div>
</div>
