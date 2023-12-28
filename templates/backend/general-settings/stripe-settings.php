<?php
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="ts-group">
	<div class="ts-group-head"><h3>General</h3></div>
	<div class="x-row">
		<?php \Voxel\Form_Models\Select_Model::render( [
			'v-model' => 'config.stripe.currency',
			'label' => 'Currency',
			'choices' => \Voxel\Stripe\Currencies::all(),
			'classes' => 'x-col-12',
		] ) ?>
	</div>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>API keys</h3>
	</div>
	<div class="x-row">
		<div class="ts-form-group x-col-12">
			<p>
				Enter your Stripe account API keys. You can get your keys in
				<a href="https://dashboard.stripe.com/apikeys" target="_blank">dashboard.stripe.com/apikeys</a>
			</p>
		</div>
		<?php \Voxel\Form_Models\Text_Model::render( [
			'v-model' => 'config.stripe.key',
			'label' => 'Public key',
			'classes' => 'x-col-12',
		] ) ?>

		<?php \Voxel\Form_Models\Password_Model::render( [
			'v-model' => 'config.stripe.secret',
			'label' => 'Secret key',
			'classes' => 'x-col-12',
			'autocomplete' => 'new-password',
		] ) ?>
	</div>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Test mode</h3>
	</div>
	<div class="x-row">

		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.stripe.test_mode',
			'label' => 'Enable Stripe test mode',
			'classes' => 'x-col-12',
		] ) ?>

		<template v-if="config.stripe.test_mode">
			<?php \Voxel\Form_Models\Text_Model::render( [
				'v-model' => 'config.stripe.test_key',
				'label' => 'Test public key',
				'classes' => 'x-col-12',
			] ) ?>

			<?php \Voxel\Form_Models\Password_Model::render( [
				'v-model' => 'config.stripe.test_secret',
				'label' => 'Test secret key',
				'classes' => 'x-col-12',
				'autocomplete' => 'new-password',
			] ) ?>
		</template>
	</div>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Live mode webhook endpoints</h3>

	</div>
	<?php if ( $config['stripe']['secret'] ): ?>
		<div class="x-row">
			<div class="ts-form-group x-col-12">
				<!-- <p> Live mode webhook endpoints are active.</p> -->
				<div class="basic-ul">
					<li>
						<a href="#" @click.prevent="checkEndpointStatus('live')" ref="liveEndpointStatus" class="ts-button ts-outline">Check status</a>
					</li>
					<li>
						<a href="#" @click.prevent="checkEndpointStatus('live', true)" class="ts-button ts-outline">Stripe Connect status</a>
					</li>

					<li>
						<a href="#" @click.prevent="webhooks.liveDetails = ! webhooks.liveDetails" class="ts-button ts-outline">Details</a>
					</li>

					<li>
						<a
					href="https://dashboard.stripe.com/webhooks/<?= esc_attr( $config['stripe']['webhooks']['live']['id'] ) ?>"
					target="_blank"
					class="ts-button ts-outline"
				>Open in Stripe Dashboard</a>
					</li>
				</div>
			</div>
		</div>
		<template v-if="webhooks.liveDetails">
			<div class="x-row" :class="{'vx-disabled': !webhooks.editLiveDetails}">
				<div class="ts-form-group x-col-12">
					<label>Endpoint ID</label>
					<input type="text" v-model="config.stripe.webhooks.live.id">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Endpoint secret</label>
					<input type="text" v-model="config.stripe.webhooks.live.secret">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Connect endpoint ID</label>
					<input type="text" v-model="config.stripe.webhooks.live_connect.id">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Connect endpoint secret</label>
					<input type="text" v-model="config.stripe.webhooks.live_connect.secret">
				</div>
			</div>
			<div class="x-row">
				<div class="ts-form-group x-col-12">
					<a
						href="#"
						class="ts-button ts-outline"
						@click.prevent="webhooks.editLiveDetails = !webhooks.editLiveDetails"
					>Modify</a>
				</div>
			</div>
		</template>
	<?php else: ?>
		<div class="ts-form-group ">
			<p>Stripe API keys are required to setup webhook endpoints.</p>
		</div>
	<?php endif ?>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Test mode webhook endpoints</h3>
	</div>
	<?php if ( $config['stripe']['test_secret'] ): ?>
		<div class="x-row">
			<div class="ts-form-group x-col-12">
				<!-- <p><i class="las la-check"></i> Test mode webhook endpoints are active.</p> -->

				<div class="basic-ul">
					<li>
						<a href="#" @click.prevent="checkEndpointStatus('test')" class="ts-button ts-button ts-outline" ref="testEndpointStatus">Check status</a>
					</li>
					<li>
						<a href="#" @click.prevent="checkEndpointStatus('test', true)" class="ts-button ts-button ts-outline">Stripe Connect status</a>
					</li>
					<li>
						<a href="#" @click.prevent="webhooks.testDetails = ! webhooks.testDetails" class="ts-button ts-button ts-outline">Details</a>
					</li>
					<li>
						<a
							href="https://dashboard.stripe.com/test/webhooks/<?= esc_attr( $config['stripe']['webhooks']['test']['id'] ) ?>"
							target="_blank"
							class="ts-button ts-button ts-outline"
						>Open in Stripe Dashboard</a>
					</li>
				</div>
			</div>
		</div>
		<template v-if="webhooks.testDetails">
			<div class="x-row" :class="{'vx-disabled': !webhooks.editTestDetails}">
				<div class="ts-form-group x-col-12">
					<label>Endpoint ID</label>
					<input type="text" v-model="config.stripe.webhooks.test.id">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Endpoint secret</label>
					<input type="text" v-model="config.stripe.webhooks.test.secret">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Connect endpoint ID</label>
					<input type="text" v-model="config.stripe.webhooks.test_connect.id">
				</div>
				<div class="ts-form-group x-col-12">
					<label>Connect endpoint secret</label>
					<input type="text" v-model="config.stripe.webhooks.test_connect.secret">
				</div>
			</div>
			<div class="x-row">
				<div class="ts-form-group x-col-12">
					<a
						href="#"
						class="ts-button ts-outline"
						@click.prevent="webhooks.editTestDetails = !webhooks.editTestDetails"
					>Modify</a>
				</div>
			</div>
		</template>
	<?php else: ?>
		<div class="ts-form-group ">
			Test mode API keys are required to setup webhook endpoints.
		</div>
	<?php endif ?>
</div>
<div class="ts-group">
	<div class="ts-group-head">
		<h3>Local Stripe</h3>
	</div>
	<div class="x-row">
		<?php \Voxel\Form_Models\Switcher_Model::render( [
			'v-model' => 'config.stripe.webhooks.local.enabled',
			'label' => 'This is a local installation',
			'classes' => 'x-col-12',
		] ) ?>


		<div v-if="config.stripe.webhooks.local.enabled" class="ts-form-group x-col-12">
			<label>Follow these steps to setup Stripe webhook events on a local installation:</label>
			<p>Read more about local testing <a href="https://stripe.com/docs/webhooks/test" target="_blank">here.</a></p>
			<ol>
				<li>
					<a href="https://stripe.com/docs/stripe-cli" target="_blank">Install the Stripe CLI</a>
					and log in to authenticate your account.
				</li>
				<li>
					Forward webhook events to your local endpoint using the following command:<br>
					<pre class="ts-snippet"><span class="ts-green">stripe</span> listen <span class="ts-italic">--forward-to="<?= home_url('?vx=1&action=stripe.webhooks') ?>"</span></pre>
				</li>
				<li>
					Paste the generated webhook signing secret below.
				</li>
			</ol>
		</div>

		<div v-if="config.stripe.webhooks.local.enabled" class="ts-form-group x-col-12">
			<label>Webhook secret from Stripe CLI</label>
			<input type="text" v-model="config.stripe.webhooks.local.secret">

		</div>
	</div>
</div>
